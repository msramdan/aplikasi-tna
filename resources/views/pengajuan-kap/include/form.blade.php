
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="row mb-2">
    <div class="col-md-3 mb-2">
        <label for="jenis-program">{{ __('Jenis Program') }}</label>
        <select class="form-control js-example-basic-multiple @error('jenis_program') is-invalid @enderror"
            name="jenis_program" id="jenis-program" required>
            <option value="" selected disabled>-- {{ __('Select jenis program') }} --</option>

            @foreach ($jenis_program as $program)
                <option value="{{ $program }}"
                    {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == $program ? 'selected' : (old('jenis_program') == $program ? 'selected' : '') }}>
                    {{ $program }}
                </option>
            @endforeach
        </select>
        @error('jenis_program')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-3 mb-2">
        <label for="indikator-kinerja">{{ __('Indikator Kinerja') }}</label>
        <input type="text" name="indikator_kinerja" id="indikator-kinerja"
            class="form-control @error('indikator_kinerja') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_kinerja : old('indikator_kinerja') }}"
            placeholder="{{ __('Indikator Kinerja') }}" required />
        @error('indikator_kinerja')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-3 mb-2">
        <label for="kompetensi-id">{{ __('Kompetensi') }}</label>
        <select class="form-control js-example-basic-multiple @error('kompetensi_id') is-invalid @enderror"
            name="kompetensi_id" id="kompetensi-id" required>
            <option value="" selected disabled>-- {{ __('Select kompetensi') }} --</option>

            @foreach ($kompetensis as $kompetensi)
                <option value="{{ $kompetensi->id }}"
                    {{ isset($pengajuanKap) && $pengajuanKap->kompetensi_id == $kompetensi->id ? 'selected' : (old('kompetensi_id') == $kompetensi->id ? 'selected' : '') }}>
                    {{ $kompetensi->nama_kompetensi }}
                </option>
            @endforeach
        </select>
        @error('kompetensi_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="topik-id">{{ __('Topik') }}</label>
        <select class="form-control js-example-basic-multiple @error('topik_id') is-invalid @enderror" name="topik_id"
            id="topik-id" required>
            <option value="" selected disabled>-- {{ __('Select topik') }} --</option>

            @foreach ($topiks as $topik)
                <option value="{{ $topik->id }}"
                    {{ isset($pengajuanKap) && $pengajuanKap->topik_id == $topik->id ? 'selected' : (old('topik_id') == $topik->id ? 'selected' : '') }}>
                    {{ $topik->nama_topik }}
                </option>
            @endforeach
        </select>
        @error('topik_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="concern-program-pembelajaran">{{ __('Concern Program Pembelajaran') }}</label>
        <input type="text" name="concern_program_pembelajaran" id="concern-program-pembelajaran"
            class="form-control @error('concern_program_pembelajaran') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->concern_program_pembelajaran : old('concern_program_pembelajaran') }}"
            placeholder="{{ __('Concern Program Pembelajaran') }}" required />
        @error('concern_program_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label
            for="indikator-dampak-terhadap-kinerja-organisasi">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</label>
        <input type="text" name="indikator_dampak_terhadap_kinerja_organisasi"
            id="indikator-dampak-terhadap-kinerja-organisasi"
            class="form-control @error('indikator_dampak_terhadap_kinerja_organisasi') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi : old('indikator_dampak_terhadap_kinerja_organisasi') }}"
            placeholder="{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}" required />
        @error('indikator_dampak_terhadap_kinerja_organisasi')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label
            for="penugasan-yang-terkait-dengan-pembelajaran">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</label>
        <input type="text" name="penugasan_yang_terkait_dengan_pembelajaran"
            id="penugasan-yang-terkait-dengan-pembelajaran"
            class="form-control @error('penugasan_yang_terkait_dengan_pembelajaran') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran : old('penugasan_yang_terkait_dengan_pembelajaran') }}"
            placeholder="{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}" required />
        @error('penugasan_yang_terkait_dengan_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="skill-group-owner">{{ __('Skill Group Owner') }}</label>
        <input type="text" name="skill_group_owner" id="skill-group-owner"
            class="form-control @error('skill_group_owner') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->skill_group_owner : old('skill_group_owner') }}"
            placeholder="{{ __('Skill Group Owner') }}" required />
        @error('skill_group_owner')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>



    <div class="col-md-6 mb-2">
        <label for="sasaran-pesertum">{{ __('Sasaran Peserta') }}</label>
        <input type="text" name="sasaran_peserta" id="sasaran-pesertum"
            class="form-control @error('sasaran_peserta') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}"
            placeholder="{{ __('Sasaran Peserta') }}" required />
        @error('sasaran_peserta')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="kriteria-pesertum">{{ __('Kriteria Peserta') }}</label>
        <input type="text" name="kriteria_peserta" id="kriteria-pesertum"
            class="form-control @error('kriteria_peserta') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : old('kriteria_peserta') }}"
            placeholder="{{ __('Kriteria Peserta') }}" required />
        @error('kriteria_peserta')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="aktivitas-prapembelajaran">{{ __('Aktivitas Prapembelajaran') }}</label>
        <input type="text" name="aktivitas_prapembelajaran" id="aktivitas-prapembelajaran"
            class="form-control @error('aktivitas_prapembelajaran') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->aktivitas_prapembelajaran : old('aktivitas_prapembelajaran') }}"
            placeholder="{{ __('Aktivitas Prapembelajaran') }}" required />
        @error('aktivitas_prapembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="sertifikat">{{ __('Sertifikat') }}</label>
        <input type="text" name="sertifikat" id="sertifikat"
            class="form-control @error('sertifikat') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}"
            placeholder="{{ __('Sertifikat') }}" required />
        @error('sertifikat')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="bentuk-pembelajaran">{{ __('Bentuk Pembelajaran') }}</label>
        <select class="form-control js-example-basic-multiple @error('bentuk_pembelajaran') is-invalid @enderror"
            name="bentuk_pembelajaran" id="bentuk-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select bentuk pembelajaran') }} --</option>
            <option value="Klasikal"
                {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Klasikal' ? 'selected' : (old('bentuk_pembelajaran') == 'Klasikal' ? 'selected' : '') }}>
                Klasikal</option>
            <option value="Nonklasikal"
                {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Nonklasikal' ? 'selected' : (old('bentuk_pembelajaran') == 'Nonklasikal' ? 'selected' : '') }}>
                Nonklasikal</option>
        </select>
        @error('bentuk_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="jalur-pembelajaran">{{ __('Jalur Pembelajaran') }}</label>
        <select class="form-control js-example-basic-multiple @error('jalur_pembelajaran') is-invalid @enderror"
            name="jalur_pembelajaran" id="jalur-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select jalur pembelajaran') }} --</option>
            @foreach ($jalur_pembelajaran as $row)
                <option value="{{ $row }}"
                    {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == $row ? 'selected' : (old('jalur_pembelajaran') == $row ? 'selected' : '') }}>
                    {{ $row }}
                </option>
            @endforeach
        </select>
        @error('jalur_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="model-pembelajaran">{{ __('Model Pembelajaran') }}</label>
        <select class="form-control js-example-basic-multiple @error('model_pembelajaran') is-invalid @enderror"
            name="model_pembelajaran" id="model-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select model pembelajaran') }} --</option>
            <option value="Pembelajaran terstruktur"
                {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Pembelajaran terstruktur' ? 'selected' : (old('model_pembelajaran') == 'Pembelajaran terstruktur' ? 'selected' : '') }}>
                Pembelajaran terstruktur</option>
            <option value="Pembelajaran kolaboratif"
                {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Pembelajaran kolaboratif' ? 'selected' : (old('model_pembelajaran') == 'Pembelajaran kolaboratif' ? 'selected' : '') }}>
                Pembelajaran kolaboratif</option>
            <option value="Pembelajaran di tempat kerja"
                {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Pembelajaran di tempat kerja' ? 'selected' : (old('model_pembelajaran') == 'Pembelajaran di tempat kerja' ? 'selected' : '') }}>
                Pembelajaran di tempat kerja</option>
            <option value="Pembelajaran terintegrasi"
                {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Pembelajaran terintegrasi' ? 'selected' : (old('model_pembelajaran') == 'Pembelajaran terintegrasi' ? 'selected' : '') }}>
                Pembelajaran terintegrasi</option>
        </select>
        @error('model_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="jenis-pembelajaran">{{ __('Jenis Pembelajaran') }}</label>
        <select class="form-control js-example-basic-multiple @error('jenis_pembelajaran') is-invalid @enderror"
            name="jenis_pembelajaran" id="jenis-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select jenis pembelajaran') }} --</option>
            <option value="Kedinasan"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Kedinasan' ? 'selected' : (old('jenis_pembelajaran') == 'Kedinasan' ? 'selected' : '') }}>
                Kedinasan</option>
            <option value="Fungsional auditor"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Fungsional auditor' ? 'selected' : (old('jenis_pembelajaran') == 'Fungsional auditor' ? 'selected' : '') }}>
                Fungsional auditor</option>
            <option value="Teknis substansi"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Teknis substansi' ? 'selected' : (old('jenis_pembelajaran') == 'Teknis substansi' ? 'selected' : '') }}>
                Teknis substansi</option>
            <option value="Sertifikasi non JFA"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Sertifikasi non JFA' ? 'selected' : (old('jenis_pembelajaran') == 'Sertifikasi non JFA' ? 'selected' : '') }}>
                Sertifikasi non JFA</option>
        </select>
        @error('jenis_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="metode-pembelajaran">{{ __('Metode Pembelajaran') }}</label>
        <select class="form-control js-example-basic-multiple @error('metode_pembelajaran') is-invalid @enderror"
            name="metode_pembelajaran" id="metode-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select metode pembelajaran') }} --</option>
            <option value="Synchronous learning"
                {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'Synchronous learning' ? 'selected' : (old('metode_pembelajaran') == 'Synchronous learning' ? 'selected' : '') }}>
                Synchronous learning</option>
            <option value="Asynchronous learning"
                {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'Asynchronous learning' ? 'selected' : (old('metode_pembelajaran') == 'Asynchronous learning' ? 'selected' : '') }}>
                Asynchronous learning</option>
            <option value="Blended learning"
                {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'Blended learning' ? 'selected' : (old('metode_pembelajaran') == 'Blended learning' ? 'selected' : '') }}>
                Blended learning</option>
        </select>
        @error('metode_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label for="penyelenggara-pembelajaran">{{ __('Penyelenggara Pembelajaran') }}</label>
        <select
            class="form-control js-example-basic-multiple @error('penyelenggara_pembelajaran') is-invalid @enderror"
            name="penyelenggara_pembelajaran" id="penyelenggara-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select penyelenggara pembelajaran') }} --</option>
            <option value="Pusdiklatwas BPKP"
                {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Pusdiklatwas BPKP' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Pusdiklatwas BPKP' ? 'selected' : '') }}>
                Pusdiklatwas BPKP</option>
            <option value="Unit kerja"
                {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Unit kerja' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Unit kerja' ? 'selected' : '') }}>
                Unit kerja</option>
            <option value="Lainnya"
                {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Lainnya' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Lainnya' ? 'selected' : '') }}>
                Lainnya</option>
        </select>
        @error('penyelenggara_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-3 mb-2">
        <label>{{ __('Fasilitator Pembelajaran') }}</label>
        <div>
            @foreach(['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya'] as $fasilitator)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitator_pembelajaran[]" id="fasilitator_{{ $fasilitator }}"
                           value="{{ $fasilitator }}"
                           {{ isset($pengajuanKap) ? (in_array($fasilitator, json_decode($pengajuanKap->fasilitator_pembelajaran)) ? 'checked' : '') : (in_array($fasilitator, old('fasilitator_pembelajaran', [])) ? 'checked' : '') }}>
                    <label class="form-check-label" for="fasilitator_{{ $fasilitator }}">
                        {{ $fasilitator }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('fasilitator_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
