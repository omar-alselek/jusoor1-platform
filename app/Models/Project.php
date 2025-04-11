<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'location',
        'status',
        'start_date',
        'end_date',
        'image',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the donations for the project.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the volunteers for the project.
     */
    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    /**
     * Get the posts for the project.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
