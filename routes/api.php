<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/companies', [APIController::class, 'companies']);
Route::get('/employees', [APIController::class, 'employees']);
Route::get('companies/{id}', [ApiController::class, 'showCompany']);
Route::get('employees/{id}', [ApiController::class, 'showEmployee']);
