<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKapTahunan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['tahun', 'tanggal_mulai', 'tanggal_selesai'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['tahun' => 'integer', 'tanggal_mulai' => 'date:d/m/Y', 'tanggal_selesai' => 'date:d/m/Y', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    

}
