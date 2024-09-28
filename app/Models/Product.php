<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $table = "products";
    protected $casts = [

        'image' => 'array',
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id');
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class, 'variety_id');
    }
}
