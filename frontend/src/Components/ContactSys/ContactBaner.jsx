import React from "react";
import banner from "../../Assets/Images/banner2.jpg";

function ContactBaner() {
  return (
    <div className="container mx-auto py-16">
      <h2 className="text-3xl text-black font-bold text-center mb-8">
        Thông tin liên hệ
      </h2>
      <div className="lg:flex lg:items-center lg:justify-between border-t space-y-8 lg:space-y-0">
        <div className="lg:w-1/2">
          <div className="bg-white shadow-lg rounded-lg p-8">
            <h4 className="text-3xl font-bold text-blue-600 mb-4">
              Cao đẳng Sysedu
            </h4>
            <p className="text-xl text-gray-700">Cao đẳng Sysedu Cần Thơ</p>
            <p className="text-lg text-gray-600 my-2">
              Hỗ trợ khách hàng:{" "}
              <span className="font-bold">0345456544 - 0345456545</span>
            </p>
            <p className="text-lg text-gray-600 mb-4">
              Email: <span className="font-bold">caodangsysedu@sys.edu.vn</span>
            </p>
            <button className="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
              Liên hệ ngay
            </button>
          </div>
        </div>
        <div className="lg:w-1/2">
          <div className="bg-gray-100 p-8 rounded-lg">
            <img
              src={banner}
              alt="SysEdu banner"
              className="w-full h-auto rounded-lg shadow-md"
            />
          </div>
        </div>
      </div>

      <div className="bg-whiter py-16 px-16 mt-10">
        <h2 className="text-2xl font-semibold mb-4">
          Cơ sở đào tạo tại Cần Thơ
        </h2>
        <p className="text-lg mb-2">
          Địa chỉ: Toà nhà F, Phường Trường Thạnh, Quận Ninh Kiều, TP. Cần Thơ
        </p>
        <p className="text-lg mb-2">
          <strong>Điện thoại:</strong> 0345456544 - 0345456545
        </p>
        <p className="text-lg mb-2">
          <strong>Email:</strong> caodangsysedu@gmail.com
        </p>
        <h3 className="text-xl font-semibold mt-6 mb-4">
          Các phòng ban liên quan:
        </h3>
        <ul className="list-none">
          <li>
            <strong>Phòng Giới thiệu – Tuyển sinh:</strong> (024) 6327 6402
          </li>
          <li>
            <strong>Phòng Đào tạo:</strong> (024) 6327 6402
          </li>
          <li>
            <strong>Phòng Tài chính – Kế toán:</strong> (024) 6327 6402
          </li>
          <li>
            <strong>Phòng Hành chính – Nhân sự:</strong> (024) 6327 6402
          </li>
        </ul>
      </div>
      <div>
        <h2 className="text-3xl font-semibold mb-4 mt-10">
          Bản đồ địa chỉ
        </h2>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d177859.28351141888!2d105.63952704794647!3d9.91962524858424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08906415c355f%3A0x416815a99ebd841e!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1734459540038!5m2!1svi!2s"
          className="w-full mt-6"
          title="SysEdu"
          height="450"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
    </div>
  );
}

export default ContactBaner;
