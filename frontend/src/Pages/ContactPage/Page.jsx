import React, { useState, useEffect } from "react";
import ContactBaner from "../../Components/ContactSys/ContactBaner";
import CommentSection from "../../Components/Admissions/CommentSection";

function ContactPage() {
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
      {/* contact-banner */}
      <ContactBaner />

      {/* comment */}
      <CommentSection />
    </div>
  );
}

export default ContactPage;
