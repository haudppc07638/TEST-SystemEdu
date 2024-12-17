import React, { useState } from "react";
import Logo from "../../Assets/Images/logo.png";

function Header() {
    const [isSearchVisible, setIsSearchVisible] = useState(false);

    const toggleSearch = () => {
        setIsSearchVisible(!isSearchVisible);
    };

    return (
        <div>
            <div className="bg-white h-20 px-4 md:px-16 py-6 mx-auto flex justify-between items-center space-x-8">
                <div className="flex items-center">
                    <a href="/home">
                        <img
                            src={Logo}
                            alt="Logo"
                            className="h-[50px] md:h-[70px] transform transition duration-300"
                        />
                    </a>
                </div>
                <nav className="hidden md:flex space-x-6 md:space-x-8">
                    <a
                        href="/general-introduction"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        GIỚI THIỆU CHUNG
                    </a>
                    <a
                        href="/admissions"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        THÔNG TIN TUYỂN SINH
                    </a>
                    <a
                        href="/"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        ĐĂNG KÍ ONLINE
                    </a>
                    <a
                        href="/"
                        className="text-blue-600 hover:text-blue-300 transition duration-300 text-sm font-medium"
                    >
                        HOTLINE: 0345456544
                    </a>
                    <div className="relative flex items-center">
                        <button className="text-sm px-2" onClick={toggleSearch}>
                            <i className="text-blue-600 fa fa-search" />
                        </button>
                    </div>
                </nav>
            </div>

            {isSearchVisible && (
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
        </div>
    );
}

export default Header;
