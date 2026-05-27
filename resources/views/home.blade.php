@extends('layouts.app')

@section('content')

<!-- Category Filter Tabs -->
<div class="mb-8 mt-4">
    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Browse Categories</h3>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('home', array_merge(request()->except('category'), ['category' => null])) }}" 
           class="px-4 py-2 rounded-full text-xs font-medium border transition {{ !$selectedCategorySlug ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
            All Categories
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', array_merge(request()->except('category'), ['category' => $category->slug])) }}" 
               class="px-4 py-2 rounded-full text-xs font-medium border transition {{ $selectedCategorySlug == $category->slug ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</div>

<!-- Active Filter Status -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">
        Latest Promotional Deals @if(session('selected_city_name')) in {{ session('selected_city_name') }} @endif
    </h2>
    <span class="text-xs text-gray-500">Showing {{ $deals->count() }} active listings</span>
</div>

<!-- Deals Grid -->
@if($deals->isEmpty())
    <div class="text-center py-12 bg-white border border-gray-200 rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">No active promotions found</h3>
        <p class="mt-1 text-sm text-gray-500">Try changing your filters or selected city.</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($deals as $deal)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition duration-200 flex flex-col">
                <!-- Deal Image / Placeholder -->
                <div class="relative h-48 bg-gray-100">
                    @if($deal->image)
                        <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                            <span class="text-sm font-medium">NearBuy Promo Image</span>
                        </div>
                    @endif
                    <!-- Discount Badge -->
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded">
                        {{ number_format($deal->discount_percentage, 0) }}% OFF
                    </span>
                </div>

                <!-- Deal Info -->
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                {{ $deal->category->name }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $deal->business->city->name }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 line-clamp-1 mb-1">
                            {{ $deal->title }}
                        </h3>
                        <p class="text-xs text-gray-600 line-clamp-2 mb-4">
                            {{ $deal->description }}
                        </p>
                    </div>

                    <div>
                        <!-- Pricing Details -->
                        <div class="flex items-baseline gap-2 mb-4">
                            @if($deal->discounted_price)
                                <span class="text-lg font-extrabold text-gray-900">${{ number_format($deal->discounted_price, 2) }}</span>
                                <span class="text-xs text-gray-400 line-through">${{ number_format($deal->original_price, 2) }}</span>
                            @else
                                <span class="text-base font-bold text-gray-900">Value Discount Option</span>
                            @endif
                        </div>

                        <!-- Card Action -->
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3 text-xs">
                            <span class="text-red-500 font-medium">
                                Expires: {{ $deal->expiry_date->format('M d, Y') }}
                            </span>
                            <a href="{{ route('deal.show', $deal->slug) }}" class="text-blue-600 font-semibold hover:underline">
                                View Deal &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination links -->
    <div class="mt-8">
        {{ $deals->appends(request()->input())->links() }}
    </div>
@endif
@endsection