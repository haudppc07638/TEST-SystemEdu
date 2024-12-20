import React, { useState, useEffect } from "react";
import News from "../../Components/SchoolNews/News";
import RelatedNews from "../../Components/SchoolNews/RelatedNews";

function SchoolNews() {
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
      {/* news */}
      <News />

      {/* relatedNews */}
      <RelatedNews />
    </div>
  );
}

export default SchoolNews;
