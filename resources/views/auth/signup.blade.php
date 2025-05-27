@extends('admin.layouts.app')

@section('title', 'Signup - Advice Associates Real Estate Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-xl font-semibold mb-4">Sign Up</h1>

        <form id="signupForm">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" placeholder="John Doe" required>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="w-full border px-3 py-2 rounded" placeholder="name@example.com" required>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full border px-3 py-2 rounded" placeholder="Password" required>
            </div>

            <!-- Terms & Conditions -->
            <div class="mb-4">
                <div class="flex items-center mb-0">
                    <input class="form-checkbox appearance-none rounded border border-gray-200 accent-green-600 checked:appearance-auto dark:accent-green-600 focus:border-green-300 focus:ring-0 focus:ring-green-200 focus:ring-opacity-50 mr-2" type="checkbox" value="" id="acceptTerms">
                    <label class="text-slate-400" for="acceptTerms">I Accept <a href="#" class="text-green-600">Terms and Conditions</a></label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">Register</button>
            </div>

            <!-- Redirect to Login -->
            <div class="text-center">
                <span class="text-slate-400">Already have an account? </span> <a href="{{ route('login') }}" class="text-black">Sign in</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('signupForm');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                axios.post('{{ route("register") }}', formData)
                    .then(response => {
                        alert('Registration successful!');
                        window.location.href = '{{ route("login") }}';  // Redirect to login page after successful registration
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred during registration.');
                    });
            });
        });
    </script>
@endpush
