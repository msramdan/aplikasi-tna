<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class RuangKelas extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'ruang_kelas';
    protected static $logUnguarded = true;

    protected $fillable = ['nama_kelas', 'lokasi_id', 'kuota', 'status_ruang_kelas', 'keterangan'];

    protected $casts = ['nama_kelas' => 'string', 'kuota' => 'integer', 'keterangan' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_ruang_kelas')
            ->logOnly(['nama_kelas', 'lokasi_id', 'kuota', 'status_ruang_kelas', 'keterangan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        } else {
            $user = "Super Admin";
        }
        return "Ruang kelas " . $this->nama_kelas . " {$eventName} By "  . $user;
    }

    public function lokasi()
    {
        return $this->belongsTo(\App\Models\Lokasi::class);
    }
}
