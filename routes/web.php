<?php

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

//首页
//Route::get('/', 'PagesController@root')->name('root')->middleware('verified');
Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function() {
    //地址
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    //收藏//取消收藏
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    //收藏列表
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
    //加入购物车
    Route::post('cart', 'CartController@add')->name('cart.add');
    //查看购物车
    Route::get('cart', 'CartController@index')->name('cart.index');
    //移除购物车
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    //下单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    //用户订单查看
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    //订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');

    //第三方支付

    //支付宝支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    //前段回调
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
    //微信支付
    Route::get('payment/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');
    //确认收货
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
//    评价页面/接口
    Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
    Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
    //退款
    Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');
//    优惠券
    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
    //众筹
    Route::post('crowdfunding_orders', 'OrdersController@crowdfunding')->name('crowdfunding_orders.store');
    //分期付款创建
    Route::post('payment/{order}/installment', 'PaymentController@payByInstallment')->name('payment.installment');
    //分期付款列表
    Route::get('installments', 'InstallmentsController@index')->name('installments.index');
//分期付款详情
    Route::get('installments/{installment}', 'InstallmentsController@show')->name('installments.show');
//支付宝    分期付款拉起支付
    Route::get('installments/{installment}/alipay', 'InstallmentsController@payByAlipay')->name('installments.alipay');
    //支付宝分期付款前段回调
    Route::get('installments/alipay/return', 'InstallmentsController@alipayReturn')->name('installments.alipay.return');
    //微信分期付款前段回调
    Route::get('installments/{installment}/wechat', 'InstallmentsController@payByWechat')->name('installments.wechat');
});
//商品详情

Route::get('products/{product}', 'ProductsController@show')->name('products.show');
//支付宝回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
//支付宝后端回调
// 后端回调不能放在 auth 中间件中
Route::post('installments/alipay/notify', 'InstallmentsController@alipayNotify')->name('installments.alipay.notify');
//微信回调
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');
//分期微信支付后端回调
Route::post('installments/wechat/notify', 'InstallmentsController@wechatNotify')->name('installments.wechat.notify');
//微信退款回调
Route::post('payment/wechat/refund_notify', 'PaymentController@wechatRefundNotify')->name('payment.wechat.refund_notify');

//分期付款微信回调
Route::post('installments/wechat/refund_notify', 'InstallmentsController@wechatRefundNotify')->name('installments.wechat.refund_notify');
Route::get('alipay', function() {
    return app('alipay')->web([
        'out_trade_no' => time(),
        'total_amount' => '1',
        'subject' => 'test subject - 测试',
    ]);
});




Route::get('cache', 'PaymentController@cache');
