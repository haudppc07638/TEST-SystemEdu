import React, { useState } from "react";

import JobImg1 from "../../Assets/Images/tuyendung1.png";
import JobImg2 from "../../Assets/Images/tuyendung2.png";
import JobImg3 from "../../Assets/Images/tuyendung3.png";
import JobImg4 from "../../Assets/Images/tuyendung4.png";
import JobImg5 from "../../Assets/Images/tuyendung5.png";
import JobImg6 from "../../Assets/Images/tuyendung6.png";
import JobImg7 from "../../Assets/Images/tuyendung7.png";
import Job from "../../Assets/Images/tuyendungbanner.jpg";

const jobPosts = [
    {
        id: 1,
        imageUrl: JobImg1,
        title: "Tuyển dụng TTS Design",
        description:
            "Thông báo tuyển dụng vị trí Thực tập sinh Design (Mã TD1815) Bạn là sinh viên trường Cao đẳng Sysedu đang tìm kiếm việc làm?",
        link: "#",
    },
    {
        id: 2,
        imageUrl: JobImg2,
        title: "Tuyển dụng TTS Kinh doanh Sapo",
        description:
            "Thông báo tuyển dụng vị trí Thực tập sinh Kinh doanh Sapo (Mã tuyển dụng TD1917) Bạn là sinh viên trường Cao đẳng Sysedu đang tìm kiếm việc làm?",
        link: "#",
    },
    {
        id: 3,
        imageUrl: JobImg3,
        title: "Tuyển dụng Leader Kinh doanh Online",
        description:
            "Thông báo tuyển dụng vị trí Leader Kinh doanh online. Bạn muốn tìm kiếm cơ hội việc làm?",
        link: "#",
    },
    {
        id: 4,
        imageUrl: JobImg4,
        title: "Tuyển dụng nhân viên Sale Admin",
        description:
            "Tuyển dụng vị trí Nhân viên Sale Admin. Bạn mong muốn tìm kiếm cơ hội việc làm?",
        link: "#",
    },
    {
        id: 5,
        imageUrl: JobImg5,
        title: "Tuyển dụng TTS Phát triển đối tác Amazon",
        description:
            "Tuyển dụng vị trí TTS Phát triển đối tác Amazon. Bạn là sinh viên Cao đẳng Sysedu và đang muốn tìm kiếm việc làm và phát triển kỹ năng?",
        link: "#",
    },
    {
        id: 6,
        imageUrl: JobImg6,
        title: "Tuyển dụng Nhân viên Kế hoạch sản xuất",
        description:
            "Tuyển dụng vị trí Nhân viên Kế hoạch sản xuất. Bạn là sinh viên Cao đẳng Sysedu và đang muốn tìm kiếm việc làm?",
        link: "#",
    },
    {
        id: 7,
        imageUrl: JobImg7,
        title: "Tuyển dụng TTS Editor",
        description:
            "Tuyển dụng vị trí Thực tập sinh Editor. Bạn là sinh viên Cao đẳng Sysedu và đang muốn phát triển kỹ năng editor?",
        link: "#",
    },
];

const sidebarItems = [
    { id: 1, text: "Thông báo tuyển sinh", icon: "fa-bell" },
    { id: 2, text: "Chương trình đào tạo", icon: "fa-graduation-cap" },
    { id: 3, text: "Quy chế tuyển sinh", icon: "fa-book" },
    { id: 4, text: "Phiếu đăng kí học", icon: "fa-file-text" },
    { id: 5, text: "Hướng dẫn nhập học", icon: "fa-info-circle" },
    { id: 6, text: "Học phí", icon: "fa fa-university" },
    { id: 7, text: "Câu hỏi thường gặp", icon: "fa-question-circle" },
];

const featuredNews = [
    { id: 1, title: "Ngày hội việc làm tại Cao đẳng Sysedu", link: "#" },
    {
        id: 2,
        title: "Thông báo tuyển dụng TTS tại Công ty Công nghệ CND Quận 7 TP.Hồ Chí Minh",
        link: "#",
    },
    { id: 3, title: "Tuyển dụng nhân viên Thiết kế Content", link: "#" },
    {
        id: 4,
        title: "Tuyển dụng Leader Quản lý sản xuất tại Cty TNHH Samsung",
        link: "#",
    },
];

