<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// All Listings
Route::get('/', [ListingController::class, 'index']);


// Show Create Form

// middleware('auth'): The auth middleware is designed to protect routes that should only be accessible by authenticated users. When you apply this middleware to a route, Laravel intercepts the request to that route and checks if the user is logged in

// If the user is not authenticated (i.e., not logged in), Laravel's default behavior is to redirect the user to a login page
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single Listing (make sure this is at bottom)
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register/Create Form. middleware('guest') is used to specify that a given route should only be accessible to users who are not currently authenticated
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form. By naming the login route with ->name('login'), you're explicitly telling Laravel, "Here is the route to use when you need to redirect unauthenticated users."
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Route::get('/hello', function() {
//   return response("<h1>Hello World</h1>", 200)
//     ->header('Content-Type', 'text/plain')
//     ->header('foo', 'bar');
// });

// Route::get('/posts/{id}', function($id) {
//   return response('Post ' . $id * 2);
// })->where('id', '[0-9]+');

// Route::get('/search', function(Request $request) {
//   return $request->name . ' ' . $request->city;
// });
