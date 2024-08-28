<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNomenklaturPembelajaranRequest extends FormRequest
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
            'rumpun_pembelajaran_id' => 'required|exists:App\Models\RumpunPembelajaran,id',
			'nama_topik' => 'required|string|max:255',
			'status' => 'required|in:Pendding,Approved,Rejected',
			'user_created' => 'required|exists:App\Models\User,id',
			'tanggal_pengajuan' => 'required',
			'catatan_user_created' => 'required|string',
			'user_review' => 'required|exists:App\Models\User,id',
			'tanggal_review' => 'required',
			'catatan_user_review' => 'required|string',
        ];
    }
}
