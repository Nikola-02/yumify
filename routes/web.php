<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FrontEndController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\RestaurantController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\BenefitController;
use \App\Http\Controllers\RatingController;
use \App\Http\Controllers\MealController;
use \App\Http\Controllers\RestaurantAdminController;


//Home
Route::get('/', [FrontEndController::class, 'index'])->name('home');

//Author
Route::get('/author', [FrontEndController::class, 'author'])->name('author');

//Auth
Route::middleware('guestAuth')->group(function (){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'performLogin'])->name('performLogin');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('performRegister');
});
Route::middleware('user')->post('/logout', [AuthController::class, 'logout'])->name('logout');

//User
Route::middleware('user')->prefix('/user')->group(function (){
    Route::get('/location', [UserController::class, 'userLocation'])->name('userLocation');
    Route::put('/location', [UserController::class, 'updateLocation'])->name('updateLocation');
});

//Restaurant
Route::prefix('/restaurants')->group(function (){
    Route::get('/', [RestaurantController::class, 'index'])->name('indexRestaurant');
    Route::get('/{id}', [RestaurantController::class, 'show'])->name('showRestaurant');
    Route::middleware('user')->post('/{restaurant}/rating', [RestaurantController::class, 'postReview'])->name('postReview');
    Route::middleware('user')->get('/{restaurant}/menu', [RestaurantController::class, 'showMenu'])->name('showMenu');
    Route::middleware('user')->get('/api/{restaurant}/menu', [RestaurantController::class, 'apiMealsMenu'])->name('apiMealsForMenuInRestaurant');
});

//Order
Route::middleware('user')->prefix('/order')->group(function (){
    Route::get('/', [OrderController::class, 'index'])->name('indexOrder');
    Route::get('/api', [OrderController::class, 'apiOrderCartIndex'])->name('apiOrderCartIndex');
    Route::post('/meal', [OrderController::class, 'storeMealInOrder'])->name('storeMealInOrder');
    Route::put('/line/{orderLine}/quantity', [OrderController::class, 'updateQuantityOfOrderLine'])->name('updateQuantityOfOrderLine');
    Route::delete('/line/{orderLine}', [OrderController::class, 'deleteItemFromOrder'])->name('deleteItemFromOrder');
    Route::put('/user', [OrderController::class, 'orderCartNow'])->name('orderCartNow');
    Route::get('/history', [OrderController::class, 'orderHistoryIndex'])->name('orderHistoryIndex');
});

//Admin
Route::middleware('admin')->prefix('/admin')->group(function (){
    //Resource za sve tabele (odvojeni controlleri), osim za ratings, tu ide samo delete (meals, restaurants, roles, types, users, ratings - samo delete)
    Route::get('/', [AdminController::class, 'index'])->name('admin_home');

    //Prikaz tabele na admin panelu
    Route::get('/{table}', [AdminController::class, 'show'])->name('admin_show_page');

    //Rute za admin panel
    Route::resource('/benefits', BenefitController::class);
    Route::resource('/meals', MealController::class);
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy']);
    Route::resource('/restaurants', RestaurantAdminController::class);
    Route::resource('/types', TypeController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
});
