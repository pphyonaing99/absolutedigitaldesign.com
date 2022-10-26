<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});*/

Route::post('login', 'api\LoginController@login');

//Project
Route::post('project_list', 'api\ManagerController@project_list')->name('project_list');
Route::get('create_project', 'api\ManagerController@create_project')->name('create_project');
Route::post('store_project', 'api\ManagerController@store_project')->name('store_project');

Route::post('store_phase', 'api\ManagerController@store_phase')->name('store_phase');
Route::post('check_phase_list', 'api\ManagerController@check_phase_list')->name('check_phase_list');
Route::post('task_list','api\ManagerController@task_list')->name('task_list');
Route::post('store_task', 'ProjectController@store_task')->name('store_task');

//Checked Task Finished or not
Route::post('store_reported_task','api\ManagerController@store_reported_task');

//Warehouse
Route::post('product_list', 'api\SiteController@product_list'); //Warehouse Inventory
Route::post('store_item', 'api\WarehouseController@store_item');

Route::post('wh_purchase_order_list', 'api\WarehouseController@purchase_order_list');
Route::post('wh_purchase_order_create', 'api\WarehouseController@wh_purchase_order_create');

Route::post('delivery_order', 'api\WarehouseController@delivery_order');

Route::get('wh_purchase_order_create', 'api\SiteController@Purchase_Order_Create');

Route::post('wh_store_purchase_order', 'api\WarehouseController@store_purchase_order');

//Site Start
Route::post('receive_order', 'api\SiteController@Receive_Order');

Route::post('receive_order_store', 'api\SiteController@Receive_Order_Store');


//Site
Route::post('site_good_receive_note','api\SiteController@sendsitegrn');
Route::post('site_product_detail','api\SiteController@site_grn_product_details');
Route::post('accept_site_products','api\SiteController@accept_site_product');
Route::post('reject_site_products','api\SiteController@reject_site_product');
//Site => Purchase Order
Route::post('site_purchase_order_list', 'api\SiteController@Purchase_Orderlist');
Route::post('item_list_details','api\SiteController@item_list_details');
Route::post('site_order_list_item', 'api\SiteController@site_order_list_item');

Route::post('site_purchase_order_create', 'api\SiteController@Purchase_Order_Create');
Route::post('site_purchase_order_store', 'api\SiteController@Purchase_Order_Store');
Route::post('site_purchase_order_group', 'api\SiteController@Purchase_Order_Group');

//Site => Material Request
Route::post('site_material_request_store', 'api\SiteController@site_material_request_store');
Route::post('material_request_list', 'api\SiteController@material_request_list');
Route::post('material_item_list', 'api\SiteController@material_item_list');

//Site => Delivery Order
Route::post('delivery_order_list','api\DeliveryOrderController@delivery_order_list');
Route::post('delivery_itemlist_details','api\DeliveryOrderController@delivery_itemlist_details');
Route::post('delivery_order_accept','api\DeliveryOrderController@delivery_order_accept');

//Site => Site Inventory

Route::post('site_inventories','api\SiteInventoryController@site_inventories')->name('site_inventories');

Route::post('product_store','api\ProductController@product_store')->name('product_store');

//Site => Handtool
Route::post('handtool_list','api\HandtoolController@handtoolList');

Route::post('assign-detail','api\HandtoolController@assignDetail');
Route::post('assign-handtool','api\HandtoolController@assignHandtoolList');
Route::post('accept-handtool','api\HandtoolController@acceptHandtool');
Route::post('return-handtool','api\HandtoolController@returnHandtool');

