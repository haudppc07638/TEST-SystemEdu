import React from "react";
import HeaderBlog from "../Layouts/Header";
import FooterBlog from "../Layouts/Footer";

function LayoutBlog({children}) {
    return (
        <div className="flex bg-white">
            <div className="flex-grow">
                <HeaderBlog />
                <main>{children}</main>
                <FooterBlog />
            </div>
        </div>
    );
}

export default LayoutBlog;
