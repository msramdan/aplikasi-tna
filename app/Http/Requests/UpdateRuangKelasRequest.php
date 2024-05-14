<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRuangKelasRequest extends FormRequest
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
        return [
            'nama_kelas' => 'required|string|max:150',
			'lokasi_id' => 'required|exists:App\Models\Lokasi,id',
			'kuota' => 'required|numeric',
			'status_ruang_kelas' => 'required|in:Available,Not available',
			'keterangan' => 'required|string',
        ];
    }
}
