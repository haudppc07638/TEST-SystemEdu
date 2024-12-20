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

        return response()->json($major);
    }

    public function store(EnrollmentRequest $request)
    {
        $validated = $request->validated();
        Enrollment::create($validated);

        return response()->json([
            'message' => 'Enrollment thêm thành công',
            'data' => $validated
        ], 201);
    }
}
