@extends('layouts.app')

@section('title', 'Unauthorized Access')

@section('content')

    <div class="page-content text-center">
        <div class="container-fluid">
            <h1>404</h1>
            <h2>Page Not Found</h2>
            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
        </div>
    </div>
@endsection
