<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TheLoai extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'TenTheLoai';
    protected $keyType = 'string';

    protected $fillable = [
        'TenTheLoai',
        'MoTa'
    ];

    public function ctNauAns(): HasMany
    {
        return $this->hasMany(CTNauAn::class, "TenTheLoai", "TenTheLoai");
    }
}
