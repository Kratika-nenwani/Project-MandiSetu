<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\DailyRate;
use App\Models\Dukandar;
use App\Models\Notification;
use App\Models\Product;
use App\Models\PurchaseRequest;
use App\Models\Stock;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function get_users($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }
    public function approve_purchase_request($id)
    {
        $purchase_request = PurchaseRequest::find($id);
        if (!$purchase_request) {
            return response()->json([
                'error' => "Purchase Request not found"
            ], 404);
        }
        if ($purchase_request->status == "approved") {
            return response()->json([
                'success' => "Purchase Request Already Approved"
            ], 200);
        }

        $purchase_request->status = "approved";
        $purchase_request->save();

        $notification = new Notification();
        $notification->sender_id = Auth::id();
        $notification->receiver_id = $purchase_request->user_id;
        $notification->purchase_request_id = $id;
        $notification->message = "Your Purchase Request is Approved";
        $notification->type = "REQUEST APPROVED";
        $notification->date = now()->format('d-m-Y');
        $notification->save();

        return response()->json([
            'success' => "Purchase Request Approved",
            'data' => $purchase_request
        ], 200);
    }
    public function approve_cancel_request($id)
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

        $purchase_request->status = "cancelled";
        $purchase_request->save();

        $notification = new Notification();
        $notification->sender_id = Auth::id();
        $notification->receiver_id = $purchase_request->user_id;  // Directly assign the user_id
        $notification->purchase_request_id = $id;
        $notification->message = "Your Cancel Request is Approved";
        $notification->type = "CANCEL REQUEST";
        $notification->date = now()->format('d-m-Y');  // Assuming `date` is stored as a string
        $notification->save();

        return response()->json([
            'success' => "Purchase Request Cancelled"
        ], 200);
    }


    public function reject_purchase_request($id)
    {
        $purchase_request = PurchaseRequest::find($id);
        if (!$purchase_request) {
            return response()->json([
                'error' => "Purchase Request not found"
            ], 404);
        }
        if ($purchase_request->status == "rejected") {
            return response()->json([
                'success' => "Purchase Request Already Rejected"
            ], 200);
        }

        $purchase_request->status = "rejected";
        $purchase_request->save();

        $notification = new Notification();
        $notification->sender_id = Auth::id();
        $notification->receiver_id = $purchase_request->user_id;
        $notification->purchase_request_id = $id;
        $notification->message = "Your Purchase Request is Rejected";
        $notification->type = "REQUEST REJECTED";
        $notification->date = now()->format('d-m-Y');
        $notification->save();

        return response()->json([
            'success' => "Purchase Request Rejected",
            'data' => $purchase_request
        ], 200);
    }

    public function get_dukandars()
    {
        $dukandars = Dukandar::all();
        if ($dukandars->isEmpty()) {
            return response()->json([
                'error' => "No dukandars",
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $dukandars,
        ], 200);
    }

    public function get_dukandars_of_mandivyapari($mandivyapari_id)
    {
        $dukandars = Dukandar::where('mandivyapari_id', $mandivyapari_id)->get();

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

    public function mark_delivered($id)
    {
        $purchase_request = PurchaseRequest::find($id);

        if ($purchase_request->delivery_status == "delivered") {
            return response()->json([
                'success' => "Purchase Request already delivered"
            ], 200);
        }

        if (!$purchase_request) {
            return response()->json([
                'error' => "Purchase Request not found"
            ], 404);
        }

        if ($purchase_request->status != "approved") {
            return response()->json([
                'error' => "Purchase Request not approved yet"
            ], 400);
        }

        // Update delivery status
        $purchase_request->delivery_status = "delivered";
        $purchase_request->save();

        $notification = new Notification();
        $notification->sender_id = Auth::id();
        $notification->receiver_id = $purchase_request->user_id;
        $notification->purchase_request_id = $id;
        $notification->message = "Your Purchase Request is Delivered";
        $notification->type = "DELIVERED";
        $notification->date = now()->format('d-m-Y');
        $notification->save();

        $stock = Stock::where('product_id', $purchase_request->product_id)->where('mandivyapari_id', $purchase_request->user_id)->first();
        if (!$stock) {
            $stock = new Stock();
            $quantity = (int) $purchase_request->quantity;
            $stock->quantity = (int) $stock->quantity + $quantity;
            $stock->unit = $purchase_request->unit;
            $stock->mandivyapari_id = $purchase_request->user_id;
            $stock->product_id = $purchase_request->product_id;

        } else {
            $quantity = (int) $purchase_request->quantity;
            $stock->quantity = (int) $stock->quantity + $quantity;

        }
        $stock->save();


        return response()->json([
            'success' => "Delivered..",
            'data' => $purchase_request
        ], 200);
    }

     public function daily_rates_update()
    {
        $client = new Client();

        $commodities = Commodity::pluck('name')->implode(',');

        $url = 'https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070';
        $params = [
            'filters[commodity]' => $commodities,
            'limit' => '20000',
            'api-key' => '579b464db66ec23bdd000001b6100a27efb043b441006c7f63d9f1f9',
            'format' => 'json',
        ];

        try {
            $response = $client->request('GET', $url, [
                'query' => $params,
                'headers' => [
                    'accept' => 'application/json',
                ],
            ]);

            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody, true);
        
            if (isset($data['records']) && is_array($data['records'])) {
                foreach ($data['records'] as $record) {
                    $arrivalDate = Carbon::createFromFormat('d/m/Y', $record['arrival_date'])->format('Y-m-d');

                    DB::table('daily_rates')->updateOrInsert(
                        [
                            'state' => $record['state'],
                            'district' => $record['district'],
                            'market' => $record['market'],
                            'commodity' => $record['commodity'],
                            'variety' => $record['variety'],
                            'arrival_date' => $arrivalDate,
                        ],
                        [
                            'grade' => $record['grade'] ?? null,
                            'min_x0020_price' => $record['min_price'] ?? null,
                            'max_x0020_price' => $record['max_price'] ?? null,
                            'modal_x0020_price' => $record['modal_price'] ?? null,
                            'updated_at' => now(),
                        ]
                    );
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No records found in the response.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Daily rates updated successfully.',
            ]);
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function averagePriceByState(Request $request)
    {
        $state = $request->input('state');

        $averagePrices = DailyRate::select('commodity', 'variety', DB::raw('AVG(modal_x0020_price) as average_price'))
            ->where('state', $state)
            ->groupBy('commodity', 'variety')
            ->get();

        return response()->json([
            'success' => true,
            'state' => $state,
            'data' => $averagePrices,
        ]);
    }
    
    
    public function filter_rate(Request $request)
    {
    $query = DailyRate::query();

    // Filter by commodities if provided
    if ($request->has('commodities')) {
        $commodities = $request->input('commodities');

        // If commodities are passed as a comma-separated string, convert it to an array
        if (is_string($commodities)) {
            $commodities = explode(',', $commodities);
        }

        // Apply the filter to the query
        $query->whereIn('commodity', $commodities);
    }

    // Filter by state if provided
    if ($request->has('state')) {
        $query->where('state', $request->input('state'));
        
    }

    // Execute the query and get the results
    $products = $query->get();
   
    // Return a JSON response with the results
    return response()->json([
        'success' => true,
        'message' => 'Product List',
        'data' => $products,
    ], 200);
    }


    public function averagePriceByStateAndDistrict(Request $request)
    {
        $state = $request->input('state');

        $averagePrices = DailyRate::select('district', 'commodity', 'variety', DB::raw('AVG(modal_x0020_price) as average_price'))
            ->where('state', $state)
            ->groupBy('district', 'commodity', 'variety')
            ->get();

        return response()->json([
            'success' => true,
            'state' => $state,
            'data' => $averagePrices,
        ]);
    }


    public function realtime_mandi_rate()
    {
    $commodities = Commodity::all();
    $data = [];

    foreach ($commodities as $commodity) {
        $dummy = DailyRate::where('commodity', $commodity->name)
            ->where('arrival_date', Carbon::today()->format('Y-m-d'))
            // ->take(3) 
            ->get();

        foreach ($dummy as $rate) {

            $data[] = [
                'commodity' => $rate->commodity,
                'state' => $rate->state,
                'district' => $rate->district,
                'market' => $rate->district, 
                'variety' => $rate->variety,
                'price' => $rate->modal_x0020_price,
                'min_price' => $rate->min_x0020_price,
                'max_price' => $rate->max_x0020_price,
            ];

            
        }
    }

    return response()->json([
        'success' => true,
        'data' => $data,
    ]);
    }

    public function mandi_rate_by_commodity(Request $request)
    {
    
        $data = [];

    
        $dummy = DailyRate::where('commodity', $request->commodity_name)
            ->where('arrival_date', Carbon::today()->format('Y-m-d'))
            ->get();

        foreach ($dummy as $rate) {
            

            $data[] = [
                'commodity' => $rate->commodity,
                'state' => $rate->state,
                'district' => $rate->district,
                'market' => $rate->district, 
                'variety' => $rate->variety,
                'price' => $rate->modal_x0020_price,
                'min_price' => $rate->min_x0020_price,
                'max_price' => $rate->max_x0020_price,
            ];
        }
    return response()->json([
        'success' => true,
        'data' => $data,
    ]);
    }
    
    public function getStatistics(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
                'commodity' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        $commodity = $request->input('commodity');
        
        $data = DB::table('daily_rates')
            ->where('commodity', $commodity)
            ->get();
        
        $statistics = [];
        foreach ($data as $item) {
            $date = Carbon::parse($item->arrival_date)->toDateString();
            if (!isset($statistics[$date])) {
                $statistics[$date] = ['min' => [], 'max' => [], 'modal' => []];
            }
            
            $statistics[$date]['min'][] = (float) $item->min_x0020_price;
            $statistics[$date]['max'][] = (float) $item->max_x0020_price;
            $statistics[$date]['modal'][] = (float) $item->modal_x0020_price;
        }
        $data = [];
        foreach ($statistics as $date => $values) {
            // $statistics[$date]['min'] = array_sum($values['min']) / count($values['min']);
            // $statistics[$date]['max'] = array_sum($values['max']) / count($values['max']);
            // $statistics[$date]['modal'] = array_sum($values['modal']) / count($values['modal']);
            $data[] = [
                'date' => $date,
                'min' => round(array_sum($values['min']) / count($values['min']), 3),
                'max' => round(array_sum($values['max']) / count($values['max']), 3),
                'modal' => round(array_sum($values['modal']) / count($values['modal']), 3),
            ];
        }
        
        return response()->json([
            'commodity' => $commodity,
            // 'statistics' => $statistics,
            'data' => $data,
        ]);
    }
    
    public function static_mandi_rate()
    {
    
        $datas = ['Ashgourd','Banana','Apple','Rice'];
        $data=[];
        $count=0;
        
        
        
        foreach($datas as $d)
        {
            
            $count++;
            
            $dummy = DailyRate::where('commodity', $d)->first();
            
         
            $data[] = [
            'image'=>"image".$count.".png",
            'commodity' => $dummy->commodity,
            'state' => $dummy->state,
            'district' => $dummy->district,
            'market' => $dummy->market,
            'price' => $dummy->modal_x0020_price,
            'min_price' => $dummy->min_x0020_price,
            'max_price' => $dummy->max_x0020_price,
            ];
           
            
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    
    
}
