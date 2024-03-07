<?php

use App\Models\CTNauAn;
use App\Models\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CTNauAnController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\TheLoaiController;

Route::prefix('api')->group(function () {
    
    Route::get('/cac_the_loai', [TheLoaiController::class, 'findAll']);
    Route::post('/cac_the_loai', [TheLoaiController::class,'create']);
    Route::delete('/cac_the_loai', [TheLoaiController::class,'deleteAll']);

    Route::get('/cac_the_loai/{id}', [TheLoaiController::class, 'findOne']);
    Route::post('/cac_the_loai/{id}', [TheLoaiController::class, 'update']);
    Route::delete('/cac_the_loai/{id}', [TheLoaiController::class,'delete']);

    Route::get('/cac_cong_thuc', [CTNauAnController::class,'findAll']);
    Route::post('/cac_cong_thuc', [CTNauAnController::class,'create']);
    Route::delete('/cac_cong_thuc', [CTNauAnController::class,'deleteAll']);

    Route::get('/cac_cong_thuc/{id}', [CTNauAnController::class,'findOne']);
    Route::post('/cac_cong_thuc/{id}', [CTNauAnController::class,'update']);
    Route::delete('/cac_cong_thuc/{id}', [CTNauAnController::class,'delete']);

    Route::get('/danh_gia', [DanhGiaController::class,'findAll']);
    Route::post('/danh_gia', [DanhGiaController::class,'create']);
    Route::delete('/danh_gia', [DanhGiaController::class,'deleteAll']);

    Route::get('/danh_gia/{id}', [DanhGiaController::class,'findOne']);
    Route::put('/danh_gia/{id}', [DanhGiaController::class,'update']);
    Route::delete('/danh_gia/{id}', [DanhGiaController::class,'delete']);

    Route::get('/users', function (Request $request) {
        $user = $request->user();
        if ($user->TenVaiTro != "Admin") {
            abort(404);
        }
        return \App\Models\User::all();
    });
    Route::get('/users/{id}', function (Request $request, String $id) {
        $role = $request->user()->TenVaiTro;
        $user = App\Models\User::find($id);
        if ($user == null || $role != "Admin") {
            abort(404);
        }
        return $user;
    });
});

Route::middleware(['auth'])->group(function () {

    Route::get('/user-test', function () {
        dd(Auth::user());
    });

    Route::get('/api/user-session', function () {
        return Auth::user();
    });

    Route::get('/dang-tai-the-loai', function () {
        if (Auth::user()->TenVaiTro != "Admin") {
            abort(404);
        }
        return view('dang_tai.the_loai');
    });

    Route::get('/dang-tai-cong-thuc', function () {
        return view('dang_tai.cong_thuc');
    });


    Route::get('/chinh-sua-the-loai/', function (Request $request) {
        $tenTL = $request->tenTL;
        if (Auth::user()->TenVaiTro != "Admin") {
            abort(404);
        }

        if ($tenTL != null) {
            $theLoai = TheLoai::where('TenTheLoai', '=', $tenTL)->first();
            if ($theLoai == null) {
                abort(404);
            }
            return view('dang_tai.chinh_sua_the_loai', ['theLoai' => $theLoai]);
        }

        return view('dang_tai.chinh_sua_the_loai', ['theLoai' => null]);
    });

    Route::get('/chinh-sua-cong-thuc/', function (Request $request) {
        $maCT = $request->maCT;
        $ctNauAn = CTNauAn::where('MaCT', '=', $maCT)->first();
        if ($ctNauAn == null || $ctNauAn->MaND != Auth::user()->MaND && Auth::user()->TenVaiTro != "Admin") {
            abort(404);
        }
        return view('dang_tai.chinh_sua_cong_thuc', ['ctNauAn' => $ctNauAn]);
    });
});
