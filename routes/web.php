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

// LISTING-CENTRIC ROUTES
// -------------------
// -------------------
// -------------------
// -------------------

//All Listings (Archive Page)(GET REQUEST)
Route::get('/', 
[ListingController::class, 'index']);

//Show Create Form (GET REQUEST)
Route::get('/listings/create', 
[ListingController::class, 'create'])->middleware('auth');

//Store Listing Data (POST REQUEST)
Route::post('/listings', 
[ListingController::class, 'store'])->middleware('auth');

//Show Edit Form
Route::get('/listings/{listing}/edit', 
[ListingController::class, 'editListing'])->middleware('auth');

//Update Listing
Route::put('/listings/{listing}', 
[ListingController::class, 'updateListing'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', 
[ListingController::class, 'deleteListing'])->middleware('auth');

//Manage Listing (per User)
Route::get('/listings/manage',
[ListingController::class, 'manageListing'])->middleware('auth');


// USER-CENTRIC ROUTES
// -------------------
// -------------------
// -------------------
// -------------------

//Show Register/Create Form
Route::get('/register',
[UserController::class, 'registerUser'])->middleware('guest');

//Create New User
Route::post('/users', 
[UserController::class, 'storeUser']);

//Log User Out
Route::post('/logout',
[UserController::class, 'userLogout'])->middleware('auth');

//Show Login Form
Route::get('/login', 
[UserController::class, 'userLogin'])->name('login')->middleware('guest');

//Log In User
Route::post('/users/authenticate', 
[UserController::class, 'authUser']);






// KEEP AT BOTTOM
// -------------------
// -------------------
// -------------------
// -------------------

//Single Listing (Listing Single) [KEEP AT THE BOTTOM]
Route::get('/listings/{listing}', [ListingController::class, 'show']);