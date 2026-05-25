@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Merchant Header Banner -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            @if($business->logo)
                <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-100">
            @endif
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $business->name }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">Operating in: <span class="font-semibold text-gray-700">{{ $business->city->name }}</span></p>
                <p class="text-xs text-gray-500">Address: {{ $business->address }}</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('business.deals.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-center font-medium text-xs px-4 py-2.5 rounded-lg transition duration-150">
                + Create New Promotion
            </a>
        </div>
    </div>

    <!-- Inventory / Deals List -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4">Our Published Promotional Offers</h2>

        @if($deals->isEmpty())
            <div class="text-center py-12 bg-white border border-gray-200 rounded-xl">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No deals published yet</h3>
                <p class="mt-1 text-sm text-gray-500">Add your first custom discount offer, seasonal clearance, or coupon.</p>
                <a href="{{ route('business.deals.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs px-4 py-2 rounded-lg transition">
                    Create First Deal
                </a>
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                    <thead class="bg-gray-50 font-medium text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">Deal Details</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Discount Details</th>
                            <th scope="col" class="px-6 py-3">Expiry Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-700">
                        @foreach($deals as $deal)
                            <tr>
                                <!-- Title & Preview link -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $deal->title }}</div>
                                    <a href="{{ route('deal.show', $deal->slug) }}" target="_blank" class="text-[10px] text-blue-600 hover:underline">
                                        View Public Page &nearr;
                                    </a>
                                </td>
                                <!-- Category -->
                                <td class="px-6 py-4">
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded">
                                        {{ $deal->category->name }}
                                    </span>
                                </td>
                                <!-- Discount Price -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ number_format($deal->discount_percentage, 0) }}% Off</div>
                                    @if($deal->discounted_price)
                                        <div class="text-xs text-gray-500">${{ number_format($deal->discounted_price, 2) }} <span class="line-through text-[10px]">${{ number_format($deal->original_price, 2) }}</span></div>
                                    @endif
                                </td>
                                <!-- Status / Expiry -->
                                <td class="px-6 py-4">
                                    @if($deal->expiry_date->isPast())
                                        <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold">EXPIRED</span>
                                    @else
                                        <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold">ACTIVE</span>
                                    @endif
                                    <div class="text-xs text-gray-500 mt-1">Exp: {{ $deal->expiry_date->format('Y-m-d') }}</div>
                                </td>
                                <!-- Actions -->
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap text-xs font-semibold">
                                    <a href="{{ route('business.deals.edit', $deal->id) }}" class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>
                                    <form action="{{ route('business.deals.destroy', $deal->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this deal permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection