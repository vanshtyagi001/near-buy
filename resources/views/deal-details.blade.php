@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left/Center Columns: Main Coupon Details -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden p-6 shadow-sm">
            <!-- Back Link -->
            <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-4">
                &larr; Back to all deals
            </a>

            <!-- Deal Heading -->
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-2.5 py-1 rounded">
                    {{ $deal->category->name }}
                </span>
                <span class="bg-red-50 text-red-600 text-xs font-bold px-2.5 py-1 rounded">
                    {{ number_format($deal->discount_percentage, 0) }}% Off Deal
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-4">{{ $deal->title }}</h1>

            <!-- Promo Image -->
            <div class="relative h-64 md:h-96 w-full bg-gray-100 rounded-lg overflow-hidden mb-6">
                @if($deal->image)
                    <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                        <span class="text-sm">No Promotion Image Provided</span>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <h3 class="text-lg font-bold text-gray-900 mb-2">Offer Details</h3>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line mb-6">
                {{ $deal->description }}
            </p>

            <div class="border-t border-gray-100 pt-6 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-gray-400 block uppercase font-semibold">Promotion Expires</span>
                    <span class="text-sm font-semibold text-red-600">{{ $deal->expiry_date->format('F d, Y') }}</span>
                </div>

                <!-- Pricing Display -->
                <div class="flex items-baseline gap-2">
                    @if($deal->discounted_price)
                        <div class="text-right">
                            <span class="text-xs text-gray-400 block uppercase font-semibold">Deal Price</span>
                            <span class="text-3xl font-extrabold text-blue-600">${{ number_format($deal->discounted_price, 2) }}</span>
                            <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($deal->original_price, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Business Contact Card & Interactive Actions -->
    <div class="space-y-6">
        
        <!-- Favorites Interaction (Only for 'user' accounts) -->
        @auth
            @if(auth()->user()->role === 'user')
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-center">
                    <p class="text-sm text-gray-500 mb-4">Would you like to keep track of this deal?</p>
                    <form action="{{ route('user.favorite.toggle', $deal->id) }}" method="POST">
                        @csrf
                        @if(auth()->user()->favorites()->where('deal_id', $deal->id)->exists())
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2.5 rounded-lg text-sm border border-red-200 transition duration-150">
                                &#9733; Remove from Favorites
                            </button>
                        @else
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg text-sm transition duration-150">
                                &#9734; Save to Favorites
                            </button>
                        @endif
                    </form>
                </div>
            @endif
        @else
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-center">
                <p class="text-xs text-gray-500 mb-3">Want to save this deal for your next visit?</p>
                <a href="{{ route('login') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg text-xs transition duration-150">
                    Log in to Save Favorites
                </a>
            </div>
        @endauth

        <!-- Business details -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Offered By</h3>

            <div class="flex items-center gap-3 mb-4">
                @if($deal->business->logo)
                    <img src="{{ asset('storage/' . $deal->business->logo) }}" alt="{{ $deal->business->name }}" class="w-12 h-12 rounded-full object-cover border border-gray-200">
                @endif
                <div>
                    <h4 class="text-base font-bold text-gray-900">{{ $deal->business->name }}</h4>
                    <span class="text-xs text-gray-500">{{ $deal->business->city->name }}</span>
                </div>
            </div>

            @if($deal->business->description)
                <p class="text-xs text-gray-600 leading-relaxed mb-4">
                    {{ $deal->business->description }}
                </p>
            @endif

            <div class="space-y-3 pt-4 border-t border-gray-100 text-xs">
                <!-- Address -->
                <div>
                    <span class="text-gray-400 block font-semibold">Store Address</span>
                    <span class="text-gray-700 font-medium">{{ $deal->business->address }}</span>
                </div>

                <!-- Phone -->
                @if($deal->business->phone)
                <div>
                    <span class="text-gray-400 block font-semibold">Call Store</span>
                    <span class="text-gray-700 font-medium">{{ $deal->business->phone }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection