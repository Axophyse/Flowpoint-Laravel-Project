@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css')}}">

<div class="home-body">

    <div class="dashboard-header">
        <h1>Welcome {{ Auth::user()->name }}</h1>
    </div>
    <div>
        <h5>What do you want to do today?</h5>
    </div>

</div>
@endsection
