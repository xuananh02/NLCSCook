<?php

namespace App\Http\Controllers;

use App\Models\CTNauAn;
use App\Models\DanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{
    public function findAll(Request $request)
    {
        $maCT = $request->MaCT;
        $danhGias = !is_null($maCT) ? DanhGia::where('MaCT', '=', $maCT)->get() : DanhGia::all();
        return [
            'cac-danh-gia' => $danhGias
        ];
    }

    public function findOne($id)
    {
        $danhGia = DanhGia::where('MaDanhGIa', '=', $id)->first();
        if (is_null($danhGia)) {
            return [
                'message' => 'invalid!!'
            ];
        }

        return $danhGia;
    }

    public function create(Request $request)
    {
        $request->validate([
            'MaCT' => 'required',
            'BinhLuan' => 'required'
        ]);

        $user = Auth::user() ?? [
            'MaND' => 1
        ];
        $maCT = $request->MaCT;

        $ctNauAn = CTNauAn::where('MaCT', '=', $maCT)->first();
        if ($ctNauAn == null) {
            return [
                'message' => 'invalid!!'
            ];
        }
        $danhGia = DanhGia::create([
            'MaCT' => $ctNauAn->MaCT,
            'MaND' => $user['MaND'],
            'BinhLuan' => $request->BinhLuan
        ]);

        return [
            'danh-gia' => $danhGia
        ];
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'MaCT' => 'required',
            'BinhLuan' => 'required'
        ]);
        $maND = Auth::user() ?? [
            'MaND' => 1
        ];
        $maCT = $request->MaCT;
        $ctNauAn = CTNauAn::where('MaCT', '=', $maCT)->first();
        $danhGia = DanhGia::where('MaDanhGia', '=', $id)->first();
        if ($danhGia == null || $ctNauAn == null) {
            return [
                'message' => 'invalid!!'
            ];
        } else if ($danhGia->MaND != $maND['MaND']) {
            return [
                'message' => 'invalid!!'
            ];
        }

        $danhGia->update([
            'BinhLuan' => $request->BinhLuan
        ]);

        return [
            'danh-gia' => $danhGia
        ];
    }
    public function delete(Request $request, string $id)
    {
        
        $danhGia = DanhGia::where('MaDanhGia', '=', $id)->first();
        if ($danhGia == null) {
            return [
                'message' => 'invalid!!'
            ];
        }

        $danhGia->delete();

        return [
            'danh-gia' => $danhGia
        ];
    }

    public function deleteAll()
    {
        DanhGia::truncate();
        return ["delete" => "completed"];
    }
}
