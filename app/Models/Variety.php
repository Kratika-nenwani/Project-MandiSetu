<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $table = "varieties";

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id');
    }
    
}
