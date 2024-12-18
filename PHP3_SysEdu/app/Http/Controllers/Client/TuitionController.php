<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentSubjectClass;
use App\Models\TotalTuition;
use App\Models\Tuition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class TuitionController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $studentSubjectClasses = StudentSubjectClass::getIncompleteFeedbackClasses($student->id);

        $tuition = Tuition::getSubjectStudentRegister();
        $totalTuition = TotalTuition::getTotal();

        if ($studentSubjectClasses->isNotEmpty()) {
            return view('client.home-feedback', [
                'studentSubjectClasses' => $studentSubjectClasses,
            ]);
        }
        return view('client.tuition', [
            'student' => $student,
            'tuitionView' => $tuition,
            'totalTuitionView' => $totalTuition,
        ]);
    }
    public function tuition($id)
    {
        $studentSubjectClass = StudentSubjectClass::findOrFail($id);
        $tuition = Tuition::insertTuitionJoinClass($studentSubjectClass->id);

        return redirect()->route('tuition.success')->with('success', 'Tuition created successfully');
    }
    public function generateVietQr(Request $request, $studentId)
    {
        $clientId = env('VIETQR_CLIENT_ID');
        $apiKey = env('VIETQR_API_KEY');
        $apiUrl = 'https://api.vietqr.io/v2/generate';

        $student = Student::findOrFail($studentId);
        $amount = ceil(TotalTuition::getTotalByStudentId($student->id));
        $amount = (int)$amount;

        if ($amount <= 0) {
            return back()->with('error', 'Số tiền thanh toán phải lớn hơn 0.');
        }

        if ($amount <= 0) {
            return back()->with('error', 'Không có học phí cần thanh toán.');
        }
        $accountNo = '06301360240402';
        $accountName = 'VO MINH KHANH';
        $acqId = 970422;
        $addInfo = 'Thanh toán học phí' . $student->code;
        $data = [
            'accountNo' => $accountNo,
            'accountName' => strtoupper($accountName),
            'acqId' => $acqId,
            'amount' => $amount,
            'addInfo' => $addInfo,
            'format' => 'image',
            'template' => 'J5NYvUt',
        ];

        $response = Http::withHeaders([
            'x-client-id' => $clientId,
            'x-api-key' => $apiKey,
            'Accept' => 'application/json',
        ])->post($apiUrl, $data);

        if ($response->successful()) {
            $responseData = $response->json();

            if (isset($responseData['code']) && $responseData['code'] === '00') {
                $qrCodeUrl = $responseData['data']['qrDataURL'];
                // dd($qrCodeUrl);
                return view('vietqr.index', compact('qrCodeUrl'));
            } else {
                return back()->with('error', 'Lỗi từ API: ' . ($responseData['desc'] ?? 'Không rõ lỗi.'));
            }
        }
    }

    //     public function showVietQr()
    // {
    //     try {
    //         // Gọi hàm generateVietQr với các tham số cần thiết
    //         $qrCodeUrl = $this->generateVietQr(
    //             'VCB',            // Mã ngân hàng (Ví dụ: Vietcombank)
    //             '123456789',      // Số tài khoản ngân hàng
    //             100000,           // Số tiền thanh toán (100,000 VNĐ)
    //             'Thanh toán đơn hàng #123'  // Mô tả thanh toán
    //         );

    //         // Trả về view với URL mã QR
    //         return view('vietqr', compact('qrCodeUrl'));
    //     } catch (\Exception $e) {
    //         // Nếu có lỗi, quay lại và hiển thị thông báo lỗi
    //         return back()->with('error', $e->getMessage());
    //     }
    // }
}
