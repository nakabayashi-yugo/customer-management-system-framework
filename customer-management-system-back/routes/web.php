<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerUsers;
use App\Http\Controllers\ControllerCustomers;
use App\Http\Controllers\ControllerCompanies;

// Route::prefix('api')
//     ->middleware('api')
//     ->group(base_path('routes/api.php'));

Route::get("/", function () {
    return view("welcome");
});

// // CSRFをまとめて外すグループ
// Route::middleware(['web', 'without-csrf'])->group(function () {

//     Route::post("/api/users/login", [ControllerUsers::class, "userLogin"]);
//     Route::post("/api/users/entry", [ControllerUsers::class, "userEntry"]);

//     Route::post("/api/customers/list", [ControllerCustomers::class, "customerList"]);
//     Route::post("/api/customers/count", [ControllerCustomers::class, "customerCount"]);
//     Route::post("/api/customers/delete", [ControllerCustomers::class, "customerDelete"]);
//     Route::post("/api/customers/entry", [ControllerCustomers::class, "customerEntry"]);
//     Route::post("/api/customers/edit", [ControllerCustomers::class, "customerEdit"]);
//     Route::post("/api/customers/getCustomer", [ControllerCustomers::class, "getCustomer"]);
//     Route::post("/api/customers/getCustomers", [ControllerCustomers::class, "getCustomers"]);

//     Route::post("/api/companies/getCompany", [ControllerCompanies::class, "getCompany"]);
//     Route::post("/api/companies/getCompanyIds", [ControllerCompanies::class, "getCompanyIds"]);
//     Route::post("/api/companies/list", [ControllerCompanies::class, "companyList"]);
//     Route::post("/api/companies/delete", [ControllerCompanies::class, "companyDelete"]);
//     Route::post("/api/companies/entry", [ControllerCompanies::class, "companyEntry"]);
//     Route::post("/api/companies/edit", [ControllerCompanies::class, "companyEdit"]);

// });
