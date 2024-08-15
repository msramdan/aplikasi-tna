<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class SettingApp extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'setting_apps';
    protected static $logUnguarded = true;


    protected $fillable = [
        'aplication_name',
        'logo',
        'favicon',
        'is_maintenance'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_setting_app')
            ->logOnly(['aplication_name', 'logo', 'favicon','is_maintenance'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        } else {
            $user = "System";
        }
        return "Setting apps {$eventName} By {$user}";
    }
}
