<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>@yield('title')</title>

<!-- خط تاجوال من جوجل -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet" />

<!-- Bootstrap CSS (نسخة مستقرة 5.3.0) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

<style>
  body {
    background-color: #f0f2f5;
    font-family: 'Tajawal', sans-serif;
    min-height: 100vh;
  }
  .sidebar {
    width: 280px;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    transition: all 0.3s;
    position: fixed;
    height: 100%;
    overflow-y: auto;
    top: 0;
    right: 0;
    z-index: 1000;
  }
  .sidebar.collapsed {
    transform: translateX(100%);
  }
  .main-content {
    margin-right: 280px;
    padding: 20px;
    transition: all 0.3s;
  }
  @media (max-width: 991.98px) {
    .sidebar {
      transform: translateX(100%);
    }
    .sidebar.show {
      transform: translateX(0);
    }
    .main-content {
      margin-right: 0;
    }
  }
  .sidebar-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  .profile-pic {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #0d6efd;
  }
  .nav-link {
    border-radius: 8px;
    padding: 12px 16px;
    color: #495057;
    transition: all 0.2s;
  }
  .nav-link:hover, .nav-link.active {
    background-color: #e3f2fd;
    color: #0d6efd;
  }
  .nav-link i {
    width: 24px;
  }
</style>
</head>
<body>

<button class="btn btn-primary d-block d-lg-none m-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
  <i class="fas fa-bars"></i>
</button>

<nav id="sidebarMenu" class="sidebar collapse d-lg-block">
  <div class="sidebar-header text-center p-4 border-bottom">
        <div class="avatar-circle mx-auto mb-3 d-flex align-items-center justify-content-center"    style="width: 80px; height: 80px; background-color: #0d6efd; color: white; border-radius: 50%; font-size: 36px; font-weight: bold; user-select: none;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
            <h5 class="fw-bold mb-1 text-primary">{{ Auth::user()->name }}</h5>
            <small class="text-muted fst-italic">{{ __('student_dashboard.student_role') }}</small>
    </div>

  <div class="list-group">
    {{-- تم تغيير `href="#"` إلى `route()` ليوجه بشكل صحيح إلى لوحة التحكم --}}
    <a href="{{ route('student.dashboard') }}" class="list-group-item list-group-item-action border-0 nav-link active">
      <i class="fas fa-tachometer-alt me-2"></i> {{ __('student_dashboard.dashboard_link') }}
    </a>
    <a href="{{ route('student.attendance.index') }}" class="list-group-item list-group-item-action border-0 nav-link">
      <i class="fas fa-calendar-check me-2"></i> {{ __('student_dashboard.attendance_link') }}
    </a>
    <a href="{{ route('student.payments.index') }}" class="list-group-item list-group-item-action border-0 nav-link">
    <i class="fas fa-wallet me-2"></i> {{ __('dashboard.payments_link') }}
    </a>

    {{-- إضافة رابط تسجيل الخروج الذي يشغل النموذج --}}
    <a href="#" class="list-group-item list-group-item-action border-0 nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
    </a>
  </div>
</nav>

<!-- نموذج تسجيل الخروج -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>

<div class="main-content">
  @yield('student_content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
