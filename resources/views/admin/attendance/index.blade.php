@extends('layouts.admin_app')

@section('title', 'إدارة الحضور والغياب')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.attendance_management') }}</h1>
        <div class="d-flex">
            <a href="{{ url()->previous() }}" class="btn btn-lg btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg me-4">
                <i class="fas fa-arrow-left fa-sm me-2"></i>{{ __('admin.back') }}
            </a>

            <a href="{{ route('admin.attendances.create') }}" class="btn btn-lg btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg me-4">
                <i class="fas fa-plus fa-sm me-2"></i> {{ __('admin.record_attendance') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-pill shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-auto">
                <form action="{{ route('admin.attendances.index') }}" method="GET" class="d-flex align-items-center flex-wrap">
                    <div class="input-group rounded-pill shadow-sm overflow-hidden me-2 mb-2" style="max-width: 250px;">
                        <span class="input-group-text bg-white border-0">{{ __('admin.date') }}</span>
                        <input type="date" name="date" id="date-input" class="form-control border-0 ps-2" value="{{ request('date') }}">
                    </div>
                    
                    <div class="input-group rounded-pill shadow-sm overflow-hidden me-2 mb-2" style="max-width: 250px;">
                        <span class="input-group-text bg-white border-0">{{ __('admin.status') }}</span>
                        <select name="status" id="status-select" class="form-select border-0 ps-2">
                            <option value="all" @if(request('status') === 'all' || !request('status')) selected @endif>{{ __('admin.all') }}</option>
                            <option value="present" @if(request('status') === 'present') selected @endif>{{ __('admin.present') }}</option>
                            <option value="late" @if(request('status') === 'late') selected @endif>{{ __('admin.late') }}</option>
                            <option value="absent" @if(request('status') === 'absent') selected @endif>{{ __('admin.absent') }}</option>
                        </select>
                    </div>

                    <div class="input-group rounded-pill shadow-sm overflow-hidden me-2 mb-2" style="max-width: 250px;">
                        <span class="input-group-text bg-white border-0">{{ __('admin.course_name') }}</span>
                        <select name="course_id" id="course-select" class="form-select border-0 ps-2">
                            <option value="all" @if(request('course_id') === 'all' || !request('course_id')) selected @endif>{{ __('admin.all_courses') }}</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" @if(request('course_id') == $course->id) selected @endif>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <button type="submit" class="btn btn-primary px-4 transition-transform duration-300 hover:scale-105 rounded-pill shadow-sm">
                        <i class="fas fa-filter me-2"></i> {{ __('admin.apply') }}
                    </button>
                </form>
            </div>

            <div class="col-md-auto ms-auto">
                <form action="{{ route('admin.attendances.index') }}" method="GET">
                    <div class="input-group rounded-pill shadow-sm overflow-hidden transition-all duration-300">
                        <input type="text" name="search" id="search-input" class="form-control border-0 ps-4" placeholder="{{ __('admin.search_placeholder_attendance') }}" aria-label="{{ __('admin.search_by_name_id') }}" value="{{ request('search') }}">
                        @if(request('date'))
                            <input type="hidden" name="date" value="{{ request('date') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('course_id'))
                            <input type="hidden" name="course_id" value="{{ request('course_id') }}">
                        @endif
                        <button type="submit" class="btn btn-primary px-4 transition-transform duration-300 hover:scale-105">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" class="py-3 px-4">#</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.student_id') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.student_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.course_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.date') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.status') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.notes') }}</th>
                            <th scope="col" class="text-center py-3 px-4">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td class="py-3 px-4">{{ $loop->iteration + ($attendances->perPage() * ($attendances->currentPage() - 1)) }}</td>
                            <td class="py-3 px-4">{{ $attendance->student->student_id }}</td>
                            <td class="py-3 px-4">{{ $attendance->student->name }}</td>
                            <td class="py-3 px-4">
                                @forelse($attendance->student->courses as $course)
                                    <span class="badge bg-secondary">{{ $course->name }}</span>
                                @empty
                                    --
                                @endforelse
                            </td>
                            <td class="py-3 px-4">{{ $attendance->date }}</td>
                            <td class="py-3 px-4">
                                @if($attendance->status == 'present')
                                    <span class="badge bg-success">{{ __('admin.present') }}</span>
                                @elseif($attendance->status == 'late')
                                    <span class="badge bg-warning text-dark">{{ __('admin.late') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('admin.absent') }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $attendance->notes ?? '--' }}</td>
                            <td class="text-center py-3 px-4">
                                <a href="{{ route('admin.attendances.edit', $attendance->id) }}" class="btn btn-sm btn-info rounded-pill me-2 text-white">
                                    <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                                </a>
                                <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذا السجل؟')">
                                        <i class="fas fa-trash-alt"></i> {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4"> <i class="fas fa-exclamation-circle me-2"></i> {{ __('admin.no_attendances_found') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $attendances->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection