<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengajuanKapRequest extends FormRequest
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
            'kode_pembelajaran' => 'required|string|max:50',
			'type_pembelajaran' => 'required|in:Tahunan,Insidentil',
			'indikator_kinerja' => 'required|string|max:255',
			'kompetensi_id' => 'required|exists:App\Models\Kompetensi,id',
			'topik_id' => 'required|exists:App\Models\Topik,id',
			'concern_program_pembelajaran' => 'required|string|max:255',
			'alokasi_waktu' => 'required|string|max:10',
			'indikator_dampak_terhadap_kinerja_organisasi' => 'required|string|max:255',
			'penugasan_yang_terkait_dengan_pembelajaran' => 'required|string|max:255',
			'skill_group_owner' => 'required|string|max:255',
			'jalur_pembelajaran' => 'required|in:Pelatihan,Sertifikasi,Pelatihan di kantor sendiri,Belajar mandiri',
			'model_pembelajaran' => 'required|in:Terstruktur,Social learning,Experiential learning',
			'jenis_pembelajaran' => 'required|in:Fungsional,Teknis substansi,Kedinasan,Sertifikasi non JFA',
			'metode_pembelajaran' => 'required|in:Tatap muka,PJJ,E-learning,Blended',
			'sasaran_peserta' => 'required|string|max:255',
			'kriteria_peserta' => 'required|string|max:255',
			'aktivitas_prapembelajaran' => 'required|string|max:255',
			'penyelenggara_pembelajaran' => 'required|in:Pusdiklatwas BPKP,Unit kerja,Lainnya',
			'fasilitator_pembelajaran' => 'required|in:Widyaiswara,Instruktur,Praktisi,Pakar,Tutor,Coach,Mentor,Narasumber lainnya',
			'sertifikat' => 'required|string|max:255',
        ];
    }
}
