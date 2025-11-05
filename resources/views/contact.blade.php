@extends('layouts.app')

@section('title','Contact Us')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<div class="main-body">

    <div class="header">
        <h1>Contact Us</h1>
        <p class="lead">Get in touch with us. We'd love to hear from you.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

<div class="content-body">
    <div class="send-message">
        <h5 class="card-title">Send us a Message</h5>
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <div class="contact-information">
        <h5 class="card-title">Contact Information</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
                <strong>Address:</strong><br>
                123 Main Street<br>
                City, State 12345
            </li>
            <li class="mb-2">
                <strong>Phone:</strong><br>
                +1 (555) 123-4567
            </li>
            <li class="mb-2">
                <strong>Email:</strong><br>
                info@example.com
            </li>
            <li class="mb-2">
                <strong>Business Hours:</strong><br>
                Mon-Fri: 9AM-5PM<br>
                Sat: 10AM-2PM
            </li>
        </ul>
    </div>
</div>
</div>
@endsection