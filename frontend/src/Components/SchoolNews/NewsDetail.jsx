import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";

function NewsDetail() {
  const { id } = useParams();
  const [news, setArticle] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchNews = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/news/${id}`);
        setArticle(response.data);
      } catch (err) {
        setError(err.message);
      }
    };
    fetchNews();
  }, [id]);

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString("vi-VN", options);
  };

  if (error)
    return (
      <p className="w-full h-100 mx-auto py-16 text-center text-red-600">
        Đã xảy ra lỗi: {error}
      </p>
    );

  if (!news) {
    return (
      <div className="flex justify-center items-center h-screen">
        <div className="border-t-4 border-blue-500 border-solid rounded-full w-16 h-16 animate-spin"></div>
      </div>
    );
  }

  return (
    <div className="container mx-auto py-16">
      <h2 className="text-3xl text-black font-bold text-center mb-8">
        Chi tiết tin tức
      </h2>

      <div className="flex flex-col md:flex-row items-start border-t pt-6 space-y-4 md:space-y-0">
        <div className="md:w-1/2 px-4 mt-4">
          <h3 className="text-2xl font-semibold text-blue-600 mb-2">
            {news.title}
          </h3>
          <p className="text-gray-600 text-justify mt-2">
            Ngày đăng: {formatDate(news.created_at)}
          </p>
          <p
            className="text-gray-600 text-lg font-medium text-justify"
            dangerouslySetInnerHTML={{ __html: news.content }}
          ></p>
        </div>

        <div className="md:w-1/2 px-4">
          <img
            src={`/images/${news.image}`}
            alt={news.title}
            className="w-full h-100 shadow-md"
          />
        </div>
      </div>
    </div>
  );
}

export default NewsDetail;
