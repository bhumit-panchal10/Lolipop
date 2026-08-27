<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourierController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OtherPagesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ShoowroomController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SmsTestController;

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

// Route::fallback(function () {
//     return view('errors.404'); // Make sure the view path matches your custom 404 page
// });

Route::get('/login', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

// Route::get('/mail-debug', function () {
//     return config('mail.mailers.smtp');
// });

Route::get('/test-sms', [SmsTestController::class, 'send']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return 'Cache is cleared';
});

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});

//Category Master
Route::prefix('admin')->name('category.')->middleware('auth')->group(function () {
    Route::get('/category/index', [CategoryController::class, 'index'])->name('index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/category/edit/{id?}', [CategoryController::class, 'editview'])->name('edit');
    Route::post('/category/update/{id?}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/category/delete', [CategoryController::class, 'delete'])->name('delete');

    Route::get('/category/chk/unique/{id?}', [CategoryController::class, 'chk_unique'])->name('chk_unique');
    Route::get('/category/chkunique/edit/{id?}', [CategoryController::class, 'editchk_unique'])->name('editchk_unique');

    Route::get('/category/update/status/{category_id}/{status}', [CategoryController::class, 'updateStatus'])->name('status');
});

//Sub Category Master
Route::prefix('admin')->name('subcategory.')->middleware('auth')->group(function () {
    Route::get('/subcategory/index', [SubCategoryController::class, 'index'])->name('index');
    Route::post('/subcategory/store', [SubCategoryController::class, 'create'])->name('store');
    Route::get('/subcategory/edit/{id?}', [SubCategoryController::class, 'editview'])->name('edit');
    Route::post('/subcategory/update', [SubCategoryController::class, 'update'])->name('update');
    Route::delete('/subcategory/delete', [SubCategoryController::class, 'delete'])->name('delete');
});

//Product Master
Route::prefix('admin')->name('product.')->middleware('auth')->group(function () {
    Route::any('/product/index', [ProductController::class, 'index'])->name('index');
    Route::get('/product/create', [ProductController::class, 'createview'])->name('create');
    Route::post('/product/store', [ProductController::class, 'create'])->name('store');
    Route::get('/product/edit/{id?}', [ProductController::class, 'editview'])->name('edit');
    Route::post('/product/update/{id?}', [ProductController::class, 'update'])->name('update');
    Route::delete('/product/delete', [ProductController::class, 'delete'])->name('delete');

    Route::get('/product/getsubcategory', [ProductController::class, 'getsubcategory'])->name('getsubcategory');
    Route::get('/product/getGST', [ProductController::class, 'getGST'])->name('getGST');
    Route::get('/product/geteditsubcategory', [ProductController::class, 'getEditsubcategory'])->name('getEditsubcategory');
    Route::POST('/product/GetSelectedSubCategory/{Category?}/{SubCategory?}', [ProductController::class, 'GetSelectedSubCategory'])->name('GetSelectedSubCategory');
    Route::post('productimage-delete/{id}', [ProductController::class, 'productimage'])->name('imagedelete');

    Route::get('/product/photos/{id?}', [ProductController::class, 'productphotos'])->name('productphotos');
    Route::delete('/product/photos/delete/{id?}', [ProductController::class, 'productphotosdelete'])->name('productphotosdelete');

    Route::get('/product/attribute/index/{id?}', [ProductController::class, 'product_attribute'])->name('product_attribute');
    Route::post('/product/attribute', [ProductController::class, 'product_attribute_store'])->name('product_attribute_store');
    Route::get('/product/attribute/edit/{id?}', [ProductController::class, 'product_attribute_editview'])->name('product_attribute_editview');
    Route::post('/product/attribute/update', [ProductController::class, 'product_attribute_update'])->name('product_attribute_update');
    Route::delete('/product/attribute/delete', [ProductController::class, 'product_attribute_delete'])->name('product_attribute_delete');

    //Inward
    Route::get('/product/inward/index/{id?}', [ProductController::class, 'product_inward'])->name('product_inward');
    Route::post('/product/inward', [ProductController::class, 'product_inward_store'])->name('product_inward_store');
    Route::delete('/product/inward/delete', [ProductController::class, 'product_inward_delete'])->name('product_inward_delete');

    Route::get('/product/update/status/{product_id}/{status}', [ProductController::class, 'updateStatus'])->name('status');

    Route::get('/product/Inward/data/{id?}', [ProductController::class, 'inwardData'])->name('inwardData');
});

//Offer Master
Route::prefix('admin')->name('offer.')->middleware('auth')->group(function () {
    Route::get('/offer/index', [OfferController::class, 'index'])->name('index');
    Route::post('/offer/store', [OfferController::class, 'create'])->name('store');
    Route::get('/offer/edit/{id?}', [OfferController::class, 'editview'])->name('edit');
    Route::post('/offer/update', [OfferController::class, 'update'])->name('update');
    Route::delete('/offer/delete', [OfferController::class, 'delete'])->name('delete');
});

//Courier Master
Route::prefix('admin')->name('courier.')->middleware('auth')->group(function () {
    Route::get('/courier/index', [CourierController::class, 'index'])->name('index');
    Route::post('/courier/store', [CourierController::class, 'create'])->name('store');
    Route::get('/courier/edit/{id?}', [CourierController::class, 'editview'])->name('edit');
    Route::post('/courier/update', [CourierController::class, 'update'])->name('update');
    Route::delete('/courier/delete', [CourierController::class, 'delete'])->name('delete');

    Route::get('courier/validate', [CourierController::class, 'validatename'])->name('validatename');
    Route::get('courier/Edit/validate', [CourierController::class, 'validateeditname'])->name('validateeditname');
});

//Faq Master
Route::prefix('admin')->name('faq.')->middleware('auth')->group(function () {
    Route::get('/faq/index', [FaqController::class, 'index'])->name('index');
    Route::post('/faq/store', [FaqController::class, 'create'])->name('store');
    Route::get('/faq/edit/{id?}', [FaqController::class, 'editview'])->name('edit');
    Route::post('/faq/update', [FaqController::class, 'update'])->name('update');
    Route::delete('/faq/delete', [FaqController::class, 'delete'])->name('delete');
});

//Testimonial Master
Route::prefix('admin')->name('testimonial.')->middleware('auth')->group(function () {
    Route::get('/testimonial/index', [TestimonialController::class, 'index'])->name('index');
    Route::post('/testimonial/store', [TestimonialController::class, 'create'])->name('store');
    Route::get('/testimonial/edit/{id?}', [TestimonialController::class, 'editview'])->name('edit');
    Route::post('/testimonial/update', [TestimonialController::class, 'update'])->name('update');
    Route::delete('/testimonial/delete', [TestimonialController::class, 'delete'])->name('delete');
});

//Shipping Master
Route::prefix('admin')->name('shipping.')->middleware('auth')->group(function () {
    Route::get('/shipping/index', [ShippingController::class, 'index'])->name('index');
    Route::get('/shipping/edit/{id?}', [ShippingController::class, 'editview'])->name('edit');
    Route::post('/shipping/update', [ShippingController::class, 'update'])->name('update');
});

//inquiry
Route::prefix('admin')->name('Inquiry.')->middleware('auth')->group(function () {
    Route::get('Inquiry/index', [InquiryController::class, 'index'])->name('index');
    Route::delete('/Inquiry-delete', [InquiryController::class, 'delete'])->name('delete');
    Route::get('Inquiry/view/detail/{id?}', [InquiryController::class, 'viewdetail'])->name('viewdetail');
});

Route::prefix('admin')->name('metaData.')->middleware('auth')->group(function () {
    Route::get('/seo/index', [MetaDataController::class, 'index'])->name('index');
    Route::get('seo/{id}/edit', [MetaDataController::class, 'edit'])->name('edit');
    Route::put('seo/{id}', [MetaDataController::class, 'update'])->name('update');
});

//Reports
Route::prefix('admin')->name('report.')->middleware('auth')->group(function () {
    Route::any('/Payment/Report', [ReportController::class, 'paymentReport'])->name('paymentReport');
    Route::any('Order/Tracking/', [ReportController::class, 'orderTracking'])->name('orderTracking');

    Route::any('Search/Customer/', [ReportController::class, 'searchCustomer'])->name('searchCustomer');

    Route::any('send/confirmation/message/{id?}', [ReportController::class, 'send_confirmation_message'])->name('send_confirmation_message');
    Route::any('send/whatsapp/tracking/link/{id?}', [ReportController::class, 'send_whatsapp_tracking_link'])->name('send_whatsapp_tracking_link');

    Route::any('order/collection/', [ReportController::class, 'order_collection'])->name('order_collection');

    Route::any('total/sales', [ReportController::class, 'total_sales'])->name('total_sales');
});

