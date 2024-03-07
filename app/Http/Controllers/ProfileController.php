<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CTNauAn;
use App\Models\DanhGia;
use App\Models\HinhAnh;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function userWeb()
    {
        return Auth::user();
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->upload != null) {
            $path = 'images/';
            $oldAvatar = $request->user()->pathAvatar;
            if ($oldAvatar != 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp') {
                unlink(storage_path('app/' . $oldAvatar));
            }

            $file = $request->upload;
            $fileName = $file->hashName();
            $file->storeAs($path, $fileName);
            $request->user()->update([
                'pathAvatar' => $path . $fileName,
            ]);
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $ctNauAnBuilder = CTNauAn::where('MaND', '=', Auth::user()->MaND);
        $ctNauAns = $ctNauAnBuilder->get();
        $maCTNauAns = $ctNauAnBuilder->select('MaCT')->get();

        $hinhAnhBuilder = HinhAnh::whereIn('MaCT', $maCTNauAns);
        $hinhAnhs = $hinhAnhBuilder->get();
        foreach ($hinhAnhs as $hinhAnh) {
            unlink(storage_path('app/' . $hinhAnh->Nguon));
        }

        $danhGiaBuilder = DanhGia::whereIn('MaCT', $maCTNauAns);
        $danhGias = $danhGiaBuilder->get();

        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }
        if ($hinhAnhs->isNotEmpty()) {
            $hinhAnhBuilder->delete();
        }
        if ($ctNauAns->isNotEmpty()) {
            $ctNauAnBuilder->delete();
        }
        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function delete($userId)
    {
        $admin = Auth::user();
        if ($admin->TenVaiTro != "Admin") {
            abort(404);
        }

        $user = User::find($userId);
        if ($user == null) {
            abort(404);
        }
        $ctNauAnBuilder = CTNauAn::where('MaND', '=', $userId);
        $ctNauAns = $ctNauAnBuilder->get();
        $maCTNauAns = $ctNauAnBuilder->select('MaCT')->get();

        $hinhAnhBuilder = HinhAnh::whereIn('MaCT', $maCTNauAns);
        $hinhAnhs = $hinhAnhBuilder->get();
        foreach ($hinhAnhs as $hinhAnh) {
            unlink(storage_path('app/' . $hinhAnh->Nguon));
        }

        $danhGiaBuilder = DanhGia::whereIn('MaCT', $maCTNauAns);
        $danhGias = $danhGiaBuilder->get();

        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }
        if ($hinhAnhs->isNotEmpty()) {
            $hinhAnhBuilder->delete();
        }
        if ($ctNauAns->isNotEmpty()) {
            $ctNauAnBuilder->delete();
        }
        if ($danhGias->isNotEmpty()) {
            $danhGiaBuilder->delete();
        }

        if ($user->pathAvatar != 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp') {
            unlink(storage_path('app/' . $user->pathAvatar));
        }
        $user->delete();

        return "Deleted";
    }
}
