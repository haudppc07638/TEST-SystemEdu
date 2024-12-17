import React from "react";
import ContentIntroduction from "../../Components/GeneralIntroduction/ContentIntroduction";
import HeaderIntroduction from "../../Components/GeneralIntroduction/HearderIntroduction";
import CommentSection from "../../Components/Admissions/CommentSection";

function GeneralIntroduction() {
    return (
        <div>
            {/* header */}
            <HeaderIntroduction />

            {/* content-introduct */}
            <ContentIntroduction />

            {/* comment-introduction */}
            <CommentSection />
        </div>
    )
}

export default GeneralIntroduction;
