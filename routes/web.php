<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Vote\VoteController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Categorypost\CategorypostController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\User\CustomerController;


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

Route::get('/', function () {
    return view('welcome');
})->name('user');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* ========== ADMIN =========== */

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

    /*----------- USER ----------*/
    Route::prefix('admin/user')->group(function () {
        Route::get('/info', [UserController::class, 'info'])->name('user.info');
        Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update', [UserController::class, 'update'])->name('user.update');
        Route::get('/editPassword', [UserController::class, 'editPassword'])->name('user.editPassword');
        Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('user.updatePassword');

        Route::get('/list', [AdminController::class, 'index'])->name('user.list');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit-user/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/delete', [AdminController::class, 'delete'])->name('admin.delete');
        Route::post('/restore', [AdminController::class, 'restore'])->name('admin.restore');
        Route::post('/force-delete', [AdminController::class, 'forceDelete'])->name('admin.forceDelete');
        Route::post('/updatePassword-user/{id}', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
    });

    /* ------- CUSTOMER ------------ */
    Route::prefix('admin/customer')->group(function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('customer.list');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update', [CustomerController::class, 'update'])->name('customer.update');
        Route::post('/updatePassword/{id}', [CustomerController::class, 'updatePassword'])->name('customer.updatePassword');
        Route::post('/delete', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::post('/restore', [CustomerController::class, 'restore'])->name('customer.restore');
        Route::post('/force-delete', [CustomerController::class, 'forceDelete'])->name('customer.forceDelete');
    });
    /* ---------- ROLE ------------- */
    Route::prefix('admin/role')->group(function () {
        Route::get('/list', [RoleController::class, 'index'])->name('role.list');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::post('/delete', [RoleController::class, 'delete'])->name('role.delete');
    });

    /* ---------------- POST --------------- */
    Route::prefix('admin/post')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/create', [PostController::class, 'store'])->name('post.store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::post('/delete', [PostController::class, 'destroy'])->name('post.delete');
        Route::post('/delete-img', [PostController::class, 'deleteImg'])->name('post.deleteImg');
    });

    /* ---------------- VOTE --------------- */
    Route::prefix('admin/vote')->group(function () {
        Route::prefix('post')->group(function (){
            Route::get('/', [VoteController::class, 'indexVotePost'])->name('vote.indexPost');
            Route::get('/create', [VoteController::class, 'createVotePost'])->name('vote.createPost');
            Route::post('/create', [VoteController::class, 'storeVotePost'])->name('vote.storePost');
            Route::get('/edit/{id}', [VoteController::class, 'editVotePost'])->name('vote.editPost');
            Route::post('/update/{id}', [VoteController::class, 'updateVotePost'])->name('vote.updatePost');
            Route::post('/delete', [VoteController::class, 'destroyVotePost'])->name('vote.deletePost');
        });
        Route::prefix('product')->group(function (){
            Route::get('/', [VoteController::class, 'indexVoteProduct'])->name('vote.indexProduct');
            Route::get('/create', [VoteController::class, 'createVoteProduct'])->name('vote.createProduct');
            Route::post('/create', [VoteController::class, 'storeVoteProduct'])->name('vote.storeProduct');
            Route::get('/edit/{id}', [VoteController::class, 'editVoteProduct'])->name('vote.editProduct');
            Route::post('/update/{id}', [VoteController::class, 'updateVoteProduct'])->name('vote.updateProduct');
            Route::post('/delete', [VoteController::class, 'destroyVoteProduct'])->name('vote.deleteProduct');

        });

    });

    /* ---------------- PRODUCT--------------- */
    Route::prefix('admin/products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/create', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
        Route::post('/update/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::post('/delete', [ProductsController::class, 'destroy'])->name('products.delete');
        Route::post('/delete-img', [ProductsController::class, 'deleteImgAjax'])->name('products.deleteImg');
        // Route::post('/cropimg', [ProductsController::class, 'uploadCropImage'])->name('cropimg');
    });


    /* --------- Slider ------------ */
    Route::prefix('admin/slider')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/create', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::post('/delete', [SliderController::class, 'destroy'])->name('slider.delete');
        Route::post('/delete-img', [SliderController::class, 'deleteImg'])->name('slider.deleteImg');
    });


    /* ---------- ORDER --------------- */
    Route::prefix('admin/order')->group(function () {
        Route::get('/list', [OrderController::class, 'index'])->name('order.list');
        Route::post('/delete', [OrderController::class, 'delete'])->name('order.delete');
        Route::post('/restore', [OrderController::class, 'restore'])->name('order.restore');
        Route::post('/force-delete', [OrderController::class, 'forceDelete'])->name('order.forceDelete');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/update', [OrderController::class, 'update'])->name('order.update');
        Route::post('/updateCustomer', [OrderController::class, 'updateCustomer'])->name('order.updateCustomer');
        Route::post('/update-ajax', [OrderController::class, 'updateAjax'])->name('order.updateAjax');
    });


    Route::prefix('admin/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::get('/search', [CategoryController::class, 'search'])->name('category.search');
        Route::post('/create', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('category.delete');
        });

     Route::prefix('admin/categorypost')->group(function () {
        Route::get('/', [CategorypostController::class, 'index'])->name('categorypost.index');
        Route::get('/create', [CategorypostController::class, 'create'])->name('categorypost.create');
        Route::get('/search', [CategorypostController::class, 'search'])->name('categorypost.search');
        Route::post('/create', [CategorypostController::class, 'store'])->name('categorypost.store');
        Route::post('/update/{id}', [CategorypostController::class, 'update'])->name('categorypost.update');
        Route::get('/edit/{id}', [CategorypostController::class, 'edit'])->name('categorypost.edit');
        Route::post('/delete', [CategorypostController::class, 'destroy'])->name('categorypost.delete');
        });
});
