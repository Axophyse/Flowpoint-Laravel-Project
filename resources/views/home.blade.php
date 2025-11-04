@extends('layouts.app')

@section('content')
<div class="body">

    <div>
        <h2>Welcome {{ Auth::user()->name }}</h2>
    </div>

</div>
@endsection
