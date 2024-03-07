<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home', ['noCalories' => App\Models\TheLoai::find("Không Calories")]);
});

// Route::get('/receipe')

Route::get('/the-loai', function (Request $request) {
    $tenTheLoai = $request->tenTheLoai;
    $theLoai = App\Models\TheLoai::where("TenTheLoai", "=", $tenTheLoai)->first();
    if ($theLoai == null) {
        abort(404);
    }
    return view('category_index', ['theLoai' => $theLoai]);
});

Route::get('/cong-thuc', function (Request $request) {
    $maCT = $request->maCT;
    $ctNauAn = App\Models\CTNauAn::where("MaCT", "=", $maCT)->first();
    if ($ctNauAn == null) {
        abort(404);
    }
    return view('cong_thuc', ['ctNauAn' => $ctNauAn]);
});


Route::get('/search', function (Request $request) {
    $tenMonAn = ($request->TenMonAn != null) ? str_replace("+", " ", $request->TenMonAn) : '';
    $ctNauAns = App\Models\CTNauAn::where('TenMonAn', 'like', '%'.$tenMonAn.'%')->get();
    return view('search', ['ctNauAns' => $ctNauAns]);
});

Route::get("/about", function () {
    return view("about");
});

Route::get('/dashboard', function () {
    if (Auth::user()->TenVaiTro != "Admin") {
        abort(404);
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/delete/{userId}', [ProfileController::class, 'delete'])->name('profile.delete');
});


require __DIR__.'/auth.php';
require __DIR__.'/hinh_anh.php';
require __DIR__.'/cook.php';