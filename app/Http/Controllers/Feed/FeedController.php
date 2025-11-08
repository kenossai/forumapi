<?php

namespace App\Http\Controllers\Feed;

use App\Models\Feed;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:6',
        ]);

        auth()->user()->feeds()->create([
            'content' => $request->input('content'),
        ]);

        return response()->json(['message' => 'Feed created successfully'], 201);
    }

    public function like(Request $request, $feed_id)
    {
        $feed = Feed::whereId($feed_id)->first();

        if (!$feed) {
            return response()->json(['message' => 'Feed not found'], 404);
        }

        $unlike = Like::where('user_id', auth()->id())->where('feed_id', $feed_id)->first();
        if ($unlike) {
            $unlike->delete();
            return response()->json(['message' => 'Unliked'], 200);
        }
        $like = Like::create([
            'user_id' => auth()->id(),
            'feed_id' => $feed_id,
        ]);
        if ($like) {
            return response()->json(['message' => 'Liked'], 200);
        }
        // return response()->json(['message' => 'Feed liked successfully'], 200);
    }
}
