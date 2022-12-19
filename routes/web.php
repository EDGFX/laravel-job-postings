<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

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

// Common Resource Routes:
// index - Show All Listings
// show - Show Single Listing
// create - Show Form to Create New Listing
// store - Store New Listing
// edit - Show Form to Edit Listing
// Update - Update Listing
// destroy - Delete Listing

//All Listings (Archive Page)(GET REQUEST)
Route::get('/', [ListingController::class, 'index']);

//Show Create Form (GET REQUEST)
Route::get('/listings/create', [ListingController::class, 'create']);

//Store Listing Data (POST REQUEST)
Route::post('/listings', [ListingController::class, 'store']);

//Register Form Data
Route::get('/register/user', [UserController::class, 'index']);

//Store Registration Form Data
Route::post('/register', [UserController::class, 'store']);





//Single Listing (Listing Single) [KEEP AT THE BOTTOM]
Route::get('/listings/{listing}', [ListingController::class, 'show']);