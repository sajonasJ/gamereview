@extends('layouts.master')

@section('title', 'Welcome Page')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <main class='home-content'>
       <p>home</p>
       <p>list all item reviews</p>
       <p>should show all stars per review</p>
       <p>should show the number of comments per review</p>
       <p>show names of the items</p>
       <p>show picture of the item</p>
    </main>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
