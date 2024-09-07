@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class='homePage-content w-100 d-flex flex-column justify-content-start align-items-center'>
        @foreach($items as $item)
            <!-- Make the card clickable and pass the item's name to the route -->
            <a href="{{ route('item.details', ['name' => $item->name]) }}" class='item card rounded-4 m-3 p-4 w-75 text-decoration-none text-dark'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $item->name }}</h2>
                    <p class='card-subtitle'>Publisher: {{ $item->manufacturer_name }}</p>
                    <p class='card-text'>Average Rating: {{ $item->ave_rating }}</p>
                    <p class='card-text'>Review Count: {{ $item->review_count }}</p>
                </div>
            </a>
        @endforeach
    </main>
@endsection




@section('footer')
    @include('layouts.footer')
@endsection
