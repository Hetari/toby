<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'is_fav', 'description', 'user_id', 'user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function tabs()
    {
        return $this->hasMany(Tab::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
        ];
    }
}
