@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <p>Welcome to the homepage!</p>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
