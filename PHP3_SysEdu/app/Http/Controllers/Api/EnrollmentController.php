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

    public function store(EnrollmentRequest $request)
    {
        $validated = $request->validated();
        Enrollment::create($validated);

        return response()->json([
            'message' => 'Enrollment created successfully',
            'data' => $validated
        ], 201)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
    }
}
