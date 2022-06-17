<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestLoanController;

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

// set the locale of the entire website to NL, because that is the project's requirement
Illuminate\Support\Facades\App::setLocale('nl');

Route::view('/', 'auth/login')
    ->middleware('guest') // check if user is guest, otherwise redirect
    ->name('login-page'); // using 'login' causes an error

Route::controller(UserController::class)->group(function() {
    Route::get('/create/activate/{userId}/{code}/activate', 'activateUser')
        ->where('userId', '[0-9]+') // userId must be a number, check using regex
        ->name('user.activate');
    Route::post('/create/activate/{userId}/{code}/activate', 'activateUserPost')
        ->where('userId', '[0-9]+') // userId must be a number, check using regex
        ->name('user.activate.post');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//request articles
Route::get('/articles', [ArticlesController::class, 'showArticles'])->middleware(['auth:sanctum',"auth.roles:super-user,student", 'verified'])->name('show.articles');

Route::post('/articles/request', [ArticlesController::class, 'requestArticle'])->middleware(['auth:sanctum',"auth.roles:super-user,student", 'verified'])->name('request.articles');

//FA: for all
Route::get('/articlesFA', [ArticlesController::class, 'viewArticlesFA'])->middleware(['auth:sanctum'])->name('viewFA.articles');

// logged in group
// everything inside this group requires you to be logged in
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name("dashboard");

    Route::get('/orders' , [OrderController::class, 'getOrders'])->name('orders');
    Route::prefix('loan')->group(function () { // everything inside starts with /loan/

        Route::controller(LoanController::class)->group(function () {
            Route::get('/overview', 'getLoans')
                ->middleware('auth.roles:super-user,warehouse-admin')
                ->name('overview-loan');

            Route::post('/take-in/{loan}', 'takeInLoan')
                ->middleware('auth.role:warehouse-admin')
                ->name('loan.take-in');
        });

        Route::prefix('request')->group(function () { // everything inside starts with /loan/request

            Route::controller(RequestLoanController::class)->group(function () {

                Route::get('/overview', 'getRequests')
                    ->middleware('auth.roles:super-user,warehouse-admin')
                    ->name('request.view');

                Route::post('/accept/{loanRequest}', 'acceptRequest')
                    ->middleware('auth.role:warehouse-admin')
                    ->name('loan.request.accept');
                Route::post('/reject/{loanRequest}', 'rejectRequest')
                    ->middleware('auth.role:warehouse-admin')
                    ->name('loan.request.reject');
            });
        });
    });

    Route::prefix('user')->group(function () { // everything inside starts with /user/

        Route::get('/create', [UserController::class, 'createUser'])
            ->middleware("auth.role:super-user")
            ->name("user.create");
        Route::post('/create/make', [UserController::class, 'createUserPost'])
            ->middleware("auth.role:super-user")
            ->name('user.create.post');

        // more user pages here

    });

    // more pages here :)
});

