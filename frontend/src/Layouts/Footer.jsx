import React from "react";
import logo from "../Assets/Images/logo.png";

function FooterBlog() {
    return (
        <footer className="bg-whiter p-8 mt-5 border-t-8 border-blue-600">
            <div className="container mx-auto">
                <div className="grid grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div className="text-center lg:text-left">
                        <h3 className="text-xl font-bold text-blue-600">TRỤ SỞ CHÍNH</h3>
                        <img
                            src={logo}
                            alt="Sysedu Logo" 
                            className="w-24 mt-4 mx-auto lg:mx-0 hover:scale-105 transition-transform duration-300"
                        />
                        <div className="mt-4">
                            <h3 className="text-blue-600 text-2xl font-bold hover:text-blue-700 transition-colors">
                                College Sysedu
                            </h3>
                            <p className="text-sm hover:text-blue-600 transition-colors">
                                <i className="fa fa-map text-blue-600" aria-hidden="true"></i>{" "}
                                Toà nhà F, Phường Trường Thạnh, Quận Ninh Kiều,
                                TP. Cần Thơ
                            </p>
                        </div>
                    </div>
                    <div className="text-center lg:text-left">
                        <h3 className="text-xl font-bold text-blue-600">
                            HỆ THỐNG VĂN PHÒNG
                        </h3>
                        <div className="mt-4 space-y-6">
                            <div className="hover:translate-x-2 transition-transform duration-300">
                                <h2 className="text-lg font-semibold text-blue-600">
                                    Cơ sở Cần Thơ
                                </h2>
                                <p className="text-sm">
                                    <i className="fa fa-map text-blue-600" aria-hidden="true"></i>{" "}
                                    Toà nhà F, Phường Trường Thạnh, Quận Ninh Kiều,
                                    TP. Cần Thơ
                                </p>
                                <p className="text-sm font-medium">
                                    Hotline: 034 5456 544 - 034 5456 545
                                </p>
                            </div>
                            <div className="hover:translate-x-2 transition-transform duration-300">
                                <h2 className="text-lg font-semibold text-blue-600">
                                    Cơ sở Hồ Chí Minh
                                </h2>
                                <p className="text-sm">
                                    <i className="fa fa-map text-blue-600" aria-hidden="true"></i>{" "}
                                    Tòa nhà QTSC9 (Tòa T), Đường Tô Ký, Phường Tăng
                                    Nhơn Phú B, TP. Thủ Đức, TP. HCM
                                </p>
                                <p className="text-sm font-medium">
                                    Hotline: 090 1660 002 - 028 6686 648
                                </p>
                            </div>
                            <div className="hover:translate-x-2 transition-transform duration-300">
                                <h2 className="text-lg font-semibold text-blue-600">
                                    Cơ sở Đà Nẵng
                                </h2>
                                <p className="text-sm">
                                    <i className="fa fa-map text-blue-600" aria-hidden="true"></i>{" "}
                                    219 Đường Nguyễn Sinh Sắc, Phường Liên Chiểu,
                                    TP. Đà Nẵng
                                </p>
                                <p className="text-sm font-medium">
                                    Hotline: 023 6371 099 - 094 3025 282
                                </p>
                            </div>
                        </div>
                    </div>
                    <div className="text-center lg:text-left">
                        <h3 className="text-xl font-bold text-blue-600">THÔNG TIN LIÊN HỆ</h3>
                        <div className="mt-4">
                            <div className="flex justify-center lg:justify-start space-x-6 mt-4 mb-8">
                                <a
                                    href="/"
                                    className="bg-blue-600 p-4 px-5 text-white rounded-lg hover:text-blue-600 hover:bg-white hover:scale-110 transition-all duration-300 shadow-lg"
                                >
                                    <i className="fab fa-facebook-f text-xl"></i>
                                </a>
                                <a
                                    href="/"
                                    className="bg-blue-600 p-4 text-white rounded-lg hover:text-blue-600 hover:bg-white hover:scale-110 transition-all duration-300 shadow-lg"
                                >
                                    <i className="fab fa-twitter text-xl"></i>
                                </a>
                                <a
                                    href="/"
                                    className="bg-pink-600 p-4 text-white rounded-lg hover:text-pink-600 hover:bg-white hover:scale-110 transition-all duration-300 shadow-lg"
                                >
                                    <i className="fab fa-instagram text-xl"></i>
                                </a>
                                <a
                                    href="/"
                                    className="bg-blue-600 p-4 text-white rounded-lg hover:text-blue-600 hover:bg-white hover:scale-110 transition-all duration-300 shadow-lg"
                                >
                                    <i className="fab fa-linkedin-in text-xl"></i>
                                </a>
                            </div>
                            <div className="flex justify-center lg:justify-start items-center space-x-2 mt-4 hover:translate-x-2 transition-transform duration-300">
                                <i className="fa fa-envelope text-blue-600" />{" "}
                                <a
                                    href="mailto:caodangsysedu@gmail.com"
                                    className="transition duration-300 text-sm font-medium hover:text-blue-600"
                                >
                                    caodangsysedu@gmail.com
                                </a>
                            </div>
                            <div className="flex justify-center lg:justify-start items-center space-x-2 mt-4 hover:translate-x-2 transition-transform duration-300">
                                <i className="fa fa-phone text-blue-600" />{" "}
                                <a
                                    href="tel:0345456544"
                                    className="transition duration-300 text-sm font-medium hover:text-blue-600"
                                >
                                    0345456544 - 0345456545
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="mt-8 text-center">
                <p className="flex justify-center items-center text-sm font-bold text-gray-600 hover:text-blue-600 transition-colors">
                    College Sysedu © {new Date().getFullYear()}, All Rights
                    Reserved
                </p>
            </div>
        </footer>
    );
}

export default FooterBlog;
