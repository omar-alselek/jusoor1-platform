<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Get the friendships where the user is the sender.
     */
    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }
    
    /**
     * Get the friendships where the user is the receiver.
     */
    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }
    
    /**
     * Get all friendships for the user.
     */
    public function friendships()
    {
        return $this->sentFriendships->merge($this->receivedFriendships);
    }
    
    /**
     * Get all friends of the user (friendships with status = accepted).
     */
    public function friends()
    {
        $sentFriendIds = $this->sentFriendships()
            ->where('status', 'accepted')
            ->pluck('receiver_id')
            ->toArray();
            
        $receivedFriendIds = $this->receivedFriendships()
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->toArray();
            
        return User::whereIn('id', array_merge($sentFriendIds, $receivedFriendIds))->get();
    }
    
    /**
     * Check if the user is friends with another user.
     */
    public function isFriendsWith($userId)
    {
        return $this->sentFriendships()
            ->where('receiver_id', $userId)
            ->where('status', 'accepted')
            ->exists()
        || $this->receivedFriendships()
            ->where('sender_id', $userId)
            ->where('status', 'accepted')
            ->exists();
    }

    /**
     * Check if the user has a pending friend request from another user.
     */
    public function hasPendingFriendRequestFrom($userId)
    {
        return $this->receivedFriendships()
            ->where('sender_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }
    
    /**
     * Check if the user has sent a pending friend request to another user.
     */
    public function hasSentPendingFriendRequestTo($userId)
    {
        return $this->sentFriendships()
            ->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Get the volunteers for the user.
     */
    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
    
    /**
     * Get the messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    /**
     * Get the messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    
    /**
     * Get the unread messages for the user.
     */
    public function unreadMessages()
    {
        return $this->receivedMessages()->where('is_read', false);
    }
    
    /**
     * Get the conversations where the user is a participant.
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }
}
