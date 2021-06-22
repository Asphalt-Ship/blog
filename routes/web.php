<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function(){
    Auth::logout();
    Session::flush();
    return redirect()->route('login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/index', [App\Http\Controllers\User\UserController::class, 'index'])->name('user.index');
    // route pour la page index qui accueille les nouveaux utilisateurs

Route::get('/admin/index', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

Route::get('/admin/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');

Route::get('/admin/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');

Route::post('/admin/categories/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');

Route::get('/admin/categories/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');

Route::patch('/admin/categories/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');

Route::delete('/admin/categories/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.delete');

    // on peut ajouter à la fin de chaque route les middlewares sans avoir à les écrire dans les controllers : 
    // ->middleware('auth', 'admin')
        // on peut aussi les ajouter dans AuthRouteMethod.php

Route::get('admin/posts/index', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.posts.index');

Route::get('/admin/posts/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.posts.create');

Route::post('admin/posts/store', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.posts.store');

Route::get('admin/posts/show/{id}', [App\Http\Controllers\Admin\PostController::class, 'show'])->name('admin.posts.show');

Route::put('admin/posts/published/{id}', [App\Http\Controllers\Admin\PostController::class, 'published'])->name('admin.posts.published');

Route::get('/admin/posts/edit/{id}', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.posts.edit');

Route::patch('/admin/posts/update/{id}', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.posts.update');

Route::delete('/admin/posts/trashed/{id}', [App\Http\Controllers\Admin\PostController::class, 'trashed'])->name('admin.posts.trashed');

