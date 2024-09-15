 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Báo Cáo Thống Kê</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Đào Tạo</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.faculties.index')}}">
              <i class="bi bi-circle"></i><span>Khoa</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.majors.index')}}">
              <i class="bi bi-circle"></i><span>Chuyên Ngành</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.subjects.index')}}">
              <i class="bi bi-circle"></i><span>Môn Học</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.departments.index')}}">
              <i class="bi bi-circle"></i><span>Phòng Ban</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.classrooms.index')}}">
              <i class="bi bi-circle"></i><span>Phòng Học</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Lịch học</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.schedules.index')}}">
              <i class="bi bi-circle"></i><span>Lịch học</span>
            </a>
          </li>
          {{-- <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Ca Học</span>
            </a>--}}
          {{-- </li>
          <li>
            <a href="{{ route('admin.daycombinations.index')}}">
              <i class="bi bi-circle"></i><span>Ngày Học</span>
            </a>
          </li>  --}}
          <li>
            <a href="{{ route('admin.semesters.index')}}">
              <i class="bi bi-circle"></i><span>Học Kỳ</span>
            </a>
          </li>
        </ul>
      </li><!-- End Schedule Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.faculties')}}">
          <i class="bi bi-folder-fill"></i>
          <span>Lớp Chuyên Ngành </span>
        </a>
      </li><!-- End Class Page Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.students.index')}}">
          <i class="bi bi-person-square"></i>
          <span>Sinh Viên</span>
        </a>
      </li><!-- End students Page Nav --> 

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.employees.index')}}">
          <i class="bi bi-person-rolodex"></i>
          <span>Nhân Sự</span>
        </a>
      </li><!-- End employees Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.notifications.index')}}"> 
          <i class="bi bi-bell-fill"></i>
          <span>Gửi Thông Báo</span>
        </a>
      </li><!-- End Notifications  Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('admin.timeslots.index')}}">
          <i class="bi bi-clock"></i>
          <span>Thời Gian Theo Ca</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.subjectclasses.index')}}"> 
          <i class="bi bi-folder2-open"></i>
          <span>Lớp Môn </span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->