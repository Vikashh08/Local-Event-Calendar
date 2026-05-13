<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'date',
        'time',
        'location',
        'status',
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
