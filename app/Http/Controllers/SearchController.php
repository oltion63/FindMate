<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $user = auth()->user();

        $results = Post::with('category', 'company', 'location')
            ->where(function ($q) use ($query) {
                $q->where('tittle', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%")
                    ->orWhere('type', 'like', "%$query%")
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('location', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    });
            });

        // 🧩 Add time restriction only for non-premium users
        if (!$user || !$user->is_premium) {
            $results->where('created_at', '<=', now()->subHours(24));
        }

        return response()->json($results->limit(10)->get());
    }
}
