import React, { useState, useEffect } from "react";
import Logo from "../../Assets/Images/logo.png";
import banner from "../../Assets/Images/banner3.jpg";
import banner1 from "../../Assets/Images/banner1.jpg";
import banner2 from "../../Assets/Images/banner2.jpg";

function BannerTop() {
    const [currentBanner, setCurrentBanner] = useState(0);
    const [isSearchVisible, setIsSearchVisible] = useState(false);
    const banners = [banner, banner1, banner2];

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentBanner((prevBanner) => (prevBanner + 1) % banners.length);
        }, 3000);
        return () => clearInterval(interval);
    }, [banners.length]);

    const toggleSearch = () => {
        setIsSearchVisible(!isSearchVisible);
    };

    return (
        <div
            className="sticky z-50 bg-cover bg-center bg-no-repeat h-[700px] shadow-lg"
            style={{ backgroundImage: `url(${banners[currentBanner]})` }}
        >
            <div className="flex justify-end space-x-6 py-4 px-16 border-b">
                <div className="flex items-center space-x-2">
                    <i className="text-white fa fa-envelope" />{" "}
                    <a
                        href="mail:caodangsysedu@gmail.com"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        caodangsysedu@gmail.com
                    </a>
                </div>

                <div className="flex items-center space-x-2">
                    <i className="text-white fa fa-phone" />{" "}
                    <a
                        href="tel:0345456544"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        0345456544 - 0345456545
                    </a>
                </div>

                <div className="relative">
                    {isSearchVisible && (
                        <input
                            type="text"
                            placeholder=" Tìm kiếm thông tin..."
                            className="rounded bg-white text-sm p-0 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style={{ width: "200px" }}
                        />
                    )}
                    <button
                        className="text-white text-sm px-2"
                        onClick={toggleSearch}
                    >
                        <i className="text-white fa fa-search" />{" "}
                    </button>
                </div>
            </div>

            <div className=" h-20 px-16 py-14 mx-auto flex justify-center items-center bg-opacity-50 space-x-8">
                <div className="flex items-center">
                    <a href="/home">
                        <img
                            src={Logo}
                            alt="Logo Sysedu"
                            className="h-[80px] transform transition duration-300"
                        />
                    </a>
                </div>

                <nav className="hidden md:flex space-x-8">
                    <a
                        href="/home"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        TRANG CHỦ
                    </a>
                    <a
                        href="/admissions"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        TUYỂN SINH
                    </a>
                    <a
                        href="/recruitment"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        TUYỂN DỤNG
                    </a>
                    <a
                        href="/training-program"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        CHƯƠNG TRÌNH ĐÀO TẠO
                    </a>
                    <a
                        href="/general-introduction"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        GIỚI THIỆU CHUNG
                    </a>
                    <a
                        href="/news"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        TIN TỨC
                    </a>
                    <a
                        href="/contacts"
                        className="text-white hover:text-blue-500 transition duration-300 text-sm font-medium"
                    >
                        LIÊN HỆ
                    </a>
                </nav>
            </div>
        </div>
    );
}

export default BannerTop;
