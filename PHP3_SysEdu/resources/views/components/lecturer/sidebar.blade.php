 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('teacher.home') }}">
                <i class="bi bi-grid"></i>
                <span>Thông báo tin tức</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('student.index') }}">
                <i class="bi bi-person-square"></i>
                <span>Tra cứu sinh viên</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('classes') }}">
                <i class="bi bi-person-rolodex"></i>
                <span>Lớp của tôi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.notifications.index') }}">
                <i class="bi bi-bell-fill"></i>
                <span>Lịch dạy</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.timeslots.index') }}">
                <i class="bi bi-clock"></i>
                <span>Lịch thi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.subjectclasses.index') }}">
                <i class="bi bi-folder2-open"></i>
                <span>Feedback </span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
