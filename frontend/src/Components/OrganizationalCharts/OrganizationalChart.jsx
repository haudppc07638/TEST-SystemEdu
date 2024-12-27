import React, { useState, useEffect } from "react";
import axios from "axios";

function OrganizationalCharts() {
  const [departments, setDepartments] = useState([]);
  const [error, setError] = useState(null);

  const fetchDepartments = async () => {
    try {
      const response = await axios.get("http://127.0.0.1:8000/departments/list");
      setDepartments(response.data.data || []);  
    } catch (err) {
      setError(err.message);
    }
  };

  useEffect(() => {
    fetchDepartments();
  }, []);

  if (error)
    return (
      <p className="w-full h-100 mx-auto py-16 text-center text-red-600">
        Đã xảy ra lỗi: {error}
      </p>
    );

  if (departments.length === 0) {
    return (
      <div className="flex justify-center items-center h-screen">
        <div className="border-t-4 border-blue-500 border-solid rounded-full w-16 h-16 animate-spin"></div>
      </div>
    );
  }

  return (
    <div className="container mx-auto py-16">
      <h2 className="text-4xl text-black font-extrabold text-center mb-12">
        Sơ đồ tổ chức của trường
      </h2>

      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 p-4">
        {departments.map((department) => (
          <div
            key={department.id}
            className="bg-blue-500 text-white flex flex-col justify-center items-center h-48 p-6 rounded-xl"
          >
            <h3 className="text-2xl font-semibold mb-4">{department.name}</h3>
            <p className="text-lg">{department.location}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default OrganizationalCharts;
