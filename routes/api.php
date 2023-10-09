<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\UserCategoriesController;
use App\Models\Categories;

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

Route::post('register', [ApiController::class, 'register']);
Route::post('updateregister', [ApiController::class, 'updateregister']);
Route::post('login', [ApiController::class, 'login']);
Route::post('userupdate', [ApiController::class, 'userupdate']);
Route::post('phoneotp', [ApiController::class, 'phoneotp']);
Route::post('generateotp', [ApiController::class, 'generateotp']);
Route::post('categories', [UserCategoriesController::class, 'categories']);
Route::post('getcategories', [UserCategoriesController::class, 'getcategories']);



Route::middleware('auth:api')->group(function () {
    Route::controller(ToursController::class)->group(function () {
        Route::post('tours', 'tours')->name('tours.tours');
        Route::get('gettours', 'gettours')->name('tours.gettours');
        Route::post('toursimages', 'toursimages')->name('tours.toursimages');
        Route::get('gettoursimages', 'gettoursimages')->name('tours.gettoursimages');
        Route::post('toursreviews', 'toursreviews')->name('tours.toursreviews');
        Route::get('gettoursreviews', 'gettoursreviews')->name('tours.gettoursreviews');
        Route::post('toursbooking', 'toursbooking')->name('tours.toursbooking');
        Route::get('gettoursbooking', 'gettoursbooking')->name('tours.gettoursbooking');
        Route::post('categories', 'categories')->name('tours.categories');
        Route::post('bookingsgroups', 'bookingsgroups')->name('tours.bookingsgroups');
        Route::get('getbookingsgroups', 'getbookingsgroups')->name('tours.getbookingsgroups');
        Route::post('rentalbookings', 'rentalbookings')->name('tours.rentalbookings');
        Route::get('getrentalbookings', 'getrentalbookings')->name('tours.getrentalbookings');
        Route::post('dispute', 'dispute')->name('tours.dispute');
        Route::get('getcategories', 'getcategories')->name('categories.getcategories');
    });


    Route::controller(RentalsController::class)->group(function () {
        Route::post('rentals', 'store')->name('rentals.rentals');
        Route::get('getrentals', 'getrentals')->name('rentals.getrentals');
        Route::post('rentaladdons', 'rentaladdons')->name('rentals.rentaladdons');
        Route::post('rentalreviews', 'rentalreviews')->name('rentals.rentalreviews');
        Route::get('getrentalreviews', 'getrentalreviews')->name('rentals.getrentalreviews');
        Route::get('userrentalreviews/{rental_id}', 'userrentalreviews')->name('rentals.userrentalreviews');
        Route::post('rentalimages', 'rentalimages')->name('rentals.rentalimages');
        Route::get('getrentalimages', 'getrentalimages')->name('rentals.getrentalimages');
        Route::get('userrentalimages/{rental_id}', 'userrentalimages')->name('rentals.userrentalimages');
    });


    Route::controller(UserCategoriesController::class)->group(function () {
        // Route::post('categories', 'categories')->name('user.categories');
        // Route::get('getcategories', 'getcategories')->name('user.getcategories');
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
        Route::post('bookings', 'bookings')->name('tours.bookings');
        Route::get('getbookings', 'getbookings')->name('tours.getbookings');
        Route::post('bookingGroups', 'bookingGroups')->name('tours.bookingGroups');
        Route::get('getbookingGroups', 'getbookingGroups')->name('tours.getbookingGroups');
        Route::get('getuserbookingGroups/{booking_id}', 'getuserbookingGroups')->name('tours.getuserbookingGroups');
        Route::get('upcomingbookings', 'upcomingbookings')->name('booking.upcomingbookings');
        Route::get('pastbookings', 'pastbookings')->name('booking.pastbookings');
    });
});
