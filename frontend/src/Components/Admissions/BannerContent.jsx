import React from "react";
import bannerbottom from "../../Assets/Images/banner-botton.png";

function BannerContent() {
    return (
        <div
            className="sticky bg-cover bg-center bg-no-repeat h-[500px] shadow-lg border-t-4 border-white"
            style={{ backgroundImage: `url(${bannerbottom})` }}
        ></div>
    );
}

export default BannerContent;
