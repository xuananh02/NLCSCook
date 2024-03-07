<?php

namespace App\Http\Controllers;

use App\Models\CTNauAn;
use App\Models\DanhGia;
use App\Models\HinhAnh;
use App\Models\TheLoai;
use App\Models\QuyTrinh;
use App\Models\NguyenLieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CTNauAnController extends Controller
{

    private function saveImage($images, $ctNauAn)
    {
        // delete images
        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')->select('MaHinhAnh')->where('MaCT', '=', $ctNauAn->MaCT)
            ->get()->map( function ($item, $key) { return $item->MaHinhAnh; } );
        $hinhAnhOlds = HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->get();
        foreach ($hinhAnhOlds as $hinhAnh) {
            unlink(storage_path('app/' . $hinhAnh->Nguon));
        }
        HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->delete();
        DB::table('hinh_anh_c_t_nau_an')->where('MaCT', '=', $ctNauAn->MaCT)->delete();

        // save images
        $path = "images/";
        $arrHinhAnh = [];
        $arrHinhAnhCongThuc = [];

        foreach ($images as $file) {
            $fileName = $file->hashName();
            $file->storeAs($path . $fileName);

            $hinhAnh = HinhAnh::create([
                'Nguon' => $path . $fileName,
            ]);

            DB::table('hinh_anh_c_t_nau_an')->insert([
                'MaHinhAnh' => $hinhAnh->MaHinhAnh,
                'MaCT' => $ctNauAn->MaCT
            ]);

            $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                ->where('MaHinhAnh', '=', $hinhAnh->MaHinhAnh)
                ->where('MaCT', '=', $ctNauAn->MaCT)
                ->first();

            $arrHinhAnh[] = $hinhAnh;
            $arrHinhAnhCongThuc[] = $hinhAnhCongThuc;
        }

        return [
            "arrHinhAnh" => $arrHinhAnh,
            "arrHinhAnhCongThuc" => $arrHinhAnhCongThuc
        ];
    }

    private function saveNguyenLieu($ctNauAn, $nguyenLieus)
    {
        $newNguyenLieus = [];
        $oldNguyenLieus = NguyenLieu::where('MaCT', '=', $ctNauAn->MaCT)->get();
        foreach ($nguyenLieus as $nguyenLieu) {
            $form = [
                "TenNguyenLieu" => $nguyenLieu["tenNL"],
                "SoLuong" => $nguyenLieu["slNL"],
                "DonVi" => $nguyenLieu["dvNL"],
                "MaCT" => $ctNauAn->MaCT
            ];
            if ($nguyenLieu["MaNL"] != "") {
                $id = $nguyenLieu["MaNL"];
                $oldNguyenLieu = NguyenLieu::find($id);
                $oldNguyenLieu->update($form);
                $newNguyenLieus[] = $oldNguyenLieu;
            } else {
                $newNguyenLieus[] = NguyenLieu::create($form);
            }
        }
        foreach ($oldNguyenLieus as $oldNguyenLieu) {
            $isDelete = 1;
            $maNLOld = $oldNguyenLieu->MaNL;
            foreach ($newNguyenLieus as $newNguyenLieu) {
                $maNLNew = $newNguyenLieu->MaNL;
                if ($maNLNew == $maNLOld) {
                    $isDelete = 0;
                    break;
                }
            }
            if ($isDelete) {
                NguyenLieu::where('MaNL', '=', $maNLOld)->delete();
            }
        }

        return $newNguyenLieus;
    }

    public function saveQuyTrinh($ctNauAn, $quyTrinhs)
    {
        $newQuyTrinhs = [];
        $oldQuyTrinhs = QuyTrinh::where('MaCT', '=', $ctNauAn->MaCT)->get();
        foreach ($quyTrinhs as $quyTrinh) {
            $form = [
                'MaCT' => $ctNauAn->MaCT,
                'ThoiGian' => $quyTrinh['tGian'],
                'NoiDungBuoc' => $quyTrinh['noiDung'],
            ];

            if ($quyTrinh['MaQT'] != "") {
                $id = $quyTrinh['MaQT'];
                $oldQuyTrinh = QuyTrinh::find($id);
                $oldQuyTrinh->update($form);
                $newQuyTrinhs[] = $oldQuyTrinh;
            } else {
                $newQuyTrinhs[] = QuyTrinh::create($form);
            }
        }

        foreach ($oldQuyTrinhs as $oldQuyTrinh) {
            $isDelete = 1;
            $maQTOld = $oldQuyTrinh->MaQT;
            foreach ($newQuyTrinhs as $newQuyTrinh) {
                $maQTNew = $newQuyTrinh->MaQT;
                if ($maQTOld == $maQTNew) {
                    $isDelete = 0;
                    break;
                }
            }

            if ($isDelete) {
                QuyTrinh::where('MaQT', '=', $maQTOld)->delete();
            }
        }

        return $newQuyTrinhs;
    }

    public function findOne(string $id)
    {
        $ctNauAnRemake = [];
        $ctNauAn = CTNauAn::find($id);
        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')->where('MaCT', '=', $ctNauAn->MaCT)->select('MaHinhAnh')
            ->get()->map( function ($item, $key) { return $item->MaHinhAnh; } );
        $ctNauAnRemake = [
            'cong-thuc-nau-an' => $ctNauAn,
            'hinh-anh-cong-thuc' => HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->get(),
            'nguyen-lieu-cong-thuc' => NguyenLieu::where('MaCT', '=', $ctNauAn->MaCT)->get(),
            'quy-trinh-cong-thuc' => QuyTrinh::where('MaCT', '=', $ctNauAn->MaCT)->get()
        ];
        return [
            'cong-thuc' => $ctNauAnRemake,
        ];
    }
    public function findAll(Request $request)
    {
        $ctNauAnRemakes = [];
        $tenTL = $request->TenTheLoai;
        $ctNauAns = !is_null($tenTL) ? CTNauAn::where('TenTheLoai', '=', $tenTL)->get() : CTNauAn::all();
        foreach ($ctNauAns as $ctNauAn) {
            $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')->where('MaCT', '=', $ctNauAn->MaCT)->select('MaHinhAnh')
                ->get()->map( function ($item, $key) { return $item->MaHinhAnh; } );
            $ctNauAnRemakes[] = [
                'cong-thuc-nau-an' => $ctNauAn,
                'hinh-anh-cong-thuc' => HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->get(),
                'nguyen-lieu-cong-thuc' => NguyenLieu::where('MaCT', '=', $ctNauAn->MaCT)->get(),
                'quy-trinh-cong-thuc' => QuyTrinh::where('MaCT', '=', $ctNauAn->MaCT)->get()
            ];
        }
        return [
            'cac-cong-thuc-nau-an' => $ctNauAnRemakes,
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'MaND' => 'required',
            'TenTheLoai' => 'required',
            'TenMonAn' => 'required',
            'MoTa' => 'required',
            'MoTaChiTiet' => 'required',
            'NguyenLieu' => 'required',
            'QuyTrinh' => 'required',
            'images' => 'required',
            'images.*' => 'present|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

       
        $tenTL = $request->TenTheLoai;
        $theLoai = TheLoai::where('TenTheLoai', '=', $tenTL)->first();
        if ($theLoai == null) {
            return [
                'message' => 'invalid!'
            ];
        }

        $ctNauAn = CTNauAn::create([
            'MaND' => $request->MaND,
            'TenMonAn' => $request->TenMonAn,
            'MoTa' => $request->MoTa,
            'MoTaChiTiet' => $request->MoTaChiTiet,
            'TenTheLoai' => $tenTL
        ]);

        // Sometimes it's $request->file('image'), sometimes it's $request->image
        // because of the upload_max_filesize, post_max_size in php.ini cause
        $resultSaveImage = $this->saveImage($request->file('images'), $ctNauAn);
        $arrHinhAnhCongThuc = $resultSaveImage["arrHinhAnhCongThuc"];
        $arrHinhAnh = $resultSaveImage["arrHinhAnh"];

        $newNguyenLieus = $this->saveNguyenLieu($ctNauAn, $request->NguyenLieu);
        $newQuyTrinhs = $this->saveQuyTrinh($ctNauAn, $request->QuyTrinh);

        return [
            'cong-thuc-nau-an' => $ctNauAn,
            'cac-quy-trinh' => $newQuyTrinhs,
            'cac-nguyen-lieu' => $newNguyenLieus,
            'cac-hinh-anh' => $arrHinhAnh,
            'cac-hinh-anh-cong-thuc' => $arrHinhAnhCongThuc
        ];
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'TenTheLoai' => 'required',
            'TenMonAn' => 'required',
            'MoTa' => 'required',
            'MoTaChiTiet' => 'required',
            'NguyenLieu' => 'required',
            'QuyTrinh' => 'required',
        ]);

        $tenTL = $request->TenTheLoai;
        $ctNauAn = CTNauAn::where('MaCT', '=', $id)->first();
        $arrHinhAnh = [];
        $arrHinhAnhCongThuc = [];

        if ($ctNauAn == null) {
            return [
                'message' => 'invalid!!'
            ];
        } else if ($ctNauAn->TenTheLoai != $tenTL) {
            return [
                'message' => 'invalid!!'
            ];
        }

        if ($request->hasFile('images')) {
            // save new images
            // Sometimes it's $request->file('image'), sometimes it's $request->image
            $resultSaveImage = $this->saveImage($request->images, $ctNauAn);
            $arrHinhAnhCongThuc = $resultSaveImage["arrHinhAnhCongThuc"];
            $arrHinhAnh = $resultSaveImage["arrHinhAnh"];
        }

        $ctNauAn->update([
            'TenMonAn' => $request->TenMonAn,
            'MoTa' => $request->MoTa,
            'MoTaChiTiet' => $request->MoTaChiTiet,
        ]);



        $newNguyenLieus = $this->saveNguyenLieu($ctNauAn, $request->NguyenLieu);
        $newQuyTrinhs = $this->saveQuyTrinh($ctNauAn, $request->QuyTrinh);

        return [
            'cong-thuc-nau-an' => $ctNauAn,
            'cac-nguyen-lieu' => $newNguyenLieus,
            'cac-quy-trinh' => $newQuyTrinhs,
            'cac-hinh-anh-new' => $arrHinhAnh,
            'cac-hinh-anh-cong-thuc-new' => $arrHinhAnhCongThuc
        ];

    }
    public function delete(Request $request, string $id)
    {
        $ctNauAn = CTNauAn::where('MaCT', '=', $id)->first();

        if ($ctNauAn == null) {
            return [
                'message' => 'invalid!!'
            ];
        }
        $danhGiaBuilder = DanhGia::where('MaCT', '=', $id);
        $danhGias = $danhGiaBuilder->get();

        $hinhAnhCongThucBuilder = DB::table('hinh_anh_c_t_nau_an')->where('MaCT', '=', $ctNauAn->MaCT);
        $hinhAnhCongThuc = $hinhAnhCongThucBuilder->select('MaHinhAnh')
            ->get()->map( function ($item, $key) { return $item->MaHinhAnh; } );
        $hinhAnhBuilder = HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc);
        $hinhAnhs = $hinhAnhBuilder->get();

        $nguyenLieuBuilder = NguyenLieu::where('MaCT', '=', $ctNauAn->MaCT);
        $nguyenLieus = $nguyenLieuBuilder->get();

        $quyTrinhBuilder = QuyTrinh::where('MaCT', '=', $ctNauAn->MaCT);
        $quyTrinhs = $quyTrinhBuilder->get();

        if ($hinhAnhs->isNotEmpty()) {
            foreach ($hinhAnhs as $hinhAnh) {
                unlink(storage_path('app/' . $hinhAnh->Nguon));
            }
            $hinhAnhCongThucBuilder->delete();
            $hinhAnhBuilder->delete();
        }
        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }
        if ($nguyenLieus->isNotEmpty()) {
            $nguyenLieuBuilder->delete();
        }
        if ($quyTrinhs->isNotEmpty()) {
            $quyTrinhBuilder->delete();
        }
        $ctNauAn->delete();

        return [
            'cong-thuc-nau-an' => $ctNauAn,
            'cac-hinh-anh' => $hinhAnhs,
            'cac-danh-gia' => $danhGias,
            'cac-nguyen-lieu' => $nguyenLieus,
            'cac-quy-trinh' => $quyTrinhs,
        ];
    }


}