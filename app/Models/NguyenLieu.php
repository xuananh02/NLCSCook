<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NguyenLieu extends Model
{
    use HasFactory;

    protected $primaryKey = 'MaNL';

    protected $fillable = [
        'TenNguyenLieu',
        'SoLuong',
        'DonVi',
        'MaCT'
    ];

    public function ctNauAn(): BelongsTo
    {
        return $this->belongsTo(CTNauAn::class, "MaCT", "MaCT");
    }
}
