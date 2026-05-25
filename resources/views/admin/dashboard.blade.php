@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Admin Header Banner -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Admin Control Panel</h1>
        <p class="text-sm text-gray-500 mt-1">Supervise operating parameters, review active businesses, and manage local regions.</p>
    </div>

    <!-- Statistical Counter Widgets Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Users -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold uppercase">Total Users</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-gray-900">{{ $stats['total_users'] }}</span>
                <span class="text-xs text-blue-500 font-semibold bg-blue-50 px-2 py-0.5 rounded">Customers</span>
            </div>
        </div>

        <!-- Businesses -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold uppercase">Registered Businesses</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-gray-900">{{ $stats['total_businesses'] }}</span>
                <span class="text-xs text-purple-500 font-semibold bg-purple-50 px-2 py-0.5 rounded">Stores</span>
            </div>
        </div>

        <!-- Active Deals -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold uppercase">Live Deals</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-gray-900">{{ $stats['active_deals'] }}</span>
                <span class="text-xs text-green-500 font-semibold bg-green-50 px-2 py-0.5 rounded">Active</span>
            </div>
        </div>

        <!-- Cities -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <span class="text-xs text-gray-400 font-semibold uppercase">Supported Cities</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl font-extrabold text-gray-900">{{ $stats['total_cities'] }}</span>
                <span class="text-xs text-orange-500 font-semibold bg-orange-50 px-2 py-0.5 rounded">Locations</span>
            </div>
        </div>
    </div>

    <!-- Navigation Hub Cards Grid -->
    <div>
        <h2 class="text-base font-bold text-gray-900 mb-4">Management Hubs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Cities Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Supported Cities</h3>
                    <p class="text-xs text-gray-500 mt-1">Configure physical operating boundaries where buyers discover deals.</p>
                </div>
                <a href="{{ route('admin.cities') }}" class="text-xs font-semibold text-blue-600 hover:underline mt-4 inline-block">
                    Manage Cities &rarr;
                </a>
            </div>

            <!-- Categories Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Deals Categories</h3>
                    <p class="text-xs text-gray-500 mt-1">Organize offers into categorized search groupings such as Food, Salons, or Electronics.</p>
                </div>
                <a href="{{ route('admin.categories') }}" class="text-xs font-semibold text-blue-600 hover:underline mt-4 inline-block">
                    Manage Categories &rarr;
                </a>
            </div>

            <!-- Businesses Control -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Registered Businesses</h3>
                    <p class="text-xs text-gray-500 mt-1">Supervise, suspend, or verify local business profiles and owner details.</p>
                </div>
                <a href="{{ route('admin.businesses') }}" class="text-xs font-semibold text-blue-600 hover:underline mt-4 inline-block">
                    Supervise Stores &rarr;
                </a>
            </div>

            <!-- Deals Management -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">All Active Promotions</h3>
                    <p class="text-xs text-gray-500 mt-1">Monitor, inspect, or immediately clean up spam, fake listings, or expired coupons.</p>
                </div>
                <a href="{{ route('admin.deals') }}" class="text-xs font-semibold text-blue-600 hover:underline mt-4 inline-block">
                    Moderate Active Deals &rarr;
                </a>
            </div>

            <!-- Users Management -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between hover:border-gray-300 transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">User Directory</h3>
                    <p class="text-xs text-gray-500 mt-1">View registered buyer directories or revoke system access privileges.</p>
                </div>
                <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-blue-600 hover:underline mt-4 inline-block">
                    Manage Users &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection