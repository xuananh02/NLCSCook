<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanhGia extends Model
{
    use HasFactory;

    protected $primaryKey = 'MaDanhGia';

    protected $fillable = [
        'MaCT',
        'BinhLuan',
        'MaND'
    ];

    public function ctNauAn(): BelongsTo
    {
        return $this->belongsTo(CTNauAn::class, "MaCT", "MaCT");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "MaND", "MaND");
    }
}
