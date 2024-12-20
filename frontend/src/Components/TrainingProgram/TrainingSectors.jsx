import React, { useState, useEffect } from "react";
import axios from "axios";

function TrainingSectors() {
  const [majors, setPrograms] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchPrograms = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/majors/list");
        setPrograms(response.data);
      } catch (err) {
        setError(err.message);
      } 
    };

    fetchPrograms();
  }, []);

  if (error) {
    return (
      <p className="text-center py-16 text-red-500">Đã xảy ra lỗi: {error}</p>
    );
  }

  return (
    <div className="container mx-auto py-16">
      <h2 className="text-3xl text-black font-bold text-center mb-8">
        Chương trình đào tạo
      </h2>
      <div className="pt-6 px-4">
        <table className="table-auto w-full border-collapse border border-gray-200">
          <thead>
            <tr className="bg-gray-100">
              <th className="border border-gray-300 px-4 py-2 text-center">
                Số thứ tự ngành
              </th>
              <th className="border border-gray-300 px-4 py-2 text-center">
                Tên ngành đào tạo
              </th>
              <th className="border border-gray-300 px-4 py-2 text-center">
                Mã ngành học
              </th>
              <th className="border border-gray-300 px-4 py-2 text-center">
                Số tín chỉ
              </th>
            </tr>
          </thead>
          <tbody>
            {majors.map((major) => (
              <tr key={major.id} className="hover:bg-gray-50">
                <td className="border border-gray-300 px-4 py-2 text-center">
                  {major.id}
                </td>
                <td className="border border-gray-300 px-4 py-2">
                  {major.name}
                </td>
                <td className="border border-gray-300 px-4 py-2 text-center">
                  {major.code}
                </td>
                <td className="border border-gray-300 px-4 py-2 text-center">
                  {major.total_credits} tín chỉ
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default TrainingSectors;
