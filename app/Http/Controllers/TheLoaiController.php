<?php

namespace App\Http\Controllers;

use App\Models\CTNauAn;
use App\Models\DanhGia;
use App\Models\HinhAnh;
use App\Models\TheLoai;
use App\Models\QuyTrinh;
use App\Models\NguyenLieu;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TheLoaiController extends Controller
{
    private function saveImage($image, $theLoai, string $tenTheLoaiOld)
    {
        // delete old image
        $hinhAnhTheLoaiOldBuilder = DB::table('hinh_anh_the_loai')->where('TenTheLoai', '=', $tenTheLoaiOld);
        $hinhAnhTheLoaiOld = $hinhAnhTheLoaiOldBuilder->select('MaHinhAnh')
            ->get()->map(function ($item) {
                return $item->MaHinhAnh;
            });
        $hinhAnhOldBuilder = HinhAnh::whereIn('MaHinhAnh', $hinhAnhTheLoaiOld);
        $hinhAnhOlds = $hinhAnhOldBuilder->get();
        foreach ($hinhAnhOlds as $hinhAnh) {
            unlink(storage_path('app/' . $hinhAnh->Nguon));
        }
        $hinhAnhOldBuilder->delete();
        $hinhAnhTheLoaiOldBuilder->delete();

        // save new image
        $path = "images/";
        $file = $image;
        $fileName = $file->hashName();
        $file->storeAs($path . $fileName);

        $hinhAnh = HinhAnh::create([
            'Nguon' => $path . $fileName,
        ]);
        DB::table('hinh_anh_the_loai')->insert([
            'MaHinhAnh' => $hinhAnh->MaHinhAnh,
            'TenTheLoai' => $theLoai->TenTheLoai
        ]);
        $hinhAnhTheLoai = DB::table('hinh_anh_the_loai')
            ->where('MaHinhAnh', '=', $hinhAnh->MaHinhAnh)
            ->where('TenTheLoai', '=', $theLoai->TenTheLoai)
            ->first();

        return [
            'hinhAnh' => $hinhAnh,
            'hinhAnhTheLoai' => $hinhAnhTheLoai
        ];
    }

    public function extractTheLoai($tenTheLoai, $moTaTheLoai)
    {
        $theLoai = [
            'TenTheLoai' => $tenTheLoai,
            'MoTa' => $moTaTheLoai
        ];

        return $theLoai;
    }

    public function findAll(Request $request)
    {
        $theLoaiRemake = [];
        $theLoais = TheLoai::all();
        foreach ($theLoais as $theLoai) {
            $hinhAnhTheLoai = DB::table('hinh_anh_the_loai')->where('TenTheLoai', '=', $theLoai->TenTheLoai)
                ->select('MaHinhAnh')->get()
                ->map(function ($item) {
                    return $item->MaHinhAnh;
                });
            $theLoaiRemake[] = [
                'the-loai' => $theLoai,
                'hinh-anh-the-loai' => HinhAnh::whereIn('MaHinhAnh', $hinhAnhTheLoai)->get(),
            ];
        }

        return [
            'cac-the-loai' => $theLoaiRemake
        ];
    }

    public function findOne(string $id)
    {
        $theLoai = TheLoai::find($id);
        if (!$theLoai) {
            return [
                'message' => 'invalid!!'
            ];
        }

        $hinhAnhTheLoai = DB::table('hinh_anh_the_loai')->where('TenTheLoai', '=', $theLoai->TenTheLoai)
            ->select('MaHinhAnh')->get()
            ->map(function ($item) {
                return $item->MaHinhAnh;
            });
        return [
            'the-loai' => $theLoai,
            'hinh-anh-the-loai' => HinhAnh::whereIn('MaHinhAnh', $hinhAnhTheLoai)->get(),
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'TenTheLoai' => 'required',
            'MoTaTheLoai' => 'required',
            'image' => 'required',
            'image.*' => 'present|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $fieldData = $this->extractTheLoai($request->TenTheLoai, $request->MoTaTheLoai);

        $theLoai = TheLoai::create($fieldData);

        // Sometimes it's $request->file('image'), sometimes it's $request->image
        // because of the upload_max_filesize in php.ini cause
        $resultSaveImage = $this->saveImage($request->file('image'), $theLoai, "");
        $hinhAnhTheLoai = $resultSaveImage['hinhAnhTheLoai'];
        $hinhAnh = $resultSaveImage['hinhAnh'];

        return [
            'The-Loai:' => $theLoai,
            'Hinh-Anh-TL' => $hinhAnhTheLoai,
            'Hinh-Anh' => $hinhAnh
        ];
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'TenTheLoai' => 'required',
        ]);

        $theLoai = TheLoai::where('TenTheLoai', '=', $id)->first();

        if ($theLoai == null) {
            return [
                'message' => 'invalid!!'
            ];
        }

        $hinhAnhTheLoai = null;
        $hinhAnh = null;


        if ($request->MoTaTheLoai != null) {
            $theLoai->update([
                'TenTheLoai' => $request->TenTheLoai,
                'MoTa' => $request->MoTaTheLoai
            ]);
        } else {
            $theLoai->update([
                'TenTheLoai' => $request->TenTheLoai
            ]);
        }

        CTNauAn::where('TenTheLoai', '=', $id)->update(['TenTheLoai' => $request->TenTheLoai]);

        if ($request->hasFile('image')) {
            $resultSaveImage = $this->saveImage($request->file('image'), $theLoai, $id);
            $hinhAnhTheLoai = $resultSaveImage['hinhAnhTheLoai'];
            $hinhAnh = $resultSaveImage['hinhAnh'];
        } else {
            DB::table('hinh_anh_the_loai')
                ->where('TenTheLoai', '=', $id)
                ->update(["TenTheLoai" => $request->TenTheLoai]);
        }

        return [
            'The-Loai:' => $theLoai,
            'Hinh-Anh-TL' => $hinhAnhTheLoai,
            'Hinh-Anh' => $hinhAnh
        ];
    }
    public function delete($id)
    {

        $theLoai = TheLoai::where('TenTheLoai', '=', $id)->first();
        $hinhAnhTheLoaiBuilder = DB::table('hinh_anh_the_loai')->where('TenTheLoai', '=', $id);
        $hinhAnhTheLoais = $hinhAnhTheLoaiBuilder->pluck('MaHinhAnh');
        

        if ($theLoai == null) {
            return [
                'message' => 'invalid!!'
            ];
        }

        $ctNauAnBuilder = CTNauAn::where('TenTheLoai', '=', $id);
        $ctNauAns = $ctNauAnBuilder->get();
        $maCTNauAns = $ctNauAnBuilder->select('MaCT')->get();


        $hinhAnhCongThucBuilder = DB::table('hinh_anh_c_t_nau_an')->whereIn('MaCT', $maCTNauAns);
        $hinhAnhCongThuc = $hinhAnhCongThucBuilder->pluck('MaHinhAnh');

        $union = Arr::collapse($hinhAnhCongThuc, $hinhAnhTheLoais);

        $hinhAnhBuilder = HinhAnh::whereIn('MaHinhAnh', $union);
        $hinhAnhs = $hinhAnhBuilder->get();
        foreach ($hinhAnhs as $hinhAnh) {
            unlink(storage_path('app/' . $hinhAnh->Nguon));
        }

        $danhGiaBuilder = DanhGia::whereIn('MaCT', $maCTNauAns);
        $danhGias = $danhGiaBuilder->get();

        $nguyenLieuBuilder = NguyenLieu::whereIn('MaCT', $maCTNauAns);
        $nguyenLieus = $nguyenLieuBuilder->get();

        $quyTrinhBuilder = QuyTrinh::whereIn('MaCT', $maCTNauAns);
        $quyTrinhs = $quyTrinhBuilder->get();

        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }
        if ($hinhAnhs->isNotEmpty()) {
            $hinhAnhBuilder->delete();
            $hinhAnhCongThucBuilder->delete();
        }
        if ($ctNauAns->isNotEmpty()) {
            $ctNauAnBuilder->delete();
        }
        if ($nguyenLieus->isNotEmpty()) {
            $nguyenLieuBuilder->delete();
        }
        if ($quyTrinhs->isNotEmpty()) {
            $quyTrinhBuilder->delete();
        }
        if ($danhGias->isNotEmpty()) {
            $hinhAnhTheLoaiBuilder->delete();
            $danhGiaBuilder->delete();
        }
        if ($theLoai != null) {
            $theLoai->delete();
        }

        return [
            'The-Loai:' => $theLoai,
            // 'cac-cong-thuc-nau-an' => $ctNauAns,
            // 'cac-hinh-anh-cong-thuc' => $hinhAnhs,
            // 'cac-danh-gia' => $danhGias,
            // 'cac-nguyen-lieu' => $nguyenLieus
        ];
    }
}