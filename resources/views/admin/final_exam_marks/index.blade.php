@extends('layouts.admin_app')

@section('title', __('admin.final_exam_marks'))

@section('content')

<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.final_exam_marks') }}</h1>
<a href="{{ route('admin.final_exam_marks.create') }}" class="btn btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
<i class="fas fa-plus fa-sm me-2"></i> {{ __('admin.add_new') }}
</a>
</div>

@if(session('success'))
<div class="alert alert-success rounded-pill shadow-sm mb-4">
    {{ session('success') }}
</div>
@endif

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="py-3 px-4">{{ __('admin.student_name') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('admin.subject') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('admin.mark') }}</th>
                        <th scope="col" class="text-center py-3 px-4">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marks as $mark)
                    <tr>
                        <td class="py-3 px-4">{{ $mark->student->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $mark->test?->subject?->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $mark->mark }}</td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.final_exam_marks.edit', $mark->id) }}" class="btn btn-sm btn-info rounded-pill me-2 text-white">
                                <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                            </a>
                            <form action="{{ route('admin.final_exam_marks.destroy', $mark->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('هل أنت متأكد من الحذف؟');">
                                    <i class="fas fa-trash-alt"></i> {{ __('admin.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ __('admin.no_final_exam_marks_found') }}
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