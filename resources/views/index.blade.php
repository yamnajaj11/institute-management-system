@extends('layouts.app')

@section('title', __('home.title'))

@section('content')
    <section class="hero-section text-center py-5 bg-light">
        <div class="container">
            <h1 class="display-4 fw-bold">{{ __('home.main_slogan') }}</h1>
            <p class="lead">{{ __('home.sub_slogan') }}</p>
        </div>
    </section>


@endsection
