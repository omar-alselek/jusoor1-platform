<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('social.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('social.posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'images.*' => 'nullable|image|max:2048',
            'privacy' => 'required|in:public,friends',
        ]);
        
        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $validated['content'];
        $post->privacy = $validated['privacy'];
        
        // Process images if present
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
            // تخزين المصفوفة مباشرة دون استخدام json_encode
            $post->images = $imagePaths;
        }
        
        $post->save();
        
        return redirect()->route('social.feed')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments.user']);
        
        return view('social.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        // Check if the user is authorized to edit the post
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('social.feed')
                ->with('error', 'You are not authorized to edit this post.');
        }
        
        return view('social.posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Check if the user is authorized to update the post
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('social.feed')
                ->with('error', 'You are not authorized to update this post.');
        }
        
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'privacy' => 'required|in:public,friends',
        ]);
        
        $post->content = $validated['content'];
        $post->privacy = $validated['privacy'];
        $post->save();
        
        return redirect()->route('social.posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        // Check if the user is authorized to delete the post
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('social.feed')
                ->with('error', 'You are not authorized to delete this post.');
        }
        
        $post->delete();
        
        return redirect()->route('social.feed')
            ->with('success', 'Post deleted successfully!');
    }
    
    /**
     * Like or unlike a post
     */
    public function like(Post $post)
    {
        $user_id = auth()->id();
        
        // Check if the user already liked the post
        $like = Like::where('user_id', $user_id)
            ->where('post_id', $post->id)
            ->first();
            
        if ($like) {
            // Unlike the post
            $like->delete();
            $message = 'Post unliked successfully!';
        } else {
            // Like the post
            Like::create([
                'user_id' => $user_id,
                'post_id' => $post->id,
            ]);
            $message = 'Post liked successfully!';
        }
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'likes_count' => $post->likes()->count(),
            ]);
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Add a comment to a post
     */
    public function comment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);
        
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->content = $validated['content'];
        $comment->save();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully!',
                'comment' => $comment,
                'user' => auth()->user()->only(['id', 'name']),
            ]);
        }
        
        return back()->with('success', 'Comment added successfully!');
    }
    
    /**
     * Update an existing comment
     */
    public function updateComment(Request $request, Comment $comment)
    {
        // التحقق من أن المستخدم هو مالك التعليق
        if (auth()->id() !== $comment->user_id) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مصرح لك بتعديل هذا التعليق'
                ], 403);
            }
            
            return back()->with('error', 'غير مصرح لك بتعديل هذا التعليق');
        }
        
        // تعامل مع طلبات JSON بشكل مختلف
        if ($request->isJson() || $request->expectsJson()) {
            $validated = $request->validate([
                'content' => 'required|string|max:500',
            ]);
        } else {
            $validated = $request->validate([
                'content' => 'required|string|max:500',
            ]);
        }
        
        $comment->content = $validated['content'];
        $comment->save();
        
        if (request()->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث التعليق بنجاح!',
                'comment' => $comment
            ]);
        }
        
        return back()->with('success', 'تم تحديث التعليق بنجاح!');
    }
    
    /**
     * Delete a comment
     */
    public function deleteComment(Request $request, Comment $comment)
    {
        // التحقق من أن المستخدم هو مالك التعليق
        if (auth()->id() !== $comment->user_id) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مصرح لك بحذف هذا التعليق'
                ], 403);
            }
            
            return back()->with('error', 'غير مصرح لك بحذف هذا التعليق');
        }
        
        $comment->delete();
        
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف التعليق بنجاح!'
            ]);
        }
        
        return back()->with('success', 'تم حذف التعليق بنجاح!');
    }
} 