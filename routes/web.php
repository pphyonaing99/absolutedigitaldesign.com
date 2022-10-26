<?php

use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//Clear configurations:
			Route::get('/config-clear', function() {
				$status = Artisan::call('config:clear');
				return '<h1>Configurations cleared</h1>';
			});

//Clear cache:
			Route::get('/cache-clear', function() {
				$status = Artisan::call('cache:clear');
				return '<h1>Cache cleared</h1>';
			});

//Clear configuration cache:
			Route::get('/config-cache', function() {
				$status = Artisan::call('config:cache');
				return '<h1>Configurations cache cleared</h1>';
			});
//Login
Route::get('/', 'LoginController@userlogin')->name('userlogin');
Route::post('loginprocess', 'LoginController@loginprocess')->name('loginprocess');
Route::get('logoutprocess', 'LoginController@logoutprocess')->name('logoutprocess');
Route::get('general_setting', 'GeneralSettingController@general_setting')->name('general_setting');

//Discount Type
Route::get('discount_type','MasterDataController@discount_type')->name('discount_type');
Route::post('ajaxDiscountType','MasterDataController@ajaxDiscountType')->name('ajaxDiscountType');

Route::group(['middleware' => ['UserAuth']], function () {
    Route::get('category_list','MasterDataController@category_list')->name('category_list');
    Route::post('ajaxCategory','MasterDataController@ajaxCategory')->name('ajaxCategory');
    
    Route::get('subcategory_list','MasterDataController@subcategory_list')->name('subcategory_list');
    Route::post('ajaxSubCategory','MasterDataController@ajaxSubCategory')->name('ajaxSubCategory');
    
    Route::get('brand_list','MasterDataController@brand_list')->name('brand_list');
    Route::post('ajaxStoreBrand','MasterDataController@ajaxStoreBrand')->name('ajaxStoreBrand');
    Route::post('getSubCategory','MasterDataController@getSubCategory')->name('getSubCategory');

    Route::post('store_regional','MasterDataController@store_regional_ware')->name('store_regional_warehouse');

    Route::get('add_regional_ware','MasterDataController@create_regional_ware')->name('add_regional');
    Route::post('store_regional_ware','MasterDataController@store_regional_ware')->name('store_regional');
    
    //product
    Route::get('zone', 'ProductController@zone')->name('zone');
    Route::post('ajaxStoreZone', 'ProductController@ajaxStoreZone')->name('ajaxStoreZone');
    
    Route::get('shelve/{zone_id}', 'ProductController@shelve')->name('shelve');
    Route::post('store_shelve', 'ProductController@storeShelve')->name('store_shelve');
    Route::post('getShelveList', 'ProductController@getShelveList')->name('getShelveList'); //get shelve list in product list page at warehouse panel
    Route::post('assign-shelve', 'ProductController@assignShelve')->name('assign-shelve'); //Assign Shelve to product
    
    Route::get('shelve_product_list/{shelve_id}', 'ProductController@shelveProductList')->name('shelve_product_list');
    
    Route::get('product_list', 'ManagerController@product_list')->name('product_list');
    Route::get('create_product/{shelve_id}', 'ManagerController@create_product')->name('create_product'); //create page from shelve list
    Route::get('create-product', 'ProductController@createProduct')->name('create-product'); // Create product page from product list
    
    Route::get('defect','ProductController@getDefectItemList')->name('defect-list');
    Route::post('store-defect','ProductController@storeDefectItem')->name('store-defect');
    
    Route::post('store_product', 'ManagerController@store_product')->name('store_product');
    Route::post('store_part', 'ManagerController@store_part')->name('store_part');
    
    Route::get('handtool','ProductController@handtoolList')->name('handtool');
    Route::get('assign','ProductController@assign')->name('assign');
    Route::post('store-handtool','ProductController@storeHandTool')->name('store-handtool');
    Route::post('assign-handtool','ProductController@assignHandTool')->name('assign-handtool');
    Route::get('return-handtool','ProductController@returnHandTool')->name('return-handtool');
    Route::post('acceptHandtool','ProductController@acceptHandtool');
    Route::post('getSiteEngineer','ProductController@getSiteEngineer');
    
    Route::get('site_delivery_order','DeliveryOrderController@site_delivery_order')->name('site_delivery_order');
    Route::post('update_do_customer_information','DeliveryOrderController@update_customer_site_do')->name('update_do_customer');
    Route::post('minus_do_list_stockqty','DeliveryOrderController@minus_do_list_eachproduct')->name('minus_do_list_stockqty');
    
    Route::get('store_deliver_order_regional/{id}','DeliveryOrderController@store_reg_site_delivery_order')->name('store_deliver_order_regional');
    Route::get('approve_delivery_order_site/{do_id}','DeliveryOrderController@approve_reg_site_delivery_order')->name('approve_do');
    Route::post('check_deliver_date','DeliveryOrderController@check_delivery_date')->name('check_deliver_date');
    Route::post('reduce_do_stock','DeliveryOrderController@reduce_do_rejectstock')->name('reduce_do_stock');
    Route::post('get_mi_date','DeliveryOrderController@get_material_issue_date');
    /*ajaxSiteInventory*/
    
    Route::post('getProjectSiteInventory','SiteInventoryController@getProjectSiteInventory')->name('getProjectSiteInventory');
    
   /* Good Receive Note */
    
    Route::get('good_receive_note_list', 'PurchaseController@goodReceiveNoteList')->name('good_receive_note_list_normal');
    
    Route::get('good_receive_note_details/{good_receive_note_id}', 'PurchaseController@goodReceiveNoteDetails')->name('good_receive_note_details');

    Route::get('good_receive_note_approve/{good_receive_note_id}', 'PurchaseController@goodReceiveNoteApprove')->name('good_receive_note_approve');
    Route::post('ajaxonapprovegrn', 'PurchaseController@ajaxgrnapprove')->name('grn_approve');

    Route::get('good_receive_note_details_regional', 'PurchaseController@goodReceiveNoteDetailsRegional')->name('good_receive_note_details_regional');
   
    Route::post('check_grn_date','PurchaseController@check_grn_date_prpo')->name('check_grn_date');
    Route::post('acceptproduct_main', 'PurchaseController@acceptproductMain')->name('acceptproduct_main');
    Route::post('acceptproduct_regional', 'PurchaseController@acceptproductRegional')->name('acceptproduct_regional');

    //reject
    Route::post('rejectproductware','PurchaseController@rejectWare')->name('rejectproductware');
    Route::post('rejectproductmain','PurchaseController@rejectMain')->name('rejectproductmain');
    // Route::post('reject_details','PurchaseController@rejectdetails')->name('reject_details');
    Route::get('reject_details_pro','PurchaseController@rejectDetailspro')->name('reject_details_pro');
    //Ajax
    Route::post('postregionalnameid', 'PurchaseController@postregionalName')->name('postregionalnameid');
    Route::post('ajaxReject_grnproduct','PurchaseController@reject_regional_eachproduct')->name('ajaxReject_grnproduct');
    Route::post('ajaxReject_grnproduct_main','PurchaseController@reject_regional_eachproduct_Main')->name('ajaxReject_grnproduct_main');
});

