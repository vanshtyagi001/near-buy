@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
        &larr; Back to Dashboard
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Manage Categories</h1>
    <p class="text-sm text-gray-500 mt-1">Create general categories to index and catalog promotional offers.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Create Category Form -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm h-fit">
        <h2 class="text-sm font-bold text-gray-900 mb-4">Add Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-xs font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" required placeholder="e.g. Restaurants"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label for="icon" class="block text-xs font-medium text-gray-700">Icon / CSS Code (Optional)</label>
                <input type="text" id="icon" name="icon" placeholder="e.g. coffee"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-xs transition">
                Add Category
            </button>
        </form>
    </div>

    <!-- Right: Categories List Table -->
    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
            <thead class="bg-gray-50 font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Category Name</th>
                    <th class="px-6 py-3">Slug</th>
                    <th class="px-6 py-3">CSS Identifier</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-gray-500 font-mono text-[10px]">{{ $category->icon ?? 'None' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection