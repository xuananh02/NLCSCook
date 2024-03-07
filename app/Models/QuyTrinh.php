<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuyTrinh extends Model
{
    use HasFactory;

    protected $primaryKey = 'MaQT';

    protected $fillable = [
        'MaCT',
        'ThoiGian',
        'NoiDungBuoc'
    ];

    public function ctNauAn(): BelongsTo
    {
        return $this->belongsTo(CTNauAn::class, "MaCT", "MaCT");
    }
}
