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

Route::get("/", "PageController@home")->name('home');
Route::get("/destinasi", "PageController@destinasi")->name('destinasi.index');
Route::get("/destinasi/create", "PageController@destinasiCreate")->name('destinasi.create');
Route::post("/destinasi", "PageController@destinasiStore")->name('destinasi.store');
Route::get("/destinasi/{id}", "PageController@destinasiShow")->name('destinasi.show');
Route::get("/destinasi/{id}/edit", "PageController@destinasiEdit")->name('destinasi.edit');
Route::put("/destinasi/{id}", "PageController@destinasiUpdate")->name('destinasi.update');
Route::delete("/destinasi/{id}", "PageController@destinasiDelete")->name('destinasi.destroy');
