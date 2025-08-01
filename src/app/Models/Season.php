<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    /**
     * 商品との多対多リレーション
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
