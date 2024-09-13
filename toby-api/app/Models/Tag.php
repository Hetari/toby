<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id'];

    // Many-to-Many relationship with Collection
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_tag');
    }
}
