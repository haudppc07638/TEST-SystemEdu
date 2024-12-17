import React from "react";
import banner from "../../Assets/Images/banner.jpg";

function BannerTop() {
    return (
        <div
            className="sticky z-50 bg-cover bg-center bg-no-repeat h-[700px] shadow-lg"
            style={{ backgroundImage: `url(${banner})` }}
        ></div>
    );
}

export default BannerTop;
