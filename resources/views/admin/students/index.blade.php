@extends('layouts.admin_app')

@section('title', __('admin.view_all'))

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.students_list') }}</h1>
        <a href="{{ route('admin.students.create') }}" class="btn btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
            <i class="fas fa-plus fa-sm me-2"></i> {{ __('admin.add_new') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-pill shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- نموذج البحث --}}
    <form action="{{ route('admin.students.index') }}" method="GET" class="mb-4">
        <div class="input-group rounded-pill shadow-sm overflow-hidden transition-all duration-300">
            <input type="text" name="search" id="search-input" class="form-control border-0 ps-4" placeholder="{{ __('admin.search_placeholder') }}" aria-label="{{ __('admin.search_by_name') }}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4 transition-transform duration-300 hover:scale-105">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>


    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col" class="py-3 px-4">#</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.student_id') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.gender') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.father_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.mother_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.phone_number') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.address') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.enrolled_courses') }}</th> {{-- العمود الجديد --}}
                            <th scope="col" class="py-3 px-4">{{ __('admin.created_at') }}</th>
                            <th scope="col" class="text-center py-3 px-4">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td class="py-3 px-4">{{ $loop->iteration + ($students->perPage() * ($students->currentPage() - 1)) }}</td>
                            <td class="py-3 px-4">{{ $student->student_id }}</td>
                            <td class="py-3 px-4">{{ $student->name }}</td>
                            <td class="py-3 px-4">{{ __('admin.' . $student->gender) }}</td>
                            <td class="py-3 px-4">{{ $student->father_name }}</td>
                            <td class="py-3 px-4">{{ $student->mother_name }}</td>
                            <td class="py-3 px-4">{{ $student->phone }}</td>
                            <td class="py-3 px-4">{{ $student->address }}</td>
                            {{-- عرض الدورات المسجل بها الطالب --}}
                            <td class="py-3 px-4">
                                @forelse($student->courses as $course)
                                    <span class="badge bg-primary me-1">{{ $course->name }}</span>
                                @empty
                                    <span class="text-muted">{{ __('admin.no_courses_enrolled') }}</span>
                                @endforelse
                            </td>
                            <td class="py-3 px-4">{{ $student->created_at->format('Y-m-d') }}</td>
                            <td class="text-center py-3 px-4">
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-info rounded-pill me-2 text-white">
                                    <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                                </a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">
                                        <i class="fas fa-trash-alt"></i> {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ __('admin.students_not_found') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- روابط التنقل (Pagination) --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection