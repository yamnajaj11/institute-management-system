@extends('layouts.admin_app')

@section('title', __('admin.manage_sections'))

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.sections_list') }}</h1>
        <a href="{{ route('admin.sections.create') }}" class="btn btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
            <i class="fas fa-plus fa-sm me-2"></i> {{ __('admin.add_new_section') }}
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

    {{-- Search Form --}}
    <form action="{{ route('admin.sections.index') }}" method="GET" class="mb-4">
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
                            <th scope="col" class="py-3 px-4">{{ __('admin.section_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.subject_name') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.max_students') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.enrolled_students') }}</th>
                            <th scope="col" class="text-center py-3 px-4">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                            <tr>
                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4">{{ $section->name }}</td>
                                <td class="py-3 px-4">{{ $section->subject->name }}</td>
                                <td class="py-3 px-4">{{ $section->max_students }}</td>
                                <td class="py-3 px-4">{{ $section->students_count }}</td>
                                <td class="text-center py-3 px-4">
                                    <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-sm btn-info rounded-pill me-2 text-white">
                                        <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                                    </a>
                                    <a href="{{ route('admin.sections.show', $section) }}" class="btn btn-sm btn-primary rounded-pill me-2 text-white">
                                        <i class="fas fa-users"></i> {{ __('admin.manage_students') }}
                                    </a>
                                    <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            <i class="fas fa-trash-alt"></i> {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ __('admin.no_sections_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection