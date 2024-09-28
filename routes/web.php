<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NormalController;
use App\Http\Controllers\NotificationSendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });
// Route::get('/', function () {
//     return view('login');
// })->name('login');

Route::get("/", [HomeController::class, "index_main"])->name('index_main');
// Route::get('/register1', function(){
//     return view('auth.register');
// })->name('register1');
Route::post("/save", [NormalController::class, "save"])->name('save');

Route::get("/buy", [HomeController::class, "buy"])->name('buy');
Route::get("/cart", [HomeController::class, "cart"])->name('cart');
Route::get("/checkout", [HomeController::class, "checkout"])->name('checkout');
Route::get("/invoice/{orderId}", [HomeController::class, "invoice"])->name('invoice');
Route::post("/productupdate/{id}", [HomeController::class, "productupdate"])->name('productupdate');

Route::get('cart/add/{productId}', [HomeController::class, "addcart"]);
Route::get('/cart/remove/{productId}', [HomeController::class, 'removecart']);
Route::get('/cart/minus/{productId}', [HomeController::class, 'minuscart']);

Route::post('/savecheckout', [HomeController::class, 'savecheckout'])->name('savecheckout');
Route::get('/myorders', [HomeController::class, 'myorders'])->name('myorders');






Route::middleware(['Wholesaler', 'SuperAdmin'])->group(function () {
    Route::get("/wholesaler-dashboard", [HomeController::class, "wholesaler_dashboard"])->name('wholesaler-dashboard');
    Route::get("/commodity", [HomeController::class, "commodity"])->name('commodity');
    Route::get("/superadmin-dashboard", [HomeController::class, "superadmin_dashboard"])->name('superadmin-dashboard');
    Route::get("/addvariety", [HomeController::class, "addvariety"])->name('addvariety');
    Route::get("/createcommodity", [HomeController::class, "createcommodity"])->name('createcommodity');

    Route::post("/storecommodity", [HomeController::class, "storecommodity"])->name('storecommodity');
    Route::post("/commodityup/{id}", [HomeController::class, "commodityup"])->name('commodityup');
    Route::get("/updatecommodity/{id}", [HomeController::class, "updatecommodity"])->name('updatecommodity');
    Route::get("/viewcommodity", [HomeController::class, "viewcommodity"])->name('viewcommodity');
    Route::get("/delete-commodity", [HomeController::class, "delete_commodity"])->name('delete-commodity');


    Route::post("/upload-news", [HomeController::class, "upload_news"])->name('upload-news');
    
    Route::get("/delete-news", [HomeController::class, "delete_news"])->name('delete-news');
    Route::post("/upload-banner", [HomeController::class, "uploadBanner"])->name('upload-banner');
    Route::post("/change-type/{id}", [HomeController::class, "changeType"])->name('change-type');
    
    Route::post("/delete-banner", [HomeController::class, "deleteBanner"])->name('delete-banner');

    Route::post("/storevariety", [HomeController::class, "storevariety"])->name('storevariety');
    Route::post("/varietyup/{id}", [HomeController::class, "varietyup"])->name('varietyup');
    Route::get("/updatevariety/{id}", [HomeController::class, "updatevariety"])->name('updatevariety');
    Route::get("/viewvariety", [HomeController::class, "viewvariety"])->name('viewvariety');
    Route::get("/delete-variety", [HomeController::class, "delete_variety"])->name('delete-variety');
    Route::get("/addproducts", [HomeController::class, "addproducts"])->name('addproducts');
    Route::post("/storeproduct", [HomeController::class, "storeproduct"])->name('storeproduct');

    Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile');
    // Route::get("/productupdate/{id}", [HomeController::class, "productupdate"])->name('productupdate');
    Route::get("/viewproducts", [HomeController::class, "viewproducts"])->name('viewproducts');
    Route::get("/delete-product", [HomeController::class, "delete_product"])->name('delete-product');
    Route::get("/sell", [HomeController::class, "sell"])->name('sell');

    Route::get("/all-users", [HomeController::class, "all_users"])->name('all-users');
    Route::get("/delete-users", [HomeController::class, "delete_users"])->name('delete-users');

    Route::get("/purchase-request", [HomeController::class, "purchase_request"])->name('purchase-request');
    Route::post("/request-status", [HomeController::class, "request_status"])->name('request-status');
    Route::get("/delivery-status", [HomeController::class, "delivery_status"])->name('delivery-status');
    Route::get("/delete-request", [HomeController::class, "delete_request"])->name('delete-request');

    Route::get("/view-banners", [HomeController::class, "view_banners"])->name('view-banners');
    Route::get("/view-news", [HomeController::class, "view_news"])->name('view-news');
    
    
    Route::get('/order-details', [HomeController::class, 'order_details'])->name('order-details');
});

Route::middleware('MandiVyapari')->group(function () {
    Route::get("/mandi-dashboard", [HomeController::class, "mandi_dashboard"])->name('mandi-dashboard');
    Route::get("/add-dukandar", [HomeController::class, "add_dukandar"])->name('add-dukandar');
    Route::get("/view-dukandar", [HomeController::class, "view_dukandar"])->name('view-dukandar');
    Route::post("/store-dukandar", [HomeController::class, "store_dukandar"])->name('store-dukandar');
    Route::post("/update-dukandar/{id}", [HomeController::class, "update_dukandar"])->name('update-dukandar');
    Route::get("/delete-dukandar", [HomeController::class, "delete_dukandar"])->name('delete-dukandar');

    Route::get("/view-sales", [HomeController::class, "view_sales"])->name('view-sales');
    Route::get("/sale-dukandar", [HomeController::class, "sale_dukandar"])->name('sale-dukandar');
    Route::get("/delete-sale", [HomeController::class, "delete_sale"])->name('delete-sale');

    Route::get("/view-stock", [HomeController::class, "view_stock"])->name('view-stock');
    Route::get("/delete-stock", [HomeController::class, "delete_stock"])->name('delete-stock');



});

Route::post("/updatesales/{id}", [HomeController::class, "updatesales"])->name('updatesales');
Route::post('/store-sale', [HomeController::class, 'store_sale'])->name('store-sale');








Route::post('/savecommodity', [HomeController::class, 'savecommodity'])->name('savecommodity');
Route::post('/saveproduct', [HomeController::class, 'saveproduct'])->name('saveproduct');
Route::get('/fetch-variants/{commodityId}', [HomeController::class, 'fetchVariants']);
Route::get('/search-commodities/{searchTerm}', [HomeController::class, 'searchCommodities']);
Route::post('/storepurchase', [HomeController::class, 'storepurchase'])->name('storepurchase');

Route::get('/editable', [HomeController::class, 'editable'])->name('editable');
Route::get("/notification", [HomeController::class, "notification"])->name('notification');
Route::post('/update-user-role', [HomeController::class, 'update_user_role'])->name('update-user-role');
Route::post('/savedevice', [HomeController::class, 'savedevice'])->name('savedevice');



// Route::post('/send-notification-to-admin', [HomeController::class, 'sendNotificationToAdmin']);
// Route::post('/send-web-notification', [HomeController::class, 'sendNotificationToAdmin'])->name('send.web-notification');
// Route::post('/store-token', [HomeController::class, 'updateDeviceToken'])->name('store.token');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/purchase-request/add', [HomeController::class, 'storePurchaseRequest']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});
