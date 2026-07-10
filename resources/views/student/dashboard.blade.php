@extends('layouts.students.student-layout')

@section('title', __('dashboard.title'))  {{-- بدل 'student_dashboard.page_title' إلى 'dashboard.title' مثلاً --}}

@section('student_content')
<div class="container py-5">
    <div class="p-5 mb-4 bg-primary text-white rounded-4 shadow-lg text-center" style="background-image: linear-gradient(135deg, #0d6efd, #00b0ff); position: relative; overflow: hidden;">
        <div class="position-absolute top-0 end-0 bottom-0 start-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'6\' height=\'6\' viewBox=\'0 0 6 6\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M5 0h1L0 6V5zm1 6L6 5.01L5.01 6z\'/%3E%3C/g%3E%3C/svg%3E'); opacity: 0.8;"></div>
        <div style="position: relative;">
            <h1 class="display-4 fw-bold">مرحباً بك، {{ Auth::user()->name }}</h1>
            <p class="fs-5 mt-3">{{ __('dashboard.welcome') }}</p>
        </div>
    </div>
</div>
@endsection
