<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Asrama extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'asrama';
    protected static $logUnguarded = true;


    protected $fillable = ['nama_asrama', 'lokasi_id', 'kuota', 'status_asrama', 'keterangan'];

    protected $casts = ['nama_asrama' => 'string', 'kuota' => 'integer', 'keterangan' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function lokasi()
    {
        return $this->belongsTo(\App\Models\Lokasi::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_asrama')
            ->logOnly(['nama_asrama', 'lokasi_id', 'kuota', 'status_asrama', 'keterangan'])
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
        return "Asrama " . $this->nama_asrama . " {$eventName} By "  . $user;
    }
}
