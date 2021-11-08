<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [ProductController::class, 'index']);


Route::get('/filter','ProductController@index');
Route::post('/filter','ProductController@getpost');
 
Route::get('res-search', [ProductController::class, 'search']);



// route to return Add product views with categories
Route::get('/add-product', [ProductController::class, 'addproduct']);
// route to store product
Route::post('/createproduct', [ProductController::class, 'create']);



// route to return Add category views with categories
Route::get('/add-category', [CategoryController::class, 'addcategory']);
// route to store category
Route::post('/createcategory', [CategoryController::class, 'create']);