<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo thanh toán thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .content {
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thông báo thanh toán thành công</h2>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $student->full_name }}</strong>,</p>
            <p>Chúng tôi đã nhận được khoản thanh toán của bạn.</p>
            <p><strong>Số tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VND</p>
            <p><strong>Ngày thanh toán:</strong> {{ now()->format('d/m/Y H:i') }}</p>
            <p>Cảm ơn bạn đã hoàn tất thanh toán học phí!</p>
        </div>
        <div class="footer">
            <p>Trường Cao Đẳng Công Nghệ Thông Tin</p>
            <p>Hotline: 0834441595| Email: support@cdcntt.edu</p>
        </div>
    </div>
</body>
</html>
