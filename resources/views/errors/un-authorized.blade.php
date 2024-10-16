@extends('layouts.app')

@section('title', 'Unauthorized Access')

@section('content')

    <div class="page-content text-center">
        <div class="container-fluid">
            <h1>403</h1>
            <h2>Unauthorized Access</h2>
            <p>You do not have permission to view this page.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
        </div>
    </div>
@endsection
