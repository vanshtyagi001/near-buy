@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-500 hover:text-blue-600 inline-flex items-center mb-2">
        &larr; Back to Dashboard
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Customer Accounts</h1>
    <p class="text-sm text-gray-500 mt-1">Review standard customer credentials or revoke platform access privileges.</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    @if($users->isEmpty())
        <div class="text-center py-12 text-gray-500 text-sm">
            No customer accounts registered on the platform yet.
        </div>
    @else
        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
            <thead class="bg-gray-50 font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Customer Name</th>
                    <th class="px-6 py-3">Email Address</th>
                    <th class="px-6 py-3">Assigned City Location</th>
                    <th class="px-6 py-3">Registered On</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $user->city->name ?? 'None' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="text-[10px] bg-green-100 text-green-800 px-2.5 py-0.5 rounded font-bold uppercase">Active</span>
                            @else
                                <span class="text-[10px] bg-red-100 text-red-800 px-2.5 py-0.5 rounded font-bold uppercase">Suspended</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-semibold {{ $user->is_active ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }}">
                                    {{ $user->is_active ? 'Suspend' : 'Unsuspend' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection