<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomenklaturPembelajaran extends Model
{
    use HasFactory;
    protected $table = 'nomenklatur_pembelajaran';
    protected $fillable = ['rumpun_pembelajaran_id', 'nama_topik', 'status', 'user_created', 'tanggal_pengajuan', 'catatan_user_created', 'user_review', 'tanggal_review', 'catatan_user_review'];
    protected $casts = ['nama_topik' => 'string', 'tanggal_pengajuan' => 'datetime:d/m/Y H:i', 'catatan_user_created' => 'string', 'tanggal_review' => 'datetime:d/m/Y H:i', 'catatan_user_review' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

}
