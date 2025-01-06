<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectClass;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Semester;
use App\Models\Credit;
use App\Models\StuClass;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SubjectClassRequest;
use App\Models\StudentSubjectClass;
use App\Models\SubjectLecturer;
use App\Models\Tuition;

class SubjectClassController extends Controller
{
    public function index(Request $request)
    {
        $subjectClasses = SubjectClass::latest()->get();
        $subjects = Subject::select('id', 'name', 'major_id')->with('major')->orderBy('major_id', 'asc')->get();
        $employees = Employee::select('id', 'full_name', 'code')->get();

        $filters = [
            'subject_id' => $request->get('subject_id', null),
            'employee_id' => $request->get('employee_id', null),
        ];

        $subjectClasses = SubjectClass::filterBySubject($filters)->paginate(10);

        return view('admin.subjectclasses.index', [
            'subjectClasses' => $subjectClasses,
            'subjects' => $subjects,
            'employees' => $employees,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        $subjects = Subject::with('major')->orderBy('major_id', 'asc')->get();
        $semesters = Semester::getSemester();
        $employees = Employee::getNameEmployees();
        $credits = Credit::getAllCredit();

        // Lấy danh sách lớp chuyên ngành và đếm số lượng sinh viên cho mỗi lớp
        $majorClasses = StuClass::getNameClasses()->map(function ($majorClass) {
            $majorClass->student_count = StuClass::studentCount($majorClass->id); // Gọi phương thức để đếm số lượng sinh viên
            return $majorClass;
        });

        return view('admin.subjectclasses.create', [
            'subjects' => $subjects,
            'semesters' => $semesters,
            'employees' => $employees,
            'credits' => $credits,
            'majorClasses' => $majorClasses,
        ]);
    }

    public function store(SubjectClassRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();;
        $data = $request->only([
            'quantity',
            'name',
            'start_date',
            'end_date',
            'registration_deadline',
            'employee_id',
            'subject_id',
            'semester_id',
            'major_class_id',
            'credit_id',
            'credit_price'
        ]);
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!empty($data['major_class_id'])) {
            if (SubjectClass::checkExistingClass($data['major_class_id'], $data['subject_id'])) {
                toastr()->error('Lớp chuyên ngành này đã được đăng ký cho môn học này');
                return redirect()->back()->withInput();
            }
        }

        $validatedData = $validator->validated();

        $subjectClass = SubjectClass::createSubjectClass($data);

        $subjectClass->addStudents($data['major_class_id']);

        // Thêm học sinh vào bảng thanh toán
        $this->addStudentsToTuition($subjectClass->id);

        toastr()->success('Lớp học được tạo thành công');
        return redirect()->route('admin.subjectclasses.index');
    }

    public function edit($id)
    {
        $subjectClass = SubjectClass::findOrFail($id);

        $lecturers = SubjectLecturer::with('employee')
            ->where('subject_id', $subjectClass->subject_id)
            ->get()
            ->pluck('employee');

        return view('admin.subjectclasses.edit', [
            'subjectClass' => $subjectClass,
            'lecturers' => $lecturers,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Tìm lớp học phần cần chỉnh sửa
        $subjectClass = SubjectClass::findOrFail($id);
        $studentCount = StudentSubjectClass::where('subject_class_id', $subjectClass->subject_id)->count();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|max:100|min:'.$studentCount,
            'registration_deadline' => 'required|date|before_or_equal:start_date',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'employee_id' => 'required',
        ], [
            'name.required' => 'Tên lớp học phần là bắt buộc.',
            'name.string' => 'Tên lớp học phần phải là một chuỗi văn bản.',
            'name.max' => 'Tên lớp học phần không được vượt quá 255 ký tự.',
            'quantity.required' => 'Số lượng sinh viên là bắt buộc.',
            'quantity.integer' => 'Số lượng sinh viên phải là một số nguyên.',
            'quantity.min' => 'Số lượng sinh viên phải ít nhất '.$studentCount.' so với số sinh viên đã đăng ký hiện tại !',
            'quantity.max' => 'Số lượng sinh viên tối đa là 100 !',
            'registration_deadline.required' => 'Ngày đăng ký là bắt buộc.',
            'registration_deadline.date' => 'Ngày đăng ký không hợp lệ.',
            'registration_deadline.before_or_equal' => 'Ngày đăng ký phải trước hoặc bằng ngày bắt đầu.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        if ($subjectClass->isStarted()) {
            unset($validatedData['employee_id']);
        }

        $subjectClass->update($validatedData);
        toastr()->success('Lớp học phần được cập nhật thành công.');

        // Chuyển hướng về trang danh sách lớp học phần
        return redirect()->route('admin.subjectclasses.index');
    }

    public function destroy($id)
    {
        try {
            $subjectClass = SubjectClass::findOrFail($id);
            $subjectClass->delete();
            toastr()->success('Lớp học được xóa thành công.');
            return redirect()->route('admin.subjectclasses.index');
        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.subjectclasses.index');
            }
            return redirect()->route('admin.subjectclasses.index');
        }
    }

    protected function addStudentsToTuition($subjectClassId)
    {
        $students = StudentSubjectClass::where('subject_class_id', $subjectClassId)->get();

        foreach ($students as $student) {

            Tuition::create([
                'student_subject_class_id' => $student->id,
            ]);
        }
    }
}
