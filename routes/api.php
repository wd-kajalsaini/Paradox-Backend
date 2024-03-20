<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get("user/view", "Api\UserController@view");
    Route::get("user/token_status", "Api\UserController@token_status");
    Route::post("user/edit_profile", "Api\UserController@edit_profile");
    Route::post("user/user_profile_setup", "Api\UserController@user_profile_setup");
    Route::post("user/upload_image", "Api\UserController@upload_image");
    Route::post("user/update_notification_token", "Api\UserController@update_notification_token");
    Route::post("friend/searchViaKvitelId", "Api\FriendController@searchViaKvitelId");
    Route::post("friend/free_search", "Api\FriendController@free_search");
    Route::post("friend/searchQrCode", "Api\FriendController@searchQrCode");
    Route::post("friend/addContact", "Api\FriendController@addContact");
    Route::post("friend/allContacts", "Api\FriendController@allContacts");
    Route::post("friend/overAllContacts", "Api\FriendController@overAllContacts");
    Route::post("friend/overAllMultipleContacts", "Api\FriendController@overAllMultipleContacts");
    Route::post("favourite", "Api\FavouriteController@index");
    Route::post("favourite/mark_unmark", "Api\FavouriteController@mark_unmark");
    Route::post("user/another_profile", "Api\UserController@another_profile");

    /* Request API's */

    Route::post("request/apply_request", "Api\RequestController@apply_request");
    Route::get("request/my_requests", "Api\RequestController@my_requests");

    /* Home page */

    Route::get("sections", "Api\SectionController@index");
    Route::get("banners", "Api\SectionController@banner");

    Route::post("show/detail", "Api\ShowController@detail");
    Route::post("show/update_room", "Api\ShowController@update_room");
    Route::post("section/section_shows", "Api\SectionController@section_shows");
    Route::post("subscription/mark_unmark", "Api\SubscriptionController@mark_unmark");


});

Route::get('overall_data', 'Api\HomeController@index');
Route::post('phoneVerification/sendCode', 'Api\PhoneVerificationController@sendCode');
Route::post('phoneVerification/resendCode', 'Api\PhoneVerificationController@resendCode');
Route::post('phoneVerification/verify_code', 'Api\PhoneVerificationController@verify_code');
Route::post('kvitelId/generateKvitelId', 'Api\KvitelIdController@generateKvitelId');
Route::post('user/register', 'Api\UserController@register');
Route::post('user/check_email_exist', 'Api\UserController@check_email_exist');
Route::post('user/verify_email', 'Api\UserController@verify_email');
Route::post('user/login', 'Api\UserController@login');
Route::post('user/social_login', 'Api\UserController@social_login');
Route::post('user/loginWithPhone', 'Api\UserController@loginWithPhone');
Route::get('kvitelId/list_of_products', 'Api\KvitelIdController@list_of_products');
Route::post('kvitelId/validate_id', 'Api\KvitelIdController@validate_id');
Route::post('kvitelId/updateKvitelId', 'Api\KvitelIdController@updateKvitelId');
Route::post('user/forgot_password', 'Api\UserController@forgot_password');
Route::post('user/verify_otp_reset', 'Api\UserController@verify_otp_reset');
Route::post("group/upload_image", "Api\GroupController@upload_image");

Route::get("ads", "Api\AdController@index");

/* Admin iPad API */

Route::post("admin/login", "Api\AdminController@login");
Route::get("admin/sections", "Api\AdminController@sections");
Route::get("admin/banners", "Api\AdminController@banner");
Route::post("admin/section_shows", "Api\AdminController@section_shows");
Route::post("admin/show_detail", "Api\AdminController@show_detail");

Route::get('login', array('as' => 'login', function () {
        return response()->json(['status' => 0, 'message' => 'Unauthorized Token']);
    }));

Route::any('{all}', function() {
    return response()->json(['status' => 0, 'message' => 'Page Not Found']);
})->where('all', '.*');
