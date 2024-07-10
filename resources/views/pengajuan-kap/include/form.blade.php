<div class="modal fade" id="indikatorModal" tabindex="-1" aria-labelledby="indikatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="indikatorModalLabel">Pilih Indikator Kinerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal body content goes here -->
                <!-- Example: List of indicators -->
                <ul>
                    <li>Indikator 1</li>
                    <li>Indikator 2</li>
                    <li>Indikator 3</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


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

    <div class="tab-content" style="overflow: auto">
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="display: none;">
            <form id="form-1" style="margin-top: 20px">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="jenis_program" class="col-sm-3 col-form-label">{{ __('Jenis Program') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('jenis_program') is-invalid @enderror"
                                name="jenis_program" id="jenis_program" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="indikator_kinerja"
                            class="col-sm-3 col-form-label">{{ __('Indikator Kinerja') }}</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" name="indikator_kinerja" id="indikator_kinerja"
                                    class="form-control @error('indikator_kinerja') is-invalid @enderror"
                                    value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_kinerja : old('indikator_kinerja') }}"
                                    placeholder="" required />
                                <span class="input-group-text btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#indikatorModal" style="cursor: pointer;">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Pilih
                                </span>
                                <div class="invalid-feedback">
                                    Mohon untuk diisi Indikator Kinerja
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kompetensi_id" class="col-sm-3 col-form-label">{{ __('Kompetensi') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('kompetensi_id') is-invalid @enderror"
                                name="kompetensi_id" id="kompetensi_id" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="topik_id" class="col-sm-3 col-form-label">{{ __('Topik Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('topik_id') is-invalid @enderror"
                                name="topik_id" id="topik_id" required>
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
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">{{ __('Concern Program Pembelajaran') }}</label>
                        <div class="col-sm-6"></div>
                    </div>

                    <div class="form-group row mb-1">
                        <label for="arahan_pimpinan" style="padding-left: 40px"
                            class="col-sm-3 col-form-label">{{ __('A. Arahan pimpinan/isu terkini/dll') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="arahan_pimpinan" id="arahan_pimpinan"
                                class="form-control @error('arahan_pimpinan') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->arahan_pimpinan : old('arahan_pimpinan') }}"
                                placeholder="{{ __('Arahan pimpinan/isu terkini/dll') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Arahan pimpinan/isu terkini/dll
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="prioritas_pembelajaran" style="padding-left: 40px"
                            class="col-sm-3 col-form-label">
                            {{ __('B. Prioritas Pembelajaran') }}
                        </label>
                        <div class="col-sm-6">
                            <select name="prioritas_pembelajaran" id="prioritas_pembelajaran"
                                class="form-control js-example-basic-multiple @error('prioritas_pembelajaran') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>
                                    {{ __('-- Select Prioritas Pembelajaran --') }}</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="Prioritas {{ $i }}"
                                        {{ (isset($pengajuanKap) && $pengajuanKap->prioritas_pembelajaran == $i) || old('prioritas_pembelajaran') == $i ? 'selected' : '' }}>
                                        Prioritas {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Prioritas Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="tujuan_program_pembelajaran">{{ __('Tujuan Program Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="tujuan_program_pembelajaran" id="tujuan_program_pembelajaran"
                                class="form-control @error('tujuan_program_pembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->tujuan_program_pembelajaran : old('tujuan_program_pembelajaran') }}"
                                placeholder="{{ __('Tujuan Program Pembelajaran') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Tujuan Program Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="tujuan_program_pembelajaran">{{ __('Indikator Keberhasilan') }}</label>
                        <div class="col-sm-6">
                            <table class="table table-bordered table-sm text-center">
                                <thead style="background-color: #cbccce">
                                    <tr>
                                        <th>#</th>
                                        <th>Peserta Mampu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td><input type="text" name="indikator_keberhasilan[]"
                                                class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="indikator-dampak-terhadap-kinerja-organisasi">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="indikator_dampak_terhadap_kinerja_organisasi"
                                id="indikator-dampak-terhadap-kinerja-organisasi"
                                class="form-control @error('indikator_dampak_terhadap_kinerja_organisasi') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi : old('indikator_dampak_terhadap_kinerja_organisasi') }}"
                                placeholder="{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Indikator Dampak Terhadap Kinerja Organisasi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="penugasan-yang-terkait-dengan-pembelajaran">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="penugasan_yang_terkait_dengan_pembelajaran"
                                id="penugasan-yang-terkait-dengan-pembelajaran"
                                class="form-control @error('penugasan_yang_terkait_dengan_pembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran : old('penugasan_yang_terkait_dengan_pembelajaran') }}"
                                placeholder="{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}" required />

                            <div class="invalid-feedback">
                                Mohon untuk diisi Penugasan Yang Terkait Dengan Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="skill-group-owner">{{ __('Skill Group Owner') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="skill_group_owner" id="skill-group-owner"
                                class="form-control @error('skill_group_owner') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->skill_group_owner : old('skill_group_owner') }}"
                                placeholder="{{ __('Skill Group Owner') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Skill Group Owner
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" style="display: none;">
            <form id="form-2" style="margin-top: 20px">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="alokasi-waktu" class="col-sm-3 col-form-label">{{ __('Alokasi Waktu') }}</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="number" name="alokasi_waktu" id="alokasi-waktu"
                                    class="form-control @error('alokasi_waktu') is-invalid @enderror"
                                    value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}"
                                    placeholder="{{ __('Alokasi Waktu') }}" required />
                                <span class="input-group-text">Hari</span>
                                <div class="invalid-feedback">
                                    Mohon untuk diisi Alokasi Waktu
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                            <div class="table-responsive">

                                <table class="table table-bordered table-sm" id="dynamic_field">
                                    <thead>
                                        <tr>
                                            <th>Lokasi</th>
                                            <th>Tgl Mulai</th>
                                            <th>Tgl Selesai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <select name="tempat_acara[]"
                                                class="form-control @error('lokasi') is-invalid @enderror" required>
                                                <option value="" selected disabled>-- Pilih --</option>
                                                @foreach ($lokasiData as $lokasi)
                                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="date" name="tanggal_mulai[]"
                                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                required /></td>
                                        <td><input type="date" name="tanggal_selesai[]"
                                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                required /></td>
                                        <td><button type="button" name="add_photo" id="add_photo"
                                                class="btn btn-success"><i class="fa fa-plus"
                                                    aria-hidden="true"></i></button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="bentuk_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Bentuk Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('bentuk_pembelajaran') is-invalid @enderror"
                                name="bentuk_pembelajaran" id="bentuk_pembelajaran" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="jalur_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Jalur Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('jalur_pembelajaran') is-invalid @enderror"
                                name="jalur_pembelajaran" id="jalur_pembelajaran" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="model_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Model Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('model_pembelajaran') is-invalid @enderror"
                                name="model_pembelajaran" id="model_pembelajaran" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="jenis_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Jenis Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('jenis_pembelajaran') is-invalid @enderror"
                                name="jenis_pembelajaran" id="jenis_pembelajaran" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="metode_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Metode Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('metode_pembelajaran') is-invalid @enderror"
                                name="metode_pembelajaran" id="metode_pembelajaran" required>
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
                        </div>
                    </div>


                </div>
            </form>
        </div>

        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
            <form id="form-3" style="margin-top: 20px">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="sasaran_peserta"
                            class="col-sm-3 col-form-label">{{ __('Sasaran Peserta') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="sasaran_peserta" id="sasaran_peserta"
                                class="form-control @error('sasaran_peserta') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}"
                                placeholder="{{ __('Sasaran Peserta') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sasaran Peserta
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kriteria_peserta"
                            class="col-sm-3 col-form-label">{{ __('Kriteria Peserta') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="kriteria_peserta" id="kriteria_peserta"
                                class="form-control @error('kriteria_peserta') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : old('kriteria_peserta') }}"
                                placeholder="{{ __('Sasaran Peserta') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sasaran Peserta
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="aktivitas_prapembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Aktivitas Prapembelajaran') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="aktivitas_prapembelajaran" id="aktivitas_prapembelajaran"
                                class="form-control @error('aktivitas_prapembelajaran') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->aktivitas_prapembelajaran : old('aktivitas_prapembelajaran') }}"
                                placeholder="{{ __('Aktivitas Prapembelajaran') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Aktivitas Prapembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="penyelenggara_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Penyelenggara Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('penyelenggara_pembelajaran') is-invalid @enderror"
                                name="penyelenggara_pembelajaran" id="penyelenggara_pembelajaran" required>
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
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('Fasilitator Pembelajaran') }}</label>
                        <div class="col-sm-6">
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
                            <div class="invalid-feedback" id="invalid-fasilitator" style="display: none;">
                                Mohon untuk pilih Fasilitator Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="sertifikat" class="col-sm-3 col-form-label">{{ __('Sertifikat') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="sertifikat" id="sertifikat"
                                class="form-control @error('sertifikat') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}"
                                placeholder="{{ __('Sertifikat') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sertifikat
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="level_evaluasi_instrumen"
                            class="col-sm-3 col-form-label">{{ __('Level Evaluasi dan Instrumennya') }}</label>
                        <div class="col-sm-6">
                            <table class="table table-bordered table-sm text-center">
                                <thead style="background-color: #cbccce">
                                    <tr>
                                        <th>Level</th>
                                        <th>Instrumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <input type="hidden" name="no_level[]" value="1"
                                                class="form-control @error('no_level') is-invalid @enderror" />

                                            <input type="text" name="level_evaluasi_instrumen[]"
                                                class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="hidden" name="no_level[]" value="2"
                                                class="form-control @error('no_level') is-invalid @enderror" /><input
                                                type="text" name="level_evaluasi_instrumen[]"
                                                class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="hidden" name="no_level[]" value="3"
                                                class="form-control @error('no_level') is-invalid @enderror" /><input
                                                type="text" name="level_evaluasi_instrumen[]"
                                                class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="hidden" name="no_level[]" value="4"
                                                class="form-control @error('no_level') is-invalid @enderror" /><input
                                                type="text" name="level_evaluasi_instrumen[]"
                                                class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="hidden" name="no_level[]" value="5"
                                                class="form-control @error('no_level') is-invalid @enderror" /><input
                                                type="text" name="level_evaluasi_instrumen[]"
                                                class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="sw-toolbar-elm toolbar toolbar-bottom"><button class="btn sw-btn-prev sw-btn disabled"
            type="button">Previous</button><button class="btn sw-btn-next sw-btn"
            type="button">Next</button><button class="btn btn-success" id="btnFinish" disabled=""
            onclick="onConfirm()">Submit</button>
    </div>
</div>
