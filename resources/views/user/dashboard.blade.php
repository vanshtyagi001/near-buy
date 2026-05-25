@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- User Profile Header Card -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your favorited local savings</p>
        </div>
        <div class="border-t md:border-t-0 md:border-l border-gray-150 pt-4 md:pt-0 md:pl-6 text-xs text-gray-600 space-y-1">
            <p><span class="font-semibold text-gray-700">Account Type:</span> Customer</p>
            <p><span class="font-semibold text-gray-700">Email:</span> {{ $user->email }}</p>
            <p><span class="font-semibold text-gray-700">Base Location:</span> {{ $user->city->name ?? 'None' }}</p>
        </div>
    </div>

    <!-- Favorite Deals Grid Section -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4">My Saved Promotions</h2>

        @if($favorites->isEmpty())
            <div class="text-center py-12 bg-white border border-gray-200 rounded-xl">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.25.588 1.81l-3.97 2.885a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.885a1 1 0 00-1.18 0l-3.97 2.885c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.49 11.23c-.772-.56-.373-1.81.588-1.81h4.906a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No saved deals yet</h3>
                <p class="mt-1 text-sm text-gray-500">Go back to the homepage to explore and bookmark discounts.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs px-4 py-2 rounded-lg transition">
                    Explore Deals
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $deal)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                    {{ $deal->category->name }}
                                </span>
                                <span class="text-[10px] text-gray-500 font-medium">
                                    {{ $deal->business->name }}
                                </span>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 line-clamp-1 mb-1">{{ $deal->title }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2">{{ $deal->description }}</p>
                        </div>
                        <div class="bg-gray-50 px-5 py-3 border-t border-gray-150 flex items-center justify-between">
                            <span class="text-xs text-red-500 font-medium">
                                Expires: {{ $deal->expiry_date->format('M d') }}
                            </span>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('deal.show', $deal->slug) }}" class="text-xs font-semibold text-blue-600 hover:underline">
                                    View
                                </a>
                                <form action="{{ route('user.favorite.toggle', $deal->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">
                                        Unsave
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection