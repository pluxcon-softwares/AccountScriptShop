<?php

use App\Models\Rule;
use App\Models\SubCategory;
use App\Models\MessageBoard;
use Illuminate\Support\Facades\Route;

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

//Webhook Route
Route::webhooks('webhook-receiving-url');

// RouteGroup for the Admin
Route::group(['prefix' => 'admin'], function (){
    Route::get('', 'Auth\AdminAuthController@index');
    Route::get('/login', 'Auth\AdminAuthController@login')->name('admin.login');
    Route::post('/login', 'Auth\AdminAuthController@authenticate')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminAuthController@logout')->name('admin.logout');

    Route::group(['namespace' => 'Admin', 'middleware'=>['checkifadmin']], function(){

        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

        //Ticket Routes
        Route::get('tickets', 'TicketController@index')->name('admin.tickets');
        Route::get('ticket/all', 'TicketController@fetchAllTickets');
        Route::get('ticket/{id}', 'TicketController@fetchTicketByID');
        Route::get('ticket/delete/{id}', 'TicketController@deleteTicket');
        Route::post('ticket/store/reply', 'TicketController@storeReply');

        //Admins Accounts
        Route::get('admin/accounts/index', 'AdminController@index')->name('admin.admin-account');
        Route::get('admin/account/edit/{admin_id}', 'AdminController@editAdminAccount');
        Route::post('admin/account/update/{admin_id}', 'AdminController@updateAdminAccount');
        Route::get('admin/account/delete/{admin_id}', 'AdminController@deleteAdminAccount');
        Route::get('admin/accounts/all', 'AdminController@getAdminAccounts');
        Route::post('admin/account/create', 'AdminController@createAdminAccount');

        //User Accounts
        Route::get('user/accounts/index', 'UserController@index')->name('admin.user-account');
        Route::get('user/account/edit/{user_id}', 'UserController@editUserAccount');
        Route::post('user/account/update/{user_id}', 'UserController@updateUserAccount');
        Route::get('user/account/delete/{user_id}', 'UserController@deleteUserAccount');
        Route::get('user/accounts/all', 'UserController@getUserAccounts');
        Route::post('user/account/create', 'UserController@createUserAccount');

        // Orders Routes
        Route::get('orders/index', 'OrderController@index')->name('admin.orders');
        Route::get('order/all', 'OrderController@getAllOrders');
        Route::get('order/profit', 'OrderController@getOrderProfit');

        // Messages Routes
        Route::get('message/home', 'MessageBoardController@index')->name('admin.message-board');
        Route::get('messages', 'MessageBoardController@allMessages');
        Route::post('message/create', 'MessageBoardController@createMessage');
        Route::get('message/view/{id}', 'MessageBoardController@viewMessage');
        Route::get('message/edit/{id}', 'MessageBoardController@editMessage');
        Route::post('message/update', 'MessageBoardController@updateMessage');
        Route::get('message/delete/{id}', 'MessageBoardController@deleteMessage');

        // Messages Routes
        Route::get('rules', 'RuleController@index')->name('admin.rules');
        Route::get('rule/all', 'RuleController@getRules');
        Route::post('rule/create', 'RuleController@createRule');
        Route::get('rule/view/{id}', 'RuleController@viewRule');
        Route::get('rule/edit/{id}', 'RuleController@editRule');
        Route::post('rule/update/{id}', 'RuleController@updateRule');
        Route::get('rule/delete/{id}', 'RuleController@deleteRule');

        //Product Sub Category route
        Route::get('subcategory/home', 'CategoryController@index')->name('admin.subcategories');
        Route::get('sub-categories', 'CategoryController@subCategories');
        Route::get('sub-categories/{id}', 'CategoryController@subCategoriesByID');
        Route::get('sub-category/edit/{id}', 'CategoryController@editSubCategory');
        Route::post('sub-category/update/{id}', 'CategoryController@updateSubCategory');
        Route::get('sub-category/delete/{id}', 'CategoryController@deleteSubCategory');
        Route::post('sub-category/add', 'CategoryController@addSubCategory');

        //Product Category route
        Route::get('categories', 'CategoryController@categories')->name('admin.categories');
        Route::get('category/edit/{id}', 'CategoryController@editCategory');
        Route::post('category/update/{id}', 'CategoryController@updateCategory');
        Route::get('category/delete/{id}', 'CategoryController@deleteCategory');
        Route::post('category/add', 'CategoryController@storeCategory');

        //Main Category, SubCategories, Products
        Route::get('products', 'ProductController@index')->name('admin.products');
        Route::get('product/all', 'ProductController@allProducts');
        Route::post('product/store', 'ProductController@storeProduct');
        Route::match(['get', 'post'], 'product/edit-update/{id?}', 'ProductController@editUpdateProduct');
        Route::post('product/delete', 'ProductController@deleteProduct');
        Route::get('product/view/{id}', 'ProductController@viewProduct');

        //Purchases
        Route::get('purchase/index', 'PurchaseController@index')->name('admin.purchases');
        Route::get('purchases', 'PurchaseController@allPurchases');
        Route::get('purchase/delete/{id}', 'PurchaseController@deletePurchase');

        //Settings Routes
        Route::get('settings', 'SettingsController@settings')->name('admin.settings');
        Route::post('setting/upload/site/logo', 'SettingsController@uploadSiteLogo');
        Route::post('setting/change/sitename', 'SettingsController@changeSitename');
        Route::post('setting/change/background-image', 'SettingsController@changeSiteBackgroundImage');
    });
});


//User Authentication and User Registration Route
Route::get('/', 'Auth\UserAuthController@index');
Route::get('/login', 'Auth\UserAuthController@login')->name('login');
Route::post('/login', 'Auth\UserAuthController@authenticate')->name('authenticate');
Route::get('/register', 'Auth\UserAuthController@create')->name('create');
Route::post('/register', 'Auth\UserAuthController@store')->name('store');
Route::get('/logout', 'Auth\UserAuthController@logout')->name('logout');

//User Home (Dashboard)
Route::get('/home', 'User\HomeController@index')->name('home');
Route::get('/home/profile', 'User\UserController@profile')->name('profile');
Route::post('/home/profile/change-password', 'User\UserController@changePassword')->name('change.password');

//Fetch all products by CategoryID(section)
Route::get('home/products/{category_id}', 'User\ProductController@productsByCategory')->name('user.products.by.category');

// Products
Route::get('products/{id}', 'User\ProductController@products')->name('products');
Route::get('products/subcategory/{id}', 'User\ProductController@productsBySubCategory');

// Credit Cards Routes
Route::get('/cards', 'User\CardController@index')->name('cards');

// Ticket and Ticket Reply Routes
Route::get('/tickets', 'User\TicketController@index')->name('tickets');
Route::post('/ticket/open-ticket', 'User\TicketController@openTicket')->name('open.ticket');
Route::get('/ticket/view-ticket-reply/{ticket_id}', 'User\TicketController@viewTicketReply');
Route::get('/ticket/delete-ticket/{ticket_id}', 'User\TicketController@deleteTicket');

//Rules Route
Route::get('/rules', function(){
    $rules = Rule::all();
    $title = 'Read Rules';
    return view('user.rules')->with(['title' => $title, 'rules' => $rules]);
})->name('rules');


//Wallet and Payment Processing Routes
Route::get('/add-money', 'Payment\WalletController@addMoney')->name('add.money');
Route::post('/deposit', 'Payment\WalletController@deposit')->name('deposit');
Route::get('/deposit/complete', 'Payment\WalletController@depositComplete')->name('deposit.complete');
Route::get('/deposit/canceled', 'Payment\WalletController@depositCancel')->name('deposit.cancel');

//Cart Functionality Routes
Route::get('cart-page', 'Payment\WalletController@cartPage')->name('cart');
Route::get('cart/check-cart', 'Payment\WalletController@checkCart');
Route::get('cart/process-order', 'Payment\WalletController@processOrder')->name('process.order');
Route::get('cart/thank-you', 'Payment\WalletController@thankYou')->name('thank.you');
Route::get('cart/{id}', 'Payment\WalletController@cart');
Route::get('cart/count/items', 'Payment\WalletController@countCartItems');
Route::get('cart/delete-cart-item/{id}', 'Payment\WalletController@deleteCartItem');

//Purchases Functionality Routes
Route::get('purchases', 'User\PurchaseController@index')->name('purchases');
Route::get('purchase/all', 'User\PurchaseController@getPurchasesByUser');
Route::get('purchase/view/{id}', 'User\PurchaseController@getPurchaseDetailsByUser');
Route::get('purchase/delete/{id}', 'User\PurchaseController@deletePurchaseByUser');

//MessageBoard Route
Route::get('messages', function(){
    $messages = MessageBoard::where('is_published', 1)->get();
    return response()->json(['data' => $messages]);
});
Route::get('message/{id}', function($id){
    $message = MessageBoard::find($id);
    return response()->json(['message' => $message]);
});
