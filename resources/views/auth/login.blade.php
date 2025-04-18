@extends('layouts.guest') {{-- Or your guest layout --}}
@section('title', 'Login')

@section('content')

 <div class="max-w-md mx-auto mt-28 bg-white p-8 rounded shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

    {{-- Display general login errors --}}
    @if($errors->has('email') && !$errors->has('password')) {{-- Check specifically for the credential mismatch error --}}
         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $errors->first('email') }}</span>
         </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
               class="w-full border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        {{-- Password --}}
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
             @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Remember Me --}}
        <div class="mb-4 flex items-center">
             <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
             <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Login</button>
        </div>

        <p class="text-center text-sm text-gray-600 mt-4">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>
         </p>
    </form>
</div>
@endsection
