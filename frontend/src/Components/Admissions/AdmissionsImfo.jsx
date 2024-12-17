import React from "react";
import { Link, Element } from "react-scroll";

function AdmissionInfo() {
    return (
        <div className="bg-gray-200 p-10">
            <div className="text-center mb-6">
                <h1 className="text-blue-600 text-2xl font-bold uppercase">
                    Trường Cao đẳng SysEdu Tuyển Sinh Năm 2025
                </h1>
                <h2 className="text-black text-3xl font-bold mt-4">
                    Tuyển sinh khóa K17
                </h2>
            </div>

            <div className="container mx-auto py-4 px-4">
                <div className="flex space-x-4 bg-gray-100 p-4 rounded-lg">
                    <Link
                        to="section1"
                        smooth={true}
                        duration={500}
                        offset={-100}
                        className="cursor-pointer p-6 font-bold text-black hover:text-white hover:bg-blue-600"
                    >
                        Thời gian
                    </Link>
                    <Link
                        to="section2"
                        smooth={true}
                        duration={500}
                        offset={-100}
                        className="cursor-pointer p-6 font-bold text-black hover:text-white hover:bg-blue-600"
                    >
                        Chuyên ngành
                    </Link>
                    <Link
                        to="section3"
                        smooth={true}
                        duration={500}
                        offset={-100}
                        className="cursor-pointer p-6 font-bold text-black hover:text-white hover:bg-blue-600"
                    >
                        Hồ sơ nhập học
                    </Link>
                    <Link
                        to="section4"
                        smooth={true}
                        duration={500}
                        offset={-100}
                        className="cursor-pointer p-6 font-bold text-black hover:text-white hover:bg-blue-600"
                    >
                        Học phí
                    </Link>
                    <Link
                        to="section5"
                        smooth={true}
                        duration={500}
                        offset={-100}
                        className="cursor-pointer p-6 font-bold text-black hover:text-white hover:bg-blue-600"
                    >
                        Thông tin chuyển khoản
                    </Link>
                </div>

                <div className="mt-4">
                    <div className="sroll">
                        <Element
                            name="section1"
                            className="p-4 bg-white rounded-lg shadow-md"
                        >
                            <h2 className="text-lg font-bold text-blue-600">
                                Thời gian đào tạo
                            </h2>
                            <p className="mt-4 px-6 text-justify">
                                Chương trình đào tạo kéo dài 3 năm, chia thành 7
                                học kỳ. Giúp sinh viên tiếp cận và nắm vững kiến
                                thức chuyên sâu trong lĩnh vực chuyên môn. Mỗi
                                học kỳ được thiết kế nhằm trang bị cho sinh viên
                                những kỹ năng cần thiết để áp dụng vào thực tế
                                công việc sau khi tốt nghiệp. Trong suốt khóa
                                học, sinh viên sẽ được học các môn lý thuyết cơ
                                bản và nâng cao, kết hợp với các buổi thực hành
                                và dự án thực tế giúp củng cố và phát triển kỹ
                                năng giải quyết vấn đề, tư duy sáng tạo và khả
                                năng làm việc nhóm. Ngoài ra, chương trình đào
                                tạo cũng chú trọng đến các kỹ năng mềm như giao
                                tiếp, quản lý thời gian, kỹ năng thuyết trình và
                                lãnh đạo, giúp sinh viên tự tin và chủ động
                                trong công việc. Bằng cách áp dụng phương pháp
                                học tập hiện đại, kết hợp giữa lý thuyết và thực
                                hành, sinh viên sẽ được chuẩn bị tốt nhất để đáp
                                ứng yêu cầu của các nhà tuyển dụng trong ngành
                                nghề đã chọn. Chương trình cũng giúp sinh viên
                                có cơ hội thực tập tại các doanh nghiệp, tạo
                                dựng mối quan hệ và tích lũy kinh nghiệm thực tế
                                quý báu.
                            </p>
                        </Element>

                        <Element
                            name="section2"
                            className="mt-6 p-4 bg-white rounded-lg shadow-md"
                        >
                            <h2 className="text-lg font-bold text-blue-600">
                                Chuyên ngành đào tạo
                            </h2>
                            <p className="mt-4 px-6 text-justify">
                                Các chuyên ngành đào tạo tại trường được thiết
                                kế một cách đa dạng và linh hoạt, nhằm đáp ứng
                                đầy đủ nhu cầu ngày càng cao của thị trường lao
                                động và các xu hướng nghề nghiệp hiện đại. Những
                                chuyên ngành này không chỉ chú trọng vào việc
                                trang bị kiến thức lý thuyết vững vàng mà còn
                                kết hợp chặt chẽ với thực hành, giúp sinh viên
                                có thể áp dụng ngay vào công việc thực tế. Các
                                chương trình đào tạo này giúp sinh viên nắm vững
                                các kỹ năng cần thiết, từ các kỹ thuật chuyên
                                môn cho đến các kỹ năng mềm như giao tiếp, làm
                                việc nhóm và giải quyết vấn đề. Thông tin chi
                                tiết về từng chuyên ngành sẽ là cơ sở để sinh
                                viên có thể định hướng rõ ràng về lĩnh vực mình
                                yêu thích, từ đó xác định được con đường phát
                                triển lâu dài và bền vững. Những chuyên ngành
                                này không chỉ mang lại cơ hội việc làm mà còn mở
                                ra nhiều tiềm năng để phát triển nghề nghiệp
                                trong tương lai.
                            </p>
                        </Element>

                        <Element
                            name="section3"
                            className="mt-6 p-4 bg-white rounded-lg shadow-md"
                        >
                            <h2 className="text-lg font-bold text-blue-600">
                                Hồ sơ nhập học
                            </h2>
                            <ul className="list-disc px-8 mt-4">
                                <li>Đơn đăng ký nhập học</li>
                                <li>
                                    Bản sao giấy khai sinh hoặc chứng minh nhân
                                    dân (có công chứng)
                                </li>
                                <li>
                                    Bằng tốt nghiệp hoặc giấy chứng nhận tốt
                                    nghiệp (bản sao có công chứng)
                                </li>
                                <li>
                                    Bản sao học bạ THPT hoặc bảng điểm học kỳ
                                    cuối cùng (có công chứng)
                                </li>
                                <li>Ảnh chân dung (3x4)</li>
                                <li>
                                    Khoản học phí cần thanh toán cho kì đầu tiên
                                </li>
                            </ul>
                        </Element>

                        <Element
                            name="section4"
                            className="mt-6 p-4 bg-white rounded-lg shadow-md"
                        >
                            <h2 className="text-lg font-bold text-blue-600">
                                Học phí
                            </h2>
                            <div className="px-6">
                                <p className="mt-4">
                                    Chi phí học tập được cập nhật cho từng khóa
                                    học và có thể thay đổi tùy theo chuyên
                                    ngành.
                                    <br />
                                    Thông tin chi tiết về mức học phí, các khoản
                                    đóng góp sẽ được cung cấp cụ thể, hỗ trợ
                                    sinh viên và phụ huynh dễ dàng nắm bắt và
                                    chuẩn bị.
                                </p>
                                <ul className="list-disc pl-5 mt-4">
                                    <li>
                                        <strong>Học phí:</strong> Học phí mỗi
                                        học kỳ: <strong>4,000,000 VND</strong> -
                                        Tổng số học kỳ: 7 học kỳ. Tổng học phí
                                        trong 3 năm:{" "}
                                        <strong>28,000,000 VND</strong>
                                    </li>
                                    <li>
                                        <strong>Phí cơ sở vật chất:</strong> Phí
                                        mỗi học kỳ: <strong>500,000 VND</strong>{" "}
                                        - Tổng phí cơ sở vật chất trong 3 năm:{" "}
                                        <strong>3,500,000 VND</strong>
                                    </li>
                                    <li>
                                        <strong>Phí bảo hiểm y tế:</strong> Phí
                                        mỗi năm học:{" "}
                                        <strong>300,000 VND</strong> - Tổng phí
                                        bảo hiểm y tế trong 3 năm:{" "}
                                        <strong>900,000 VND</strong>
                                    </li>
                                    <li>
                                        <strong>Phí thực hành và dự án:</strong>{" "}
                                        Phí mỗi học kỳ:{" "}
                                        <strong>1,000,000 VND</strong> - Tổng
                                        phí thực hành trong 3 năm:{" "}
                                        <strong>7,000,000 VND</strong>
                                    </li>
                                    <li>
                                        <strong>
                                            Phí các hoạt động ngoại khóa và
                                            nghiên cứu khoa học:
                                        </strong>{" "}
                                        Phí mỗi năm học:{" "}
                                        <strong>200,000 VND</strong> - Tổng phí
                                        hoạt động ngoại khóa trong 3 năm:{" "}
                                        <strong>600,000 VND</strong>
                                    </li>
                                    <li>
                                        <strong>
                                            Phí tốt nghiệp và cấp bằng:
                                        </strong>{" "}
                                        Phí một lần khi tốt nghiệp:{" "}
                                        <strong>1,500,000 VND</strong>
                                    </li>
                                </ul>
                                <h4 className="text-md font-semibold mt-4">
                                    Tổng cộng các khoản thanh toán:
                                </h4>
                                <p className="mt-2">
                                    <strong>
                                        Tổng số tiền cần thanh toán trong 3 năm
                                        học: 41,500,000 VND
                                    </strong>
                                </p>
                            </div>
                        </Element>

                        <Element
                            name="section5"
                            className="mt-6 p-4 bg-white rounded-lg shadow-md"
                        >
                            <h2 className="text-lg font-bold text-blue-600">
                                Thông tin chuyển khoản
                            </h2>
                            <ul className="list-disc px-8 mt-4">
                                <li>Tên tài khoản: [Cao đẳng SYSEDU]</li>
                                <li>Số tài khoản: [234245598685454]</li>
                                <li>Ngân hàng: [ACB]</li>
                                <li>
                                    Nội dung chuyển khoản: "Họ tên - Mã sinh
                                    viên - Học phí kỳ [X]"
                                </li>
                            </ul>
                        </Element>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AdmissionInfo;
