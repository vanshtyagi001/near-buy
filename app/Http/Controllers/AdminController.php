<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Business;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Admin Dashboard landing stats
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_businesses' => Business::count(),
            'active_deals' => Deal::where('is_active', true)->whereDate('expiry_date', '>=', now())->count(),
            'total_cities' => City::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Manage Cities list
     */
    public function cities()
    {
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.cities', compact('cities'));
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
        ]);

        City::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'City added successfully.');
    }

    public function destroyCity(City $city)
{
    // Deleting a city cascades and automatically deletes its businesses and deals 
    // due to foreign keys constraints setup in migrations
    $city->delete();
    return redirect()->back()->with('success', 'City deleted successfully.');
}

    /**
     * Manage Categories list
     */
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string|max:100', // e.g. FontAwesome icon class
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    /**
     * Manage Businesses profiles
     */
    public function businesses()
    {
        $businesses = Business::with(['owner', 'city'])->latest()->paginate(15);
        return view('admin.businesses', compact('businesses'));
    }

    public function toggleBusiness(Business $business)
    {
        $business->update(['is_active' => !$business->is_active]);
        return redirect()->back()->with('success', 'Business status toggled.');
    }

    /**
     * Manage All Deals
     */
    public function deals()
    {
        $deals = Deal::with(['business', 'category'])->latest()->paginate(15);
        return view('admin.deals', compact('deals'));
    }

    public function deleteDeal(Deal $deal)
    {
        $deal->delete();
        return redirect()->back()->with('success', 'Deal removed successfully.');
    }

    /**
     * Manage Users (Customers)
     */
    public function users()
    {
        $users = User::where('role', 'user')->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return redirect()->back()->with('success', 'User profile status changed.');
    }
}