<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dukandar;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Variety;
use App\Models\Commodity;
use App\Models\PurchaseRequest;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class MandiVyapariController extends Controller
{
   public function get_purchase_requests()
{
    $id = Auth::id();
    $purchase_requests = PurchaseRequest::all();

    if ($purchase_requests->isEmpty()) {
        return response()->json([
            'error' => "No purchase requests found",
        ], 404);
    }

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

        $user = User::find($purchase_request->user_id)->name;
        $phone = User::find($purchase_request->user_id)->phone;

        $commodity = Commodity::find($product->commodity_id)->name;
        $variety = Variety::find($product->variety_id)->name;

        $purchase_data = [
            'id' => $purchase_request->id,
            'user_id'=>$purchase_request->user_id,
            'product_id'=>$purchase_request->product_id,
            'seller_id'=>$product->user_id,
            'user' => $user,
            'phone' => $phone,
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

    public function reorder($id)
    {
        $old_request = PurchaseRequest::find($id);
        if (!$old_request) {
            return response()->json(['success' => false, 'message' => 'Purchase Request not found'], 404);
        }

        $purchase_request = new PurchaseRequest();
        $purchase_request->user_id = $old_request->user_id;
        $purchase_request->product_id = $old_request->product_id;
        $purchase_request->quantity = $old_request->quantity;
        $purchase_request->unit = $old_request->unit;
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
    public function edit_purchase_request(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch the purchase request by ID
        $purchase_request = PurchaseRequest::find($id);

        // Check if the purchase request exists
        if (!$purchase_request) {
            return response()->json([
                'error' => "No purchase request found",
            ], 404);
        }

        // Check if the purchase request status allows for editing
        if ($purchase_request->status == "not approved") {
            $purchase_request->quantity = $request->input('quantity');
            $purchase_request->unit = $request->input('unit');
            $purchase_request->save();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Request Updated successfully',
                'data' => $purchase_request,
            ], 200);
        } else {
            return response()->json([
                'error' => "Purchase request is approved and cannot be edited",
            ], 403); // 403 Forbidden is more appropriate for restricted actions
        }
    }

    // public function delete_purchase_request($id)
    // {
    //     $purchase_request = PurchaseRequest::find($id);

    //     if (!$purchase_request) {
    //         return response()->json(['success' => false, 'message' => 'Purchase Request not found'], 404);
    //     }

    //     $purchase_request->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Purchase Request deleted successfully',
    //     ], 200);
    // }


    // public function send_cancel_request($id)
    // {
    //     $purchase_request = PurchaseRequest::find($id);
    //     if (!$purchase_request) {
    //         return response()->json([
    //             'error' => "Purchase Request not found"
    //         ], 404);
    //     }
    //     if ($purchase_request->status == "cancelled") {
    //         return response()->json([
    //             'success' => "Purchase Request Already Cancelled"
    //         ], 200);
    //     }
    //     if ($purchase_request->status == "approved") {
    //         return response()->json([
    //             'error' => "Purchase Request is Approved Already and cannot be cancelled"
    //         ], 404);
    //     }
    //     $notification=new Notification();
    //     $notification->sender_id=Auth::id();
    //     $receiver_id=User::where('role','SuperAdmin')->pluck('id');
    //     $notification->receiver_id=$receiver_id;
    //     $notification->purchase_request_id=$id;
    //     $notification->message="I want cancel my purchase request";
    //     $notification->type="CANCEL REQUEST";
    //     $notification->date=currentDate();
    //     $notification->save();

    //     return response()->json([
    //         'success' => "Cancellation request sent successfully. You will be informed about your request once the admin make some decision."

    //     ], 200);
    // }
    public function send_cancel_request($id)
    {
        $purchase_request = PurchaseRequest::find($id);

        if (!$purchase_request) {
            return response()->json([
                'error' => "Purchase Request not found"
            ], 404);
        }

        if ($purchase_request->status == "cancelled") {
            return response()->json([
                'success' => "Purchase Request Already Cancelled"
            ], 200);
        }

        if ($purchase_request->status == "approved") {
            return response()->json([
                'error' => "Purchase Request is Approved Already and cannot be cancelled"
            ], 400);
        }

        $notification = new Notification();
        $notification->sender_id = Auth::id();

        $receiver_ids = User::where('role', 'SuperAdmin')->pluck('id')->toArray();

        

        $notification->receiver_id = json_encode($receiver_ids); // Store as JSON if multiple
        $notification->purchase_request_id = $id;
        $notification->message = "I want to cancel my purchase request";
        $notification->type = "CANCEL REQUEST";
        $notification->date = now()->format('d-m-Y');

        if ($notification->save()) {
            return response()->json([
                'success' => "Cancellation request sent successfully. You will be informed about your request once the admin makes a decision."
            ], 200);
        } else {
            return response()->json([
                'error' => "Failed to send cancellation request. Please try again later."
            ], 500);
        }
    }

    public function add_dukandar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => [
                'required',
                'regex:/^[0-9]{10}$/', 
            ],
            'shop_name' => 'required',
            'address' => 'required',
            ], [
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be exactly 10 digits.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dukandar = new Dukandar();
        $dukandar->mandivyapari_id = Auth::id();
        $dukandar->name = $request->name;
        $dukandar->email = $request->email;
        $dukandar->phone = $request->phone;
        if ($request->hasFile('mandi_license')) {
            $file1 = $request->file('mandi_license');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->mandi_license = $filename1;
        }
        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->gumasta = $filename1;
        }
        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->gst_registration = $filename1;
        }
        $dukandar->mandi_license_no = $request->mandi_license_no;
        $dukandar->gumasta_no = $request->gumasta_no;
        $dukandar->gst_no = $request->gst_no;
        $dukandar->aadhar = $request->aadhar;
        $dukandar->pan = $request->pan;
        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->aadhar_card = $filename1;
        }
        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->pan_card = $filename1;
        }


        $dukandar->account_no = $request->account_no;
        $dukandar->ifsc_code = $request->ifsc_code;
        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->statement = $filename1;
        }

        $dukandar->shop_name = $request->shop_name;
        $dukandar->address = $request->address;
        $dukandar->office_phn = $request->office_phn;
        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->image = $filename1;
        }
        $dukandar->save();
        return response()->json([
            'success' => true,
            'message' => 'Dukandar added successfully',
            'data' => $dukandar,
        ], 201);
    }

    public function get_dukandars_by_mandivyapari()
    {
        $id = Auth::id();
        $dukandars = Dukandar::where('mandivyapari_id', $id)->get();

        if ($dukandars->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No dukandars found for this user',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dukandars,
        ], 200);
    }

    public function edit_dukandar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'shop_name' => 'required',
            'address' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dukandar = Dukandar::find($id);
        $dukandar->name = $request->name;
        $dukandar->email = $request->email;
        $dukandar->phone = $request->phone;
        if ($request->hasFile('mandi_license')) {
            $file1 = $request->file('mandi_license');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->mandi_license = $filename1;
        }
        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->gumasta = $filename1;
        }
        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->gst_registration = $filename1;
        }
        $dukandar->mandi_license_no = $request->mandi_license_no;
        $dukandar->gumasta_no = $request->gumasta_no;
        $dukandar->gst_no = $request->gst_no;
        $dukandar->aadhar = $request->aadhar;
        $dukandar->pan = $request->pan;
        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->aadhar_card = $filename1;
        }
        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->pan_card = $filename1;
        }


        $dukandar->account_no = $request->account_no;
        $dukandar->ifsc_code = $request->ifsc_code;
        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->statement = $filename1;
        }

        $dukandar->shop_name = $request->shop_name;
        $dukandar->address = $request->address;
        $dukandar->office_phn = $request->office_phn;
        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/' . $request->name, $filename1);
            $dukandar->image = $filename1;
        }
        $dukandar->save();
        return response()->json([
            'success' => true,
            'message' => 'Dukandar updated successfully',
            'data' => $dukandar,
        ], 201);
    }

    public function add_sales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dukandar_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'price_per_unit' => 'required',
            'unit' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->product_id);
        if (!$product) {

            return response()->json([
                'success' => false,
                'message' => 'No product found',
            ], 404);
        }


        $sales = new Sale();
        $sales->mandivyapari_id = Auth::id();
        $sales->dukandar_id = $request->dukandar_id;
        $sales->product_id = $request->product_id;
        $sales->quantity = $request->quantity;
        $sales->unit = $request->unit;
        $sales->price_per_unit = $request->price_per_unit;

        $x = (int) $sales->quantity;
        $y = (int) $sales->price_per_unit;

        $sales->total = $x * $y;
        $sales->save();

        return response()->json([
            'success' => true,
            'message' => 'Sales added successfully',
            'data' => $sales,
        ], 201);
    }

}
