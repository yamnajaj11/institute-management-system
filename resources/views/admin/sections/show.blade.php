@extends('layouts.admin_app')

@section('title', __('admin.manage_section_students'))

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.manage_section_students') }} - {{ $section->name }}</h1>
        <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
            <i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_sections') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-pill shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-pill shadow-sm mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Section Details --}}
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="fw-bold text-dark mb-3">{{ __('admin.section_details') }}</h5>
            <p><strong>{{ __('admin.section_name') }}:</strong> {{ $section->name }}</p>
            <p><strong>{{ __('admin.subject') }}:</strong> {{ $section->subject->name }}</p>
            <p><strong>{{ __('admin.max_students') }}:</strong> {{ $section->max_students }}</p>
            <p><strong>{{ __('admin.current_students') }}:</strong> {{ $section->students->count() }}</p>
        </div>
    </div>

    {{-- Add Student to Section Form --}}
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="fw-bold text-dark mb-3">{{ __('admin.add_student_to_section') }}</h5>
            @if($availableStudents->isEmpty())
                <div class="alert alert-info rounded-pill shadow-sm mb-4">
                    {{ __('admin.no_students_to_add') }}
                </div>
            @else
                <form action="{{ route('admin.sections.addStudent', $section) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="form-label fw-bold">{{ __('admin.select_student') }}</label>
                        <select name="user_id" id="user_id" class="form-select rounded-pill @error('user_id') is-invalid @enderror" required>
                            <option value="" disabled selected>{{ __('admin.choose_student') }}</option>
                            @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
                            <i class="fas fa-plus me-2"></i> {{ __('admin.add_student_button') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    
    {{-- List of Enrolled Students --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="fw-bold text-dark mb-3">{{ __('admin.enrolled_students_list') }}</h5>
            @if($section->students->isEmpty())
                <div class="alert alert-warning text-center rounded-pill shadow-sm mb-4">
                    {{ __('admin.no_students_enrolled') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th scope="col" class="py-3 px-4">#</th>
                                <th scope="col" class="py-3 px-4">{{ __('admin.student_id') }}</th>
                                <th scope="col" class="py-3 px-4">{{ __('admin.student_name') }}</th>
                                <th scope="col" class="text-center py-3 px-4">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($section->students as $student)
                                <tr>
                                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4">{{ $student->student_id }}</td>
                                    <td class="py-3 px-4">{{ $student->name }}</td>
                                    <td class="text-center py-3 px-4">
                                        <form action="{{ route('admin.sections.removeStudent', ['section' => $section, 'student' => $student]) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">                                             
                                                <i class="fas fa-user-times"></i> {{ __('admin.remove_student') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection