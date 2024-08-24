@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <main class='manufacturer-content'>
        <p>manufacturer</p>
        <p>list all manufacturers</p>
        <p>manufacturer image</p>
        <p>manufacturer name</p>
        <p>stars for each manufacturer</p>
        <p>number of items</p>
        <p>number of reviews</p>
    </main>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
