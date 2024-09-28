<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Commodity;
use App\Models\Dukandar;
use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseRequest;

use App\Models\Banner;

use App\Models\News;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;
use App\Mail\PurchaseRequestNotification;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index_main()
    {
        $commodity=Commodity::all();
        if (auth()->user()->role == "Wholesaler") {
            return view('wholesaler-dashboard',compact('commodity'));
        } else if (auth()->user()->role == "MandiVyapari") {
            return view('mandi-dashboard',compact('commodity'));
        }
        if (auth()->user()->role == "SuperAdmin") {
            return view('superadmin-dashboard',compact('commodity'));
        }

    }

    public function index()
    {
        return view('home');
    }
    public function commodity()
    {
        $variants = Variety::all(); // Fetch all variants
        $commodities = Commodity::all();
        return view('commodity', compact('commodities', 'variants'));
    }

    public function mandi_dashboard()
    {
        return view('mandi-dashboard');
    }
    public function superadmin_dashboard()
    {
        $commodity=Commodity::all();
        return view('superadmin-dashboard',compact('commodity'));
    }
    public function wholesaler_dashboard()
    {
        $commodity=Commodity::all();
        return view('wholesaler-dashboard',compact('commodity'));
    }
    public function savecommodity(Request $request)
    {


        // Validate incoming request
        $request->validate([
            'name' => 'required|string',
            'variety_name' => 'required|string',
        ]);

        // Create and save the new commodity
        $commodity = new Commodity();
        $commodity->name = $request->input('name');
        $commodity->save();

        // Create and save the new variety associated with the commodity
        $variety = new Variety();
        $variety->commodity_id = $commodity->id;
        $variety->name = $request->input('variety_name');
        $variety->save();

        return redirect()->route('commodity')->with('success', 'Commodity and variety created successfully.');
    }
    public function saveproduct(Request $request)
    {

        $request->validate([
            // 'name' => 'required',
            // 'variant' => 'required',
            // 'quantity' => 'required',
            // 'price' => 'required',
            // 'image' => 'required',
        ]);
        $imagePaths = [];

        // Process each uploaded image
        $count = 1;
        foreach ($request->file('images') as $image) {
            if ($image->isValid()) {
                // Generate a unique filename for each image
                $filename = time() . '_' . $count . $image->getClientOriginalName();
                // Move the image to the desired location
                $image->move('ProductImages/');
                // Add the image path to the array
                $imagePaths[] = $filename;
                $count++;
            }
        }
        
        // Create a new product instance and save it
        $product = new Product();
        $product->user_id = Auth::id(); // Get the ID of the currently authenticated user
        $product->commodity_id = $request->input('commodity_id');
        $product->commodity_id = $request->input('commodity_id');
        $product->variety_id = $request->input('variety_id');
        $product->quality = $request->input('quality');
        $product->rate = $request->input('rate');
        $product->quantity = $request->input('quantity');
        $product->description = $request->input('description');
        $product->image = $jsonImages; // Store JSON string of image paths

        // Handle file upload

        $product->save();

        return redirect()->route('commodity')->with('success', 'Commodity created successfully.');
    }

    public function createcommodity()
    {
        return view('createcommodity');
    }

    public function updatecommodity($id)
    {
        $commodity = Commodity::find($id);
        return view('updatecommodity', compact('commodity'));
    }

    public function viewcommodity(Request $request)
    {
        $data = Commodity::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-outline-secondary btn-sm edit" title="Edit" data-id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-pencil-alt"></i>';
                    $btn .= '</a>&nbsp';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('viewcommodity', compact('data'));


    }
  public function view_banners(Request $request)
{
    $data = Banner::all();

    if ($request->ajax()) {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                // Decode JSON if $row->image is a JSON string, otherwise use it directly
                $images = json_decode($row->image, true);

                // If $images is not an array, treat it as a single image
                if (!is_array($images)) {
                    $images = [$row->image];
                }

                $imageHTML = '';

                // Check if $images is an array and contains at least one image
                if (is_array($images) && !empty($images)) {
                    foreach ($images as $image) {
                        $imageURL = asset('BannerImages/' . $image);
                        // Ensure image URL is valid and not empty
                        if (!empty($image) && file_exists(public_path('BannerImages/' . $image))) {
                            $imageHTML .= '<img src="' . $imageURL . '" style="width:100px; height:auto; margin-right: 5px;">';
                        }
                    }
                } else {
                    $imageHTML = 'No images available';
                }

                return $imageHTML;
            })
            // Uncomment and customize this section if you need action buttons
            ->addColumn('action', function ($row) {
                $btn = '<a class="btn btn-outline-secondary btn-sm changeType" title="changeType" data-id="' . $row->id . '">';
                $btn .= '    <i class="fas fa-pencil-alt"></i>';
                $btn .= '</a>&nbsp';
                $btn .= '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                $btn .= '    <i class="fas fa-trash-alt"></i>';
                $btn .= '</button>';
                return $btn;
            })
            ->rawColumns(['image','action'])
            ->make(true);
    }

    return view('banners', compact('data'));
}

     public function view_news(Request $request)
    {
        $data = News::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                // Decode JSON if $row->image is a JSON string, otherwise use it directly
                $images = json_decode($row->image, true);

                // If $images is not an array, treat it as a single image
                if (!is_array($images)) {
                    $images = [$row->image];
                }

                $imageHTML = '';

                // Check if $images is an array and contains at least one image
                if (is_array($images) && !empty($images)) {
                    foreach ($images as $image) {
                        $imageURL = asset('NewsImages/' . $image);
                        // Ensure image URL is valid and not empty
                        if (!empty($image) && file_exists(public_path('NewsImages/' . $image))) {
                            $imageHTML .= '<img src="' . $imageURL . '" style="width:100px; height:auto; margin-right: 5px;">';
                        }
                    }
                } else {
                    $imageHTML = 'No images available';
                }

                return $imageHTML;
            })
                ->addColumn('action', function ($row) {

                    // $btn = '<a class="btn btn-outline-secondary btn-sm edit" title="Edit" data-id="' . $row->id . '">';
                    // $btn .= '    <i class="fas fa-pencil-alt"></i>';
                    // $btn .= '</a>&nbsp';
                    $btn = '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }

        return view('news', compact('data'));


    }
    public function storecommodity(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
    'name' => 'required|string|max:255|unique:commodities,name',
], [
    'name.required' => 'The commodity name is required.',
    'name.string' => 'The commodity name must be a valid string.',
    'name.max' => 'The commodity name cannot exceed 255 characters.',
    'name.unique' => 'The commodity name has already been taken.',
]);

    // Create and save the new commodity
    $commodity = new Commodity();
    $commodity->name = $request->input('name');
    $commodity->save();

    return redirect()->route('viewcommodity')->with('success', 'Commodity created successfully.');
}



    public function commodityup(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',

        ]);

        // Create and save the new commodity
        $commodity = Commodity::find($id);
        $commodity->name = $request->input('name');
        $commodity->save();
        return redirect()->route('commodity')->with('success', 'Commodity created successfully.');

    }
    public function changeType( $id)
    {
        // Create and save the new commodity
        $banner = Banner::find($id);
        if($banner->type=="featured")
        $banner->type ="normal";
        else
        $banner->type ="featured";
        
        $banner->save();
        return redirect()->back()->with('success', 'Banner updated successfully.');

    }

    public function addvariety()
    {
        $commodities = Commodity::all();
        return view('addvariety', compact('commodities'));
    }

    public function updatevariety($id)
    {
        $commodities = Commodity::all();
        $variety = Variety::find($id);
        return view('updatevariety', compact('variety', 'commodities'));
    }



    public function viewvariety(Request $request)
    {
        $commodities = Commodity::all(); // Fetch the commodities
        $data = Variety::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('commodity_id', function ($row) use ($commodities) {
                    $commodity = $commodities->find($row->commodity_id);
                    return $commodity ? $commodity->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-outline-secondary btn-sm edit" title="Edit" data-id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-pencil-alt"></i>';
                    $btn .= '</a>&nbsp';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('viewvariety', compact('data', 'commodities'));
    }



    public function storevariety(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'commodity_id' => 'required',
        ]);

        $variety = new Variety();
        $variety->name = $request->name;
        $variety->commodity_id = $request->commodity_id;
        $variety->save();


        return redirect()->route('viewvariety')->with('success', 'Variety added successfully');
    }

    public function varietyup(Request $request, $id)
    {
        $request->validate([
            'commodity_id' => 'required',
            'name' => 'required',
        ]);

        $variety = Variety::find($id);
        $variety->name = $request->name;
        $variety->commodity_id = $request->commodity_id;
        $variety->save();


        return redirect()->route('viewvariety')->with('success', 'Variety added successfully');
    }

    public function addproducts()
    {
        $commodities = Commodity::all();
        $varieties = Variety::all();
        $product = Product::all();
        return view('addproducts', compact('commodities', 'varieties', 'product'));
    }




