<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'variations'];

    protected $casts = [
        'variations' => 'array',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
