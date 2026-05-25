@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
        &larr; Back to Dashboard
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Manage Supported Cities</h1>
    <p class="text-sm text-gray-500 mt-1">Users can filter, browse, and register within these supported boundary cities.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Create City Form -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm h-fit">
        <h2 class="text-sm font-bold text-gray-900 mb-4">Add Supported City</h2>
        <form action="{{ route('admin.cities.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-xs font-medium text-gray-700">City Name</label>
                <input type="text" id="name" name="name" required placeholder="e.g. Dallas"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-xs transition">
                Add City
            </button>
        </form>
    </div>

    <!-- Right: Cities List Table -->
    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
            <thead class="bg-gray-50 font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">City Name</th>
                    <th class="px-6 py-3">Slug</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($cities as $city)
                    <tr>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $city->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $city->slug }}</td>
                        <td class="px-6 py-4">
                            @if($city->is_active)
                                <span class="text-[10px] bg-green-100 text-green-800 px-2.5 py-0.5 rounded font-bold uppercase">Active</span>
                            @else
                                <span class="text-[10px] bg-gray-100 text-gray-500 px-2.5 py-0.5 rounded font-bold uppercase">Disabled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('Warning: Deleting this city will remove all associated businesses, deals, and promotions. Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection