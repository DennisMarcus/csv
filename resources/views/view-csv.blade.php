@extends('layouts.main')

@section('title', 'View')

@section('content')
    <form action="/view-csv" method="post">
        @csrf
        <input type="submit" name="filter" value="All">
        <input type="submit" name="filter" value="Currency">
        <input type="submit" name="filter" value="User">
        <input type="submit" name="filter" value="Day">
    </form>
    <table class="view-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Date</th>
                <th>Country</th>
                <th>Currency</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{$row->user_id}}</td>
                    <td>{{$row->date}}</td>
                    <td>{{$row->country}}</td>
                    <td>{{$row->currency}}</td>
                    <td>{{$row->amount_in_cents}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