public function delete_news(Request $request)
    {
    $news = News::find($request->id);

    if (!$news) {
        return response()->json([
            'message' => 'News item not found.',
        ], 200);
    }

    if ($news->image) {
        $imagePath = public_path('NewsImages/' . $news->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $news->delete();

    return response()->json([
        'message' => 'News item deleted successfully.',
    ], 200);
    }



    public function viewproducts(Request $request)
    {

        $commodities = Commodity::all();
        $varieties = Variety::all();
        $data = Product::where('user_id', auth()->user()->id)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('commodity_id', function ($row) use ($commodities) {
                    $commodity = $commodities->find($row->commodity_id);
                    return $commodity ? $commodity->name : 'N/A';
                })

                ->addColumn('variety_id', function ($row) use ($varieties) {
                    $variety = $varieties->find($row->variety_id);
                    return $variety ? $variety->name : 'N/A';
                })
                ->addColumn('image', function ($row) {
                    // $images = json_decode($row->image, true);
                    $imageHTML = '';

                    if (is_array($row->image) && !empty($row->image)) {
                        foreach ($row->image as $image) {
                            $imageURL = asset('ProductImages/' . $image);
                            if (!empty($image)) {
                                $imageHTML .= '<img src="' . $imageURL . '" style="width:100px; height:auto; margin-right: 5px;">';
                            }
                        }
                    } else {
                        $imageHTML = 'No images available';
                    }

                    return $imageHTML;
                })



                // ->addColumn('image', function ($row) {
                //     $images = json_decode($row->image, true);

                //     $imageHTML = '';

                //     if (is_array($images)) {
                //         foreach ($images as $image) {

                //             $imageURL = asset("ProductImages/" . $image);


                //             // Make sure $image is a valid string
                //             if (!empty($image)) {
                //                 $imageHTML .= '<img src="' . $imageURL . '" width="80">';
                //             }
                //         }
                //     } else {

                //         $imageHTML = 'No images available';
                //     }

                //     return $imageHTML;
                // })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-outline-secondary btn-sm edit" title="Edit" data-id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-pencil-alt"></i>';
                    $btn .= '</a>&nbsp';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        // dd($data);
        return view('viewproducts', compact('data', 'commodities', 'varieties'));
    }








    public function storeproduct(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'commodity_id' => 'required',
            'variety_id' => 'required',
            'quality' => 'required',
            'rate' => 'required',
            'quantity' => 'required',

            'description' => 'required',
        ]);

        $imagePaths = [];

        // Process each uploaded image
        $count = 1;
        foreach ($request->file('images') as $image) {
            if ($image->isValid()) {
                // Generate a unique filename for each image
                $filename = time() . '_' . $count . $image->getClientOriginalName();
                // Move the image to the desired location
                $image->move('ProductImages/', $filename);
                // Add the image path to the array
                $imagePaths[] = $filename;
                $count++;
            }
        }


        // $jsonImages = json_encode($imagePaths);

        $product = new Product();
        $product->user_id = Auth::id();
        $product->commodity_id = $request->commodity_id;
        $product->variety_id = $request->variety_id;
        $product->quality = $request->quality;
        $product->rate = $request->rate;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->image = $imagePaths;



        $product->save();

        return redirect()->route('commodity')->with('success', 'Product added successfully.');
    }


   public function productupdate(Request $request, $id)
{
    Log::info($request->all());

    // Validate incoming data
    $request->validate([
        'commodity_id' => 'required',
        'variety_id' => 'required',
        'quality' => 'required',
        'rate' => 'required',
        'quantity' => 'required',
        // 'images' => 'nullable|array',
        // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
        // 'description' => 'required',
    ]);

    // Initialize an array to store the paths of uploaded images
    $imagePaths = [];
    $count = 1;

    // Process uploaded images, if any
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            if ($image->isValid()) {
                // Generate a unique filename for each image
                $filename = time() . '_' . $count . $image->getClientOriginalName();
                // Move the image to the desired location
                $image->move(public_path('ProductImages/'), $filename);
                // Add the image path to the array
                $imagePaths[] = $filename;
                $count++;
            }
        }
    }

    // Find the product by ID
    $product = Product::find($id);
    $product->user_id = Auth::id();
    $product->commodity_id = $request->commodity_id;
    $product->variety_id = $request->variety_id;
    $product->quality = $request->quality;
    $product->rate = $request->rate;
    $product->quantity = $request->quantity;
    $product->description = $product->description;
