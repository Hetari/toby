<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'url', 'collection_id'];

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