<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumpunPembelajaran extends Model
{
    use HasFactory;
    protected $table = 'rumpun_pembelajaran';
    protected $fillable = ['rumpun_pembelajaran'];
    protected $casts = ['rumpun_pembelajaran' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
