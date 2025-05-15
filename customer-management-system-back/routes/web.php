<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerUsers;
use App\Http\Controllers\ControllerCustomers;
use App\Http\Controllers\ControllerCompanies;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/api/users/login", [ControllerUsers::class, "userLogin"]);
Route::get("/api/users/entry", [ControllerUsers::class, "userEntry"]);

Route::get("/api/customers/list", [ControllerCustomers::class, "customerList"]);
Route::get("/api/customers/count", [ControllerCustomers::class, "customerCount"]);
Route::get("/api/customers/delete", [ControllerCustomers::class, "customerDelete"]);
Route::get("/api/customers/entry", [ControllerCustomers::class, "customerEntry"]);
Route::get("/api/customers/edit", [ControllerCustomers::class, "customerEdit"]);
Route::get("/api/customers/getCustomer", [ControllerCustomers::class, "getCustomer"]);
Route::get("/api/customers/getCustomers", [ControllerCustomers::class, "getCustomers"]);

Route::get("/api/companies/getCompany", [ControllerCompanies::class, "getCompany"]);
Route::get("/api/companies/getCompanyIds", [ControllerCompanies::class, "getCompanyIds"]);
Route::get("/api/companies/list", [ControllerCompanies::class, "companyList"]);
Route::get("/api/companies/delete", [ControllerCompanies::class, "companyDelete"]);
Route::get("/api/companies/entry", [ControllerCompanies::class, "companyEntry"]);
Route::get("/api/companies/edit", [ControllerCompanies::class, "companyEdit"]);