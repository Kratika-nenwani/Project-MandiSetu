<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function add_product(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'commodity_id' => 'required|exists:commodities,id',
            'variety_id' => 'required|exists:varieties,id',
            'quality' => 'required',
            'rate' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'state' => 'required',
            'district' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user_id=Auth::id();
        $product = new Product();
        $product->user_id = $user_id;
        $product->commodity_id = $request->input('commodity_id');
        $product->variety_id = $request->input('variety_id');
        $product->quality = $request->input('quality');
        $product->rate = $request->input('rate');
        $product->quantity = $request->input('quantity');
        $product->state = $request->input('state');
        $product->district = $request->input('district');
        $product->unit = $request->input('unit');
       

        $images = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('ProductImages/' . $request->name, $filename);
                $images[] = $filename;
            }
        }
        
        $product->image = json_encode($images);

        
        
        $product->description = $request->input('description');
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully',
            'data' => $product,
        ], 201);
    }
    
    public function get_products()
{
    $products = Product::all();

    foreach ($products as $product) {
        $product->commodity_id = Commodity::where('id', $product->commodity_id)->value('name');
        $product->variety_id =  Variety::where('id', $product->variety_id)->value('name');
        $product->image = $product->image;

    }

    if ($products->isEmpty()) {
        return response()->json([
            'error' => "No Products",
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $products,
    ], 200);
}


    public function get_product($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ], 200);
    }
    public function get_product_by_wholesaler()
    {
        $user_id = Auth::id(); // Get the authenticated user's ID
    
        // Retrieve products where the user_id matches the authenticated user
        $products = Product::where('user_id', $user_id)->get();
    
        // Loop through each product to replace commodity_id and variety_id with their names
        foreach ($products as $product) {
            $product->commodity = Commodity::where('id', $product->commodity_id)->value('name');
            $product->variety = Variety::where('id', $product->variety_id)->value('name');
        }
    
        // Return the products as a JSON response
        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }



    public function edit_product(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'commodity_id' => 'required|exists:commodities,id',
            'variety_id' => 'required|exists:varieties,id',
            'quality' => 'required',
            'rate' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'district' => 'required',
            'state' => 'required',
            'image' => 'nullable',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }


        
        $user_id=Auth::id();
        $product->user_id = $user_id;
        $product->commodity_id = $request->input('commodity_id');
        $product->variety_id = $request->input('variety_id');
        $product->quality = $request->input('quality');
        $product->rate = $request->input('rate');
        
        $images = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('ProductImages/' . $request->name, $filename);
                $images[] = $filename;
            }
        }
        
        $product->image = json_encode($images);

        $product->quantity = $request->input('quantity');
        $product->state = $request->input('state');
        $product->district = $request->input('district');
        $product->unit = $request->input('unit');
        $product->description = $request->input('description');
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }
    public function delete_product($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
       
        if (isset($product->image)) {

            $imagePaths = $product->image;
        
            foreach ($imagePaths as $imagePath) {
                unlink(public_path('ProductImages/' . $imagePath));
            }
        }
        
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ], 200);
    }


    public function filters(Request $request)
    {
        
        $query = Product::query();

        if ($request->has('commodities')) {
            $commodities = $request->commodities;

            if (is_string($commodities)) {
                $commodities = explode(',', $commodities);
            }

            $query->whereIn('commodity_id', $commodities);
        }

        if ($request->has('state')) {
            $query->where('state', $request->state);
        }

        $products = $query->get();
        return response()->json([
            'success' => true,
            'message' => 'Product List',
            'data' => $products,
        ], 200);
    }

}