// 
    // Update images only if new ones are uploaded
    if (!empty($imagePaths)) {
        $product->image = $imagePaths; // Store as JSON array
    }

    // Save the updated product
    $product->save();

    return redirect()->route('viewproducts')->with('success', 'Product updated successfully.');
}

    public function delete_commodity(Request $request)
    {

        $commodity = Commodity::find($request->id);
        $commodity->delete();
        return response()->json(['success', true]);
    }

    public function delete_variety(Request $request)
    {
        $variety = Variety::find($request->id);
        $variety->delete();
        return response()->json(['success', true]);
    }

    public function delete_product(Request $request)
    {
        $product = Product::find($request->id);
        $product->delete();
        return response()->json(['success', true]);
    }

    public function fetchVariants($commodityId)
    {
        $variants = Variety::where('commodity_id', $commodityId)->get();
        return response()->json(['variants' => $variants]);
    }

    public function searchcommodities($searchTerm)
    {
        // Query the commodities based on the search term
        $commodities = Commodity::where('name', 'LIKE', "%{$searchTerm}%")
            ->get(['id', 'name']); // Fetch only necessary columns

        return response()->json(['commodities' => $commodities]);
    }

    public function sell()
    {
        $dukans = Dukandar::all();
        $products = Product::all();
        $commodities = Commodity::all(); // Fetch all commodities
        return view('sell', compact('dukans', 'products'));

    }

    public function buy()
    {

        // $products = Product::all();
        // return view('buy', compact('products'));
        $products = Product::with('commodity')
            ->where('user_id', '!=', auth()->user()->id) // Correctly use the '!=' operator
            ->get();
        return view('buy', compact('products'));
    }

    public function editable()
    {
        return view('editable');
    }

    public function cart()
    {
        Log::info('HI');
        if (Auth::check()) {
            // User is authenticated, retrieve cart data from the database
            $cartData = Cart::where('user_id', Auth::user()->id)->first();

            if ($cartData) {
                $cart = json_decode($cartData->detail, true);
            } else {
                // If no cart data is found in the database, initialize an empty cart array
                $cart = [];
            }
        } else {
            // User is not authenticated, retrieve cart data from the session
            $cart = session()->get('cart', []);

        }

        // Calculate total cost and shipping cost
        $totalCost = 0;
        $shippingCost = 0;

        foreach ($cart as $item) {
            $totalCost += $item['price'] * $item['quantity'];
            // You can add any additional logic for shipping cost calculation here
        }

        // Pass data to the view
        return view('cart', compact('cart', 'totalCost', 'shippingCost'));

    }




    public function addcart(Request $request, $productId)
    {
        //Log::info($request->all());

        // Validate and sanitize data
        $productId = (int) $productId;
        $quantity = (int) $request->input('quantity', 1); // Default to 1 if not provided
        $unit = $request->input('unit', 'kg'); // Default to 'kg' if not provided

        if (Auth::user()) {
            // If the user is logged in
            $user_cart = Cart::where('user_id', Auth::user()->id)->first();

            if ($user_cart) {
                // If the user has an existing cart in the database
                $usercart = json_decode($user_cart->detail, true);

                if (array_key_exists($productId, $usercart)) {
                    // If the product already exists in the user's cart, increase the quantity
                    $usercart[$productId]['quantity'] += $quantity;
                    $usercart[$productId]['unit'] = $unit; // Update the unit
                } else {
                    // If the product is not in the user's cart, add a new item
                    $product = Product::findOrFail($productId);
                    $usercart[$productId] = [
                        'id' => $product->id,
                        'name' => $product->commodity->name,
                        'price' => $product->rate,
                        'image' => $product->image,
                        'quantity' => $quantity,
                        'unit' => $unit
                    ];
                }

                // Update the user's cart in the database
                $user_cart->detail = json_encode($usercart);
                $user_cart->save();
            } else {
                // If the user doesn't have an existing cart in the database, create a new cart
                $product = Product::findOrFail($productId);
                $usercart = [
                    $productId => [
                        'id' => $product->id,
                        'name' => $product->commodity->name,
                        'price' => $product->rate,
                        'image' => $product->image,
                        'quantity' => $quantity,
                        'unit' => $unit
                    ]
                ];

                $user_cart = new Cart;
                $user_cart->user_id = Auth::user()->id;
                $user_cart->detail = json_encode($usercart);
                $user_cart->save();
            }

            // Calculate and return the cart count for the AJAX response
            $cartCount = array_sum(array_column($usercart, 'quantity'));

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
            ]);
        } else {
            // If the user is not logged in
            $cart = $request->session()->get('cart', []);

            if (array_key_exists($productId, $cart)) {
                // If the product already exists in the session cart, increase the quantity
                $cart[$productId]['quantity'] += $quantity;
                $cart[$productId]['unit'] = $unit; // Update the unit
            } else {
                // If the product is not in the session cart, add a new item
                $product = Product::findOrFail($productId);
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->commodity->name,
                    'price' => $product->rate,
                    'image' => $product->image,
                    'quantity' => $quantity,
                    'unit' => $unit
                ];
            }

            // Update the session cart
            $request->session()->put('cart', $cart);

            // Calculate and return the cart count for the AJAX response
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'alert' => true,
            ]);
        }
    }



    public function minuscart(Request $request, $productId)
    {


        // Validate and sanitize data
        $productId = (int) $productId;
        if (Auth::user()) {
            $user_cart = Cart::where('user_id', Auth::user()->id)->first();
            if ($user_cart) {
                $usercart = json_decode($user_cart->detail);
                $usercart = json_decode(json_encode($usercart), true);
                if (array_key_exists($productId, $usercart)) {
                    if ($usercart[$productId]['quantity'] == 1) {
                        unset($usercart[$productId]);
                    } else {
                        $usercart[$productId]['quantity']--;
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Product not found in cart']);
                }
                $user_cart->detail = $usercart;
                $user_cart->save();
            }
            $cartCount = array_sum(array_column($usercart, 'quantity'));
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
            ]);
        } else {

            // Get existing cart data from session (initialize if empty)
            $cart = $request->session()->get('cart', []);

            // Check if product already exists
            if (array_key_exists($productId, $cart)) {
                if ($cart[$productId]['quantity'] == 1) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId]['quantity']--;
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Product not found in cart']);
            }

            // Update session with cart data
            $request->session()->put('cart', $cart);

            // Calculate and return cart count for AJAX response
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                // Optionally include updated cart items HTML for frontend rendering
            ]);
        }

    }


    public function removecart(Request $request, $productId)
    {
        // Validate and sanitize data
        $productId = (int) $productId;
        if (Auth::user()) {
            $user_cart = Cart::where('user_id', Auth::user()->id)->first();
            if ($user_cart) {
                $usercart = json_decode($user_cart->detail);
                $usercart = json_decode(json_encode($usercart), true);
                if (array_key_exists($productId, $usercart)) {
                    unset($usercart[$productId]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Product not found in cart']);
                }
                $user_cart->detail = $usercart;
                $user_cart->save();
            }
            $cartCount = array_sum(array_column($usercart, 'quantity'));
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
            ]);
        } else {
            // Get existing cart data from session
            $cart = $request->session()->get('cart', []);

            // Check if product exists in cart
            if (!array_key_exists($productId, $cart)) {
                return response()->json(['success' => false, 'message' => 'Product not found in cart']);
            }

            // Remove product from cart
            unset($cart[$productId]);

            // Update session with modified cart data
            $request->session()->put('cart', $cart);

            // Calculate and return cart count for AJAX response
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
            ]);
        }


    }

    public function savecheckout(Request $request)
    {
        // dd('yes');
        Log::info($request->all());
        // Validate the incoming request data


        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'product_details' => 'required',
        ]);

        // Retrieve the products from the session cart
        if (Auth::check()) {
            // User is authenticated, retrieve cart data from the database
            $cartData = Cart::where('user_id', Auth::user()->id)->first();
            // dd($cartData);
            if ($cartData) {
                $product = json_decode($cartData->detail, true);
            } else {
                // If no cart data is found in the database, initialize an empty cart array
                $product = [];
            }
        } else {
            // User is not authenticated, retrieve cart data from the session
            $product = session()->get('cart', []);

        }


        // Create a new Order instance and fill in the details from the request
        $order = new Order();
        $order->name = $request->input('name');
        $order->email = $request->input('email');
        $order->address = $request->input('address');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->zipcode = $request->input('zipcode');
        $order->country = $request->input('country');
        $order->phone = $request->input('phone');
        $order->user_id = auth()->user()->id;
        $order->product_details = json_encode($product); // Save products as JSON

        // Save the order to the database
        $order->save();
        // Notify SuperAdmins via FCM and email
        $superAdmins = User::where('role', 'SuperAdmin')->get();

        foreach ($superAdmins as $superAdmin) {
            if ($superAdmin->device_token) {
                // Send FCM Notification
                $serverKey = 'YOUR_FCM_SERVER_KEY';

                $data = [
                    "to" => $superAdmin->device_token,
                    "notification" => [
                        "title" => 'New Purchase Request',
                        "body" => 'A wholesaler has requested to purchase products.',
                    ],
                ];

                $headers = [
                    'Authorization: key=' . $serverKey,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                $result = curl_exec($ch);

                if ($result === FALSE) {
                    Log::error('FCM Send Error: ' . curl_error($ch));
                }

                curl_close($ch);
            } else {
                Log::warning("SuperAdmin {$superAdmin->email} does not have a valid FCM token.");
            }

            // Send email notification
            Mail::to($superAdmin->email)->send(new PurchaseRequestNotification($order));
        }

        // Redirect to the 'buy' route
//   return redirect()->route('buy')->with('success', 'Purchase request created successfully.');
// }

        return redirect()->route('invoice', ['orderId' => $order->id])->with('success', 'Order placed successfully.');
    }


    public function checkout()
    {
        if (Auth::check()) {
            // User is authenticated, retrieve cart data from the database
            $cartData = Cart::where('user_id', Auth::user()->id)->first();
            // dd($cartData);
            if ($cartData) {
                $product = json_decode($cartData->detail, true);
            } else {
                // If no cart data is found in the database, initialize an empty cart array
                $product = [];
            }
        } else {
            // User is not authenticated, retrieve cart data from the session
            $product = session()->get('cart', []);

        }
        // $products = Session::get('cartData', []);
        //  dd($products);
        $subtotal = 0;
        $shipping = 0; // Replace with your actual shipping cost

        foreach ($product as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('product', 'subtotal', 'shipping'));
    }


    public function invoice($orderId, Request $request)
    {
        Log::info($request->all());

        // Fetch the order by ID
        $order = Order::findOrFail($orderId);

        // Decode product details (assuming it stores products in a JSON array)
        $products = json_decode($order->product_details, true);

        // Initialize the total
        $total = 0;

        // Calculate the total by looping through each product
        if (is_array($products) && !empty($products)) {
            foreach ($products as $product) {
                $quantity = $product['quantity'] ?? 0;
                $price = $product['price'] ?? 0;
                $lineTotal = $quantity * $price;
                $total += $lineTotal;
            }
        }

        // Pass the order, product details, and total to the view
        return view('invoice', compact('order', 'products', 'total'));
    }


    public function add_dukandar()
    {
        return view('add-dukandar');

    }

    public function view_dukandar(Request $request)
    {
        $data = Dukandar::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('view-dukandar', compact('data'));

    }

    public function store_dukandar(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'digits:10',
                'numeric',
                'unique:dukandars,phone'
            ],
            'office_phn' => [
                'required',
                'digits:10',
                'numeric'
            ],
            'shop_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'email' => 'required|email|unique:dukandars,email',
            'aadhar' => [
                'nullable',
                'digits:12', // Aadhar should be exactly 12 digits
                'numeric',   // Ensure it's a valid number
            ],
            'pan' => [
                'nullable',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', // PAN format validation
            ],
        ], [
            'phone.digits' => 'The phone number must be exactly 10 digits.',
            'phone.numeric' => 'The phone number must be a valid number.',
            'officephn.digits' => 'The phone number must be exactly 10 digits.',
            'officephn.numeric' => 'The office phone number must be a valid number.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'aadhar.digits' => 'The Aadhar number must be exactly 12 digits.',
            'aadhar.numeric' => 'The Aadhar number must be a valid number.',
            'pan.regex' => 'The PAN number must follow the format ABCDE1234F.',
        ]);


        // Create a new Shopkeeper instance

        $shopkeeper = new dukandar();
        $shopkeeper->mandivyapari_id = Auth::id();
        $shopkeeper->name = $request->input('name');
        $shopkeeper->phone = $request->input('phone');
        $shopkeeper->shop_name = $request->input('shop_name');
        $shopkeeper->address = $request->input('address');
        $shopkeeper->email = $request->input('email');
        $shopkeeper->mandi_license_no = $request->input('mandi_license_no');
        $shopkeeper->gumasta_no = $request->input('gumasta_no');
        $shopkeeper->gst_no = $request->input('gst_no');
        $shopkeeper->aadhar = $request->input('aadhar');
        $shopkeeper->pan = $request->input('pan');
        $shopkeeper->account_no = $request->input('account_no');
        $shopkeeper->ifsc_code = $request->input('ifsc_code');
        $shopkeeper->office_phn = $request->input('office_phn');

        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('gumastaImage/' . $filename1);
            $shopkeeper->gumasta = $filename1;
        }

        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('gstImage/' . $filename1);
            $shopkeeper->gst_registration = $filename1;
        }

        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('aadharImage/' . $filename1);
            $shopkeeper->aadhar_card = $filename1;
        }

        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('PancardImage/' . $filename1);
            $shopkeeper->pan_card = $filename1;
        }

        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('image/' . $filename1);
            $shopkeeper->image = $filename1;
        }

        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('statement/' . $filename1);
            $shopkeeper->statement = $filename1;
        }

        // Save the shopkeeper data to the database
        $shopkeeper->save();

        // Redirect back with success message
        return back()->with('success', 'Shopkeeper details saved successfully!');
    }
    // public function store_dukandar(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => [
    //             'required',
    //             'digits:10', // Exactly 10 digits
    //             'numeric'    // Ensure it's numeric
    //         ],
    //         'shop_name' => 'required|string|max:255',
    //         'address' => 'required|string|max:500',
    //         'email' => 'required|email|unique:users,email', // Ensure email is unique if applicable
    //     ], [
    //         'phone.digits' => 'The phone number must be exactly 10 digits.',
    //         'phone.numeric' => 'The phone number must be a valid number.',
    //         'email.email' => 'The email address must be a valid email address.',
    //         'email.unique' => 'The email address has already been taken.',
    //     ]);

    //     // Create a new Shopkeeper instance

    //     $shopkeeper = new dukandar();
    //     $shopkeeper->mandivyapari_id = Auth::id();
    //     $shopkeeper->name = $request->input('name');
    //     $shopkeeper->phone = $request->input('phone');
    //     $shopkeeper->shop_name = $request->input('shop_name');
    //     $shopkeeper->address = $request->input('address');
    //     $shopkeeper->email = $request->input('email');
    //     $shopkeeper->mandi_license_no = $request->input('mandi_license_no');
    //     $shopkeeper->gumasta_no = $request->input('gumasta_no');
    //     $shopkeeper->gst_no = $request->input('gst_no');
    //     $shopkeeper->aadhar = $request->input('aadhar');
    //     $shopkeeper->pan = $request->input('pan');
    //     $shopkeeper->account_no = $request->input('account_no');
    //     $shopkeeper->ifsc_code = $request->input('ifsc_code');
    //     $shopkeeper->office_phn = $request->input('office_phn');

    //     if ($request->hasFile('gumasta')) {
    //         $file1 = $request->file('gumasta');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('gumastaImage/' . $filename1);
    //         $shopkeeper->gumasta = $filename1;
    //     }

    //     if ($request->hasFile('gst_registration')) {
    //         $file1 = $request->file('gst_registration');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('gstImage/' . $filename1);
    //         $shopkeeper->gst_registration = $filename1;
    //     }

    //     if ($request->hasFile('aadhar_card')) {
    //         $file1 = $request->file('aadhar_card');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('aadharImage/' . $filename1);
    //         $shopkeeper->aadhar_card = $filename1;
    //     }

    //     if ($request->hasFile('pan_card')) {
    //         $file1 = $request->file('pan_card');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('PancardImage/' . $filename1);
    //         $shopkeeper->pan_card = $filename1;
    //     }

    //     if ($request->hasFile('image')) {
    //         $file1 = $request->file('image');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('image/' . $filename1);
    //         $shopkeeper->image = $filename1;
    //     }

    //     if ($request->hasFile('statement')) {
    //         $file1 = $request->file('statement');
    //         $ext = $file1->getClientOriginalExtension();
    //         $filename1 = time() . '_1.' . $ext;
    //         $file1->move('statement/' . $filename1);
    //         $shopkeeper->statement = $filename1;
    //     }

    //     // Save the shopkeeper data to the database
    //     $shopkeeper->save();

    //     // Redirect back with success message
    //     return back()->with('success', 'Shopkeeper details saved successfully!');
    // }
    public function update_dukandar(Request $request, $id)
    {
        Log::info($request->all());

        // Validate the request data
        $request->validate([
            // 'name' => 'required',
            // 'phone' => 'required',
            // 'shop_name' => 'required',
            // 'address' => 'required',
            // 'email' => 'required',

        ]);

        // Create a new Shopkeeper instance

        $shopkeeper = dukandar::find($id);
        $shopkeeper->mandivyapari_id = Auth::id();
        $shopkeeper->name = $request->input('name');
        $shopkeeper->phone = $request->input('phone');
        $shopkeeper->shop_name = $request->input('shop_name');
        $shopkeeper->address = $request->input('address');
        $shopkeeper->email = $request->input('email');
        $shopkeeper->mandi_license_no = $request->input('mandi_license_no');
        $shopkeeper->gumasta_no = $request->input('gumasta_no');
        $shopkeeper->gst_no = $request->input('gst_no');
        $shopkeeper->aadhar = $request->input('aadhar');
        $shopkeeper->pan = $request->input('pan');
        $shopkeeper->account_no = $request->input('account_no');
        $shopkeeper->ifsc_code = $request->input('ifsc_code');
        $shopkeeper->office_phn = $request->input('office_phn');

        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('gumastaImage/' . $filename1);
            $shopkeeper->gumasta = $filename1;
        }

        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('gstImage/' . $filename1);
            $shopkeeper->gst_registration = $filename1;
        }

        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('aadharImage/' . $filename1);
            $shopkeeper->aadhar_card = $filename1;
        }

        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('PancardImage/' . $filename1);
            $shopkeeper->pan_card = $filename1;
        }

        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('image/' . $filename1);
            $shopkeeper->image = $filename1;
        }

        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('statement/' . $filename1);
            $shopkeeper->statement = $filename1;
        }

        // Save the shopkeeper data to the database
        $shopkeeper->save();

        // Redirect back with success message
        return back()->with('success', 'Shopkeeper details saved successfully!');
    }

    public function delete_dukandar(Request $request)
    {
        $shopkeeper = Dukandar::find($request->id);
        $shopkeeper->delete();
        return response()->json(['success', true]);
    }

    public function sale_dukandar()
    {
        $dukans = Dukandar::all();
        $products = Stock::all();
        return view('sale-dukandar', compact('dukans', 'products'));
    }



    public function store_sale(Request $request)
    {
        
        // Log::info($request->all());
        // Validate the request data
        $request->validate([
            'dukandar_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'price_per_unit' => 'required',
            'total' => 'required',
        ]);

        // Find the product
        $product = Stock::findOrFail($request->product_id);

        // dd($request->all());
        // Check if there is enough stock
        if ($product->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        // Update the product quantity
        $product->quantity -= $request->quantity;
        $product->save();


        $sale = new Sale();
        $sale->mandivyapari_id = Auth::id();
        $sale->dukandar_id = $request->input('dukandar_id');
        $sale->stock_id = $request->input('product_id');
        $sale->quantity = $request->input('quantity');
        $sale->unit = $request->input('unit');
        $sale->price_per_unit = $request->input('price_per_unit');
        $sale->total = $request->input('total');
        $sale->save();


        // $stock = new Stock();
        // $stock->mandivyapari_id = Auth::id();
        // $stock->product_id = $request->input('product_id');
        // $stock->quantity = $product->quantity;
        // $stock->unit = $request->input('unit');
        // $stock->save();



        return back()->with('success', 'Product sold and stock updated successfully.');
    }


    public function view_sales(Request $request)
    {

        $data = Sale::all();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('mandivyapari_id', function ($row) {
                    $user = User::find($row->mandivyapari_id);
                    return $user ? $user->name : 'N/A';
                })
                ->addColumn('dukandar_id', function ($row) {
                    $user = Dukandar::find($row->dukandar_id);
                    return $user ? $user->name : 'N/A';
                })
                // ->addColumn('stock_id', function ($row) {
                //     $user = Stock::find($row->stock_id);
                //     $product=Product::find($user->product_id);
                //     // $comm = Commodities::find($product->commodity_id);
                //     // $var = Varieties::find($product->variety_id); // Corrected Varieties model name
    
                //     return $user ?  $product->quality : 'N/A';
                // })
//                 

                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('view-sales', compact('data'));
    }


    public function delete_sale(Request $request)
    {
        $sale = Sale::find($request->id);
        $sale->delete();
        return response()->json(['success', true]);
    }


    public function updatesales(Request $request, $id)
    {
        Log::info($request->all());
        // Validate the request data
        $request->validate([
            // 'dukandar_id' => 'required',
            // 'product_id' => 'required',
            // 'quantity' => 'required',
            // 'unit' => 'required',
            // 'price_per_unit' => 'required',
            // 'total' => 'required'
        ]);

        // Create a new sale record
        $sale = Sale::find($id);
        $sale->mandivyapari_id = Auth::id();
        $sale->dukandar_id = $request->input('dukandar_id');
        $sale->product_id = $request->input('product_id');
        $sale->quantity = $request->input('quantity');
        $sale->unit = $request->input('unit');
        $sale->price_per_unit = $request->input('price_per_unit');
        $sale->total = $request->input('total');
        $sale->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Sale recorded successfully.');
    }


    public function view_stock(Request $request)
    {
        $data = Stock::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('mandivyapari_id', function ($row) {
                    $user = User::find($row->mandivyapari_id);
                    return $user ? $user->name : 'N/A';
                })
                // ->addColumn('product_id', function ($row) {
                //     $user = Product::find($row->product_id);
                //     return $user ? $user->quality : 'N/A';
                // })
                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('view-stock', compact('data'));
    }


    public function delete_stock(Request $request)
    {
        //Log::info($request->all());
        $stock = Stock::find($request->id);
        $stock->delete();
        return response()->json(['success', true]);
    }


    public function all_users(Request $request)
    {
        $data = User::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    // Button to change role to MandiVyapari
                    // $btn = '<button type="button" class="btn btn-outline-primary btn-sm change-role" data-id="' . $row->id . '" data-role="MandiVyapari" title="Change to MandiVyapari">';
                    // $btn .= '    MandiVyapari';
                    // $btn .= '</button>&nbsp';
    
                    // // Button to change role to Wholesaler
                    // $btn .= '<button type="button" class="btn btn-outline-success btn-sm change-role" data-id="' . $row->id . '" data-role="Wholesaler" title="Change to Wholesaler">';
                    // $btn .= '    Wholesaler';
                    // $btn .= '</button>&nbsp';
                    $btn = '<button type="button" class="btn btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>&nbsp';
                    $btn .= '<form action="/profile/' . $row->id . '" method="get" style="display:inline;">';
                    $btn .= '   <button type="submit" class="btn btn-sm view" title="View">';
                    $btn .= '       <i class="fas fa-eye"></i>';
                    $btn .= '   </button>';
                    $btn .= '</form>&nbsp';


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('all-users', compact('data'));
    }
    public function profile(Request $request)
    {
        $user=User::where('id',$request->id)->first();
        $products=Product::where('user_id',$user->id)->get();
        $dukandars=Sale::where('mandivyapari_id',$user->id)->get();
        // dd($dukandars);
         foreach ($products as $product) {
       if (is_array($product->image)) {
        $product->image = json_encode($product->image); // Encode array to JSON string if needed
    }
    }
        return view('profile',compact('user','products','dukandars'));
    }


    public function delete_users(Request $request)
    {
        //Log::info($request->all());
        $user = User::find($request->id);
        $user->delete();
        return response()->json(['success', true]);
    }



    public function purchase_request(Request $request)
    {
        $data = Order::all();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a type="button" class="btn btn-outline-primary btn-sm change" data-id="' . $row->id . '" data-status="Approved">Approve</a>&nbsp';
                    $btn .= '<a type="button" class="btn btn-outline-danger btn-sm reject" data-id="' . $row->id . '" data-status="Rejected">Reject</a>&nbsp';

                    $btn .= '<button type="button" class="btn btn-danger btn-sm delete" title="Delete" id="' . $row->id . '">';
                    $btn .= '    <i class="fas fa-trash-alt"></i>';
                    $btn .= '</button>&nbsp';

                    return $btn;
                })
                ->editColumn('product_details', function ($row) {
                    $products = json_decode($row->product_details, true);
                    $productNames = array_map(function ($product) {
                        return $product['name'];
                    }, $products);
                    return implode(', ', $productNames);
                })
                ->editColumn('quantity', function ($row) {
                    $products = json_decode($row->product_details, true);
                    $quantities = array_map(function ($product) {
                        return $product['quantity'];
                    }, $products);
                    return implode(', ', $quantities);
                })
                ->editColumn('unit', function ($row) {
                    $products = json_decode($row->product_details, true);
                    $units = array_map(function ($product) {
                        return $product['unit'];
                    }, $products);
                    return implode(', ', $units);
                })
                ->editColumn('status', function ($row) {
                    return ucfirst($row->status); // Capitalize status
                })
                ->rawColumns(['action', 'product_details', 'quantity', 'unit', 'status'])
                ->make(true);
        }
        return view('purchase-request', compact('data'));
    }
    public function myorders(Request $request)
    {
        $data = Order::where('user_id', auth()->user()->id)->get();
        if ($request->ajax()) {
            return Datatables::of($data)

            ->editColumn('product_details', function ($row) {
                $products = json_decode($row->product_details, true);
            
                // Fetch all products in one query
                $productIds = array_column($products, 'id');
                $productData = Product::whereIn('id', $productIds)->pluck('quality', 'id')->toArray();
            
                $productNames = array_map(function ($product) use ($productData) {
                    $quality = $productData[$product['id']] ?? 'Unknown'; // Handle cases where quality might not be found
                    return $product['name'] . " (" . $quality . ")";
                }, $products);
            
                return implode(', ', $productNames);
            })
            
                ->editColumn('quantity', function ($row) {
                    $products = json_decode($row->product_details, true);
                    $quantities = array_map(function ($product) {
                        return $product['quantity'];
                    }, $products);
                    return implode(', ', $quantities);
                })
                ->editColumn('unit', function ($row) {
                    $products = json_decode($row->product_details, true);
                    $units = array_map(function ($product) {
                        return $product['unit'];
                    }, $products);
                    return implode(', ', $units);
                })
                ->editColumn('status', function ($row) {
                    return ucfirst($row->status); // Capitalize status
                })
                ->rawColumns(['product_details', 'quantity', 'unit', 'status'])
                ->make(true);
        }
        
        return view('myorders', compact('data'));
    }




    public function request_status(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        $purchaseRequest = Order::findOrFail($request->id);
        $purchaseRequest->status = $request->status;
       if($request->status == "Approved") {
            $role = User::where('id', $purchaseRequest->user_id)->value('role');
            
            if($role == "MandiVyapari") {
                $productDetails = json_decode($purchaseRequest->product_details, true);
        
                if ($productDetails && is_array($productDetails)) {
                    foreach ($productDetails as $product) {
                        // Check if stock already exists for this product
                        $existingStock = Stock::where('mandivyapari_id', $purchaseRequest->user_id)
                            ->where('product_id', $product['id'])
                            ->first();
        
                        if ($existingStock) {
                            // If stock exists, add the new quantity to the existing quantity
                            $existingStock->quantity += $product['quantity'];
                            $existingStock->save();
                        } else {
                            // If stock doesn't exist, create a new entry
                            $stock = new Stock();
                            $stock->mandivyapari_id = $purchaseRequest->user_id;
                            $stock->product_id = $product['id'];
                            $stock->quantity = $product['quantity'];
                            $stock->units = $product['unit'];
                            $stock->save();
                        }
                    }
                }
            }
        }

        $purchaseRequest->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }

    public function delivery_status()
    {
        return view('delivery-status');
    }

    public function delete_request()
    {
        return view('delete-request');
    }



    public function notification()
    {
        return view('notification');
    }

    public function update_user_role(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            $user->role = $request->role;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function storePurchaseRequest(Request $request)
    {
        // Log incoming request data
        //Log::info($request->all());

        // Validate request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required|string',
        ]);

        // Store the purchase request
        $purchaseRequest = new PurchaseRequest();
        $purchaseRequest->user_id = Auth::id();
        $purchaseRequest->product_id = $request->input('product_id');
        $purchaseRequest->quantity = $request->input('quantity');
        $purchaseRequest->unit = $request->input('unit');
        $purchaseRequest->save();



        return redirect()->route('buy')->with('success', 'Purchase request created successfully.');
    }




    public function order_details()
    {
        return view('order-details');
    }

