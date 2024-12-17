import React from "react";
import imfomation from "../../Assets/Images/congnghethongtin.jpg";
import automation from "../../Assets/Images/tudonghoa.png";
import tourism from "../../Assets/Images/dulich.jpg";
import restaurant from "../../Assets/Images/nhahang.jpg";
import otherindustry from "../../Assets/Images/nganhkhac.png";

function Content() {
    return (
        <div className="container mx-auto py-16">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 p-8 bg-white rounded-lg">
                <div className="bg-gray p-4">
                    <h2 className="text-xl font-bold mb-4 mt-4">
                        CÁC NGÀNH ĐÀO TẠO
                    </h2>
                    <p className="text-sm text-justify pr-4">
                        Sysedu còn có đội ngũ giảng viên giàu kinh nghiệm, nhiệt
                        huyết và hệ thống cơ sở vật chất hiện đại, đáp ứng đầy
                        đủ nhu cầu học tập và nghiên cứu của sinh viên. Môi
                        trường học tập năng động và sáng tạo tại Sysedu sẽ là
                        nền tảng vững chắc giúp sinh viên tự tin bước vào thị
                        trường lao động đầy cạnh tranh.
                    </p>
                </div>
                <div className="relative overflow-hidden">
                    <img
                        src={imfomation}
                        alt="Công nghệ thông tin"
                        className="w-full h-full inset-0 bg-white bg-opacity-60"
                    />
                    <a
                        href="/"
                        className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                    >
                        <h3 className="text-xl font-bold text-white hover:text-blue-600">
                            CÔNG NGHỆ THÔNG TIN
                        </h3>
                    </a>
                </div>
                <div className="relative overflow-hidden">
                    <img
                        src={automation}
                        alt="Tự động hóa"
                        className="w-full h-full inset-0 bg-white bg-opacity-60"
                    />
                    <a
                        href="/"
                        className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                    >
                        <h3 className="text-xl font-bold text-white hover:text-blue-600">
                            TỰ ĐỘNG HÓA
                        </h3>
                    </a>
                </div>
                <div className="relative overflow-hidden">
                    <img
                        src={restaurant}
                        alt="Ngành nhà hàng"
                        className="w-full h-full inset-0 bg-white bg-opacity-60"
                    />
                    <a
                        href="/"
                        className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                    >
                        <h3 className="text-xl font-bold text-white hover:text-blue-600">
                            NGÀNH NHÀ HÀNG
                        </h3>
                    </a>
                </div>
                <div className="relative overflow-hidden">
                    <img
                        src={tourism}
                        alt="Ngành du lịch"
                        className="w-full h-full inset-0 bg-white bg-opacity-60"
                    />
                    <a
                        href="/"
                        className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                    >
                        <h3 className="text-xl font-bold text-white hover:text-blue-600">
                            NGÀNH DU LỊCH
                        </h3>
                    </a>
                </div>
                <div className="relative overflow-hidden">
                    <img
                        src={otherindustry}
                        alt="Ngành khác"
                        className="w-full h-full inset-0 bg-white bg-opacity-60"
                    />
                    <a
                        href="/"
                        className="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                    >
                        <h3 className="text-xl font-bold text-white hover:text-blue-600">
                            NGÀNH KHÁC...
                        </h3>
                    </a>
                </div>
            </div>
        </div>
    );
}

export default Content;
