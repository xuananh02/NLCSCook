<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CTNauAn extends Model
{
    use HasFactory;

    protected $primaryKey = 'MaCT';

    protected $fillable = [
        'MaCT',
        'MaND',
        'MaHinhAnh',
        'TenMonAn',
        'MoTa',
        'MoTaChiTiet',
        'TenTheLoai'
    ];

    public function nguyenLieus(): HasMany
    {
        return $this->hasMany(NguyenLieu::class, "MaCT", "MaCT");
    }

    public function quyTrinhs(): HasMany
    {
        return $this->hasMany(QuyTrinh::class, "MaCT", "MaCT");
    }

    public function danhGias(): HasMany
    {
        return $this->hasMany(DanhGia::class, "MaCT", "MaCT");
    }

    public function theLoai(): BelongsTo
    {
        return $this->belongsTo(TheLoai::class, "TenTheLoai", "TenTheLoai");
    }
    
}
