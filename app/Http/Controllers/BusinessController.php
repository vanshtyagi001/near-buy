<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\City;
use App\Models\Category;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Business Dashboard main entry
     */
    public function dashboard()
    {
        $business = auth()->user()->business;

        if (!$business) {
            return redirect()->route('business.create');
        }

        $deals = Deal::where('business_id', $business->id)->with('category')->latest()->get();

        return view('business.dashboard', compact('business', 'deals'));
    }

    /**
     * Show form to create business profile details
     */
    public function create()
    {
        if (auth()->user()->business) {
            return redirect()->route('business.dashboard');
        }

        $cities = City::where('is_active', true)->get();
        return view('business.create', compact('cities'));
    }

    /**
     * Store Business profile details
     */
    public function store(Request $request)
    {
        if (auth()->user()->business) {
            return redirect()->route('business.dashboard');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city_id' => 'required|exists:cities,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Business::create([
            'user_id' => auth()->id(),
            'city_id' => $request->city_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000, 9999),
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'logo' => $logoPath,
            'is_active' => true,
        ]);

        return redirect()->route('business.dashboard')->with('success', 'Business profile registered successfully.');
    }

    /**
     * Edit Deal creation form
     */
    public function createDeal()
    {
        $categories = Category::all();
        return view('business.deals.create', compact('categories'));
    }

    /**
     * Store Deal entry
     */
    public function storeDeal(Request $request)
    {
        $business = auth()->user()->business;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'original_price' => 'nullable|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('deals', 'public');
        }

        Deal::create([
            'business_id' => $business->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(1000, 9999),
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'expiry_date' => $request->expiry_date,
            'image' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('business.dashboard')->with('success', 'Deal created successfully.');
    }

    /**
     * Edit Deal form
     */
    public function editDeal(Deal $deal)
    {
        // Safety check to ensure business owner editing own deal
        if ($deal->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        $categories = Category::all();
        return view('business.deals.edit', compact('deal', 'categories'));
    }

    /**
     * Update Deal entry
     */
    public function updateDeal(Request $request, Deal $deal)
    {
        if ($deal->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'original_price' => 'nullable|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
            }
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('business.dashboard')->with('success', 'Deal updated successfully.');
    }

    /**
     * Delete Deal entry
     */
    public function destroyDeal(Deal $deal)
    {
        if ($deal->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }

        $deal->delete();

        return redirect()->route('business.dashboard')->with('success', 'Deal removed.');
    }
}