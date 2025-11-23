<?php

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

Route::get("/dashboard", "PageController@home")->name('home');
Route::get("/destinasi", "PageController@destinasi")->name('destinasi.index');
Route::get("/destinasi/create", "PageController@destinasiCreate")->name('destinasi.create');
Route::post("/destinasi", "PageController@destinasiStore")->name('destinasi.store');
Route::get("/destinasi/{id}", "PageController@destinasiShow")->name('destinasi.show');
Route::get("/destinasi/{id}/edit", "PageController@destinasiEdit")->name('destinasi.edit');
Route::put("/destinasi/{id}", "PageController@destinasiUpdate")->name('destinasi.update');
Route::delete("/destinasi/{id}", "PageController@destinasiDelete")->name('destinasi.destroy');

Route::get("/users", "PageController@users")->name('users.index');
Route::get("/users/create", "PageController@usersCreate")->name('users.create');
Route::post("/users", "PageController@usersStore")->name('users.store');
Route::delete("/users/{id}", "PageController@usersDelete")->name('users.destroy');

Route::get("/", "PageController@login")->name('login');
Route::post("/login", "PageController@loginPost")->name('login.post');
