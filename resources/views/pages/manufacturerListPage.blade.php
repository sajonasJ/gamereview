@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <main class='manufacturerListPage-content w-100 d-flex flex-column justify-content-start align-items-center'>
        @foreach($manufacturerList as $manufacturer)
            <div class='item card rounded-4 m-3 p-4 w-75'>
                <div class='card-body'>
                    <h2 class='card-title mb-4'>{{ $manufacturer->name }}</h2>
                </div>
            </div>
        @endforeach
    </main>
@endsection


@section('footer')
    @include('layouts.footer')
@endsection
