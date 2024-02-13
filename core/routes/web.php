<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpecialProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserSettings;
use Illuminate\Support\Facades\Route;

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
Route::get('send-wa',function(){
    $send = sendWA('test send wa','081529963914');
    return $send;
});

Route::get('/',[HomeController::class,'index']);
Route::get('/product/{slug}',[HomeController::class,'product']);
Route::get('/catalog',[HomeController::class,'catalog']);
Route::get('/special-catalog',[HomeController::class,'specialCatalog']);

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::get('/forgot-password',[AuthController::class,'forgot'])->name('forgot');
Route::get('/reset-password',[AuthController::class,'resetPass'])->name('reset');
Route::post('/reset-password',[AuthController::class,'resetPassPost'])->name('reset.post');
Route::get('/otp',[AuthController::class,'otp'])->name('otp');
Route::post('/otp',[AuthController::class,'checkOTP'])->name('otp.post');

Route::post('/forgot-password',[AuthController::class,'forgotPost'])->name('forgot.post');
Route::post('/register',[AuthController::class,'registered'])->name('register.post');
Route::post('/login',[AuthController::class,'authecicate'])->name('login.post');

Route::get('/invoice/{inv}',[TransactionController::class,'invoice']);

Route::get('/stock-log/{id}',[StockController::class,'getLog']);
Route::post('update-stock',[StockController::class,'updateStok']);


Route::middleware('auth')->group(function(){
    Route::get('/chart',[TransactionController::class,'chart']);
    Route::get('/chart-add',[TransactionController::class,'chartAdd']);
    Route::get('/chart-del/{id}',[TransactionController::class,'chartDel']);
    Route::get('/chart-del-all',[TransactionController::class,'chartDelAll']);
    Route::post('/trasaction',[TransactionController::class,'trasaction']);

    Route::put('/upload-images/{id}',[TransactionController::class,'uploadImage'])->name('image.upload');

    Route::get('/invoice',[TransactionController::class,'invoiceAll']);

    Route::get('/profile',[HomeController::class,'profile']);
    Route::put('/profile/{id}',[HomeController::class,'profileUpdate']);

    Route::post('/logout',[AuthController::class,'logout']);
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/transaction',[TransactionController::class,'adminView']);
    Route::put('/transaction/{id}',[TransactionController::class,'adminUpdate']);
    Route::resource('/brand',BrandController::class);
    Route::resource('/categories', CategoriesController::class);
    Route::resource('/tags', TagController::class);
    Route::resource('/products',ProductController::class);
    Route::get('/stock',[StockController::class,'index']);

    Route::resource('/special-products',SpecialProductController::class);
    Route::prefix('report')->name('report.')->group(function(){
        Route::get('/export-pdf/{type}',[ReportController::class,'exportPDF'])->name('pdf');
        Route::get('/export-excel/{type}',[ReportController::class,'exportExcel'])->name('excel');

        Route::get('/customer',[ReportController::class,'customer'])->name('customer');
        Route::get('/selling',[ReportController::class,'sell'])->name('seller');
        Route::get('/discount',[ReportController::class,'discount'])->name('disc');
        Route::get('/product',[ReportController::class,'product'])->name('product');
        Route::get('/category',[ReportController::class,'category'])->name('category');
        Route::get('/brand',[ReportController::class,'brand'])->name('brand');
        
    });
    Route::prefix('settings')->name('settings.')->group(function(){
        Route::resource('/app',SettingController::class);
        Route::get('/user',[UserSettings::class,'index']);
    });
});
Route::prefix('lead')->name('lead.')->middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/settings/user',[UserSettings::class,'index']);

    Route::prefix('report')->name('report.')->group(function(){
        Route::get('/export-pdf/{type}',[ReportController::class,'exportPDF'])->name('pdf');
        Route::get('/export-excel/{type}',[ReportController::class,'exportExcel'])->name('excel');
        Route::get('/customer',[ReportController::class,'customer'])->name('customer');
        Route::get('/selling',[ReportController::class,'sell'])->name('seller');
        Route::get('/discount',[ReportController::class,'discount'])->name('disc');
        Route::get('/product',[ReportController::class,'product'])->name('product');
        Route::get('/category',[ReportController::class,'category'])->name('category');
        Route::get('/brand',[ReportController::class,'brand'])->name('brand');
        
    });
    Route::prefix('settings')->name('settings.')->group(function(){
        Route::resource('/app',SettingController::class);
        Route::get('/user',[UserSettings::class,'index']);
    });
});
 Route::put('/user-setings/{id}',[UserSettings::class,'update'])->name('user.update');
