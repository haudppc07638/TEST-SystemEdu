import React from "react";
import BannerTop from "../../Components/Admissions/BannerTop";
import Content from "../../Components/Home/Content";
import Header from "../../Components/Admissions/Header";
import Introduce from "../../Components/Home/Introduce";
import BannerSection from "../../Components/Admissions/BannerSection";
import BannerContent from "../../Components/Admissions/BannerContent";
import AdmissionImfo from "../../Components/Admissions/AdmissionsImfo";
import RegisterImfo from "../../Components/Admissions/RegisterImfo";
import Partners from "../../Components/Home/Partners";
import CommentSection from "../../Components/Admissions/CommentSection";

function Admissions() {
    return (
        <div>
            {/* header */}
            <Header />

            {/* banner top */}
            <BannerTop />

            {/* introduct */}
            <Introduce />

            {/* banner-section */}
            <BannerSection />

            {/* banner-content */}
            <BannerContent />

            {/* content */}
            <Content />

            {/* admissions imfo */}
            <AdmissionImfo />

            {/* register imfo */}
            <RegisterImfo />

            {/* partners */}
            <Partners />

            {/* comment */}
            <CommentSection />
        </div>
    );
}

export default Admissions;
