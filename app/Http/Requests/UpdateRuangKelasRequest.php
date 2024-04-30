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
            'campus_id' => 'required|exists:App\Models\Campus,id',
			'nama_kelas' => 'required|string|max:150',
			'kuota' => 'required|numeric',
			'status' => 'required|in:Available,Not available',
			'keterangan' => 'required|string',
        ];
    }
}
