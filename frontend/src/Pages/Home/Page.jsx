import React from "react";
import BannerTop from "../../Components/Home/BannerTop";
import Introduce from "../../Components/Home/Introduce";
import Partners from "../../Components/Home/Partners";
import Content from "../../Components/Home/Content";
import BlogHome from "../../Components/Home/BlogHome";
import BannerBottom from "../../Components/Home/BannerBottom";
import ChatBox from "../../Components/ChatBox/ChatBox";

function Home() {
    return (
        <div>
            {/* background */}
            <BannerTop />

            {/* introduct */}
            <Introduce />

            {/* content */}
            <Content />

            {/* blog home */}
            <BlogHome />

            {/* partners */}
            <Partners />

            {/* backgrond bottom */}
            <BannerBottom />

            {/* ChatBox */}
            <ChatBox />
        </div>
    );
}

export default Home;
