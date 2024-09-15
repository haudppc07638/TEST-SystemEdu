<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Faculty;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use App\Exports\EmployeesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
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
        $employees = Employee::getAllEmployees();
        return view('admin.employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::getNameFaculties();
        $departments = Department::getNameDepartments();

        return view('admin.employees.create', [
            'faculties' => $faculties,
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only([
            'fullname',
            'email',
            'password',
            'phone',
            'image',
            'position',
            'faculty_id',
            'department_id',
        ]);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['image'] = $this->imageService->handleImageStore($request);

        $employee = Employee::create($data);
        toastr()->success('Thêm thành công nhân sự: ' . $employee->fullname);
        return redirect()->route('admin.employees.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::getEmployeeById($id);
        $faculties = Faculty::getNameFaculties();
        $departments = Department::getNameDepartments();

        return view('admin.employees.edit', [
            'employee' => $employee,
            'faculties' => $faculties,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $id)
    {
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only([
            'fullname',
            'email',
            'phone',
            'image',
            'position',
            'faculty_id',
            'department_id',
        ]);
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $employee = Employee::getEmployeeById($id);
        $data['image'] = $this->imageService->handleImageUpdate($request, $employee);
        $employee->update($data);
        toastr()->success('Cập nhật thành công thông tin nhân sự: ' . $employee->fullname);
        return redirect()->route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::getEmployeeById($id);
            $this->imageService->handleImageDelete($employee->image);
            $employee->delete();
            toastr()->success('Xoá thành công nhân sự: ' . $employee->fullname);
            return redirect()->route('admin.employees.index');
        } catch (QueryException $e) {
            if ($e->getCode()) {
                return redirect()->route('admin.employees.index');
            }
            return redirect()->route('admin.employees.index');
        }
    }
}