//Order Master
Route::prefix('admin')->name('order.')->middleware('auth')->group(function () {
    Route::any('/order/pending', [OrderController::class, 'pending'])->name('pending');
    Route::any('/user/order/pending', [OrderController::class, 'userpending'])->name('userpending');
    Route::any('/order/dispatched', [OrderController::class, 'dispatched'])->name('dispatched');
    Route::any('/order/cancel', [OrderController::class, 'cancel'])->name('cancel');

    Route::get('/order/to/cancel/{id?}', [OrderController::class, 'statustocancel'])->name('statustocancel');
    Route::post('/order/to/dispatch/{id?}', [OrderController::class, 'statustodispatched'])->name('statustodispatched');
    Route::get('/order/to/pending/{id?}', [OrderController::class, 'statustopending'])->name('statustopending');

    Route::get('/order/detail/{id?}', [OrderController::class, 'orderdetail'])->name('orderdetail');

    Route::get('/order/pdf/{id?}', [OrderController::class, 'DetailPDF'])->name('DetailPDF');

    Route::get('/order/dispatch/pdf/{id?}', [OrderController::class, 'DispatchPDF'])->name('DispatchPDF');

    Route::get('/order/generatedelivery/{id?}', [OrderController::class, 'generatedelivery'])->name('generatedelivery');

    Route::get('/Tirupati/{id?}', [OrderController::class, 'tirupati'])->name('tirupati');

    Route::get('/Delivery/{id?}', [OrderController::class, 'delivery'])->name('delivery');

    Route::any('/order/moved/to/courier', [OrderController::class, 'orderMovedToCourier'])->name('orderMovedToCourier');

    Route::any('/payment/pending/order', [OrderController::class, 'pendingOrder'])->name('pendingOrder');

    //move to order -9-12
    Route::get('/order/move-to-order/{id}', [OrderController::class, 'moveToOrder'])
        ->name('ordermovetorder');

    //edit shipping mobile
    Route::post('/admin/order/update-shipping-mobile', [OrderController::class, 'updateShippingMobile'])->name('order.updateShippingMobile');

    Route::get('/success/order', [OrderController::class, 'successOrder'])->name('successOrder');

    Route::get('/link/send/customer/{id?}', [OrderController::class, 'linkSendToCustomer'])->name('linkSendToCustomer');

    Route::post('/dispatch/through/payment/pending/order/{id?}', [OrderController::class, 'dispatchThroughPaymentPendingOrder'])->name('dispatchThroughPaymentPendingOrder');
});

//Product Deatil Master
Route::prefix('admin')->name('productdetail.')->middleware('auth')->group(function () {
    Route::get('/productdetail/index/{id?}', [ProductDetailController::class, 'index'])->name('index');
    Route::post('/productdetail/store', [ProductDetailController::class, 'create'])->name('store');
    Route::delete('/productdetail/delete', [ProductDetailController::class, 'delete'])->name('delete');
    Route::DELETE('/productdetail/deleteselected', [ProductDetailController::class, 'deleteselected'])->name('deleteselected');
});

//Attribute
Route::prefix('admin')->name('attribute.')->middleware('auth')->group(function () {
    Route::get('/attribute/index', [AttributeController::class, 'index'])->name('index');
    Route::post('/attribute/store', [AttributeController::class, 'create'])->name('store');
    Route::get('/attribute/edit/{id?}', [AttributeController::class, 'editview'])->name('edit');
    Route::post('/attribute/update', [AttributeController::class, 'update'])->name('update');
    Route::delete('/attribute/delete', [AttributeController::class, 'delete'])->name('delete');
});

//Setting
Route::prefix('admin')->name('setting.')->middleware('auth')->group(function () {
    Route::get('/setting/index', [SettingController::class, 'index'])->name('index');
    Route::post('/setting/store', [SettingController::class, 'create'])->name('store');
    Route::get('/setting/edit/{id?}', [SettingController::class, 'editview'])->name('edit');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('update');
    Route::delete('/setting/delete', [SettingController::class, 'delete'])->name('delete');
});

//Banner
Route::prefix('admin')->name('banner.')->middleware('auth')->group(function () {
    Route::get('/banner/index', [BannerController::class, 'index'])->name('index');
    Route::post('/banner/store', [BannerController::class, 'store'])->name('store');
    Route::delete('/banner/delete', [BannerController::class, 'delete'])->name('delete');
});

