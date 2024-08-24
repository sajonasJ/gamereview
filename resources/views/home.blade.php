@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <main class='home-content'>
        <p>Welcome to the homepage!</p>
        <p>this includes the description of the website</p>
        <p>objective of the website</p>
        <p>information about the author</p>
    </main>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
