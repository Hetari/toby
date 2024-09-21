<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'collection_id'];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
        ];
    }
}
