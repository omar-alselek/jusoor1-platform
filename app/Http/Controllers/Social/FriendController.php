<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;

class FriendController extends Controller
{
    /**
     * Display a listing of the user's friends.
     */
    public function index()
    {
        $user_id = auth()->id();
        
        // Get all accepted friendships
        $friends = Friendship::where(function($query) use ($user_id) {
                $query->where('sender_id', $user_id)
                    ->orWhere('receiver_id', $user_id);
            })
            ->where('status', 'accepted')
            ->get();
            
        // Get the actual user models
        $friendIds = $friends->map(function($friendship) use ($user_id) {
            return $friendship->sender_id === $user_id 
                ? $friendship->receiver_id 
                : $friendship->sender_id;
        });
        
        $friends = User::with('profile')
            ->whereIn('id', $friendIds)
            ->get();
            
        // Get pending friend requests received
        $pendingRequests = Friendship::with('sender.profile')
            ->where('receiver_id', $user_id)
            ->where('status', 'pending')
            ->get();
            
        return view('social.friends.index', compact('friends', 'pendingRequests'));
    }
    
    /**
     * Display suggested friends for the user.
     */
    public function suggestions()
    {
        $user_id = auth()->id();
        
        // Get ids of existing friends and pending requests
        $existingRelationships = Friendship::where(function($query) use ($user_id) {
                $query->where('sender_id', $user_id)
                    ->orWhere('receiver_id', $user_id);
            })
            ->get();
            
        $existingUserIds = $existingRelationships->map(function($friendship) use ($user_id) {
            return $friendship->sender_id === $user_id 
                ? $friendship->receiver_id 
                : $friendship->sender_id;
        })->push($user_id);
        
        // Find users who are not already friends or have pending requests
        $suggestions = User::with('profile')
            ->whereNotIn('id', $existingUserIds)
            ->inRandomOrder()
            ->limit(10)
            ->get();
            
        return view('social.friends.suggestions', compact('suggestions'));
    }
    
    /**
     * Send a friend request to a user.
     */
    public function sendRequest(User $user)
    {
        $sender_id = auth()->id();
        $receiver_id = $user->id;
        
        // Check if a friendship already exists
        $existingFriendship = Friendship::where(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id);
            })
            ->orWhere(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                    ->where('receiver_id', $sender_id);
            })
            ->first();
            
        if ($existingFriendship) {
            return back()->with('error', 'A friendship request already exists with this user.');
        }
        
        // Create a new friendship request
        Friendship::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Friend request sent successfully!');
    }
    
    /**
     * Accept a friend request.
     */
    public function acceptRequest(User $user)
    {
        $sender_id = $user->id;
        $receiver_id = auth()->id();
        
        $friendship = Friendship::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->where('status', 'pending')
            ->firstOrFail();
            
        $friendship->status = 'accepted';
        $friendship->save();
        
        return back()->with('success', 'Friend request accepted!');
    }
    
    /**
     * Reject a friend request.
     */
    public function rejectRequest(User $user)
    {
        $sender_id = $user->id;
        $receiver_id = auth()->id();
        
        $friendship = Friendship::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->where('status', 'pending')
            ->firstOrFail();
            
        $friendship->delete();
        
        return back()->with('success', 'Friend request rejected!');
    }
    
    /**
     * Remove a friend.
     */
    public function removeFriend(User $user)
    {
        $user_id = auth()->id();
        $friend_id = $user->id;
        
        Friendship::where(function($query) use ($user_id, $friend_id) {
                $query->where('sender_id', $user_id)
                    ->where('receiver_id', $friend_id);
            })
            ->orWhere(function($query) use ($user_id, $friend_id) {
                $query->where('sender_id', $friend_id)
                    ->where('receiver_id', $user_id);
            })
            ->delete();
            
        return back()->with('success', 'Friend removed successfully!');
    }
    
    /**
     * Search for users.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::with('profile')
            ->where('name', 'like', "%{$query}%")
            ->orWhereHas('profile', function($q) use ($query) {
                $q->where('bio', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            })
            ->paginate(10);
            
        return view('social.search.users', compact('users', 'query'));
    }
} 