//Tearm & Condition
Route::prefix('admin')->name('otherpages.')->middleware('auth')->group(function () {
    Route::get('/otherpages/index', [OtherPagesController::class, 'index'])->name('index');
    Route::post('/otherpages/store', [OtherPagesController::class, 'create'])->name('store');
    Route::get('/otherpages/edit/{id?}', [OtherPagesController::class, 'editview'])->name('edit');
    Route::post('/otherpages/update', [OtherPagesController::class, 'update'])->name('update');
    Route::delete('/otherpages/delete', [OtherPagesController::class, 'delete'])->name('delete');
    Route::get('/otherpages/view/detail/{id?}', [OtherPagesController::class, 'viewdetail'])->name('viewdetail');
});

//Stock
Route::prefix('admin')->name('stock.')->middleware('auth')->group(function () {
    Route::get('/stock/index', [StockController::class, 'index'])->name('index');
});

//==============================================Front Start====================================================

//Route::any('/Home', [FrontController::class, 'index'])->name('FrontIndex');
Route::any('/', [FrontController::class, 'index'])->name('FrontIndex');
//Route::any('/', [FrontController::class, 'products'])->name('FrontProduct');
Route::get('/about-us', [FrontController::class, 'about'])->name('Frontaboutus');
Route::get('/track-order', [FrontController::class, 'trackorder'])->name('Fronttrackorder');

Route::get('/category/{id?}', [FrontController::class, 'FrontCategory'])->name('FrontCategory');

Route::get('/contact-us', [FrontController::class, 'contactus'])->name('FrontContactUs');
Route::post('/submit/contact_us', [FrontController::class, 'contact_us'])->name('contact_us');

//product
Route::any('/product/get/price', [FrontController::class, 'bindpriceonsize'])->name('product.bindpriceonsize');
Route::any('/products/{id?}', [FrontController::class, 'products'])->name('FrontProduct');
Route::get('/product/detail/{category?}/{id?}', [FrontController::class, 'productdetail'])->name('productdetail');
Route::get('/product/popup/{id?}', [FrontController::class, 'productpopupview'])->name('productpopupview');
//Features
Route::get('Features', [FrontController::class, 'isfeatures'])->name('IsFeatures');

Route::get('refresh_captcha', [FrontController::class, 'refreshCaptcha'])->name('refresh_captcha');

Route::get('/loadMoreProducts', [FrontController::class, 'loadMoreProducts'])->name('loadMoreProducts');
Route::get('/loadMoreCategoryProducts', [FrontController::class, 'loadMoreCategoryProducts'])->name('loadMoreCategoryProducts');

Route::get('/loadMoreSearchData', [FrontController::class, 'loadMoreSearchData'])->name('loadMoreSearchData');


//===================================Cart routes start============================
Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

Route::post('/coupon', [FrontController::class, 'couponcodeapply'])->name('couponcodeapply');
//===================================Cart routes end============================

//===============================Check-Out start=============================
Route::get('Check-Out', [FrontController::class, 'checkout'])->name('checkout');
Route::post('checkout/store', [FrontController::class, 'checkoutstore'])->name('checkoutstore');
//===============================Check-Out end=============================

//login
Route::get('/track/order', [FrontController::class, 'frontlogin'])->name('FrontLogin');
Route::post('Front/Login/Store', [FrontController::class, 'frontloginstore'])->name('FrontLoginStore');

//OTP
Route::get('otp/{guid?}', [FrontController::class, 'otp'])->name('FrontOtp');
Route::any('otp/submit', [FrontController::class, 'otpsubmit'])->name('FrontOtpSubmit');


//register
Route::get('Register', [FrontController::class, 'register'])->name('FrontRegister');
Route::post('Register/Store', [FrontController::class, 'registerstore'])->name('registerstore');
//Log-Out
Route::get('Front/LogOut', [FrontController::class, 'Frontlogout'])->name('Frontlogout');

