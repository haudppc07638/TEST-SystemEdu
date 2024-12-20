import React, { useEffect, useState } from "react";
import blog1 from "../../Assets/Images/blog1.jpg";
import blog2 from "../../Assets/Images/blog2.jpg";
import axios from "axios";

function BlogHome() {
  const [news, setNews] = useState([]);
  const [error, setError] = useState(null);

  const fetchNews = async () => {
    try {
      const response = await axios.get("http://localhost:8000/news");
      const sortedNews = response.data.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
      setNews(sortedNews);
    } catch (err) {
      setError(err.message);
    }
  };

  useEffect(() => {
    fetchNews();
  }, []);

  const truncateDescription = (description) => {
    const words = description.split(" ");
    if (words.length > 20) {
      return words.slice(0, 20).join(" ") + "...";
    }
    return description;
  };

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString("vi-VN", options);
  };

  return (
    <div className="bg-white mx-auto py-16 flex justify-center">
      <div className="container grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="flex flex-col lg:items-start min-h-full space-y-4">
          <h3 className="text-xl font-bold mb-4">TIN MỚI NHẤT</h3>
          {error && <p className="text-red-600">Đã xảy ra lỗi: {error}</p>}
          {news.length > 0 && (
            <div key={news[0].id} className="mb-4">
              <img
                src={`/images/${news[0].image}`}
                alt="Tin mới nhất"
                className="w-full h-64 object-cover"
              />
              <h3 className="text-blue-600 text-lg font-bold mt-4 text-center lg:text-left">
                {news[0].title
                  ? truncateDescription(news[0].title)
                  : "Chi tiết bài viết"}
              </h3>
              <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
                {news[0].created_at
                  ? formatDate(news[0].created_at)
                  : "Ngày đăng"}
              </p>
            </div>
          )}
          <ul>
            {news.length > 0 &&
              news.slice(0, 2).map((article) => (
                <li key={article.id} className="mb-2">
                  <a
                    href={`/news/${article.id}`}
                    className="text-lg hover:text-blue-600 font-bold text-black"
                  >
                    {article.title
                      ? truncateDescription(article.title)
                      : "Chi tiết bài viết"}
                  </a>
                  <p className="text-gray-500 text-sm">
                    {article.created_at
                      ? formatDate(article.created_at)
                      : "Ngày đăng"}
                  </p>
                </li>
              ))}
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
              Sinh viên SysEdu giành giải nhất cuộc thi khởi nghiệp trẻ
            </h3>
            <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
              18 tháng 10, 2024
            </p>
          </div>
          <ul>
            <li className="mb-2">
              <a
                href="/"
                className="text-lg hover:text-blue-600 font-bold text-black"
              >
                Người tiên phong trong lĩnh vực nghiên cứu robot tại SysEdu
              </a>
              <p className="text-gray-500 text-sm">18 tháng 10, 2024</p>
            </li>
            <li className="mb-2">
              <a
                href="/"
                className="text-lg hover:text-blue-600 font-bold text-black"
              >
                Sinh viên SysEdu tạo ra hệ thống phân tích dữ liệu tự động dựa
                trên Blockchain
              </a>
              <p className="text-gray-500 text-sm">18 tháng 10, 2024</p>
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
              Sinh viên SysEdu chung tay xây dựng nhà tình nghĩa cho người nghèo
            </h3>
            <p className="text-gray-500 text-sm mt-2 text-center lg:text-left">
              18 tháng 10, 2024
            </p>
          </div>
          <ul>
            <li className="mb-2">
              <a
                href="/"
                className="text-lg hover:text-blue-600 font-bold text-black"
              >
                Ngày hội “Hiến máu nhân đạo” tại SysEdu – Một giọt máu, triệu
                tấm lòng
              </a>
              <p className="text-gray-500 text-sm">18 tháng 10, 2024</p>
            </li>
            <li className="mb-2">
              <a
                href="/"
                className="text-lg hover:text-blue-600 font-bold text-black"
              >
                Hỗ trợ sinh viên vùng sâu vùng xa đến học tập tại SysEdu
              </a>
              <p className="text-gray-500 text-sm">18 tháng 10, 2024</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
}

export default BlogHome;
