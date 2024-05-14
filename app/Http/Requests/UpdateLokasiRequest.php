<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLokasiRequest extends FormRequest
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
            'kota_id' => 'required|exists:App\Models\Kotum,id',
			'type' => 'required|in:Kampus,Hotel',
			'nama_lokasi' => 'required|string|max:250',
        ];
    }
}
