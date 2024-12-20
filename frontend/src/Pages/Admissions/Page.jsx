import React, { useState, useEffect } from "react";
import BannerTop from "../../Components/Admissions/BannerTop";
import Header from "../../Components/Admissions/Header";
import Introduce from "../../Components/Home/Introduce";
import BannerSection from "../../Components/Admissions/BannerSection";
import BannerContent from "../../Components/Admissions/BannerContent";
import AdmissionImfo from "../../Components/Admissions/AdmissionsImfo";
import RegisterImfo from "../../Components/Admissions/RegisterImfo";
import Partners from "../../Components/Home/Partners";
import CommentSection from "../../Components/Admissions/CommentSection";
import TrainingSectors from "../../Components/TrainingProgram/TrainingSectors";

function Admissions() {
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
            <TrainingSectors />
            
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
