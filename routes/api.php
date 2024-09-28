<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CommodityController;
use App\Http\Controllers\Api\MandiVyapariController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseRequestsController;
use App\Http\Controllers\Api\SuperAdminController;
use App\Http\Controllers\Api\VarietyController;
use App\Http\Controllers\Api\WholesalerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/daily-rate-updates', [SuperAdminController::class, 'daily_rates_update']);
Route::get('/average-price-by-state', [SuperAdminController::class, 'averagePriceByState']);
Route::get('/average-price-by-state-district', [SuperAdminController::class, 'averagePriceByStateAndDistrict']);
Route::get('/realtime-mandi-rate', [SuperAdminController::class, 'realtime_mandi_rate']);
Route::get('/mandi-rate-by-commodity', [SuperAdminController::class, 'mandi_rate_by_commodity']);
Route::get('/get-stats', [SuperAdminController::class, 'getStatistics']);
Route::get('/get-user/{id}', [SuperAdminController::class, 'get_users']);

Route::get('/static-mandi-rate', [SuperAdminController::class, 'static_mandi_rate']);
Route::get('/banner', [BannerController::class, 'index']);
Route::post('/upload-banner', [BannerController::class, 'uploadBanner']);
Route::get('/news', [BannerController::class, 'index1']);
Route::post('/delete-news/{id}', [BannerController::class, 'delete_news']);
Route::post('/upload-news', [BannerController::class, 'upload_news']);
Route::post('/delete-banner/{id}', [BannerController::class, 'deleteBanner']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/add-commodity', [CommodityController::class, 'add_commodity']);
    Route::get('/get-commodities', [CommodityController::class, 'get_commodities']);
    Route::post('/edit-commodity/{id}', [CommodityController::class, 'edit_commodity']);
    Route::get('/get-commodity/{id}', [CommodityController::class, 'get_commodity']);
    Route::post('/delete-commodity/{id}', [CommodityController::class, 'delete_commodity']);


    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/add-variety', [VarietyController::class, 'add_variety']);
    Route::get('/get-varieties', [VarietyController::class, 'get_varieties']);
    Route::get('/get-varieties-by-commodity/{id}', [VarietyController::class, 'get_variety_by_commodity']);
    Route::post('/edit-variety/{id}', [VarietyController::class, 'edit_variety']);
    Route::get('/get-variety/{id}', [VarietyController::class, 'get_variety']);
    Route::post('/delete-variety/{id}', [VarietyController::class, 'delete_variety']);


    Route::post('/add-product', [ProductController::class, 'add_product']);
    Route::get('/get-products', [ProductController::class, 'get_products']);
    Route::get('/get-product/{id}', [ProductController::class, 'get_product']);
    Route::get('/get-product-by-wholesaler', [ProductController::class, 'get_product_by_wholesaler']);
    Route::post('/edit-product/{id}', [ProductController::class, 'edit_product']);
    Route::get('/filters', [ProductController::class, 'filters']);
    Route::post('/delete-product/{id}', [ProductController::class, 'delete_product']);


    Route::get('/search/{name?}', [CommodityController::class, 'search']);


    Route::post('/send-purchase-request', [PurchaseRequestsController::class, 'send_purchase_request']);
    Route::get('/get-purchase-requests', [PurchaseRequestsController::class, 'get_purchase_requests']);
    Route::get('/get-notifications', [PurchaseRequestsController::class, 'get_notifications']);
    Route::get('/get-purchase-requests-of-mandivyapari', [PurchaseRequestsController::class, 'get_purchase_requests_of_mandivyapri']);

    Route::post('/approve-purchase-request/{id}', [SuperAdminController::class, 'approve_purchase_request']);
    Route::post('/approve-cancel-request/{id}', [SuperAdminController::class, 'approve_cancel_request']);
    Route::post('/mark-delivered/{id}', [SuperAdminController::class, 'mark_delivered']);
    Route::post('/reject-purchase-request/{id}', [SuperAdminController::class, 'reject_purchase_request']);
    Route::get('/get-dukandars', [SuperAdminController::class, 'get_dukandars']);
    Route::get('/get-dukandars-of-mandivyapari/{id}', [SuperAdminController::class, 'get_dukandars_of_mandivyapari']);


    Route::get('/get-purchase-request', [MandiVyapariController::class, 'get_purchase_requests']);
    Route::post('/edit-purchase-request/{id}', [MandiVyapariController::class, 'edit_purchase_request']);
    Route::post('/send-cancel-request/{id}', [MandiVyapariController::class, 'send_cancel_request']);
    // Route::post('/cancel-purchase-request/{id}', [MandiVyapariController::class, 'cancel_purchase_request']);
    Route::post('/add-dukandar', [MandiVyapariController::class, 'add_dukandar']);
    Route::post('/edit-dukandar/{id}', [MandiVyapariController::class, 'edit_dukandar']);
    Route::get('/get-dukandars-by-mandivyapari', [MandiVyapariController::class, 'get_dukandars_by_mandivyapari']);
    Route::post('/add-sales', [MandiVyapariController::class, 'add_sales']);
    Route::post('/reorder/{id}', [MandiVyapariController::class, 'reorder']);


    Route::get('/get-products-wholesaler', [WholesalerController::class, 'get_products']);
    Route::get('/filter-rate', [SuperAdminController::class, 'filter_rate']);


});