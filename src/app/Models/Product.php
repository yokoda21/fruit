<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description'
    ];

    /**
     * 季節との多対多リレーション
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }
}
