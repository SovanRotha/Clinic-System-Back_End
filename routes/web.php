<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/create-admin', function () {
//     \App\Models\RegisterModel::create([
//         'name' => 'Admin',
//         'email' => 'admin@gmail.com',
//         'password' => bcrypt('admin123456789'),
//         'phone_number'=> '1234567890',
//         'role' => 'admin'
//     ]);

//     return "Admin created successfully";
// });