//Forgot-Password Page
Route::get('Forgot-Password', [FrontController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('forgotpassword', [FrontController::class, 'forgotpasswordsubmit'])->name('forgotpasswordsubmit');

//New-Password Page
Route::get('New-Password/{token?}', [FrontController::class, 'newpassword'])->name('newpassword');
Route::post('New-Password', [FrontController::class, 'newpasswordsubmit'])->name('newpasswordsubmit');


Route::get('Profile', [FrontController::class, 'profile'])->name('FrontProfile');


//==========================after login tab view start=============================
//personal information
Route::get('My-Account', [FrontController::class, 'myaccount'])->name('myaccount');
Route::post('My-Account', [FrontController::class, 'myaccountedit'])->name('myaccountedit');
//change password
Route::get('Change-Password', [FrontController::class, 'changepassword'])->name('changepassword');
Route::post('Change-Password', [FrontController::class, 'changepasswordsubmit'])->name('changepasswordsubmit');
//my orders
Route::any('My-Order', [FrontController::class, 'myorders'])->name('myorders');
//my orders detail
Route::get('My-Order/detail/{id}', [FrontController::class, 'myordersdetails'])->name('myordersdetails');

//customer order
Route::get('Order/{ORDER_ID?}/{guid?}', [FrontController::class, 'customerorder'])->name('customerorder');

//My-WishList page
Route::get('My-WishList', [FrontController::class, 'mywishlistpage'])->name('mywishlist');
//add to My-WishList
Route::any('WishList', [FrontController::class, 'addwishlist'])->name('wishlist');
//==========================after login tab view end=============================

//privacy policy
Route::get('Cancellation-and-Refund', [FrontController::class, 'CancellationandRefund'])->name('CancellationandRefund');
Route::get('Shipping-and-Delivery', [FrontController::class, 'ShippingandDelivery'])->name('ShippingandDelivery');
Route::get('Term-&-Condition', [FrontController::class, 'termandcondition'])->name('termandcondition');
Route::get('Privacy-Policy', [FrontController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('No-Return/No-Exchange', [FrontController::class, 'noReturnNoExchange'])->name('noReturnNoExchange');

Route::any('ccavRequestHandler', [FrontController::class, 'ccavRequestHandler'])->name('ccavRequestHandler');
// Route::get('/ccavResponseHandler', function(){
//     return view('frontview/ccavResponseHandler');
// });
Route::post('ccavResponseHandler', [FrontController::class, 'ccavResponseHandler'])->name('ccavResponseHandler');
Route::get('payment-success', [FrontController::class, 'payment_success'])->name('payment_success');
Route::get('payment-fail', [FrontController::class, 'payment_fail'])->name('payment_fail');



Route::get('/weight-bind', [FrontController::class, 'weightBind'])->name('productweight.weightBind');

Route::get('/Page-Not-Available', [FrontController::class, 'ordernotavailable'])->name('ordernotavailable');

use Gregwar\Captcha\CaptchaBuilder;

Route::get('/captcha_code', function () {
    $builder = new CaptchaBuilder;
    $builder->build();
    session(['captcha' => $builder->getPhrase()]);
    return response($builder->output())->header('Content-type', 'image/png');
});


Route::any('/Search', [FrontController::class, 'HeaderSearch'])->name('HeaderSearch');

Route::get('/Thank-You', [FrontController::class, 'contactthankyou'])->name('contactthankyou');

Route::get('/check/mobile', [FrontController::class, 'checkmobile'])->name('checkmobile');

//payment
Route::get('card-payment/{id}', [RazorpayController::class, 'index'])->name('razorpay.index')->where(['id' => '[0-9]+']);
Route::post('paysuccess', [RazorpayController::class, 'razorPaySuccess'])->name('razprpay.success');
Route::get('payment/success/{id?}', [RazorpayController::class, 'RazorThankYou'])->name('razorpay.thankyou');
Route::get('payment/fail', [RazorpayController::class, 'RazorFail'])->name('razorpay.RazorFail');

// Route::get('payment/test/success/{id?}', [RazorpayController::class, 'RazorThankYoutest'])->name('razorpay.thankyou');

//==============================================Shoowroom Routes====================================================

Route::prefix('admin')->group(function () {

    Route::get('shoowroom', [ShoowroomController::class, 'index'])->name('shoowroom.index');

    Route::get('shoowroom/create', [ShoowroomController::class, 'create'])->name('shoowroom.create');

    Route::post('shoowroom/store', [ShoowroomController::class, 'store'])->name('shoowroom.store');

    Route::get('shoowroom/{id}/edit', [ShoowroomController::class, 'edit'])->name('shoowroom.edit');
    Route::post('shoowroom/{id}/update', [ShoowroomController::class, 'update'])->name('shoowroom.update');


    Route::delete('shoowroom/{id}', [ShoowroomController::class, 'destroy'])->name('shoowroom.destroy');


    Route::get('shoowroom/resend/{id}', [ShoowroomController::class, 'resend'])
        ->name('shoowroom.resend');
});




Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a test email from Laravel.', function ($message) {
            $message->to('mihirrathod97@gmail.com')
                ->subject('Laravel Mail Test');
        });
        return '✅ Mail sent successfully!';
    } catch (\Exception $e) {
        return '❌ Mail failed: ' . $e->getMessage();
    }
});
