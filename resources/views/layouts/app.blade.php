<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NearBuy - Local Business Promotions</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col h-full text-gray-800">

    <!-- Global Header/Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-blue-600">
                        Near<span class="text-gray-900">Buy</span>
                    </a>
                    
                    <!-- City Selector Dropdown Form -->
                    @if(isset($cities) && $cities->count() > 0)
                    <form action="{{ route('set-city') }}" method="POST" class="hidden sm:block">
                        @csrf
                        <select name="city_slug" onchange="this.form.submit()" class="bg-gray-100 text-gray-700 text-sm rounded-md border-0 py-1.5 px-3 focus:ring-2 focus:ring-blue-500">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->slug }}" {{ session('selected_city_slug') == $city->slug ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @endif
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">All Deals</a>

                    @auth
                        <!-- Dashboard Links depending on Role -->
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Admin Dashboard</a>
                        @elseif(auth()->user()->isBusiness())
                            <a href="{{ route('business.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Business Dashboard</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">My Saved Deals</a>
                        @endif

                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-600 hidden md:inline">Hello, {{ auth()->user()->name }}</span>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md transition duration-150">Register Business / User</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Global Alert Notifications -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} NearBuy Portal. Connecting local buyers and local sellers.
        </div>
    </footer>

</body>
</html>