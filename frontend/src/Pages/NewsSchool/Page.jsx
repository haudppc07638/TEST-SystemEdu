import React from "react";
import News from "../../Components/SchoolNews/News";
import RelatedNews from "../../Components/SchoolNews/RelatedNews";

function SchoolNews() {
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