Route::group(['middleware' => ['UserAuth', 'ProjectManagerPermission']], function () {
    //Project
    Route::get('project_list', 'ProjectController@project_list')->name('project_list');
    Route::get('create_project', 'ProjectController@create_project')->name('create_project');
    Route::post('store_project', 'ProjectController@store_project')->name('store_project');
    
    Route::post('store_phase_now', 'ProjectController@store_phaseNow')->name('store_phase_now');

    // Route::post('store_phase', 'ProjectController@store_phaseNow')->name('store_phase');
    Route::get('check_phase_list/{project_id}', 'ProjectController@check_phase_list')->name('check_phase_list');
    Route::post('store_task', 'ProjectController@store_task')->name('store_task');

    Route::get('detail','ProjectController@index')->name('detail');
    Route::get('check_detail/{id}','ProjectController@check_detail')->name('check_detail');
    Route::get('approve/{id}','ProjectController@approveqty')->name('approve');
    
    
    //Check Report For Task from Site
    Route::get('check_task_report/{task_id}','ProjectController@check_task_report')->name('check_task_report');
    Route::get('reportTask','ManagerController@reportTask')->name('reportTask');
    Route::post('minus_report_product','ManagerController@reportProduct_minus')->name('report_product');
    
    //Equipment
    Route::get('equipment_list', 'ManagerController@equipment_list')->name('equipment_list');
    Route::get('create_equipment', 'ManagerController@create_equipment')->name('create_equipment');
    Route::post('store_equipment', 'ManagerController@store_equipment')->name('store_equipment');
    
    //Employees
    Route::get('employee_list', 'ManagerController@employee_list')->name('employee_list');
    Route::get('create_employee', 'ManagerController@create_employee')->name('create_employee');
    Route::post('store_employee', 'ManagerController@store_employee')->name('store_employee');
    Route::get('show_form_list','ManagerController@show_form_lists')->name('show_form_list');
    Route::get('create_form','ManagerController@create_form')->name('create_form');
    Route::post('store_form','ManagerController@store_form')->name('store_form');
    Route::post('update_form','ManagerController@update_form')->name('update_form');
    
    //Manager Material Request
    Route::get('material_request_list', 'MaterialRequestController@material_request_list')->name('material_request_list');
    
    Route::post('send_material_request/{material_request_id}', 'MaterialRequestController@send_material_request')->name('send_material_request');
    
    //Manager Site Purchase Order
    Route::get('purchase_order', 'PurchaseOrderController@purchase_order')->name('purchase_order');
    Route::get('sales_order/{purchase_order_id}', 'PurchaseOrderController@sales_order')->name('sales_order');
    Route::get('sales_order_manual', 'PurchaseOrderController@sales_order_manual')->name('sales_order_manual');
    Route::post('/ajaxPhase', 'PurchaseOrderController@ajaxPhase')->name('ajaxPhase');
    Route::post('/ajaxDeliveryDate', 'PurchaseOrderController@ajaxDeliveryDate')->name('ajaxDeliveryDate');
    Route::post('/ajaxAddSaleOrder', 'PurchaseOrderController@ajaxAddSaleOrder')->name('ajaxAddSaleOrder');
    Route::post('ajax_getcategory_products','PurchaseOrderController@ajaxGetcateproducts')->name('ajax_getcategory_products');
    Route::post('ajaxPurchaseOrder_detail','PurchaseOrderController@ajaxPurchaseOrder_detail')->name('ajaxPurchaseOrder_detail');
    //Manager => Warehouse Purchase Order
    Route::get('warehouse_purchase_order','PurchaseOrderController@warehouse_purchase_order')->name('warehouse_purchase_order');
    Route::post('approveOfficerOrder','PurchaseOrderController@approveOfficerOrder');
    
    
    //Manager => Siteinventory
    Route::get('pm_site_inventory','SiteInventoryController@pm_site_inventory')->name('pm_site_inventory');
    
    Route::post('getPhaseSiteInventory','SiteInventoryController@getPhaseSiteInventory')->name('getPhaseSiteInventory');
    
    //Sales Order
    
    Route::post('ajaxSalesOrder','PurchaseOrderController@ajaxSalesOrder')->name('ajaxSalesOrder');
    
    //Customer Purchase Order
    Route::get('purchase_order', 'PurchaseOrderController@purchase_order')->name('purchase_order');
    
    Route::get('check_warehouse_transfer','ManagerController@CheckWarehouseTransfer')->name('CheckWarehouseTransfer');
    Route::post('ApproveWarehouseTransfer','ManagerController@ApproveWarehouseTransfer')->name('ApproveWarehouseTransfer');
    Route::post('ApproveDeliveryOrder','ManagerController@ApproveDeliveryOrder')->name('ApproveDeliveryOrder');


    //Excel
    Route::post('export', 'DemoController@export')->name('export');
    /*Good Receive Note */
});
//Warehoouse Start

