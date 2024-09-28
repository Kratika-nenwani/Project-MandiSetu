<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\Product;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommodityController extends Controller
{
    public function add_commodity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $commodity = new Commodity();
        $commodity->name = $request->input('name');
        $commodity->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Commodity added successfully',
            'data' => $commodity,
        ], 201);

    }
    public function get_commodities()
    {
        $commodities = Commodity::all();
        if ($commodities->isEmpty()) {
            return response()->json([
                'error' => "No commodities found",
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $commodities,
        ], 200);
    }
    public function edit_commodity(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $commodity = Commodity::find($id);

        if (!$commodity) {
            return response()->json(['success' => false, 'message' => 'Commodity not found'], 404);
        }

        $commodity->name = $request->input('name');
        $commodity->save();

        return response()->json([
            'success' => true,
            'message' => 'Commodity updated successfully',
            'data' => $commodity,
        ], 200);
    }
    public function get_commodity($id)
    {
        $commodity = Commodity::find($id);

        if (!$commodity) {
            return response()->json(['success' => false, 'message' => 'Commodity not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $commodity,
        ], 200);
    }

    public function delete_commodity($id)
    {
        $commodity = Commodity::find($id);

        if (!$commodity) {
            return response()->json(['success' => false, 'message' => 'Commodity not found'], 404);
        }

        $commodity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commodity deleted successfully',
        ], 200);
    }
    public function search($name = null)
    {
        if (!$name) {
            return response()->json(['message' => 'Empty', 'data' => []], 200);
        }

        // Find commodities matching the search term
        $commodities = Commodity::where('name', 'LIKE', "%" . $name . "%")->get();
        $commoditywithvariety = [];

        foreach ($commodities as $commodity) {
            // Get varieties for each commodity
            $varieties = Variety::where('commodity_id', $commodity->id)->get();

            // Get products related to each commodity and its varieties
            $products = Product::where('commodity_id', $commodity->id)
                ->orWhereIn('variety_id', $varieties->pluck('id'))
                ->get();

            // Attach varieties and related products to the commodity
            $commodity->varieties = $varieties;
            $commodity->products = $products;

            $commoditywithvariety[] = $commodity;
        }

        if ($commodities->count() > 0) {
            return response()->json(['message' => 'Related Products', 'data' => $commoditywithvariety], 200);
        } else {
            return response()->json(['message' => 'Not Found', 'data' => $commoditywithvariety], 200);
        }
    }
    // public function search($keyword = null)
    // {
    //     if (!$keyword) {
    //         return response()->json(['message' => 'Empty', 'data' => []], 200);
    //     }

    //     // Search commodities by name
    //     $commodities = Commodity::where('name', 'LIKE', "%" . $keyword . "%")->get();

    //     // Search varieties by name
    //     $varieties = Variety::where('name', 'LIKE', "%" . $keyword . "%")->get();
    //     $variety_ids = $varieties->pluck('id');

    //     // Search products by description and include those with related varieties
    //     $products = Product::where('description', 'LIKE', "%" . $keyword . "%")
    //         ->orWhereIn('variety_id', $variety_ids)
    //         ->get();

    //     // Prepare response data
    //     $commodities_with_varieties_and_products = [];

    //     // Add products to commodities
    //     foreach ($commodities as $commodity) {
    //         $commodity_varieties = Variety::where('commodity_id', $commodity->id)->get();
    //         $commodity_products = $products->filter(function ($product) use ($commodity) {
    //             return $product->commodity_id == $commodity->id;
    //         });

    //         // Attach varieties and products to each commodity
    //         foreach ($commodity_varieties as $variety) {
    //             $variety_products = $products->filter(function ($product) use ($variety) {
    //                 return $product->variety_id == $variety->id;
    //             });

    //             $variety->products = $variety_products;
    //         }

    //         $commodity->varieties = $commodity_varieties;
    //         $commodity->products = $commodity_products;

    //         $commodities_with_varieties_and_products[] = $commodity;
    //     }

    //     // Add products to varieties
    //     foreach ($varieties as $variety) {
    //         $variety_products = $products->filter(function ($product) use ($variety) {
    //             return $product->variety_id == $variety->id;
    //         });

    //         $variety->products = $variety_products;
    //     }

    //     return response()->json([
    //         'message' => 'Search Results',
    //         'data' => [
    //             'commodities' => $commodities_with_varieties_and_products,
    //             'varieties' => $varieties,
    //             'products' => $products
    //         ]
    //     ], 200);
    // }


}
