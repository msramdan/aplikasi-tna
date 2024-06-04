<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class JadwalKapTahunan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'jadwal_kap_tahunan';
    protected static $logUnguarded = true;


    protected $fillable = ['tahun', 'tanggal_mulai', 'tanggal_selesai'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_jadwal_kap_tahunan')
            ->logOnly(['tahun', 'tanggal_mulai', 'tanggal_selesai'])
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
        return "jadwal KAP tahunan " . $this->tahun . " {$eventName} By "  . $user;
    }

    protected $casts = ['tahun' => 'integer', 'tanggal_mulai' => 'date:d/m/Y', 'tanggal_selesai' => 'date:d/m/Y', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
