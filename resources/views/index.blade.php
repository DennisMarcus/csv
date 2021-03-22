@extends('layouts.main')

@section('title', 'Homepage')

@section('content')
    <form class="homepage-button" action="/upload-csv" method="post">
        @csrf
        <input type="hidden" name="fileName" value="payments">
        <input type="submit" value="Upload">
    </form>
    <form class="homepage-button" action="/view-csv" method="post">
        @csrf
        <input type="hidden" name="filter" value="all">
        <input type="submit" value="View">
    </form>
@endsection
