<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\EnrollmentRequest;
use App\Models\Enrollment;
use App\Models\Major;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $major = Major::all();

        return response()->json($major)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullName' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|integer',
            'ethnicity' => 'required|string|max:100',
            'idNumber' => 'required|string|max:15',
            'issueDate' => 'required|date',
            'issuePlace' => 'required|string|max:100',
            'province' => 'required|string|max:150',
            'district' => 'required|string|max:150',
            'ward' => 'required|string|max:150',
            'addressDetail' => 'required|string|max:10',
            'phoneNumber' => 'required|string|max:15',
            'email' => 'required|email|unique:enrollments',
            'guardianName' => 'required|string|max:150',
            'guardianPhone' => 'required|string|max:15',
            'campus' => 'required|string|max:150',
            'major1' => 'required|integer',
            'method1' => 'required|in:grade_score,exam_score',
            'major2' => 'nullable|integer',
            'method2' => 'nullable|in:grade_score,exam_score',
            'year' => 'required|date_format:Y',
            'graduationProvince' => 'required|string|max:150',
            'graduationDistrict' => 'required|string|max:150',
            'graduationWard' => 'required|string|max:150',
            'recipient' => 'required|in:student,parents',
            'address' => 'required|in:residence_address,at_school',
            'idFront' => 'required|string',
            'idBack' => 'required|string',
            'diploma' => 'required|string',
        ]);

        $enrollment = Enrollment::create([
            'full_name' => $validatedData['fullName'],
            'date_of_birth' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'nation' => $validatedData['ethnicity'],
            'identity_card' => $validatedData['idNumber'],
            'card_issuance_date' => $validatedData['issueDate'],
            'card_location' => $validatedData['issuePlace'],
            'province_city' => $validatedData['province'],
            'district' => $validatedData['district'],
            'commune_level' => $validatedData['ward'],
            'house_number' => $validatedData['addressDetail'],
            'phone' => $validatedData['phoneNumber'],
            'email' => $validatedData['email'],
            'sponsor_name' => $validatedData['guardianName'],
            'sponsor_phone' => $validatedData['guardianPhone'],
            'first_major_id' => $validatedData['major1'],
            'application_method_1' => $validatedData['method1'],
            'second_major_id' => $validatedData['major2'],
            'application_method_2' => $validatedData['method2'],
            'year_graduation' => $validatedData['year'],
            'province_city_graduate' => $validatedData['graduationProvince'],
            'district_graduate' => $validatedData['graduationDistrict'],
            'commune_level_graduate' => $validatedData['graduationWard'],
            'recipient' => $validatedData['recipient'],
            'address' => $validatedData['address'],
            'front_id_card' => $validatedData['idFront'],
            'back_id_card' => $validatedData['idBack'],
            'graduation_certificate' => $validatedData['diploma'],
        ]);

        return response()->json($enrollment, 201)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
    }
}
