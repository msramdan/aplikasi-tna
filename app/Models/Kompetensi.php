<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Kompetensi extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'kompetensi';

    protected $fillable = ['nama_kompetensi', 'deskripsi_kompetensi'];

    protected $casts = ['nama_kompetensi' => 'string', 'deskripsi_kompetensi' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_kompetensi')
            ->logOnly(['nama_kompetensi', 'deskripsi_kompetensi'])
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
        return "kompetensi " . $this->nama_kompetensi . " {$eventName} By "  . $user;
    }
}
