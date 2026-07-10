@extends('layouts.admin_app')

@section('title', __('admin.subject_list'))

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('admin.subject_list') }}</h1>
        <!-- زر إضافة مادة جديدة مع تكبيره -->
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> {{ __('admin.add_new_subject') }}
        </a>
    </div>

    <!-- عرض التنبيهات عند النجاح -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- تصميم جديد باستخدام البطاقات -->
    <div class="row">
        @forelse ($subjects as $subject)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $subject->name }}</h5>

              

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> {{ __('admin.edit') }}
                            </a>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> {{ __('admin.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>{{ __('admin.no_subjects_found') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
