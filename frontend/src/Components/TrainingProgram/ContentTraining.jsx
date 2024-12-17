import React from "react";
import WebDeveloper from "../../Assets/Images/laptrinhweb.jpg";
import GameDeveloper from "../../Assets/Images/laptrinhgame.jpg";
import SoftwareProgramming from "../../Assets/Images/laptrinhphanmem.jpg";
import SecuritySystem from "../../Assets/Images/hethongbaomat.jpg";
import ComputerProgramming from "../../Assets/Images/lapttinhmaytinh.jpg";
import NetworkEngineering from "../../Assets/Images/kythuatmang.jpeg";
import DigitalMarketing from "../../Assets/Images/maketting.jpg";
import MaketingSale from "../../Assets/Images/maketting-sale.jpg";
import MaketingTT from "../../Assets/Images/maketting-truyen-thong.jpg";
import Logistic from "../../Assets/Images/logistic.jpg";
import MechanicalSystemDesign from "../../Assets/Images/co-khi-che-tao-may.jpg";
import MachineManufacturingTechnology from "../../Assets/Images/cong-nghe-che-tao-may.png";
import MachiningTechniques from "../../Assets/Images/ky-thuat-gia-cong.jpg";
import ElectromeChanical from "../../Assets/Images/co-dien-tu.jpg";
import HotelServiceManagement from "../../Assets/Images/quan-tri-ks.jpg";
import RestaurantManagement from "../../Assets/Images/quan-ly-nha-hang.jpg";
import OrganizeEvents from "../../Assets/Images/su-kien-nha-hang.jpg";
import AccommodationServices from "../../Assets/Images/quan-ly-luu-tru.jpg";

const programs = [
    {
        category: "Lập trình",
        items: [
            {
                title: "Lập trình Website",
                imageUrl: WebDeveloper,
            },
            {
                title: "Lập trình Game",
                imageUrl: GameDeveloper,
            },
            {
                title: "Lập trình phần mềm",
                imageUrl: SoftwareProgramming,
            },
            {
                title: "Thiết kế hệ thống bảo mật",
                imageUrl: SecuritySystem,
            },
            {
                title: "Lập trình máy tính",
                imageUrl: ComputerProgramming,
            },
            {
                title: "Kỹ thuật mạng",
                imageUrl: NetworkEngineering,
            },
        ],
    },
    {
        category: "Quản trị kinh doanh",
        items: [
            {
                title: "Digital Marketing",
                imageUrl: DigitalMarketing,
            },
            {
                title: "Marketing & Sales",
                imageUrl: MaketingSale,
            },
            {
                title: "Truyền thông & Tổ chức sự kiện",
                imageUrl: MaketingTT,
            },
            {
                title: "Logistics",
                imageUrl: Logistic,
            },
        ],
    },
    {
        category: "Cơ khí chế tạo",
        items: [
            {
                title: "Thiết kế hệ thống cơ khí",
                imageUrl: MechanicalSystemDesign,
            },
            {
                title: "Công nghệ chế tạo máy",
                imageUrl: MachineManufacturingTechnology,
            },
            {
                title: "Kỹ thuật gia công",
                imageUrl: MachiningTechniques,
            },
            {
                title: "Cơ điện tử",
                imageUrl: ElectromeChanical,
            },
        ],
    },
    {
        category: "Quản trị khách sạn",
        items: [
            {
                title: "Quản lý dịch vụ khách sạn",
                imageUrl: HotelServiceManagement,
            },
            {
                title: "Quản lý nhà hàng",
                imageUrl: RestaurantManagement,
            },
            {
                title: "Tổ chức sự kiện",
                imageUrl: OrganizeEvents,
            },
            {
                title: "Dịch vụ lưu trú",
                imageUrl: AccommodationServices,
            },
        ],
    },
];

function ContentTraining() {
    return (
        <div className="container mx-auto py-16">
            <h2 className="text-3xl text-black font-bold text-center mb-8">
                Chương trình đào tạo
            </h2>
            <div className="border-t pt-6 px-4">
                {programs.map((program, index) => (
                    <div key={index} className="mb-12">
                        <h3 className="text-2xl mb-4 mt-5 font-semibold text-blue-600">
                            Ngành: {program.category}
                        </h3>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {program.items.map((item, id) => (
                                <div
                                    key={id}
                                    className="relative group overflow-hidden bg-white shadow-md rounded-lg transition-transform transform hover:scale-105"
                                >
                                    <img
                                        src={item.imageUrl}
                                        alt={item.title}
                                        className="w-full h-50 object-cover rounded-md"
                                    />
                                    <div className="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <h4 className="text-xl font-bold text-white mb-4">
                                            {item.title}
                                        </h4>
                                        <button className="bg-blue-600 text-white rounded-lg py-2 px-4 hover:bg-blue-500">
                                            Chi tiết
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default ContentTraining;
