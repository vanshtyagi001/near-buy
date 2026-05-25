@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
        &larr; Back to Dashboard
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Deals & Coupons Moderation</h1>
    <p class="text-sm text-gray-500 mt-1">Monitor published deals, evaluate expiration status, and delete fake, misleading, or spam promotions.</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    @if($deals->isEmpty())
        <div class="text-center py-12 text-gray-500 text-sm">
            No active deals published by merchants yet.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
            <thead class="bg-gray-50 font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Promotional Title</th>
                    <th class="px-6 py-3">Merchant / Store Name</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Discount Rates</th>
                    <th class="px-6 py-3">Expiration Date</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($deals as $deal)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 block">{{ $deal->title }}</span>
                            <span class="text-[10px] text-gray-400 block max-w-sm truncate">{{ $deal->description }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold block text-gray-900">{{ $deal->business->name }}</span>
                            <span class="text-gray-500 text-[10px] block">{{ $deal->business->city->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $deal->category->name }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ number_format($deal->discount_percentage, 0) }}% OFF
                        </td>
                        <td class="px-6 py-4">
                            @if($deal->expiry_date->isPast())
                                <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold uppercase">Expired</span>
                            @else
                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold uppercase">Live</span>
                            @endif
                            <span class="block text-gray-500 text-[10px] mt-1">{{ $deal->expiry_date->format('Y-m-d') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.deals.delete', $deal->id) }}" method="POST" onsubmit="return confirm('Delete this deal from the platform permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700">
                                    Remove Deal
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $deals->links() }}
        </div>
    @endif
</div>
@endsection