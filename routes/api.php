<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginsController;

use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\LevelsController;
use App\Http\Controllers\Api\CodesController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\SchoolsController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\SchoolLevelsController;
use App\Http\Controllers\Api\SearchsController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('orders', [AuthController::class, 'getOrders']);
/*
Route::get('/login/google', [LoginsController::class, "index"])->name("login");
Route::post('login/googleStore', [LoginsController::class, "store"]);
Route::get("/google-auth/logout", [LoginsController::class, "logout"])->name("logout");
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('series', SeriesController::class);
Route::resource('products', ProductsController::class);
Route::resource('levels', LevelsController::class);
Route::resource('codes', CodesController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('orders', OrdersController::class);
Route::resource('schools', SchoolsController::class);
Route::resource('schoolLevels', SchoolLevelsController::class);
Route::resource('countries', CountriesController::class);
Route::resource('searchs', SearchsController::class);


//routes of series
Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/{id}', [SeriesController::class, 'show']);
Route::get('/seriesRandom/{cantidad}', [SeriesController::class, 'serieRandom']);
Route::get('/seriesByCategory/{category}', [SeriesController::class, 'seriesByCategory']);


//routes of products
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/productsByserie/{serie_id}', [ProductsController::class, 'productsBySerie']);
Route::get('/productsByLevel/{level_id}', [ProductsController::class, 'productsByLevel']);
Route::get('/productsBySchoolLevel/{school_level}', [ProductsController::class, 'productsBySchoolLevel']);


//routes of levels
Route::get('/levels', [LevelsController::class, 'index']);
Route::get('/levels/{id}', [LevelsController::class, 'show']);
Route::get('/levelsBySerie/{id}', [LevelsController::class, 'levelsBySerie']);


//routes of codes
Route::get('/codes', [CodesController::class, 'index']);
Route::get('/codes/{id}', [CodesController::class, 'show']);


//routes of categories
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{id}', [CategoriesController::class, 'show']);
Route::get('/firstCategories/{cant}', [CategoriesController::class, 'firstCategories']);


//routes of orders  auth:sanctum    jwt.auth
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/orders', [OrdersController::class, 'index']);
    Route::get('/orders/{id}', [OrdersController::class, 'show']);
});




//routes of schools
Route::get('/schools', [SchoolsController::class, 'index']);
Route::get('/schools/{id}', [SchoolsController::class, 'show']);
Route::get('/schoolsByCountry/{country_id}', [SchoolsController::class, 'schoolsByCountry']);

//routes of schoolsLevels
Route::get('/schoolLevels', [SchoolLevelsController::class, 'index']);
Route::get('/schoolLevels/{id}', [SchoolLevelsController::class, 'show']);
Route::get('/schoolLevelsBySchool/{country_id}', [SchoolLevelsController::class, 'schoolLevelsBySchool']);


//routes of countries
Route::get('/countries', [CountriesController::class, 'index']);
Route::get('/countries/{id}', [CountriesController::class, 'show']);


//routes of searchs
Route::get('/searchs', [SearchsController::class, 'search']);
Route::get('/searchs/{keyword}', [SearchsController::class, 'show']);
