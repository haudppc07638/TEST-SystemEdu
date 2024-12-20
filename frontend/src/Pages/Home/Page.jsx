import React, { useState, useEffect } from "react";
import BannerTop from "../../Components/Home/BannerTop";
import Introduce from "../../Components/Home/Introduce";
import Partners from "../../Components/Home/Partners";
import Content from "../../Components/Home/Content";
import BlogHome from "../../Components/Home/BlogHome";
import BannerBottom from "../../Components/Home/BannerBottom";
import ChatBox from "../../Components/ChatBox/ChatBox";

function Home() {
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const timer = setTimeout(() => {
            setIsLoading(false);
        }, 500);

        return () => clearTimeout(timer);
    }, []);

    if (isLoading) {
        return (
            <div className="flex items-center justify-center h-screen bg-gray-100">
                <div className="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
            </div>
        );
    }

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

            {/* background bottom */}
            <BannerBottom />

            {/* ChatBox */}
            <ChatBox />
        </div>
    );
}

export default Home;
