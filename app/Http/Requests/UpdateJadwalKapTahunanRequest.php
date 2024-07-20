<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalKapTahunanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('jadwal_kap_tahunan');
        return [
            'tahun' => 'required|numeric|unique:jadwal_kap_tahunan,tahun,' . $id . ',id',
			'tanggal_mulai' => 'required|date',
			'tanggal_selesai' => 'required|date',
        ];
    }
}
