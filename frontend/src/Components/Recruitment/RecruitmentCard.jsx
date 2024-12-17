import React from "react";
import RecruitmentBanner from "../../Assets/Images/recruiment-banner.png";

function RecruitmentCard() {
    return (
        <div className="container mx-auto py-16">
            <h2 className="text-3xl text-black font-bold text-center mb-8">
                Tuyển dụng
            </h2>
            <div className="flex flex-col md:flex-row items-start border-t pt-6 space-y-4 md:space-y-0">
                <div className="md:w-1/2 px-4 mt-4">
                    <h3 className="text-2xl font-semibold text-blue-600 mb-2">
                        Chuyên Ngành Lập Trình Web CDS “Web Developer”
                    </h3>
                    <p className="text-gray-600 text-justify">
                        Chuyên ngành Lập Trình Web tại CDS cung cấp kiến thức và
                        kỹ năng thực hành cần thiết để phát triển các ứng dụng
                        web hiện đại. Sinh viên sẽ được học về HTML, CSS,
                        JavaScript và nhiều công nghệ khác, chuẩn bị cho sự
                        nghiệp trở thành một Web Developer chuyên nghiệp.
                    </p>
                    <button className="mt-4 px-4 py-2 text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition duration-200">
                        Xem thêm...
                    </button>
                </div>

                <div className="md:w-1/2 px-4">
                    <img
                        src={RecruitmentBanner}
                        alt="Recruitment Banner"
                        className="w-full h-100 shadow-md"
                    />
                </div>
            </div>
        </div>
    );
}

export default RecruitmentCard;
