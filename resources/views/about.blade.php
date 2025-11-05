@extends('layouts.app')

@section('title','Members')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<div class="main-body">

    <div class="about-header">
        <h2>All About Us</h2>
        <p>Learn more about Zenfour Frameworks</p>
    </div>

    <div class="about-sections">
        <div class="about-story">
            <h2>Our Story</h2>
            <p>Four members became one, formed Zenfour Frameworks</p>
        </div>

        <div class="about-mission">
            <h3>Our Mission</h3>
            <p>We do not know our mission, but we try to accomplish these:</p>
            <ul>
                <li>Quality Service</li>
                <li>Customer Satisfaction</li>
                <li>Innovation</li>
                <li>Integrity</li>
            </ul>
        </div>

        <div class="about-members">
            <h3>Members:</h3>
            <ul>
                <li>Corpuz, Cedric</li>
                <li>Berbano, Joshua</li>
                <li>Mainit, Markavana</li>
                <li>Sasil, Perlin</li>
            </ul>
        </div>
    </div>

</div>
@endsection
