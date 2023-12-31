<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RentalAddonsController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\UserCategoriesController;
use GuzzleHttp\Promise\Create;

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

Route::post('login', [ApiController::class, 'login']);
Route::post('register', [ApiController::class, 'register']);
Route::post('verify', [ApiController::class, 'verify']);
Route::post('certificates', [ApiController::class, 'certificates']);
Route::get('getcertificates', [ApiController::class, 'getcertificates']);


Route::controller(UserCategoriesController::class)->group(function () {
    Route::post('categories', 'categories')->name('user.categories');
    Route::get('getcategories', 'getcategories')->name('user.getcategories');
});


Route::middleware('auth:api')->group(function () {

    Route::controller(ApiController::class)->group(function () {
        Route::post('userupdate', 'userupdate')->name('user.userupdate');
        Route::post('changepassword', 'changepassword')->name('user.changepassword');
        Route::post('updateregister', 'updateregister')->name('user.updateregister');
        Route::post('registerdelete/{id}', 'registerdelete')->name('user.registerdelete');
        Route::post('vendordashboard', 'vendordashboard')->name('user.vendordashboard');
        Route::post('searchUser', 'searchUser')->name('user.searchUser');
        Route::post('searchLoc', 'searchLoc')->name('user.searchLoc');
        Route::post('search', 'search')->name('user.search');
        Route::post('searchTour', 'searchTour')->name('user.searchTour');
        Route::get('popular', 'popular')->name('user.popular');
        Route::post('user/update/fcm', 'fcmid');
    });


    Route::controller(ToursController::class)->group(function () {
        Route::post('tours', 'store')->name('tours.tours');
        Route::get('gettours', 'gettours')->name('tours.gettours');
        Route::get('getusertours/{user_id}', 'getusertours')->name('tours.getusertours');
        Route::get('getonetours/{id}', 'getonetours')->name('tours.getonetours');
        Route::post('toursimages', 'toursimages')->name('tours.toursimages');
        Route::get('gettoursimages', 'gettoursimages')->name('tours.gettoursimages');
        Route::get('getusertoursimages/{tour_id}', 'getusertoursimages')->name('tours.getusertoursimages');
        Route::post('toursreviews', 'toursreviews')->name('tours.toursreviews');
        Route::get('gettoursreviews', 'gettoursreviews')->name('tours.gettoursreviews');
        Route::get('getusertoursreviews/{user_id}/{tour_id}', 'getusertoursreviews')->name('tours.getusertoursreviews');
        Route::post('toursbooking', 'toursbooking')->name('tours.toursbooking');
        Route::get('gettoursbooking', 'gettoursbooking')->name('tours.gettoursbooking');
        Route::get('getusertoursbooking/{booking_id}/{tour_id}', 'getusertoursbooking')->name('tours.getusertoursbooking');
        Route::post('bookingsgroups', 'bookingsgroups')->name('tours.bookingsgroups');
        Route::get('getbookingsgroups', 'getbookingsgroups')->name('tours.getbookingsgroups');
        Route::post('rentalbookings', 'rentalbookings')->name('tours.rentalbookings');
        Route::get('getrentalbookings', 'getrentalbookings')->name('tours.getrentalbookings');
        Route::get('getuserrentalbookings/{booking_id}/{rental_id}', 'getuserrentalbookings')->name('tours.getuserrentalbookings');
        Route::post('dispute', 'dispute')->name('tours.dispute');
    });


    Route::controller(RentalsController::class)->group(function () {
        Route::post('rentals', 'store')->name('rentals.rentals');
        Route::get('getrentals', 'getrentals')->name('rentals.getrentals');
        Route::get('getuserrentals/{user_id}', 'getuserrentals')->name('rentals.getuserrentals');
        Route::get('getonerentals/{id}', 'getonerentals')->name('rentals.getonerentals');
        Route::get('getcategoryrentals/{category_id}', 'getcategoryrentals')->name('rentals.getcategoryrentals');
        Route::get('getuserrentaladdons/{rental_id}', 'getuserrentaladdons')->name('rentals.getuserrentaladdons');
        Route::post('rentalreviews', 'rentalreviews')->name('rentals.rentalreviews');
        Route::get('getrentalreviews', 'getrentalreviews')->name('rentals.getrentalreviews');
        Route::get('userrentalreviews/{rental_id}', 'userrentalreviews')->name('rentals.userrentalreviews');
        Route::post('rentalimages', 'rentalimages')->name('rentals.rentalimages');
        Route::get('getrentalimages', 'getrentalimages')->name('rentals.getrentalimages');
        Route::get('userrentalimages/{rental_id}', 'userrentalimages')->name('rentals.userrentalimages');
    });


    Route::controller(RentalAddonsController::class)->group(function () {
        Route::post('rentaladdons', 'store')->name('rentals.rentaladdons');
        Route::get('getrentaladdons', 'getrentaladdons')->name('rentals.getrentaladdons');
    });


    Route::controller(UserCategoriesController::class)->group(function () {
        Route::post('usercategories', 'usercategories')->name('user.usercategories');
        Route::get('getusercategories', 'getusercategories')->name('categories.getusercategories');
    });


    Route::controller(PaymentsController::class)->group(function () {
        Route::post('payments', 'payments')->name('payments.payments');
        Route::get('getpayments', 'getpayments')->name('payments.getpayments');
        Route::post('bank', 'bank')->name('payments.bank');
        Route::get('getbank', 'getbank')->name('payments.getbank');
        Route::post('card', 'card')->name('payments.card');
        Route::get('getcard', 'getcard')->name('payments.getcard');
    });


    Route::controller(BookingsController::class)->group(function () {
        Route::post('booking/rental', 'booking_rental');
        Route::post('booking/tour', 'booking_tour');
        Route::post('rental/check/availability', 'checkAvailability');
        Route::get('booking/search', 'getbookings')->name('tours.getbookings');
        // Route::get('getuserbookings/{user_id}', 'getuserbookings')->name('tours.getuserbookings');
        Route::get('getbookingtours', 'getbookingtours')->name('tours.getbookingtours');
        Route::get('getuserbookingtours/{user_id}', 'getuserbookingtours')->name('tours.getuserbookingtours');
        Route::get('getbookingrentals', 'getbookingrentals')->name('tours.getbookingrentals');
        Route::get('getuserbookingrentals/{user_id}', 'getuserbookingrentals')->name('tours.getuserbookingrentals');
        Route::post('bookingGroups', 'bookingGroups')->name('tours.bookingGroups');
        Route::get('getbookingGroups', 'getbookingGroups')->name('tours.getbookingGroups');
        // Route::get('getuserbookingGroups/{booking_id}', 'getuserbookingGroups')->name('tours.getuserbookingGroups');
        Route::get('upcomingbookings', 'upcomingbookings')->name('booking.upcomingbookings');
        Route::get('pastbookings', 'pastbookings')->name('booking.pastbookings');
    });
});
