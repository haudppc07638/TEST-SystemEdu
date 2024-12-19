import React, { useState, useEffect } from "react";
import axios from "axios";
import CccdFront from "../../Assets/Images/cccd-mattruoc.jpg";
import CccdBack from "../../Assets/Images/cccd-matsau.jpg";
import DiplomaTHPT from "../../Assets/Images/bangtotnghiep.jpg";

function BannerSection() {
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [enrollments, setEnrollments] = useState([]);
  const [error, setError] = useState(null);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const [submitError, setSubmitError] = useState(null);
  const [formData, setFormData] = useState({
    fullName: "",
    dob: "",
    gender: "",
    ethnicity: "",
    idNumber: "",
    issueDate: "",
    issuePlace: "",
    province: "",
    district: "",
    ward: "",
    addressDetail: "",
    phoneNumber: "",
    email: "",
    guardianName: "",
    guardianPhone: "",
    campus: "",
    major1: "",
    method1: "",
    major2: null,
    method2: null,
    year: "",
    graduationProvince: "",
    graduationDistrict: "",
    graduationWard: "",
    student: false,
    guardian: false,
    address:false,
    atschool: false,
    idFront: "",
    idBack: "",
    diploma: "",
  });

  const handleClick = () => {
    setIsModalVisible(true);
  };

  const handleClose = () => {
    setIsModalVisible(false);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  useEffect(() => {
    if (isModalVisible) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "auto";
    }
    return () => {
      document.body.style.overflow = "auto";
    };
  }, [isModalVisible]);

  const fetchEnrollment = async () => {
    try {
      const response = await axios.get("http://127.0.0.1:8000/enrollments");
      setEnrollments(response.data);
    } catch (err) {
      setError(err.message);
    }
  };

  useEffect(() => {
    fetchEnrollment();
  }, []);

  // Hàm lấy CSRF token
  const getCsrfToken = () => {
    const token = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
    return token;
  };

  // Cấu hình axios instance
  const axiosInstance = axios.create({
    baseURL: "http://127.0.0.1:8000", // Thay đổi URL backend của bạn
    headers: {
      "X-CSRF-TOKEN": getCsrfToken(), // Đảm bảo CSRF token được gửi
      "Content-Type": "application/json", // Hoặc multipart/form-data nếu có file
    },
    withCredentials: true, // Đảm bảo gửi cookies với request
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);

    try {
      const csrfToken = getCsrfToken(); // Dùng hàm getCsrfToken() để lấy token
      const formDataToSend = new FormData();

      Object.entries(formData).forEach(([key, value]) => {
        formDataToSend.append(key, value);
      });

      // Gửi request POST với CSRF token và multipart/form-data (nếu có file)
      const response = await axiosInstance.post(
        "/enrollments",
        formDataToSend,
        {
          headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "multipart/form-data",
          },
        }
      );

      setSubmitSuccess(true);
      setSubmitError(null);
      console.log("Form submitted successfully:", response.data);
    } catch (error) {
      setSubmitError(error.response?.data?.message || "Error submitting form.");
      setSubmitSuccess(false);
      console.error("Error submitting form:", error);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="container mx-auto py-16">
      <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="bg-blue-600 text-white p-6 rounded-lg">
          <p>
            Trường Sysedu thông báo tuyển sinh theo phương thức xét tuyển Tốt
            Nghiệp THPT. Thời gian đào tạo 3 năm (7 học kỳ). Sinh viên ra trường
            sẽ nhận bằng Cao đẳng chính quy.
          </p>
          <a href="/" className="text-yellow-400 font-bold mt-4 block">
            Quy chế tuyển sinh {">"}
          </a>
        </div>
        <div className="bg-yellow-400 text-white p-6 rounded-lg">
          <h3 className="text-xl font-bold">Thời gian xét tuyển</h3>
          <p className="mt-4">Thời gian: Tháng 01/2025</p>
          <p className="mt-4">Hotline phòng tư vấn tuyển sinh: 034 5456 544</p>
        </div>
      </div>

      <div className="mt-10 px-6 md:px-16 bg-gray-100 p-6 rounded-lg text-center">
        <h2 className="text-3xl font-bold text-blue-600">
          Bạn đã sẵn sàng cho kì học đầu tiên tại trường Cao đẳng Sysedu !!!
        </h2>
        <button
          className="text-2xl font-bold text-white bg-red-600 p-4 mt-6 inline-flex items-center justify-center gap-2 transform transition-transform duration-200 hover:scale-105 hover:text-white hover:bg-blue-600 rounded-lg mx-auto"
          onClick={handleClick}
        >
          <i className="fas fa-file-upload"></i>
          NỘP HỒ SƠ ONLINE
        </button>
      </div>

      {isModalVisible && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center mt-12 z-50">
          <div className="container bg-white p-8 shadow-lg w-full max-w-6xl max-h-[85vh] overflow-y-auto relative mt-8 rounded-xl">
            <h3 className="text-2xl font-bold text-blue-600 text-center mb-8">
              ĐĂNG KÍ NỘP HỒ SƠ
            </h3>
            <button
              onClick={handleClose}
              className="absolute top-4 right-6 rounded-full w-8 h-8 flex items-center justify-center text-3xl text-gray-500 hover:text-red-600 transition-colors"
            >
              &times;
            </button>
            <form
              onSubmit={handleSubmit}
              className="bg-white p-8 rounded-lg space-y-8 shadow-sm border border-gray-100"
            >
              {/* Thông tin thứ nhất */}
              <section className="bg-gray-50 p-6 rounded-xl">
                <h3 className="text-xl text-blue-600 font-semibold mb-6 flex items-center">
                  <span className="mr-3 text-blue-600 text-2xl">■</span>
                  <span className="flex items-center">THÔNG TIN THÍ SINH</span>
                </h3>

                <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Họ và tên
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="Họ và tên"
                      name="fullName"
                      value={formData.fullName}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Ngày sinh
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      type="date"
                      name="dob"
                      value={formData.dob}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Giới tính
                    </label>
                    <select
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      name="gender"
                      value={formData.gender}
                      onChange={handleChange}
                    >
                      <option value="">Chọn giới tính</option>
                      <option value="Nam">Nam</option>
                      <option value="Nữ">Nữ</option>
                    </select>
                  </div>

                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Dân tộc
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="Dân tộc"
                      name="ethnicity"
                      value={formData.ethnicity}
                      onChange={handleChange}
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Số CCCD/Chứng minh nhân dân
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="Số CCCD/Chứng minh nhân dân"
                      name="idNumber"
                      value={formData.idNumber}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Ngày cấp
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      type="date"
                      name="issueDate"
                      value={formData.issueDate}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Nơi cấp
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="Nơi cấp"
                      name="issuePlace"
                      value={formData.issuePlace}
                      onChange={handleChange}
                    />
                  </div>
                </div>

                <h5 className="text-sm font-semibold text-gray-700 mt-6 mb-4">
                  Địa chỉ thường trú (Điền đầy đủ như trong CMND/CCCD)
                </h5>
                <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                  <div className="w-full">
                    <select
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      name="province"
                      value={formData.province}
                      onChange={handleChange}
                    >
                      <option value="Chọn tỉnh/thành phố">
                        Chọn tỉnh/thành phố
                      </option>
                      <option value="Vĩnh Long">Vĩnh Long</option>
                    </select>
                  </div>
                  <div className="w-full">
                    <select
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      name="district"
                      value={formData.district}
                      onChange={handleChange}
                    >
                      <option value="Chọn Quận/Huyện">Chọn Quận/Huyện</option>
                      <option value="Long Hồ">Long Hồ</option>
                    </select>
                  </div>
                  <div className="w-full">
                    <select
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                      name="ward"
                      value={formData.ward}
                      onChange={handleChange}
                    >
                      <option value="Chọn Xã/Phường/Thị Trấn">
                        Chọn Xã/Phường/Thị Trấn
                      </option>
                      <option value="Đồng Phú">Đồng Phú</option>
                    </select>
                  </div>
                  <div className="w-full">
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="Số nhà, đường, ngõ, ấp"
                      name="addressDetail"
                      value={formData.addressDetail}
                      onChange={handleChange}
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Số điện thoại thí sinh
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="0123456789"
                      name="phoneNumber"
                      value={formData.phoneNumber}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Email thí sinh
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="email"
                      value={formData.email}
                      onChange={handleChange}
                      placeholder="email@example.com"
                      name="email"
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Họ tên phụ huynh/người giám hộ
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      value={formData.guardianName}
                      onChange={handleChange}
                      placeholder="Họ và tên"
                      name="guardianName"
                    />
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Số điện thoại phụ huynh
                    </label>
                    <input
                      className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="0123456789"
                      name="guardianPhone"
                      value={formData.guardianPhone}
                      onChange={handleChange}
                    />
                  </div>
                </div>
              </section>
              {/* Thông tin thứ 2 */}
              <section className="bg-gray-50 p-6 rounded-xl">
                <h3 className="text-xl text-blue-600 font-semibold mb-6 flex items-center">
                  <span className="mr-3 text-blue-600 text-2xl">■</span>
                  THÔNG TIN ĐĂNG KÝ TRƯỜNG CAO ĐẲNG SYSEDU CỦA THÍ SINH
                </h3>
                <div className="w-full mb-6">
                  <label className="block mb-2 font-semibold text-sm text-gray-700">
                    Cơ sở nhập học
                  </label>
                  <select
                    className="w-1/2 border border-gray-300 p-2.5 rounded-lg bg-gray-100 text-gray-500 focus:outline-none cursor-not-allowed"
                    name="Campus"
                    value="Cần Thơ"
                    onChange={handleChange}
                    disabled
                  >
                    <option value="Cần Thơ">Cần Thơ</option>
                  </select>
                </div>

                <div className="space-y-6">
                  <div>
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Nguyện vọng thứ nhất
                    </label>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="major1"
                        value={formData.major1}
                        onChange={handleChange}
                      >
                        <option value="">Chọn ngành</option>
                        {enrollments.map((item) => (
                          <option
                            className="text-black"
                            key={item.id}
                            value={item.first_major_id}
                          >
                            {item.fetchEnrollment?.name || "Tên ngành không có"}
                          </option>
                        ))}
                      </select>
                      {error && <p className="text-red-500 mt-2">{error}</p>}
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="method1"
                        value={formData.method1}
                        onChange={handleChange}
                      >
                        <option value="">Phương thức dự tuyển</option>
                        <option value="hocba">Điểm học bạ</option>
                        <option value="thpt">Điểm thi THPT quốc gia</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Nguyện vọng thứ hai
                    </label>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="major2"
                        value={formData.major2}
                        onChange={handleChange}
                      >
                        <option value="">Chọn ngành</option>
                        {enrollments.map((item) => (
                          <option
                            className="text-black"
                            key={item.id}
                            value={item.first_major_id}
                          >
                            {item.first_major_id?.name || "Tên ngành không có"}
                          </option>
                        ))}
                      </select>

                      {error && <p className="text-red-500 mt-2">{error}</p>}
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="method2"
                        value={formData.method2}
                        onChange={handleChange}
                      >
                        <option value="">Phương thức dự tuyển</option>
                        <option value="hocba">Điểm học bạ</option>
                        <option value="thpt">Điểm thi THPT quốc gia</option>
                      </select>
                    </div>
                  </div>
                  <div className="w-full">
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Năm tốt nghiệp
                    </label>
                    <input
                      className="w-1/2 border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-400 transition-all"
                      type="text"
                      placeholder="2024"
                      name="year"
                      value={formData.year}
                      onChange={handleChange}
                    />
                  </div>
                  <div>
                    <label className="block mb-2 font-semibold text-sm text-gray-700">
                      Nơi tốt nghiệp
                    </label>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="graduationProvince"
                        value={formData.graduationProvince}
                        onChange={handleChange}
                      >
                        <option value="">Chọn Tỉnh/Thành phố</option>
                        <option value="Vinh Long">Vĩnh Long</option>
                      </select>
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="graduationDistrict"
                        value={formData.graduationDistrict}
                        onChange={handleChange}
                      >
                        <option value="">Chọn Quận/Huyện</option>
                        <option value="LongHo">Long Hồ</option>
                      </select>
                      <select
                        className="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                        name="graduationWard"
                        value={formData.graduationWard}
                        onChange={handleChange}
                      >
                        <option value="">Chọn Xã/Phường/Thị Trấn</option>
                        <option value="DongPhu">Đồng Phú</option>
                      </select>
                    </div>
                  </div>
                </div>
              </section>
              {/* Thông tin thứ 3 */}
              <section className="bg-gray-50 p-6 rounded-xl">
                <h3 className="text-xl text-blue-600 font-semibold mb-6 flex items-center">
                  <span className="mr-3 text-blue-600 text-2xl">■</span>
                  THÔNG TIN NHẬN GIẤY BÁO KẾT QUẢ
                </h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div>
                    <label className="block mb-3 font-semibold text-sm text-gray-700">
                      Người nhận
                    </label>
                    <div className="space-y-4">
                      <label className="flex items-center space-x-3 cursor-pointer">
                        <input
                          name="Student"
                          value={formData.student}
                          onChange={handleChange}
                          type="checkbox"
                          className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                        />
                        <span className="text-gray-700">Thí sinh</span>
                      </label>
                      <label className="flex items-center space-x-3 cursor-pointer">
                        <input
                          name="Guardian"
                          value={formData.guardian}
                          onChange={handleChange}
                          type="checkbox"
                          className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                        />
                        <span className="text-gray-700">
                          Phụ huynh/người giám hộ
                        </span>
                      </label>
                    </div>
                  </div>

                  <div>
                    <label className="block mb-3 font-semibold text-sm text-gray-700">
                      Địa chỉ nhận
                    </label>
                    <div className="space-y-4">
                      <label className="flex items-center space-x-3 cursor-pointer">
                        <input
                          name="Address"
                          value={formData.address}
                          onChange={handleChange}
                          type="checkbox"
                          className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                        />
                        <span className="text-gray-700">
                          Địa chỉ thường trú
                        </span>
                      </label>
                      <label className="flex items-center space-x-3 cursor-pointer">
                        <input
                          name="Atschool"
                          value={formData.atschool}
                          onChange={handleChange}
                          type="checkbox"
                          className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                        />
                        <span className="text-gray-700">Tại trường</span>
                      </label>
                    </div>
                  </div>
                </div>
              </section>
              {/* Thông tin thứ 4 */}
              <section className="bg-gray-50 p-6 rounded-xl">
                <h3 className="text-xl text-blue-600 font-semibold mb-6 flex items-center">
                  <span className="mr-3 text-blue-600 text-2xl">■</span>
                  TẢI LÊN GIẤY TỜ XÁC THỰC HỒ SƠ ĐĂNG KÝ HỌC
                </h3>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                  <div className="space-y-4">
                    <label className="block font-semibold text-sm text-gray-700">
                      Ảnh CMND/CCCD mặt trước
                      <span className="text-red-500 ml-1">(bắt buộc)</span>
                    </label>
                    <img
                      src={CccdFront}
                      alt="idFront"
                      className="w-full aspect-video object-cover rounded-lg border-2 border-dashed border-gray-300"
                    />
                    <input
                      type="file"
                      name="idFront"
                      value={formData.idFront}
                      onChange={handleChange}
                      className="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                  </div>

                  <div className="space-y-4">
                    <label className="block font-semibold text-sm text-gray-700">
                      Ảnh CMND/CCCD mặt sau
                      <span className="text-red-500 ml-1">(bắt buộc)</span>
                    </label>

                    <img
                      src={CccdBack}
                      alt="idBack"
                      className="w-full aspect-video object-cover rounded-lg border-2 border-dashed border-gray-300"
                    />
                    <input
                      type="file"
                      name="idBack"
                      value={formData.idBack}
                      onChange={handleChange}
                      className="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                  </div>

                  <div className="space-y-4">
                    <label className="block font-semibold text-sm text-gray-700">
                      Bản sao/Bản chính Bằng TN THPT
                      <span className="text-red-500 ml-1">(bắt buộc)</span>
                    </label>

                    <img
                      src={DiplomaTHPT}
                      alt="diploma"
                      className="w-full aspect-video object-cover rounded-lg border-2 border-dashed border-gray-300"
                    />
                    <input
                      type="file"
                      name="diploma"
                      value={formData.diploma}
                      onChange={handleChange}
                      className="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                  </div>
                </div>

                <div className="mt-8 space-y-4">
                  <label className="flex items-center space-x-3 cursor-pointer">
                    <input
                      type="checkbox"
                      className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                    />
                    <span className="text-gray-700">
                      Tôi xin cam đoan những lời khai của tôi trên phiếu đăng ký
                      này là đúng sự thật.
                    </span>
                  </label>
                  <label className="flex items-center space-x-3 cursor-pointer">
                    <input
                      type="checkbox"
                      className="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                    />
                    <span className="text-gray-700">
                      Tôi đã đọc kỹ và cam kết tuân thủ Quy định tài chính của
                      nhà trường.
                    </span>
                  </label>
                </div>
              </section>

              <button
                type="submit"
                className={`w-full py-4 rounded-xl text-white font-bold text-lg transition duration-300 ${
                  isSubmitting ? "bg-gray-400" : "bg-blue-600"
                } ${
                  isSubmitting
                    ? "cursor-not-allowed"
                    : "hover:bg-blue-700 hover:shadow-lg"
                }`}
                disabled={isSubmitting}
              >
                {isSubmitting ? "Đang gửi..." : "Gửi hồ sơ đăng ký"}
              </button>
              {submitSuccess && (
                <div className="mt-4 text-green-600 font-semibold">
                  Hồ sơ đã được gửi thành công!
                </div>
              )}
              {submitError && (
                <div className="mt-4 text-red-600 font-semibold">
                  Lỗi: {submitError}
                </div>
              )}
            </form>
          </div>
        </div>
      )}
    </div>
  );
}

export default BannerSection;
