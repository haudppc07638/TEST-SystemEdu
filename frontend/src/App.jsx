import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import LayoutBlog from "./Layouts/LayoutBlog";
import Home from "./Pages/Home/Page";
import Admissions from "./Pages/Admissions/Page";
import Recruitment from "./Pages/Recruitment/Page";
import TrainingProgram from "./Pages/TrainingProgram/Page";
import GeneralIntroduction from "./Pages/GeneralIntroduction/Page";
import ContactPage from "./Pages/ContactPage/Page";
import ShoolNews from "./Pages/NewsSchool/Page";
import NewDetails from "./Pages/NewDetail/Page";

function App() {
  return (
    <Router>
      <LayoutBlog>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/home" element={<Home />} />
          <Route path="/admissions" element={<Admissions />} />
          <Route path="/recruitment" element={<Recruitment />} />
          <Route path="/training-program" element={<TrainingProgram />} />
          <Route
            path="/general-introduction"
            element={<GeneralIntroduction />}
          />
          <Route path="/contacts" element={<ContactPage />} />
          <Route path="/news" element={<ShoolNews />} />
          <Route path="/news/:id" element={<NewDetails />} />
        </Routes>
      </LayoutBlog>
    </Router>
  );
}

export default App;
