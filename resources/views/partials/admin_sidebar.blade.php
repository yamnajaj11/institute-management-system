<div class="sidebar d-flex flex-column p-4 text-white" style="background-color: #212529;">
    <h4 class="mb-5 text-center fw-bold">{{ __('admin.dashboard') }}</h4>
    <nav class="nav nav-pills flex-column">
        <!-- رابط الصفحة الرئيسية -->
        <a class="nav-link text-white rounded-3 mb-4 py-3 px-2 @if(Route::is('admin.dashboard')) active bg-primary @endif" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home me-3"></i> {{ __('admin.home') }}
        </a>

            <!-- قائمة إدارة الدورات -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white rounded-3 mb-2 py-3 px-2 @if(Route::is('admin.courses.*')) active bg-primary @endif" href="#" id="coursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="fas fa-book-open me-3"></i> {{ __('admin.manage_courses') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow" aria-labelledby="coursesDropdown" style="background-color: #2c3034;">
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.courses.index')) active bg-primary @endif" href="{{ route('admin.courses.index') }}">
                        {{ __('admin.view_all_courses') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.courses.create')) active bg-primary @endif" href="{{ route('admin.courses.create') }}">
                        {{ __('admin.add_new_course') }}
                    </a>
                </li>
                    <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.subjects.index')) active bg-primary @endif" href="{{ route('admin.subjects.index') }}">
                        {{ __('admin.manage_subjects') }}
                    </a>
                </li>
                 <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.sections.*')) active bg-primary @endif" href="{{ route('admin.sections.index') }}">
                        {{ __('admin.manage_sections') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- قائمة إدارة الطلاب -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white rounded-3 mb-2 py-3 px-2 @if(Route::is('admin.students.*')) active bg-primary @endif" href="#" id="studentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="fas fa-users me-3"></i> {{ __('admin.manage_students') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow" aria-labelledby="studentsDropdown" style="background-color: #2c3034;">
                <li>
                    <a class="dropdown-item py-2 rounded-3" href="{{ route('admin.students.index') }}">
                        {{ __('admin.view_all') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 rounded-3" href="{{ route('admin.students.create') }}">
                        {{ __('admin.add_new') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- قائمة إدارة الحضور -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white rounded-3 mb-2 py-3 px-2 @if(Route::is('admin.attendances.*')) active bg-primary @endif" href="#" id="attendanceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="fas fa-clipboard-check me-3"></i> {{ __('admin.manage_attendance') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow" aria-labelledby="attendanceDropdown" style="background-color: #2c3034;">
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.attendances.index')) active bg-primary @endif" href="{{ route('admin.attendances.index') }}">
                        {{ __('admin.view_all_attendances') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.attendances.create')) active bg-primary @endif" href="{{ route('admin.attendances.create') }}">
                        {{ __('admin.record_new_attendance') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- قائمة إدارة الأقساط -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white rounded-3 mb-2 py-3 px-2 @if(Route::is('admin.payments.*') || Route::is('payments.history')) active bg-primary @endif" href="#" id="paymentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="fas fa-money-bill-wave me-3"></i> {{ __('admin.manage_payments') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow" aria-labelledby="paymentsDropdown" style="background-color: #2c3034;">
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.payments.index')) active bg-primary @endif" href="{{ route('admin.payments.index') }}">
                        {{ __('admin.view_all_payments') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.payments.create')) active bg-primary @endif" href="{{ route('admin.payments.create') }}">
                        {{ __('admin.add_new_payment') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- قائمة إدارة العلامات -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white rounded-3 mb-2 py-3 px-2 @if(Route::is('admin.marks.*')) active bg-primary @endif" href="#" id="marksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="fas fa-clipboard-list me-3"></i> {{ __('admin.manage_marks') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow" aria-labelledby="marksDropdown" style="background-color: #2c3034;">
                <!-- رابط إدارة المواد -->
          
                <!-- رابط إدارة الاختبارات -->
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.tests.index')) active bg-primary @endif" href="{{ route('admin.tests.index') }}">
                        {{ __('admin.manage_tests') }}
                    </a>
                </li>
                <!-- رابط عرض كل العلامات -->
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.marks.index')) active bg-primary @endif" href="{{ route('admin.marks.index') }}">
                        {{ __('admin.view_all_marks') }}
                    </a>
                </li>
                <!-- رابط إضافة علامات الامتحان النهائي -->
                <li>
                    <a class="dropdown-item text-white @if(Route::is('admin.final_exam_marks.index')) active bg-primary @endif" href="{{ route('admin.final_exam_marks.index') }}">
                        {{ __('admin.manage_final_exam_marks') }}
                    </a>
                </li>
            </ul>
        </div>

    
        <!-- زر تسجيل الخروج -->
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="btn btn-outline-danger mt-3 w-100 rounded-pill fw-bold">
                <i class="fas fa-sign-out-alt me-2"></i> {{ __('admin.logout') }}
            </button>
        </form>
    </nav>
</div>
