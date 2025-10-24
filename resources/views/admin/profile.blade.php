@extends('layouts.app') {{-- or your admin layout --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Profile</div>

                    <div class="card-body">
                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>ID:</strong> {{ Auth::user()->id }}</p>

                        @if(Auth::user()->identities->where('provider', 'eventbrite')->first())
                            <div class="mt-3">
                                <strong>Eventbrite Connected:</strong> Yes
                            </div>
                        @endif

                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
