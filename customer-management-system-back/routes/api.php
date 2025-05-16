<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUsers;
use App\Http\Controllers\ControllerCustomers;
use App\Http\Controllers\ControllerCompanies;

Route::options('/{any}', function (Request $request) {
    return response('', 204)
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Credentials', 'true');
})->where('any', '.*');


Route::post("/users/login", [ControllerUsers::class, "userLogin"]);
Route::post("/users/entry", [ControllerUsers::class, "userEntry"]);

Route::post("/customers/list", [ControllerCustomers::class, "customerList"]);
Route::post("/customers/count", [ControllerCustomers::class, "customerCount"]);
Route::post("/customers/delete", [ControllerCustomers::class, "customerDelete"]);
Route::post("/customers/entry", [ControllerCustomers::class, "customerEntry"]);
Route::post("/customers/edit", [ControllerCustomers::class, "customerEdit"]);
Route::post("/customers/getCustomer", [ControllerCustomers::class, "getCustomer"]);
Route::post("/customers/getCustomers", [ControllerCustomers::class, "getCustomers"]);

Route::post("/companies/getCompany", [ControllerCompanies::class, "getCompany"]);
Route::post("/companies/getCompanyIds", [ControllerCompanies::class, "getCompanyIds"]);
Route::post("/companies/list", [ControllerCompanies::class, "companyList"]);
Route::post("/companies/delete", [ControllerCompanies::class, "companyDelete"]);
Route::post("/companies/entry", [ControllerCompanies::class, "companyEntry"]);
Route::post("/companies/edit", [ControllerCompanies::class, "companyEdit"]);