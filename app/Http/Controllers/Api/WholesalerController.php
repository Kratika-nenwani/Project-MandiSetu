<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WholesalerController extends Controller
{
    public function get_products()
    {
        $id=Auth::id();
        $products = Product::where('user_id', $id)->get();
    
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found for this user',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }
   
}
