@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
@endpush

<div id="smartwizard" dir="" class="sw sw-theme-arrows sw-justified">
    <ul class="nav nav-progress">
        <li class="nav-item">
            <a class="nav-link default active" href="#step-1">
                <div class="num">1</div>
                Konteks Pembelajaran
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link default" href="#step-2">
                <span class="num">2</span>
                Detil Pembelajaran
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link default" href="#step-3">
                <span class="num">3</span>
                Penyelenggaraan Pembelajaran
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="display: none;">
            <form id="form-1" style="margin-top: 40px">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="jenis-program" class="col-sm-4 col-form-label">{{ __('Jenis Program') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('jenis_program') is-invalid @enderror"
                                name="jenis_program" id="jenis-program" required>
                                <option value="" selected disabled>-- {{ __('Select jenis program') }} --</option>
                                @foreach ($jenis_program as $program)
                                    <option value="{{ $program }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == $program ? 'selected' : (old('jenis_program') == $program ? 'selected' : '') }}>
                                        {{ $program }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Jenis Program
                            </div>
                            @error('jenis_program')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="indikator-kinerja"
                            class="col-sm-4 col-form-label">{{ __('Indikator Kinerja') }}</label>

                        <div class="col-sm-8">
                            <input type="text" name="indikator_kinerja" id="indikator-kinerja"
                                class="form-control @error('indikator_kinerja') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_kinerja : old('indikator_kinerja') }}"
                                placeholder="{{ __('Indikator Kinerja') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Indikator Kinerja
                            </div>
                            @error('indikator_kinerja')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kompetensi-id" class="col-sm-4 col-form-label">{{ __('Kompetensi') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('kompetensi_id') is-invalid @enderror"
                                name="kompetensi_id" id="kompetensi-id" required>
                                <option value="" selected disabled>-- {{ __('Select kompetensi') }} --</option>
                                @foreach ($kompetensis as $kompetensi)
                                    <option value="{{ $kompetensi->id }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->kompetensi_id == $kompetensi->id ? 'selected' : (old('kompetensi_id') == $kompetensi->id ? 'selected' : '') }}>
                                        {{ $kompetensi->nama_kompetensi }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Kompetensi
                            </div>
                            @error('kompetensi_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="topik-id" class="col-sm-4 col-form-label">{{ __('Topik Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('topik_id') is-invalid @enderror"
                                name="topik_id" id="topik-id" required>
                                <option value="" selected disabled>-- {{ __('Select topik pembelajaran') }} --
                                </option>
                                @foreach ($topiks as $topik)
                                    <option value="{{ $topik->id }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->topik_id == $topik->id ? 'selected' : (old('topik_id') == $topik->id ? 'selected' : '') }}>
                                        {{ $topik->nama_topik }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Topik Pembelajaran
                            </div>
                            @error('topik_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="concern-program-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Concern Program Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="concern_program_pembelajaran" id="concern-program-pembelajaran"
                                class="form-control @error('concern_program_pembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->concern_program_pembelajaran : old('concern_program_pembelajaran') }}"
                                placeholder="{{ __('Concern Program Pembelajaran') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Concern Program Pembelajaran
                            </div>

                            @error('concern_program_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label"
                            for="tujuan_program_pembelajaran">{{ __('Tujuan Program Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="tujuan_program_pembelajaran" id="tujuan_program_pembelajaran"
                                class="form-control @error('tujuan_program_pembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->tujuan_program_pembelajaran : old('tujuan_program_pembelajaran') }}"
                                placeholder="{{ __('Tujuan Program Pembelajaran') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Tujuan Program Pembelajaran
                            </div>

                            @error('tujuan_program_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label"
                            for="indikator-dampak-terhadap-kinerja-organisasi">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="indikator_dampak_terhadap_kinerja_organisasi"
                                id="indikator-dampak-terhadap-kinerja-organisasi"
                                class="form-control @error('indikator_dampak_terhadap_kinerja_organisasi') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi : old('indikator_dampak_terhadap_kinerja_organisasi') }}"
                                placeholder="{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Indikator Dampak Terhadap Kinerja Organisasi
                            </div>

                            @error('indikator_dampak_terhadap_kinerja_organisasi')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label"
                            for="penugasan-yang-terkait-dengan-pembelajaran">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="penugasan_yang_terkait_dengan_pembelajaran"
                                id="penugasan-yang-terkait-dengan-pembelajaran"
                                class="form-control @error('penugasan_yang_terkait_dengan_pembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran : old('penugasan_yang_terkait_dengan_pembelajaran') }}"
                                placeholder="{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}" required />

                            <div class="invalid-feedback">
                                Mohon untuk diisi Penugasan Yang Terkait Dengan Pembelajaran
                            </div>

                            @error('penugasan_yang_terkait_dengan_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label"
                            for="skill-group-owner">{{ __('Skill Group Owner') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="skill_group_owner" id="skill-group-owner"
                                class="form-control @error('skill_group_owner') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->skill_group_owner : old('skill_group_owner') }}"
                                placeholder="{{ __('Skill Group Owner') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Skill Group Owner
                            </div>
                            @error('skill_group_owner')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" style="display: none;">
            <form id="form-2" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate="">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="alokasi-waktu" class="col-sm-4 col-form-label">{{ __('Alokasi Waktu') }}</label>

                        <div class="col-sm-8">
                            <input type="text" name="alokasi_waktu" id="skill-group-owner"
                                class="form-control @error('alokasi_waktu') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}"
                                placeholder="{{ __('Alokasi Waktu') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Alokasi Waktu
                            </div>
                            @error('alokasi_waktu')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="bentuk-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Bentuk Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('bentuk_pembelajaran') is-invalid @enderror"
                                name="bentuk_pembelajaran" id="bentuk-pembelajaran" required>
                                <option value="" selected disabled>-- {{ __('Select bentuk pembelajaran') }}
                                    --
                                </option>
                                <option value="Klasikal"
                                    {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Klasikal' ? 'selected' : (old('bentuk_pembelajaran') == 'Klasikal' ? 'selected' : '') }}>
                                    Klasikal</option>
                                <option value="Nonklasikal"
                                    {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Nonklasikal' ? 'selected' : (old('bentuk_pembelajaran') == 'Nonklasikal' ? 'selected' : '') }}>
                                    Nonklasikal</option>
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Bentuk Pembelajaran
                            </div>
                            @error('bentuk_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="jalur-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Jalur Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('jalur_pembelajaran') is-invalid @enderror"
                                name="jalur_pembelajaran" id="jalur-pembelajaran" required>
                                <option value="" selected disabled>-- {{ __('Select jalur pembelajaran') }}
                                    --
                                </option>
                                @foreach ($jalur_pembelajaran as $row)
                                    <option value="{{ $row }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == $row ? 'selected' : (old('jalur_pembelajaran') == $row ? 'selected' : '') }}>
                                        {{ $row }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Jalur Pembelajaran
                            </div>
                            @error('jalur_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="model-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Model Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('model_pembelajaran') is-invalid @enderror"
                                name="model_pembelajaran" id="model-pembelajaran" required>
                                <option value="" selected disabled>-- {{ __('Select model pembelajaran') }}
                                    --
                                </option>
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
                            <div class="invalid-feedback">
                                Mohon untuk pilih Model Pembelajaran
                            </div>
                            @error('model_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="jenis-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Jenis Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('jenis_pembelajaran') is-invalid @enderror"
                                name="jenis_pembelajaran" id="jenis-pembelajaran" required>
                                <option value="" selected disabled>-- {{ __('Select jenis pembelajaran') }}
                                    --
                                </option>
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
                            <div class="invalid-feedback">
                                Mohon untuk pilih Jenis Pembelajaran
                            </div>
                            @error('jenis_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="metode-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Metode Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('metode_pembelajaran') is-invalid @enderror"
                                name="metode_pembelajaran" id="metode-pembelajaran" required>
                                <option value="" selected disabled>-- {{ __('Select metode pembelajaran') }}
                                    --
                                </option>
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
                            <div class="invalid-feedback">
                                Mohon untuk pilih Metode Pembelajaran
                            </div>
                            @error('metode_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
            <form id="form-3" class="row row-cols-1 ms-5 me-5 needs-validation" novalidate="">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="sasaran-pesertum"
                            class="col-sm-4 col-form-label">{{ __('Sasaran Peserta') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="sasaran_peserta" id="sasaran-pesertum"
                                class="form-control @error('sasaran_peserta') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}"
                                placeholder="{{ __('Sasaran Peserta') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sasaran Peserta
                            </div>

                            @error('sasaran_peserta')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="aktivitas-prapembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Aktivitas Prapembelajaran') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="kriteria_peserta" id="kriteria-pesertum"
                                class="form-control @error('kriteria_peserta') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : old('kriteria_peserta') }}"
                                placeholder="{{ __('Kriteria Peserta') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Aktivitas Prapembelajaran
                            </div>
                            @error('kriteria_peserta')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="penyelenggara-pembelajaran"
                            class="col-sm-4 col-form-label">{{ __('Penyelenggara Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            <select
                                class="form-control js-example-basic-multiple @error('penyelenggara_pembelajaran') is-invalid @enderror"
                                name="penyelenggara_pembelajaran" id="penyelenggara-pembelajaran" required>
                                <option value="" selected disabled>--
                                    {{ __('Select penyelenggara pembelajaran') }} --</option>
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
                            <div class="invalid-feedback">
                                Mohon untuk pilih Penyelenggara Pembelajaran
                            </div>
                            @error('penyelenggara_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('Fasilitator Pembelajaran') }}</label>
                        <div class="col-sm-8">
                            @foreach (['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya'] as $fasilitator)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fasilitator_pembelajaran[]"
                                        id="fasilitator_{{ $fasilitator }}" value="{{ $fasilitator }}"
                                        {{ isset($pengajuanKap) ? (in_array($fasilitator, json_decode($pengajuanKap->fasilitator_pembelajaran)) ? 'checked' : '') : (in_array($fasilitator, old('fasilitator_pembelajaran', [])) ? 'checked' : '') }}>
                                    <label class="form-check-label" for="fasilitator_{{ $fasilitator }}">
                                        {{ $fasilitator }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="invalid-feedback">
                                Mohon untuk pilih Fasilitator Pembelajaran
                            </div>
                            @error('fasilitator_pembelajaran')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="sertifikat" class="col-sm-4 col-form-label">{{ __('Sertifikat') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="sertifikat" id="sertifikat"
                                class="form-control @error('sertifikat') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}"
                                placeholder="{{ __('Sertifikat') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sertifikat
                            </div>
                            @error('sertifikat')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="sw-toolbar-elm toolbar toolbar-bottom" role="toolbar"><button class="btn sw-btn-prev sw-btn disabled"
            type="button">Previous</button><button class="btn sw-btn-next sw-btn"
            type="button">Next</button><button class="btn btn-success" id="btnFinish" disabled=""
            onclick="onConfirm()">Submit</button>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Order Placed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Congratulations! Your order is placed.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal()">Ok, close and reset</button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script src="https://techlaboratory.net/projects/demo/jquery-smart-wizard/v6/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
    </script>
    <script type="text/javascript">
        const myModal = new bootstrap.Modal(document.getElementById('confirmModal'));

        function onConfirm() {
            let form = document.getElementById('form-3');
            if (form) {
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    $('#smartwizard').smartWizard("setState", [3], 'error');
                    $("#smartwizard").smartWizard('fixHeight');
                    return false;
                }

                myModal.show();
            }
        }

        function closeModal() {
            // Reset wizard
            $('#smartwizard').smartWizard("reset");

            // Reset form
            document.getElementById("form-1").reset();
            document.getElementById("form-2").reset();
            document.getElementById("form-3").reset();
            myModal.hide();
        }

        $(function() {
            // Leave step event is used for validating the forms
            $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIdx, nextStepIdx,
                stepDirection) {
                // Validate only on forward movement
                if (stepDirection == 'forward') {
                    let form = document.getElementById('form-' + (currentStepIdx + 1));
                    if (form) {
                        if (!form.checkValidity()) {
                            form.classList.add('was-validated');
                            $('#smartwizard').smartWizard("setState", [currentStepIdx], 'error');
                            $("#smartwizard").smartWizard('fixHeight');
                            return false;
                        }
                        $('#smartwizard').smartWizard("unsetState", [currentStepIdx], 'error');
                    }
                }
            });

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
                $("#prev-btn").removeClass('disabled').prop('disabled', false);
                $("#next-btn").removeClass('disabled').prop('disabled', false);
                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled').prop('disabled', true);
                } else if (stepPosition === 'last') {
                    $("#next-btn").addClass('disabled').prop('disabled', true);
                } else {
                    $("#prev-btn").removeClass('disabled').prop('disabled', false);
                    $("#next-btn").removeClass('disabled').prop('disabled', false);
                }

                // Get step info from Smart Wizard
                let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
                $("#sw-current-step").text(stepInfo.currentStep + 1);
                $("#sw-total-step").text(stepInfo.totalSteps);

                if (stepPosition == 'last') {
                    $("#btnFinish").prop('disabled', false);
                } else {
                    $("#btnFinish").prop('disabled', true);
                }

                // Focus first name
                if (stepIndex == 1) {
                    setTimeout(() => {
                        $('#first-name').focus();
                    }, 0);
                }
            });

            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                // autoAdjustHeight: false,
                theme: 'arrows', // basic, arrows, square, round, dots
                transition: {
                    animation: 'none'
                },
                toolbar: {
                    showNextButton: true, // show/hide a Next button
                    showPreviousButton: true, // show/hide a Previous button
                    position: 'bottom', // none/ top/ both bottom
                    extraHtml: `<button class="btn btn-success" id="btnFinish" disabled onclick="onConfirm()">Submit</button>`
                },
                anchor: {
                    enableNavigation: true, // Enable/Disable anchor navigation
                    enableNavigationAlways: false, // Activates all anchors clickable always
                    enableDoneState: true, // Add done state on visited steps
                    markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    unDoneOnBackNavigation: true, // While navigate back, done state will be cleared
                    enableDoneStateNavigation: true // Enable/Disable the done state navigation
                },
            });

            $("#state_selector").on("change", function() {
                $('#smartwizard').smartWizard("setState", [$('#step_to_style').val()], $(this).val(), !$(
                    '#is_reset').prop("checked"));
                return true;
            });

            $("#style_selector").on("change", function() {
                $('#smartwizard').smartWizard("setStyle", [$('#step_to_style').val()], $(this).val(), !$(
                    '#is_reset').prop("checked"));
                return true;
            });

        });
    </script>
@endpush