// Route::group(['middleware' => ['UserAuth', 'WarehouseSupervisorPermission']], function () {
    
    Route::post('/ajaxPhase', 'PurchaseOrderController@ajaxPhase')->name('ajaxPhase');
    
    Route::get('RegionalWarehouse','MasterDataController@RegionalWarehouse')->name('RegionalWarehouse');
    
    Route::post('store-regional','RegionalWarehouseController@storeRegional')->name('store-regional');
    
    Route::get('regional_inventory/{regional_id}','RegionalWarehouseController@regionalInventory')->name('regional_inventory');
    
    Route::get('reject_list', 'PurchaseController@rejectList')->name('reject_list');
    //Warehouse => Material Request
    Route::get('warehouse_material_request','MaterialRequestController@warehouse_material_request')->name('warehouse_material_request');
    
    //warehouse => Sale Order
    
    Route::get('warehouse_sale_orders','PurchaseOrderController@warehouse_sale_orders')->name('warehouse_sale_orders');
    Route::post('ajaxSendMaterialIssue','PurchaseOrderController@ajaxSendMaterialIssue')->name('ajaxSendMaterialIssue');
    Route::get('warehouse_po_create/{sales_order_id}','PurchaseOrderController@warehouse_po_create')->name('warehouse_po_create');
    Route::get('warehouse_pr_create/{material_request_id}','PurchaseOrderController@warehouse_pr_create')->name('warehouse_pr_create');
    Route::post('ajaxEachStockCheck','PurchaseOrderController@each_stockCheck_ajax');

    Route::get('material_issue_list_show','PurchaseOrderController@show_material_issue_list')->name('material_issue_list_show');
    
    //WarehouseTransferOrder
    //Create Wtransfer No ajax
    Route::post('generate_wto_no','WarehouseTransferOrderController@createwtono');
    Route::post('storewtorder','WarehouseTransferOrderController@storewaretranorder')->name('storewtorder');
    Route::get('waretransfer_list','WarehouseTransferOrderController@show_wto_list')->name('waretransfer_list');
    Route::get('waretransfer_list_reg','WarehouseTransferOrderController@show_wto_list_reg')->name('waretransfer_list_reg');
    Route::post('ajaxEachStockCheckSale','PurchaseOrderController@each_stockCheck_sale_ajax')->name('ajaxEachStockCheckSale');
    
    //warehouse => Material Issue
    Route::get('material_issue','Warehouse\MaterialIssueController@material_issue')->name('material_issue');
    
    Route::get('sendWarehouseTransfer/{material_issue_id}','Warehouse\MaterialIssueController@sendWarehouseTransfer')->name('sendWarehouseTransfer');
    Route::post('storeWarehouseTransfer','Warehouse\MaterialIssueController@storeWarehouseTransfer')->name('storeWarehouseTransfer');
    Route::get('AcceptWarehouseTransfer/{material_issue_id}','RegionalWarehouseController@AcceptWarehouseTransfer')->name('AcceptWarehouseTransfer');
    Route::post('maishowproj','Warehouse\MaterialIssueController@showproject')->name('maishowproj');
    Route::post('material_item_list','Warehouse\MaterialIssueController@getitem_list')->name('material_item_list');
    Route::post('check_waretransfer_date','Warehouse\MaterialIssueController@check_order_date')->name('check_waretransfer_date');
    Route::post('get_supported_reg_projects','Warehouse\MaterialIssueController@getprojects_regional')->name('get_supported_reg_projects');
    
    
    //Warehouse -> Purchase Order 
    
    Route::post('ajaxSendWarehousePO','PurchaseOrderController@ajaxSendWarehousePO')->name('ajaxSendWarehousePO');
    Route::post('ajaxSendWarehousePR','PurchaseOrderController@ajaxSendWarehousePR')->name('ajaxSendWarehousePR');
    
    Route::get('purchase_request_list','PurchaseRequestController@purchase_request_list')->name('purchase_request_list');
    Route::get('warehouse_purchase_request','PurchaseRequestController@warehousePurchaseRequest')->name('warehouse_purchase_request');
    
    Route::post('ajaxAcceptedWarehouseRequest','PurchaseRequestController@ajaxAcceptedWarehouseRequest')->name('ajaxAcceptedWarehouseRequest');

