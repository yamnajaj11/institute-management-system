@extends('layouts.admin_app')

@section('title', __('admin.all_marks'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('admin.all_marks') }}</h1>

    @if(session('success'))
        <div class="alert alert-success text-center fw-bold rounded-3 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <a href="{{ route('admin.marks.select_subject_for_bulk') }}" class="btn btn-success rounded-pill shadow-sm px-4 me-2 mb-2">
            {{ __('admin.add_bulk_marks') }}
        </a>

        <form action="{{ route('admin.marks.index') }}" method="GET" class="d-flex align-items-center">
            <div class="input-group rounded-pill shadow-sm overflow-hidden me-2" style="max-width: 250px;">
                <span class="input-group-text bg-white border-0">{{ __('admin.test_name') }}</span>
                <select name="test_id" id="test-select" class="form-select border-0 ps-2">
                    <option value="all" @if(request('test_id') === 'all' || !request('test_id')) selected @endif>{{ __('admin.all_tests') }}</option>
                    @foreach($tests as $test)
                        <option value="{{ $test->id }}" @if(request('test_id') == $test->id) selected @endif>{{ $test->name }}</option>
                    @endforeach
                </select>
            </div>
            
           <button type="submit" class="btn btn-primary px-4 border-0">
            <i class="fas fa-filter"></i>
        </button>
        </form>
    </div>

    <table class="table table-bordered table-striped table-hover mb-0">
        <thead class="bg-dark text-white">
            <tr>
                <th>{{ __('admin.student_name') }}</th>
                <th>{{ __('admin.test_name') }}</th>
                <th>{{ __('admin.mark') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($marks as $mark)
                <tr>
                    <td>{{ $mark->student->name }}</td>
                    <td>{{ $mark->test->name }}</td>
                    <td>{{ $mark->mark }}</td>
                    <td>
                        <form action="{{ route('admin.marks.destroy', $mark->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">{{ __('admin.delete') }}</button>
                        </form> 
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        {{ __('admin.no_marks_found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection