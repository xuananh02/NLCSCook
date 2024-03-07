<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VaiTro extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'TenVaiTro';

    protected $fillable = [
        'TenVaiTro',
        'MoTa'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