// });
//Sale Console
// Route::group(['middleware' => ['UserAuth', 'SalePermission']], function () {
    Route::get('customer','CustomerController@customer')->name('customer');
    Route::post('store-customer','CustomerController@storeCustomer')->name('store-customer');
    
    Route::get('document','CustomerController@document')->name('document');
    Route::post('/ajaxPhase', 'PurchaseOrderController@ajaxPhase')->name('ajaxPhase');
    Route::post('/store-document', 'CustomerController@storeDocument')->name('store-document');
    
    Route::get('sale_purchase_order_list','PurchaseOrderController@sale_purchase_order_list')->name('sale_purchase_order_list');
    
    Route::get('sale_purchase_order','PurchaseOrderController@sale_purchase_order')->name('sale_purchase_order');
    
    Route::post('ajaxSalePurchaseOrder','PurchaseOrderController@ajaxSalePurchaseOrder')->name('ajaxSalePurchaseOrder');
// });

Route::group(['middleware' => ['UserAuth', 'ProcurementPermission']], function () {
    //Procurement Officer
    Route::get('procurement_purchase_request_list','PurchaseRequestController@procurement_purchase_request_list')->name('procurement_purchase_request_list');
    Route::get('procurement_purchase_order_list','PurchaseRequestController@procurementPurchaseOrderList')->name('procurement_purchase_order_list');
    Route::post('createNewPO','PurchaseRequestController@createNewPO');
    Route::post('SendMailSupplier','PurchaseRequestController@SendMailSupplier')->name('SendMailSupplier');
    Route::post('getsupplieremail','PurchaseRequestController@getsupemail')->name('getsemail');
    Route::post('getSupplierProduct','PurchaseRequestController@getSupplierProduct')->name('getSupplierProduct');
    
    Route::post('SendOfficerPurchaseOrder','PurchaseRequestController@SendOfficerPurchaseOrder')->name('SendOfficerPurchaseOrder');
    Route::post('SaveAllOrder','PurchaseRequestController@SaveAllOrder')->name('SaveAllOrder');
    
    // Route::get('GoodReceiveNoteForm', 'PurchaseController@goodReceiveForm')->name('good_receive_form');

    Route::get('reject_list', 'PurchaseController@rejectList')->name('reject_list');
    
    Route::post('StoreGoodReceiveNote', 'PurchaseController@storeGoodReceiveNote')->name('store_good_receive_note');
    Route::get('grn_list','PurchaseController@show_grn_lists')->name('good_receive_note_list');
    
    Route::get('supplier_list','SupplierController@supplier_list')->name('supplier_list');
    Route::post('ajaxSupplier','SupplierController@ajaxSupplier')->name('ajaxSupplier');
    Route::post('updateitem_destination','PurchaseController@update_each_item_des')->name('updateitem_destination');
});
Route::group(['middleware' => ['UserAuth', 'RegionalWarehousePermission']], function () {
    //Regional Warehouse
    
    Route::get('WarehouseTransferOrder','RegionalWarehouseController@WarehouseTransferOrder')->name('WarehouseTransferOrder');
     Route::get('AcceptWarehouseTransfer/{material_issue_id}','RegionalWarehouseController@AcceptWarehouseTransfer')->name('AcceptWarehouseTransfer');
     Route::get('send_delivery_order/{material_issue_id}','Warehouse\MaterialIssueController@send_delivery_order')->name('send_delivery_order');
    Route::post('store_delivery_order','Warehouse\MaterialIssueController@store_delivery_order')->name('store_delivery_order');
    
    Route::get('regional_inventories','RegionalWarehouseController@regionalInventories')->name('regional_inventories');
});

