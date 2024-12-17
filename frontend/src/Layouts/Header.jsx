import React, { useState, useEffect } from "react";
import logo from "../Assets/Images/logo.png";

function Header() {
    const [isVisible, setIsVisible] = useState(false);
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const [isSearchVisible, setIsSearchVisible] = useState(false);
    const [isFormVisible, setIsFormVisible] = useState(false);

    const handleScroll = () => {
        const currentScrollPos = window.scrollY;
        if (currentScrollPos > 50) {
            setIsVisible(true);
        } else {
            setIsVisible(false);
        }
    };

    const toggleMenu = () => {
        setIsMenuOpen(!isMenuOpen);
    };

    const toggleSearch = () => {
        setIsSearchVisible(!isSearchVisible);
        setIsFormVisible(!isFormVisible);
    };

    useEffect(() => {
        window.addEventListener("scroll", handleScroll);
        return () => {
            window.removeEventListener("scroll", handleScroll);
        };
    }, []);

    return (
        <header
            className={`fixed top-0 left-0 w-full transition-transform duration-300 ease-in-out z-50 ${
                isVisible ? "translate-y-0" : "-translate-y-full"
            }`}
            style={{
                backgroundColor: "white",
                zIndex: 9999,
            }}
        >
            <div className="h-20 px-4 md:px-16 py-6 mx-auto flex justify-between items-center space-x-8">
                <div className="flex items-center">
                    <a href="/home">
                        <img
                            src={logo}
                            alt="Logo"
                            className="h-[50px] md:h-[70px] transform transition duration-300"
                        />
                    </a>
                </div>
                <button
                    className="md:hidden text-blue-600 focus:outline-none"
                    onClick={toggleMenu}
                >
                    <i
                        className={`fas ${isMenuOpen ? "fa-times" : "fa-bars"} text-2xl`}
                    ></i>
                </button>
                <nav className="hidden md:flex space-x-6 md:space-x-8">
                    <a
                        href="/home"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        TRANG CHỦ
                    </a>
                    <a
                        href="/admissions"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        TUYỂN SINH
                    </a>
                    <a
                        href="/recruitment"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        TUYỂN DỤNG
                    </a>
                    <a
                        href="/training-program"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        CHƯƠNG TRÌNH ĐÀO TẠO
                    </a>
                    <a
                        href="/general-introduction"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        GIỚI THIỆU CHUNG
                    </a>
                    <a
                        href="/"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        HOẠT ĐỘNG SV
                    </a>
                    <a
                        href="/"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        TIN TỨC
                    </a>
                    <a
                        href="/contacts"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        LIÊN HỆ
                    </a>
                    <div className="relative flex items-center">
                        <button className="text-sm px-2" onClick={toggleSearch}>
                            <i className="text-blue-600 fa fa-search" />
                        </button>
                    </div>
                </nav>
            </div>

            {isMenuOpen && (
                <div className="md:hidden bg-whiter absolute top-20 left-30 right-5 z-50 shadow-lg">
                    <nav className="flex flex-col px-6 space-y-4 py-4">
                        <a
                            href="/home"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            TRANG CHỦ
                        </a>
                        <a
                            href="/admissions"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            TUYỂN SINH
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            TUYỂN DỤNG
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            CHƯƠNG TRÌNH ĐÀO TẠO
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            GIỚI THIỆU CHUNG
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            HOẠT ĐỘNG SV
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            TIN TỨC
                        </a>
                        <a
                            href="/"
                            className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                        >
                            LIÊN HỆ
                        </a>
                    </nav>
                </div>
            )}

            {isFormVisible && (
                <div className="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-end items-start top-17 z-50 right-10 p-4">
                    <form className="bg-whiter p-6 rounded shadow-lg">
                        <input
                            type="text"
                            placeholder=" Tìm kiếm từ khóa..."
                            className="rounded bg-white text-sm p-2 border focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
                            style={{ width: "300px" }}
                        />
                        <div className="flex justify-end">
                            <button
                                type="submit"
                                className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-white hover:text-blue-600 hover: border"
                            >
                                Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            )}
        </header>
    );
}

export default Header;
