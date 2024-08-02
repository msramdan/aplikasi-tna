<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumpunPembelajaran extends Model
{
    use HasFactory;
    protected $table = 'rumpun_pembelajaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['rumpun_pembelajaran'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['rumpun_pembelajaran' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



}
