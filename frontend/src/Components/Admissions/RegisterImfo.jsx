import React, { useState } from "react";
import ReCAPTCHA from "react-google-recaptcha";

function RegisterInfo() {
    const [captchaValue, setCaptchaValue] = useState(null);

    const handleCaptchaChange = (value) => {
        setCaptchaValue(value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!captchaValue) {
            alert("Vui lòng hoàn thành CAPTCHA.");
            return;
        }
        console.log("CAPTCHA Value:", captchaValue);
        alert("Đăng ký thành công!");
        setCaptchaValue(null);
    };

    return (
        <div className="flex flex-col md:flex-row bg-white">
            <div className="md:w-1/2 p-4">
                <iframe
                    className="w-full h-full"
                    src="https://www.youtube.com/embed/cRxry0Uo_7s?si=yw0Ljuwp_NTPfDaM"
                    title="YouTube Sysedu"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                ></iframe>
            </div>

            <div className="md:w-1/2 bg-blue-600 p-8 flex justify-center items-center">
                <form
                    onSubmit={handleSubmit}
                    className="w-full max-w-md bg-white p-6 rounded shadow-lg"
                >
                    <h2 className="text-blue-600 text-2xl font-bold mb-6 text-center">
                        ĐĂNG KÍ XÉT TUYỂN NGAY
                    </h2>
                    <div className="mb-4">
                        <input
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            type="text"
                            placeholder="Họ và tên *"
                            required
                        />
                    </div>
                    <div className="mb-4">
                        <input
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            type="tel"
                            placeholder="Điện thoại *"
                            required
                        />
                    </div>
                    <div className="mb-4">
                        <input
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            type="email"
                            placeholder="Email"
                        />
                    </div>
                    <div className="mb-4">
                        <select
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        >
                            <option value="">Chọn ngành học</option>
                        </select>
                    </div>
                    <div className="mb-4">
                        <select
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required
                        >
                            <option value="">Địa điểm học *</option>
                        </select>
                    </div>
                    <div className="mb-4">
                        <input
                            className="w-full text-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                            type="text"
                            placeholder="Link Facebook của bạn"
                        />
                    </div>
                    <div className="mb-4">
                        <ReCAPTCHA
                            sitekey="ví dụ"
                            onChange={handleCaptchaChange}
                        />
                    </div>
                    <div>
                        <button
                            type="submit"
                            className="w-full bg-blue-900 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700"
                        >
                            ĐĂNG KÝ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

export default RegisterInfo;
