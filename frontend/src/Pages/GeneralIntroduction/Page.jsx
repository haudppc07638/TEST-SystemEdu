import React, { useState, useEffect } from "react";
import ContentIntroduction from "../../Components/GeneralIntroduction/ContentIntroduction";
import HeaderIntroduction from "../../Components/GeneralIntroduction/HearderIntroduction";
import CommentSection from "../../Components/Admissions/CommentSection";

function GeneralIntroduction() {
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
            {/* header */}
            <HeaderIntroduction />

            {/* content-introduct */}
            <ContentIntroduction />

            {/* comment-introduction */}
            <CommentSection />
        </div>
    );
}

export default GeneralIntroduction;
