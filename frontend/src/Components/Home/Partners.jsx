import React, { useState, useEffect } from "react";
import doitac1 from "../../Assets/Images/doitac1.png";
import doitac2 from "../../Assets/Images/doitac2.png";
import doitac3 from "../../Assets/Images/doitac3.png";
import doitac4 from "../../Assets/Images/doitac4.jpg";
import doitac5 from "../../Assets/Images/doitac5.jpg";
import doitac6 from "../../Assets/Images/doitac6.jpg";
import doitac7 from "../../Assets/Images/doitac7.png";
import doitac8 from "../../Assets/Images/doitac8.png";
import doitac9 from "../../Assets/Images/doitac9.jpg";
import doitac10 from "../../Assets/Images/doitac10.png";

function Partners() {
    const images = [
        doitac1, doitac2, doitac3, doitac4, doitac5,
        doitac6, doitac7, doitac8, doitac9, doitac10
    ];
    const [currentSlide, setCurrentSlide] = useState(0);

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentSlide((prevSlide) => (prevSlide + 1) % (images.length - 2));
        }, 3000);

        return () => clearInterval(interval);
    }, [images.length]);

    const handlePrev = () => {
        setCurrentSlide((prevSlide) => 
            (prevSlide - 1 + images.length - 2) % (images.length - 2)
        );
    };

    const handleNext = () => {
        setCurrentSlide((prevSlide) => (prevSlide + 1) % (images.length - 2));
    };

    return (
        <div className="py-16 bg-gray-50">
            <h3 className="text-center text-3xl font-bold mb-10 relative">
                ĐỐI TÁC CHIẾN LƯỢC
                <span className="block h-1 bg-blue-600 rounded mt-3 mx-auto w-32"></span>
            </h3>
            <div className="relative flex justify-center items-center min-h-[120px]">
                <div className="relative overflow-hidden w-full max-w-[1200px] mx-auto px-4">
                    <div
                        className="flex transition-transform duration-700 ease-in-out"
                        style={{
                            transform: `translateX(-${currentSlide * (100 / 3)}%)`
                        }}
                    >
                        {images.map((img, index) => (
                            <div
                                key={index}
                                className="w-1/3 flex-shrink-0 px-6"
                            >
                                <img
                                    src={img}
                                    alt={`Đối tác ${index + 1}`}
                                    className="w-full h-19 object-contain hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                        ))}
                    </div>
                    <button
                        className="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700/50 transition-colors duration-300"
                        onClick={handlePrev}
                    >
                        <i className="fas fa-angle-left text-xl"></i>
                    </button>
                    <button
                        className="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700/50 transition-colors duration-300"
                        onClick={handleNext}
                    >
                        <i className="fas fa-angle-right text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    );
}

export default Partners;
