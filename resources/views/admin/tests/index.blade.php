@extends('layouts.admin_app')

@section('title', __('admin.all_tests'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('admin.all_tests') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.tests.create') }}" class="btn btn-primary mb-3">{{ __('admin.add_new_test') }}</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('admin.test_name') }}</th>
                <th>{{ __('admin.subject') }}</th>
                <th>{{ __('admin.test_date') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->subject->name }}</td>
                    <td>{{ $test->test_date }}</td>
                    <td>
                        <a href="{{ route('admin.tests.edit', $test->id) }}" class="btn btn-warning btn-sm">{{ __('admin.edit') }}</a>
                        <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">{{ __('admin.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
