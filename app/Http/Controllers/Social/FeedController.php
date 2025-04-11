<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class FeedController extends Controller
{
    /**
     * Display the social feed
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Post::with(['user.profile', 'likes', 'comments'])
            ->latest();
        
        // تصفية المنشورات حسب المستخدم إذا تم تحديده
        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }
        
        $posts = $query->paginate(10);
        
        return view('social.feed', compact('posts'));
    }
    
    /**
     * Filter the feed based on user preferences
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $query = Post::with(['user.profile', 'likes', 'comments'])
            ->latest();
            
        // Filter by hashtag if provided
        if ($request->has('hashtag')) {
            $hashtag = $request->hashtag;
            $query->where('content', 'like', "%#{$hashtag}%");
        }
        
        // Filter by region if provided
        if ($request->has('region')) {
            $region = $request->region;
            $query->whereHas('user.profile', function($q) use ($region) {
                $q->where('location', 'like', "%{$region}%");
            });
        }
        
        // تصفية المنشورات حسب المستخدم إذا تم تحديده
        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }
        
        $posts = $query->paginate(10);
        
        return view('social.feed', compact('posts'));
    }
} 