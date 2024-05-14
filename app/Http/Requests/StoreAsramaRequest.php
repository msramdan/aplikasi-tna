<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsramaRequest extends FormRequest
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
            'nama_asrama' => 'required|string|max:150',
			'lokasi_id' => 'required|exists:App\Models\Lokasi,id',
			'kuota' => 'required|numeric',
			'starus_asrama' => 'required|in:Available,Not available',
			'keterangan' => 'required|string',
        ];
    }
}
