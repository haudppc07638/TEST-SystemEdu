<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\Major;
use App\Models\StuClass;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $students = Student::getAllStudents();
        return view('admin.students.index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::getNameMajors();
        $classes = StuClass::getNameClasses(); 
        
        return view('admin.students.create', [
            'majors' => $majors,
            'classes' => $classes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {   
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only([
            'full_name',           // Tên đầy đủ
            'date_of_birth',       // Ngày sinh
            'gender',              // Giới tính (0 - nữ, 1 - nam)
            'nation',              // Quốc tịch
            'email',               // Email
            'code',                // Mã sinh viên
            'phone',               // Số điện thoại
            'image',               // Ảnh đại diện
            'identity_card',       // CMND/CCCD
            'card_issuance_date',  // Ngày cấp CMND/CCCD
            'card_location',       // Nơi cấp CMND/CCCD
            'provice_city',        // Tỉnh/Thành phố
            'district',            // Quận/Huyện
            'commune_level',       // Xã/Phường
            'house_number',        // Số nhà
            'sponsor_name',        // Tên người bảo hộ
            'sponsor_phone',       // Số điện thoại người bảo hộ
            'major_id',            // ID chuyên ngành
            'major_class_id',
        ]);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            dd($validator);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['image'] = $this->imageService->handleImageStore($request);

        $student = Student::createStudent($data);
        toastr()->success('Thêm thành công học sinh: ' . $student->fullname);
        return redirect()->route('admin.students.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findStudentById($id);
        $majors = Major::getNameMajors();
        $classes = StuClass::getNameClasses();

        return view('admin.students.edit', [
            'student' => $student,
            'majors' => $majors,
            'classes' => $classes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, $id)
    {   
        $rules = $request->rules();
        $messages = $request->messages();
    
        $data = $request->only([
            'full_name',           // Tên đầy đủ
            'date_of_birth',       // Ngày sinh
            'gender',              // Giới tính (0 - nữ, 1 - nam)
            'nation',              // Quốc tịch
            'email',               // Email
            'phone',               // Số điện thoại
            'image',               // Ảnh đại diện
            'identity_card',       // CMND/CCCD
            'card_issuance_date',  // Ngày cấp CMND/CCCD
            'card_location',       // Nơi cấp CMND/CCCD
            'provice_city',        // Tỉnh/Thành phố
            'district',            // Quận/Huyện
            'commune_level',       // Xã/Phường
            'house_number',        // Số nhà
            'sponsor_name',        // Tên người bảo hộ
            'sponsor_phone',       // Số điện thoại người bảo hộ
            'major_id',            // ID chuyên ngành
            'major_class_id',
        ]);
        
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Student::findStudentById($id);
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->handleImageUpdate($request, $student);
        } else {
            // Giữ nguyên ảnh cũ nếu không có ảnh mới
            $data['image'] = $student->image;
        }
        $student->update($data);
        toastr()->success('Cập nhật thành công thông tin học sinh: ' . $student->full_name);
        return redirect()->route('admin.students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
        $student = Student::findStudentById($id);
        $this->imageService->handleImageDelete($student->image);
        $student->delete();
        toastr()->success('Xoá thành công học sinh: '.$student->full_name);
        return redirect()->route('admin.students.index');
    }
    catch (QueryException $e) {
        if ($e->getCode()) {
            return redirect()->route('admin.students.index');
        }
        return redirect()->route('admin.students.index');
    }}

}
