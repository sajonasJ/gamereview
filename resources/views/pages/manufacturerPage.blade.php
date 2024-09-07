@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class="manufacturerPage-content w-100 d-flex flex-column justify-content-start align-items-center">
        @foreach($manufacturers as $manufacturer)
            <!-- Wrap the card in an <a> tag to make it clickable -->
            <a href="{{ route('item.details', ['name' => $manufacturer->name]) }}" class="item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $manufacturer->manufacturer_name }}</h2>
                    <p class="card-subtitle">Item: {{ $manufacturer->name }}</p>
                    <p class="card-text">Average Rating: {{ $manufacturer->ave_rating }}</p>
                    <p class="card-text">Review Count: {{ $manufacturer->review_count }}</p>
                </div>
            </a>
        @endforeach
    </main>
@endsection




@section('footer')
    @include('layouts.footer')
@endsection
