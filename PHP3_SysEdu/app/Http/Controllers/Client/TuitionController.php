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

        $tuition = Tuition::getSubjectStudentRegister();
        $totalTuition = TotalTuition::getTotal();
        $totalTuitions = TotalTuition::where('student_id', $student->id)->first();

        // Kiểm tra xem học phí đã được thanh toán chưa
        if ($totalTuitions && $totalTuitions->payment_status === 'paid') {
            return view('client.tuition', [
                'student' => $student,
                'message' => 'Bạn đã thanh toán học phí. Không có dữ liệu hiển thị.',
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

        // Kiểm tra nếu học phí không có
        if ($amount <= 0) {
            return back()->with('error', 'Không có học phí cần thanh toán.');
        }

        // Thiết lập thông tin thanh toán
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

        // Gửi yêu cầu đến API VietQR
        $response = Http::withHeaders([
            'x-client-id' => $clientId,
            'x-api-key' => $apiKey,
            'Accept' => 'application/json',
        ])->post($apiUrl, $data);

        // Kiểm tra và xử lý phản hồi từ API
        if ($response->successful()) {
            $responseData = $response->json();

            if (isset($responseData['code']) && $responseData['code'] === '00') {
                $qrCodeUrl = $responseData['data']['qrDataURL'];

                // Cập nhật trạng thái thanh toán thành "paid"
                $totalTuition = TotalTuition::where('student_id', $student->id)->first();
                if ($totalTuition) {
                    $totalTuition->payment_status = 'paid';
                    $totalTuition->payment_date = now();
                    $totalTuition->save();
                }

                // Hiển thị mã QR thanh toán
                return view('vietqr.index', compact('qrCodeUrl'));
            } else {
                return back()->with('error', 'Lỗi từ API: ' . ($responseData['desc'] ?? 'Không rõ lỗi.'));
            }
        }

        return back()->with('error', 'Có lỗi xảy ra khi tạo mã QR.');
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
