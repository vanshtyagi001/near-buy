<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show User Dashboard with Favorited Deals
     */
    public function dashboard()
    {
        $user = auth()->user();
        // Load active, unexpired favorited deals
        $favorites = $user->favorites()
            ->where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->with(['business', 'category'])
            ->get();

        return view('user.dashboard', compact('user', 'favorites'));
    }

    /**
     * Save a deal to user favorites
     */
    public function toggleFavorite(Deal $deal)
    {
        $user = auth()->user();

        // Check if already favorited
        if ($user->favorites()->where('deal_id', $deal->id)->exists()) {
            $user->favorites()->detach($deal->id);
            $message = 'Deal removed from favorites.';
        } else {
            $user->favorites()->attach($deal->id);
            $message = 'Deal saved to favorites.';
        }

        return redirect()->back()->with('success', $message);
    }
}