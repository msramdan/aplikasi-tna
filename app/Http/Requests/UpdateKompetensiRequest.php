<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKompetensiRequest extends FormRequest
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
            'nama_kompetensi' => 'required|string|max:255',
			'deskripsi_kompetensi' => 'required|string',
            'kelompok_besar_id' => 'required',
            'kategori_kompetensi_id' => 'required',
            'akademi_id' => 'required',
        ];
    }
}
