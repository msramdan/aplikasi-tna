<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class RumpunPembelajaran extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'rumpun_pembelajaran';
    protected $fillable = ['rumpun_pembelajaran'];
    protected $casts = ['rumpun_pembelajaran' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_rumpun_pembelajaran')
            ->logOnly(['rumpun_pembelajaran'])
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
        return "Rumpun pembelajaran " . $this->rumpun_pembelajaran . " {$eventName} By "  . $user;
    }
}
