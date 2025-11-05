@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css')}}">

<div class="main-body">

    <div>
        <h2>Welcome {{ Auth::user()->name }}</h2>
    </div>

</div>
@endsection
