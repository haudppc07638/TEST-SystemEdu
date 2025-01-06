 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link " href="{{ route('admin.dashboard') }}">
                 <i class="bi bi-grid"></i>
                 <span>Báo cáo thống kê</span>
             </a>
         </li><!-- End Dashboard Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-menu-button-wide"></i><span>Đào tạo</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('admin.faculties.index') }}">
                         <i class="bi bi-circle"></i><span>Khoa</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.majors.index') }}">
                         <i class="bi bi-circle"></i><span>Chuyên ngành</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.subjects.index') }}">
                         <i class="bi bi-circle"></i><span>Môn học</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.score_types.index') }}">
                         <i class="bi bi-circle"></i><span>Quản lí loại điểm</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('admin.subject_lecturers.create') }}">
                      <i class="bi bi-circle"></i><span>Đăng ký môn dạy</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.credits.index') }}">
                         <i class="bi bi-circle"></i><span>Tín chỉ</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.departments.index') }}">
                         <i class="bi bi-circle"></i><span>Phòng ban</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.classrooms.index') }}">
                         <i class="bi bi-circle"></i><span>Phòng học</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Components Nav -->


         <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.semesters.index') }}">
                <i class="bi bi-journal"></i>
                <span>Học kỳ</span>
            </a>
        </li><!-- End Class Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.timeslots.index') }}">
                <i class="bi bi-clock"></i>
                <span>Thời gian ca học</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.students.index') }}">
                <i class="bi bi-person-square"></i>
                <span>Sinh viên</span>
            </a>
        </li><!-- End students Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.employees.index') }}">
                <i class="bi bi-person-rolodex"></i>
                <span>Nhân sự</span>
            </a>
        </li><!-- End employees Page Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" href="{{ route('admin.classes.index') }}">
                 <i class="bi bi-folder-fill"></i>
                 <span>Lớp chuyên ngành </span>
             </a>
         </li><!-- End Class Page Nav -->

         <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.subjectclasses.index') }}">
                <i class="bi bi-folder2-open"></i>
                <span>Lớp môn </span>
            </a>
        </li>
        
         <li class="nav-item">
             <a class="nav-link collapsed" href="{{ route('admin.notifications.index') }}">
                 <i class="bi bi-bell-fill"></i>
                 <span>Gửi thông báo</span>
             </a>
         </li><!-- End Notifications  Page Nav -->

         <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.news.index') }}">
                <i class="bi bi-newspaper"></i>
                <span>Tin tức</span>
            </a>
        </li><!-- End News Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.enrollments.index') }}">
                <i class="bi bi-person-check"></i>
                <span>Hồ sơ đăng ký online</span>
            </a>
        </li><!-- End Enrollments Page Nav -->


         <li class="nav-item">
             <a class="nav-link collapsed" href="{{ route('admin.feedbacks.index') }}">
                 <i class="bi bi-folder2-open"></i>
                 <span>Feedback </span>
             </a>
         </li>
     </ul>

 </aside><!-- End Sidebar-->
