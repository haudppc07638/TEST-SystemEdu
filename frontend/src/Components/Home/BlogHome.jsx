import React from "react";
import blog from "../../Assets/Images/blog.jpg";
import blog1 from "../../Assets/Images/blog1.jpg";
import blog2 from "../../Assets/Images/blog2.jpg";

function BlogHome() {
    return (
        <div className="bg-white mx-auto py-16 flex justify-center">
            <div className="container grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div className="flex flex-col lg:items-start min-h-full space-y-4">
                    <h3 className="text-xl font-bold mb-4">TIN MỚI NHẤT</h3>
                    <div className="mb-4">
                        <img
                            src={blog}
                            alt="Tin mới nhất"
                            className="w-full h-64 object-cover"
                        />
                        <h3 className="text-blue-600 text-lg font-bold mt-4 text-center lg:text-left">
                            Sinh viên SysEdu khởi động dự án bảo vệ môi trường
                            bằng công nghệ AI
                        </h3>
                        <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
                            Thứ sáu, 18/10/2024
                        </p>
                    </div>
                    <ul>
                        <li className="mb-2">
                            <a
                                href="/"
                                className="text-lg hover:text-blue-600 font-bold text-black"
                            >
                                SysEdu tổ chức cuộc thi lập trình ứng dụng thực
                                tế ảo (VR)
                            </a>
                            <p className="text-gray-500 text-sm">
                                Thứ sáu, 18/10/2024
                            </p>
                        </li>
                    </ul>
                </div>
                <div className="flex flex-col lg:items-start min-h-full space-y-4">
                    <h3 className="text-xl font-bold mb-4">GƯƠNG MẶT SYS</h3>
                    <div className="mb-4">
                        <img
                            src={blog1}
                            alt="Gương mặt SYS"
                            className="w-full h-64 object-cover"
                        />
                        <h3 className="text-blue-600 text-lg font-bold mt-4 text-center lg:text-left">
                            Sinh viên SysEdu giành giải nhất cuộc thi khởi
                            nghiệp trẻ
                        </h3>
                        <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
                            Thứ sáu, 18/10/2024
                        </p>
                    </div>
                    <ul>
                        <li className="mb-2">
                            <a
                                href="/"
                                className="text-lg hover:text-blue-600 font-bold text-black"
                            >
                                Người tiên phong trong lĩnh vực nghiên cứu robot
                                tại SysEdu
                            </a>
                            <p className="text-gray-500 text-sm">
                                Thứ sáu, 18/10/2024
                            </p>
                        </li>
                        <li className="mb-2">
                            <a
                                href="/"
                                className="text-lg hover:text-blue-600 font-bold text-black"
                            >
                                Sinh viên SysEdu tạo ra hệ thống phân tích dữ
                                liệu tự động dựa trên Blockchain
                            </a>
                            <p className="text-gray-500 text-sm">
                                Thứ sáu, 18/10/2024
                            </p>
                        </li>
                    </ul>
                </div>
                <div className="flex flex-col lg:items-start min-h-full space-y-4">
                    <h3 className="text-xl font-bold mb-4">AN SINH & XÃ HỘI</h3>
                    <div className="mb-4">
                        <img
                            src={blog2}
                            alt="An Sinh & Xã Hội"
                            className="w-full h-64 object-cover"
                        />
                        <h3 className="text-blue-600 text-lg hover:text-blue-600 font-bold mt-4 text-center lg:text-left">
                            Sinh viên SysEdu chung tay xây dựng nhà tình nghĩa
                            cho người nghèo
                        </h3>
                        <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
                            Thứ sáu, 18/10/2024
                        </p>
                    </div>
                    <ul>
                        <li className="mb-2">
                            <a
                                href="/"
                                className="text-lg hover:text-blue-600 font-bold text-black"
                            >
                                Ngày hội “Hiến máu nhân đạo” tại SysEdu – Một
                                giọt máu, triệu tấm lòng
                            </a>
                            <p className="text-gray-500 text-sm">
                                Thứ sáu, 18/10/2024
                            </p>
                        </li>
                        <li className="mb-2">
                            <a
                                href="/"
                                className="text-lg hover:text-blue-600 font-bold text-black"
                            >
                                Hỗ trợ sinh viên vùng sâu vùng xa đến học tập
                                tại SysEdu
                            </a>
                            <p className="text-gray-500 text-sm">
                                Thứ sáu, 18/10/2024
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
}

export default BlogHome;
