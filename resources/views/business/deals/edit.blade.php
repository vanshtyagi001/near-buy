@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('business.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
            &larr; Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Your Deal</h1>
        <p class="text-sm text-gray-500 mt-1">Update parameters or expand the schedule of your published discount.</p>
    </div>

    <!-- Form -->
    <form action="{{ route('business.deals.update', $deal->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Deal Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Deal Title / Tagline</label>
            <input type="text" id="title" name="title" value="{{ old('title', $deal->title) }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Category Selector -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Deal Category</label>
            <select id="category_id" name="category_id" required 
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $deal->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Detailed Description & Conditions</label>
            <textarea id="description" name="description" rows="4" required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('description', $deal->description) }}</textarea>
        </div>

        <!-- Pricing parameters and discounts -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Discount Percentage -->
            <div>
                <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount %</label>
                <input type="number" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', (int)$deal->discount_percentage) }}" required min="0" max="100" step="1"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Original Price -->
            <div>
                <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price ($)</label>
                <input type="number" id="original_price" name="original_price" value="{{ old('original_price', $deal->original_price) }}" min="0" step="0.01"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Discounted Price -->
            <div>
                <label for="discounted_price" class="block text-sm font-medium text-gray-700">Deal Price ($)</label>
                <input type="number" id="discounted_price" name="discounted_price" value="{{ old('discounted_price', $deal->discounted_price) }}" min="0" step="0.01"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <!-- Expiry Date -->
        <div>
            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Offer Expiration Date</label>
            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $deal->expiry_date->format('Y-m-d')) }}" required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <!-- Deal Banner Image Upload & Preview -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Promotional Image</label>
            @if($deal->image)
                <div class="mb-3">
                    <p class="text-xs text-gray-400 mb-1">Current Image:</p>
                    <img src="{{ asset('storage/' . $deal->image) }}" alt="Preview" class="h-24 w-36 object-cover rounded-md border border-gray-200">
                </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*"
                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-[10px] text-gray-400 mt-1">Leave empty if you don't wish to change the current promotional graphic.</p>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-3 pt-3 border-t border-gray-100">
            <button type="submit" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition duration-150 text-center">
                Save Changes
            </button>
            <a href="{{ route('business.dashboard') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-5 py-2.5 rounded-lg text-sm transition duration-150 text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection