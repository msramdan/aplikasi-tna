<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingApp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['aplication_name', 'logo', 'favicon', 'phone', 'email', 'address', 'url_wa_gateway', 'notif_wa', 'api_key_wa_gateway', 'bot_telegram', 'paper_qr_code', 'work_order_has_access_approval_users_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
}
