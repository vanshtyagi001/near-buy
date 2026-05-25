@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Set Up Your Business Profile</h1>
        <p class="text-sm text-gray-500 mt-1">Please provide details about your shop, office, or service so you can start listing promotional offers.</p>
    </div>

    <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Store Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Business / Store Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g. Downtown Pizza Co.">
        </div>

        <!-- City (Assigned Location) -->
        <div>
            <label for="city_id" class="block text-sm font-medium text-gray-700">City Location</label>
            <select id="city_id" name="city_id" required 
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Select city</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Short Description</label>
            <textarea id="description" name="description" rows="3" 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Describe what products, foods, or services your company provides..."></textarea>
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Physical Address</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g. 123 Main Street, Suite 4B">
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Store Contact Number</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g. (555) 019-2834">
        </div>

        <!-- Logo Upload -->
        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700">Upload Store Logo / Image</label>
            <input type="file" id="logo" name="logo" accept="image/*"
                class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-[10px] text-gray-400 mt-1">Recommended: Square format. Max upload size 2MB (JPG, PNG, WebP).</p>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition duration-150">
            Create Business Profile
        </button>
    </form>
</div>
@endsection