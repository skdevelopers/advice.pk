@extends('admin.layouts.app')

@section('title', 'Lockscreen')

@section('content')
    <div class="container py-6 text-center">
        <h1 class="text-2xl font-semibold mb-3">🔒 Screen Locked</h1>
        <p class="text-gray-600 mb-5">Your session is locked. Please sign in again to continue.</p>
        <a href="{{ url('/auth/eventbrite/redirect') }}" class="btn btn-primary">
            Sign in with Eventbrite
        </a>
    </div>
@endsection
