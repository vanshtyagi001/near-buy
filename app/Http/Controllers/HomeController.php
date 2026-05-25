<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\City;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Render the front main portal page with active deals
     */
    public function index(Request $request)
    {
        // Fetch parameters for filter/search
        $selectedCitySlug = $request->get('city', session('selected_city_slug'));
        $selectedCategorySlug = $request->get('category');
        $searchQuery = $request->get('search');

        // Base query for active deals from active businesses in active cities
        $query = Deal::where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->whereHas('business', function ($q) {
                $q->where('is_active', true);
            })
            ->whereHas('business.city', function ($q) {
                $q->where('is_active', true);
            });

        // Filter by selected City
        if ($selectedCitySlug) {
            $city = City::where('slug', $selectedCitySlug)->where('is_active', true)->first();
            if ($city) {
                // Save city preference to session
                session(['selected_city_id' => $city->id, 'selected_city_slug' => $city->slug, 'selected_city_name' => $city->name]);
                $query->whereHas('business', function ($q) use ($city) {
                    $q->where('city_id', $city->id);
                });
            }
        }

        // Filter by Category
        if ($selectedCategorySlug) {
            $query->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        // Filter by Search text query
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', '%' . $searchQuery . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
                  ->orWhereHas('business', function ($subQ) use ($searchQuery) {
                      $subQ->where('name', 'LIKE', '%' . $searchQuery . '%');
                  });
            });
        }

        // Get matching active deals
        $deals = $query->with(['business', 'category'])->latest()->paginate(12);

        // Fetch meta listings
        $cities = City::where('is_active', true)->get();
        $categories = Category::all();

        return view('home', compact('deals', 'cities', 'categories', 'selectedCitySlug', 'selectedCategorySlug', 'searchQuery'));
    }

    /**
     * Show details of a single promotional deal
     */
    public function showDeal($slug)
    {
        $deal = Deal::where('slug', $slug)
            ->where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->with(['business', 'category'])
            ->firstOrFail();

        return view('deal-details', compact('deal'));
    }

    /**
     * Switch context of active browsing city
     */
    public function setCity(Request $request)
    {
        $request->validate([
            'city_slug' => 'required|exists:cities,slug'
        ]);

        $city = City::where('slug', $request->city_slug)->firstOrFail();
        
        session([
            'selected_city_id' => $city->id, 
            'selected_city_slug' => $city->slug, 
            'selected_city_name' => $city->name
        ]);

        return redirect()->back();
    }
}