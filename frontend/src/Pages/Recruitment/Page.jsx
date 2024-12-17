import React from "react";
import HeaderRecruitment from "../../Components/Recruitment/Header";
import RecruitmentCard from "../../Components/Recruitment/RecruitmentCard";
import JobContent from "../../Components/Recruitment/JobContent";

function Recruitment() {
    return (
        <div>
            {/* header-recruitment */}
            <HeaderRecruitment />

            {/* recruitment-card */}
            <RecruitmentCard />

            {/* job-content */}
            <JobContent />
        </div>
    );
}

export default Recruitment;
