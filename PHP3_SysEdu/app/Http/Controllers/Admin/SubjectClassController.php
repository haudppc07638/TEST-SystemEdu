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

        $subjects = Subject::getCodeSubject();
        $semesters = Semester::getSemester();
        $employees = Employee::getNameEmployees();
        $credits = Credit::getAllCredit();
        $majorClass = StuClass::getNameClasses();

        return view('admin.subjectclasses.edit', [
            'subjectClass' => $subjectClass,
            'subjects' => $subjects,
            'semesters' => $semesters,
            'employees' => $employees,
            'credits' => $credits,
            'majorClasses' => $majorClass,
        ]);
    }

    public function update(SubjectClassRequest $request, $id)
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
            'credit_id'
        ]);
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validatedData = $validator->validated();
        $subjectClass = SubjectClass::findOrFail($id);
        $subjectClass->update($validatedData);
        toastr()->success('Lớp học được cập nhật thành công.');
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
