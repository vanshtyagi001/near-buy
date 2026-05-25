<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealApiController extends Controller
{
    /**
     * Get list of active promotional deals
     * Supports optional query parameters: ?city=slug & ?category=slug
     */
    public function index(Request $request)
    {
        $query = Deal::where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->whereHas('business', function ($q) {
                $q->where('is_active', true);
            });

        // Filter by City Slug if provided
        if ($request->has('city')) {
            $query->whereHas('business.city', function ($q) use ($request) {
                $q->where('slug', $request->query('city'));
            });
        }

        // Filter by Category Slug if provided
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->query('category'));
            });
        }

        $deals = $query->with(['business:id,name,address,phone', 'category:id,name'])->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Active deals retrieved successfully',
            'data' => $deals
        ], 200);
    }

    /**
     * Show details of an individual promotional deal
     */
    public function show($id)
    {
        $deal = Deal::where('id', $id)
            ->where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->with(['business:id,name,address,phone', 'category:id,name'])
            ->first();

        if (!$deal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Deal not found or has expired'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $deal
        ], 200);
    }
}