import React, { useState, useEffect } from "react";
import axios from "axios";

function News() {
  const [news, setNews] = useState([]);
  const [error, setError] = useState(null);
  const [showMore, setShowMore] = useState(false);

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

  const truncateDescription = (content) => {
    const words = content.split(" ");
    if (words.length > 50) {
      return words.slice(0, 50).join(" ") + "...";
    }
    return content;
  };

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString("vi-VN", options);
  };

  return (
    <div className="container mx-auto py-16">
      <h2 className="text-3xl text-black font-bold text-center mb-8">
        Tin tức mới nhất
      </h2>
      {error && (
        <div className="text-red-600 text-center mb-4">
          Đã xảy ra lỗi: {error}
        </div>
      )}
      {news.length > 0 && (
        <div className="flex flex-col md:flex-row items-start border-t pt-6 space-y-4 md:space-y-0">
          <div className="md:w-1/2 px-4 mt-4">
            <h3 className="text-2xl font-semibold text-blue-600 mb-2">
              {news[0].title}
            </h3>
            <p
              className="text-gray-600 text-lg font-medium text-justify"
              dangerouslySetInnerHTML={{
                __html: showMore
                  ? news[0].content
                  : truncateDescription(news[0]?.content || ""),
              }}
            ></p>
            <p className="text-gray-600 text-justify mt-2">
              Ngày đăng: {formatDate(news[0].created_at)}
            </p>
            <button
              className="mt-4 px-4 py-2 text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition duration-200"
              onClick={() => setShowMore(!showMore)}
            >
              {showMore ? "Ẩn bớt" : "Xem thêm..."}
            </button>
          </div>

          <div className="md:w-1/2 px-4">
            <img
              src={`/images/${news[0].image}`}
              alt={news[0].title}
              className="w-full h-100 shadow-md"
            />
          </div>
        </div>
      )}
    </div>
  );
}

export default News;
