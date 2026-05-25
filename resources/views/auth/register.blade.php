@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg shadow-sm p-6 sm:p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create your Account</h1>
        <p class="text-gray-500 text-sm mt-1">Join NearBuy to promote or discover local deals</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Role Select -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Account Type</label>
            <div class="grid grid-cols-2 gap-4 mt-1">
                <label class="flex items-center gap-2 border border-gray-200 rounded-md p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="role" value="user" checked class="text-blue-600 focus:ring-blue-500">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Regular User</p>
                        <p class="text-xs text-gray-500">Browse and Save Deals</p>
                    </div>
                </label>
                <label class="flex items-center gap-2 border border-gray-200 rounded-md p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="role" value="business" class="text-blue-600 focus:ring-blue-500">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Business Owner</p>
                        <p class="text-xs text-gray-500">Post Offers</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- City Select -->
        <div>
            <label for="city_id" class="block text-sm font-medium text-gray-700">Your Base City</label>
            <select id="city_id" name="city_id" required 
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Select your home city</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number (Optional)</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-md transition duration-150 text-sm mt-2">
            Sign Up
        </button>

        <p class="text-xs text-center text-gray-500 mt-4">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
        </p>
    </form>
</div>
@endsection