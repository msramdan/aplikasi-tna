<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaggingPembelajaranKompetensi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['topik_id', 'kompetensi_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    

	public function topik()
	{
		return $this->belongsTo(\App\Models\Topik::class);
	}	
	public function kompetensi()
	{
		return $this->belongsTo(\App\Models\Kompetensi::class);
	}
}
