<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Variety;
use App\Models\PurchaseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseRequestsController extends Controller
{
    public function send_purchase_request(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required',
            'unit' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $user_id=Auth::id();

        $purchase_request = new PurchaseRequest();
        $purchase_request->user_id = $user_id;
        $purchase_request->product_id = $request->input('product_id');
        $purchase_request->quantity = $request->input('quantity');
        $purchase_request->unit = $request->input('unit');

        $purchase_request->save();

        $notification = new Notification();
        $notification->sender_id = Auth::id();
        $receiver_ids = User::where('role', 'SuperAdmin')->pluck('id')->toArray();
        $notification->receiver_id = json_encode($receiver_ids); 
        $notification->purchase_request_id = $purchase_request->id;
        $notification->message = "New Purchase Request Arrived";
        $notification->type = "PURCHASE REQUEST";
        $notification->date = now()->format('d-m-Y');
        $notification->save();

        return response()->json([
            'success' => true,
            'message' => 'Purchase Request sent successfully',
            'data' => $purchase_request,
        ], 201);
    }

    
    public function get_purchase_requests()
    {
        $purchase_requests = PurchaseRequest::all();
        if ($purchase_requests->isEmpty()) {
            return response()->json([
                'error' => "No purchase requests found",
            ], 404);
        }
        $purchase = [];
        foreach ($purchase_requests as $purchase_request) {
            $product = Product::where('id', $purchase_request->product_id)->first();
            $purchase_request->product = $product;
            $purchase = $purchase_request;
        }
        return response()->json([
            'success' => true,
            'data' => $purchase,
        ], 200);
    }
    
     
    public function get_purchase_requests_of_mandivyapri()
    {
        $purchase_requests = PurchaseRequest::where('user_id',Auth::id())->get();
        
        $purchases = [
        'approved' => [],
        'unapproved' => [],
        'cancelled' => [],
        'rejected' => [],
        'delivered' =>[]
    ];
    
      foreach ($purchase_requests as $purchase_request) {
        $product = Product::find($purchase_request->product_id);
        
        if (!$product) {
            continue; // Skip this purchase request if the product is not found
        }

       
        $commodity = Commodity::find($product->commodity_id)->name;
        $variety = Variety::find($product->variety_id)->name;

        $purchase_data = [
            'id' => $purchase_request->id,
            'user_id'=>$purchase_request->user_id,
            'product_id'=>$purchase_request->product_id,
            'seller_id'=>$product->user_id,
            'commodity' => $commodity,
            'variety' => $variety,
            'quality' => $product->quality,
            'image' => $product->image,
            'state' => $product->state,
            'district' => $product->district,
            'description' => $product->description,
            'quantity' => $purchase_request->quantity,
            'unit' => $purchase_request->unit,
            'price_per_quantity' => $product->rate,
            'amount' => (int)$purchase_request->quantity * (int)$product->rate,
            'created_at'=>$purchase_request->created_at
        ];

        switch ($purchase_request->status) {
            case 'approved':
                if($purchase_request->delivery_status!="delivered"){
                $purchases['approved'][] = $purchase_data;}
                else
                {
                    $purchases['delivered'][] = $purchase_data;
                }
                break;
            case 'not approved':
                $purchases['unapproved'][] = $purchase_data;
                break;
            case 'cancelled':
                $purchases['cancelled'][] = $purchase_data;
                break;
            default:
                $purchases['rejected'][] = $purchase_data;
                break;
        }
    }
       
        return response()->json([
            'success' => true,
            'data' => $purchases,
        ], 200);
    }
    
    
    
    public function get_notifications()
    {
        $id = Auth::id();
        
        $notifications = Notification::whereJsonContains('receiver_id', $id)->get();
        
        if ($notifications->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "No notifications found",
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
        ], 200);
    }

    

   

}
