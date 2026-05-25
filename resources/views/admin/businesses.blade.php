@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
        &larr; Back to Dashboard
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Registered Store Profiles</h1>
    <p class="text-sm text-gray-500 mt-1">Monitor registered business storefront profiles and suspend or restore active access privileges.</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    @if($businesses->isEmpty())
        <div class="text-center py-12 text-gray-500 text-sm">
            No business profiles registered on the platform yet.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
            <thead class="bg-gray-50 font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Store Name</th>
                    <th class="px-6 py-3">Owner Contact</th>
                    <th class="px-6 py-3">Location City</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($businesses as $business)
                    <tr>
                        <td class="px-6 py-4 flex items-center gap-3">
                            @if($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="logo" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                            @endif
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $business->name }}</span>
                                <span class="text-[10px] text-gray-400">Slug: {{ $business->slug }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold block text-gray-900">{{ $business->owner->name }}</span>
                            <span class="text-gray-500 text-[10px] block">{{ $business->owner->email }}</span>
                            <span class="text-gray-500 text-[10px] block">{{ $business->phone ?? 'No phone' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $business->city->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $business->address }}</td>
                        <td class="px-6 py-4">
                            @if($business->is_active)
                                <span class="text-[10px] bg-green-100 text-green-800 px-2.5 py-0.5 rounded font-bold uppercase">Approved</span>
                            @else
                                <span class="text-[10px] bg-red-100 text-red-800 px-2.5 py-0.5 rounded font-bold uppercase">Suspended</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.businesses.toggle', $business->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-semibold {{ $business->is_active ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }}">
                                    {{ $business->is_active ? 'Suspend Store' : 'Approve Store' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $businesses->links() }}
        </div>
    @endif
</div>
@endsection