function JobContent() {
    const [currentPage, setCurrentPage] = useState(1);
    const postsPerPage = 8;
    const indexOfLastPost = currentPage * postsPerPage;
    const indexOfFirstPost = indexOfLastPost - postsPerPage;
    const currentPosts = jobPosts.slice(indexOfFirstPost, indexOfLastPost);
    const totalPages = Math.ceil(jobPosts.length / postsPerPage);

    const handlePageClick = (page) => setCurrentPage(page);

    const pageNumbers = Array.from(
        { length: totalPages },
        (_, index) => index + 1,
    );

    return (
        <div className="container mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            <div className="lg:col-span-2">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {currentPosts.map((post) => (
                        <div
                            key={post.id}
                            className="flex flex-col p-4 shadow-md rounded-lg items-start bg-white hover:shadow-lg transition-shadow duration-300"
                        >
                            <img
                                src={post.imageUrl}
                                alt={post.title}
                                className="w-full h-60 object-cover mb-4 rounded-md"
                            />
                            <h3 className="text-lg font-semibold text-blue-700 mb-2">
                                {post.title}
                            </h3>
                            <p className="text-gray-600 text-sm mb-2 line-clamp-3">
                                {post.description}
                            </p>
                            <a
                                href={post.link}
                                className="text-blue-600 hover:text-blue-500 text-sm mt-auto"
                            >
                                Xem thêm...
                            </a>
                        </div>
                    ))}
                </div>
                <div className="flex justify-center mt-8 space-x-2">
                    {pageNumbers.length > 1 &&
                        pageNumbers.map((page) => (
                            <button
                                key={page}
                                onClick={() => handlePageClick(page)}
                                className={`px-4 py-2 rounded-md ${
                                    page === currentPage
                                        ? "bg-blue-700 text-white"
                                        : "bg-blue-500 text-white hover:bg-blue-600"
                                }`}
                            >
                                {page}
                            </button>
                        ))}
                </div>
            </div>
            <div className="space-y-6">
                <div className="space-y-2">
                    {sidebarItems.map((item) => (
                        <div
                            key={item.id}
                            className="flex items-center justify-between bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-md shadow-sm transition-all duration-300"
                        >
                            <span>{item.text}</span>
                            <span className="text-xl">
                                <i className={`fas ${item.icon}`}></i>
                            </span>
                        </div>
                    ))}
                </div>

                <div className="border-t pt-4 bg-white rounded-lg shadow-md p-4">
                    <h3 className="text-xl font-bold text-blue-700 mb-4 uppercase border-b pb-2">
                        Tin Nổi Bật
                    </h3>
                    <ul className="space-y-3">
                        {featuredNews.map((news) => (
                            <li
                                key={news.id}
                                className="hover:translate-x-2 transition-transform duration-200"
                            >
                                <a
                                    href={news.link}
                                    className="text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center"
                                >
                                    <span className="text-blue-500 mr-2">
                                        ►
                                    </span>
                                    {news.title}
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
                <div className="border-t pt-4 bg-white rounded-lg shadow-md p-4">
                    <h3 className="text-xl font-bold text-blue-700 mb-4 uppercase border-b pb-2">
                        Tuyển Dụng
                    </h3>
                    <img
                        src={Job}
                        alt="Quảng cáo tuyển dụng"
                        className="w-full rounded-lg shadow-md hover:opacity-90 transition-opacity duration-300"
                    />
                </div>
                <div className="border-t pt-4 bg-white rounded-lg shadow-md p-4">
                    <h3 className="text-xl font-bold text-blue-700 mb-4 uppercase border-b pb-2">
                        GIỚI THIỆU SYSEDU
                    </h3>
                    <div className="mt-4">
                        <iframe
                            className="w-[100%] h-[300px]"
                            src="https://www.youtube.com/embed/bZjQq_T1hDE?si=Am9t0aNki8Wb2vHr"
                            title="YouTube Sysedu"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerPolicy="strict-origin-when-cross-origin"
                            allowFullScreen
                            autoPlay
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default JobContent;
