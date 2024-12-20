import React, { useState, useEffect } from "react";
import Job from "../../Assets/Images/tuyendungbanner.jpg";
import axios from "axios";

const sidebarItems = [
  { id: 1, text: "Thông báo tuyển sinh", icon: "fa-bell" },
  { id: 2, text: "Chương trình đào tạo", icon: "fa-graduation-cap" },
  { id: 3, text: "Quy chế tuyển sinh", icon: "fa-book" },
  { id: 4, text: "Phiếu đăng kí học", icon: "fas fa-file-text" },
  { id: 5, text: "Hướng dẫn nhập học", icon: "fa-info-circle" },
  { id: 6, text: "Học phí", icon: "fa fa-university" },
  { id: 7, text: "Câu hỏi thường gặp", icon: "fa-question-circle" },
];

function RelatedNews() {
  const [news, setNews] = useState([]);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const postsPerPage = 6;

  const fetchNews = async () => {
    try {
      const response = await axios.get("http://localhost:8000/news");
      setNews(response.data);
    } catch (err) {
      setError(err.message);
    }
  };

  useEffect(() => {
    fetchNews();
  }, []);

  const indexOfLastPost = currentPage * postsPerPage;
  const indexOfFirstPost = indexOfLastPost - postsPerPage;
  const currentPosts = news.slice(indexOfFirstPost, indexOfLastPost);
  const totalPages = Math.ceil(news.length / postsPerPage);

  const handlePageClick = (page) => setCurrentPage(page);

  const pageNumbers = Array.from(
    { length: totalPages },
    (_, index) => index + 1
  );

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString("vi-VN", options);
  };

  return (
    <div className="container mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
      <div className="lg:col-span-2">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {error && (
            <div className="text-red-600 text-center mb-4">
              Đã xảy ra lỗi: {error}
            </div>
          )}
          {currentPosts.map((post) => (
            <div
              key={post.id}
              className="flex flex-col p-4 shadow-md rounded-lg items-start bg-white hover:shadow-lg transition-shadow duration-300"
            >
              <img
                src={`/images/${post.image}`} 
                alt={post.title}
                className="w-full h-60 object-cover mb-4 rounded-md"
              />
              <h3 className="text-lg font-semibold text-blue-700 mb-2">
                {post.title}
              </h3>
              <h3 className="text-sm mb-2">
                Ngày đăng: {formatDate(post.created_at)}
              </h3>
              <p className="text-gray-600 text-sm mb-2 line-clamp-3 text-justify">
                {post.description}
              </p>
              <a
                href={`/news/${post.id}`}
                className="text-blue-600 hover:text-blue-500 text-sm mt-auto"
              >
                Xem thêm...
              </a>
            </div>
          ))}
        </div>

        <div className="flex justify-center text-sm mt-8 space-x-2">
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
            {news.slice(0,5).map((news) => (
              <li
                key={news.id}
                className="hover:translate-x-2 transition-transform duration-200"
              >
                <a
                  href={news.link}
                  className="text-sm text-gray-700 hover:text-blue-600 transition-colors duration-200 flex items-center"
                >
                  <span className="text-blue-500 mr-2">►</span>
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

export default RelatedNews;
