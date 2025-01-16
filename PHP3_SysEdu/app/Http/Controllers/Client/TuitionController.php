<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentSubjectClass;
use App\Models\TotalTuition;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Student;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;


class TuitionController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $studentSubjectClasses = StudentSubjectClass::getIncompleteFeedbackClasses($student->id);

        $tuition = Tuition::getSubjectStudentRegister($student->id);
        $totalTuition = TotalTuition::getTotal();
        $totalTuitions = TotalTuition::where('student_id', $student->id)->first();

        if ($totalTuitions && $totalTuitions->payment_status === 'paid') {
            return view('client.tuition', [
                'student' => $student,
                'message' => 'Bạn đã thanh toán học phí. Không có dữ liệu hiển thị.',
            ]);
        }
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

            TotalTuition::where('student_id', $student->id)
                ->update([
                    'payment_status' => 'paid',
                    'payment_date' => now(),
                ]);

            try {
                Mail::to($student->email)->send(new PaymentSuccessMail($student, $amount));
            } catch (\Exception $e) {
                return back()->with('error', 'Thanh toán thành công nhưng không thể gửi email: ' . $e->getMessage());
            }

            return view('vietqr.index', compact('qrCodeUrl'));
        } else {
            return back()->with('error', 'Có lỗi xảy ra khi tạo mã QR: ' . ($responseData['desc'] ?? 'Không rõ lỗi.'));
        }
    } else {
        return back()->with('error', 'Có lỗi xảy ra khi kết nối với VietQR API.');
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
