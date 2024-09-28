<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
     protected $table = "purchase_requests";

    protected $fillable = ['product_id', 'quantity', 'unit'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
