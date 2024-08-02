<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Topik extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'topik';
    protected static $logUnguarded = true;

    protected $fillable = ['rumpun_pembelajaran', 'nama_topik'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_topik_pembelajaran')
            ->logOnly(['rumpun_pembelajaran', 'nama_topik'])
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
        return "Pembelajaran " . $this->nama_lokasi . " {$eventName} By "  . $user;
    }

    protected $casts = ['nama_topik' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