public function upload_news(Request $request)
{
    // Validate the incoming request
    
    
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image',
        'date' => 'nullable|date',
        'description' => 'required',
        'link' => 'nullable|url',
    ]);
    // dd("hi");
    // Proceed with saving the news data after validation
    $news = new News;
    $news->title = $request->input('title');
    $news->date = $request->input('date');
    $news->description = $request->input('description');
    $news->link = $request->input('link');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move(public_path('NewsImages'), $filename); // Save image to public/NewsImages
        $news->image = $filename;
    }

    $news->save();

    return redirect()->back()->with('success', 'News added successfully.');
}

 public function uploadBanner(Request $request)
    {
    $request->validate([
        'image' => 'required',
        'type'=>'required'
    ]);


    if ($request->hasFile('image')) {
        // Process the uploaded file
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $imageName = time() . '.' . $ext; // Use current time for a unique filename
        $file->move('BannerImages/' , $imageName); // Save the image to the folder
    
        // Save the banner to the database
        $banner = new Banner();
        $banner->image = $imageName;
        $banner->type = $request->type; // Save the provided type
        $banner->save();
    }
    return redirect()->back()->with('success', 'Banner added successfully.');
    }
    
  public function deleteBanner(Request $request)
    {
        $banner = Banner::find($request->id);

        if ($banner) {
            
            $imagePath = public_path('BannerImages/' . $banner->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
           
            $banner->delete();

            return response()->json([
                'message' => 'Banner deleted successfully.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Banner not found.',
            ], 404);
        }
    }



}
