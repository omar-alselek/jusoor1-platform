<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'hours',
        'skills',
        'message',
        'status',
        'approved_at',
        'rejected_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the volunteer record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the project that owns the volunteer record.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