Route::get('report_list','ManagerController@report_list')->name('report_list');

Route::post('store_reported_task','ManagerController@store_reported_task')->name('store_reported_task');


Route::get('good_receive_note_list', 'PurchaseController@goodReceiveNoteList')->name('good_receive_note_list_normal');
Route::get('grn_list','PurchaseController@show_grn_lists')->name('good_receive_note_list');
Route::get('GoodReceiveNoteForm', 'PurchaseController@goodReceiveForm')->name('good_receive_form');
Route::get('grn_list_supervisor', 'PurchaseController@grn_supervisor_list')->name('grn_list_supervisor');
Route::get('masterpage','PurchaseController@get_master_page')->name('masterpage');
Route::get('reject_list', 'PurchaseController@rejectList')->name('reject_list');
Route::post('approve_reject_item_reg', 'PurchaseController@approve_reject_itemfromreg')->name('approve_reject_item_reg');
Route::post('ajaxAccept_grnproduct_reg', 'PurchaseController@accept_grnproduct_reg')->name('ajaxAccept_grnproduct_reg');
Route::post('ajaxAccept_grnproduct_main', 'PurchaseController@accept_grnproduct_main')->name('ajaxAccept_grnproduct_main');
Route::post('delete_grnproduct_reg', 'PurchaseController@delete_grnproduct_reg')->name('delete_grnproduct_reg');
Route::get('delete_grnproduct_reg/{grn_pivotpro_id}', 'PurchaseController@delete_grnproduct_reg')->name('delete_grnproduct_reg');

Route::get('delete_grnproduct_main/{grn_pivotpro_id}', 'PurchaseController@delete_grnproduct_main')->name('delete_grnproduct_main');
Route::post('updateitem_destination','PurchaseController@update_each_item_des')->name('updateitem_destination');
Route::get('accept_wto_regional/{wto_id}','WarehouseTransferOrderController@accept_wto_regional')->name('accept_wto_regional');
Route::post('StoreGoodReceiveNote', 'PurchaseController@storeGoodReceiveNote')->name('store_good_receive_note');

