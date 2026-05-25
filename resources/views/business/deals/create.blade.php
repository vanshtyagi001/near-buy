@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('business.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
            &larr; Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Publish a New Deal</h1>
        <p class="text-sm text-gray-500 mt-1">Advertise your discount, voucher code, or savings package to local buyers.</p>
    </div>

    <!-- Form -->
    <form action="{{ route('business.deals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Deal Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Deal Title / Tagline</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="e.g. 50% Off Large Pizzas on Tuesdays">
        </div>

        <!-- Category selector -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Deal Category</label>
            <select id="category_id" name="category_id" required 
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Detailed Description & Conditions</label>
            <textarea id="description" name="description" rows="4" required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Provide full details of the offer, including instructions on how to redeem it and any restrictions..."></textarea>
        </div>

        <!-- Pricing parameters and discounts -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Discount Percentage -->
            <div>
                <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount %</label>
                <input type="number" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', 0) }}" required min="0" max="100" step="1"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Original Price -->
            <div>
                <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price ($)</label>
                <input type="number" id="original_price" name="original_price" value="{{ old('original_price') }}" min="0" step="0.01"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Optional">
            </div>

            <!-- Discounted Price -->
            <div>
                <label for="discounted_price" class="block text-sm font-medium text-gray-700">Deal Price ($)</label>
                <input type="number" id="discounted_price" name="discounted_price" value="{{ old('discounted_price') }}" min="0" step="0.01"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Optional">
            </div>
        </div>

        <!-- Expiry Date -->
        <div>
            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Offer Expiration Date</label>
            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <p class="text-[10px] text-gray-400 mt-1">The deal will automatically hide from public feeds once this date passes.</p>
        </div>

        <!-- Deal Banner Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Upload Promotional Image</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-[10px] text-gray-400 mt-1">Recommended size: 800x600px. Max size 2MB (JPG, PNG, WebP).</p>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-3 pt-3 border-t border-gray-100">
            <button type="submit" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition duration-150 text-center">
                Publish Deal
            </button>
            <a href="{{ route('business.dashboard') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-5 py-2.5 rounded-lg text-sm transition duration-150 text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection