<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VarietyController extends Controller
{
    public function add_variety(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'commodity_id' => 'required|exists:commodities,id', // Ensures the commodity_id exists in the commodities table
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $variety = new Variety();
        $variety->name = $request->input('name');
        $variety->commodity_id = $request->input('commodity_id');
        $variety->save();

        return response()->json([
            'success' => true,
            'message' => 'Variety added successfully',
            'data' => $variety,
        ], 201);
    }
    public function get_varieties()
    {
        $varieties = Variety::all();
        if ($varieties->isEmpty()) {
            return response()->json([
                'error' => "No varieties found",
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $varieties,
        ], 200);
    }
    
    public function get_variety_by_commodity($id)
    {
        $varieties = Variety::where('commodity_id',$id)->get();
        
        return response()->json([
            'success' => true,
            'data' => $varieties,
        ], 200);
    }
    public function get_variety($id)
    {
        $variety = Variety::find($id);

        if (!$variety) {
            return response()->json(['success' => false, 'message' => 'Variety not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $variety,
        ], 200);
    }
    public function edit_variety(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'commodity_id' => 'required|exists:commodities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $variety = Variety::find($id);

        if (!$variety) {
            return response()->json(['success' => false, 'message' => 'Variety not found'], 404);
        }

        $variety->name = $request->input('name');
        $variety->commodity_id = $request->input('commodity_id');
        $variety->save();

        return response()->json([
            'success' => true,
            'message' => 'Variety updated successfully',
            'data' => $variety,
        ], 200);
    }
    public function delete_variety($id)
    {
        $variety = Variety::find($id);

        if (!$variety) {
            return response()->json(['success' => false, 'message' => 'Variety not found'], 404);
        }

        $variety->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variety deleted successfully',
        ], 200);
    }


}
