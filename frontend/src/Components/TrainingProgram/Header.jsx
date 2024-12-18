import React, { useState } from "react";
import Logo from "../../Assets/Images/logo.png";

function HeaderTraining() {
    const [isSearchVisible, setIsSearchVisible] = useState(false);
    const [isFormVisible, setIsFormVisible] = useState(false);

    const toggleSearch = () => {
        setIsSearchVisible(!isSearchVisible);
        setIsFormVisible(!isFormVisible);
    };

    return (
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
                    href="/news"
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
        </div>
    );
}

export default HeaderTraining;
