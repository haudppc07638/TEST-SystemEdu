import React from "react";
import bgschools from "../../Assets/Images/school.jpg";
import student from "../../Assets/Images/iconstudent.png";
import certification from "../../Assets/Images/iconchungnhan.png";
import base from "../../Assets/Images/iconcoso.png";
import branch from "../../Assets/Images/iconchinhanh.png";

function Introduce() {
    return (
        <div
            className="sticky z-50 bg-cover bg-center bg-no-repeat h-[400px] shadow-lg border-t-4 border-white"
            style={{ backgroundImage: `url(${bgschools})` }}
        >
            <div className="absolute inset-0 bg-white bg-opacity-60 flex items-center justify-center">
                <div className="flex flex-col md:flex-row items-center justify-around w-full max-w-6xl p-4">
                    <div className="flex flex-col items-center text-center">
                        <img
                            src={student}
                            alt="student"
                            className="text-red-500 w-[70px]"
                        />
                        <h3 className="text-2xl text-blue-600 font-bold mt-3">
                            99.99%
                        </h3>
                        <p className=" text-blue-600">Sinh viên có việc làm</p>
                    </div>
                    <div className="flex flex-col items-center text-center">
                        <img
                            src={certification}
                            alt="certification"
                            className="text-red-500 w-[70px]"
                        />
                        <h3 className="text-2xl text-blue-600 font-bold mt-3">
                            1.000+
                        </h3>
                        <p className=" text-blue-600">
                            Có doanh nghiệp đối tác
                        </p>
                    </div>
                    <div className="flex flex-col items-center text-center">
                        <img
                            src={base}
                            alt="base"
                            className="text-red-500 w-[70px]"
                        />
                        <h3 className="text-2xl  text-blue-600 font-bold mt-3">
                            15.000+
                        </h3>
                        <p className=" text-blue-600">
                            Sinh viên & Sinh vên đã ra trường
                        </p>
                    </div>
                    <div className="flex flex-col items-center text-center">
                        <img
                            src={branch}
                            alt="branch"
                            className="text-red-500 w-[70px]"
                        />
                        <h3 className="text-2xl  text-blue-600 font-bold mt-3">
                            1
                        </h3>
                        <p className=" text-blue-600">Cơ sở đào tạo Cần Thơ</p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Introduce;
