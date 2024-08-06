<div class="modal fade" id="indikatorModal" tabindex="-1" aria-labelledby="indikatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="indikatorModalLabel">Pilih Indikator Kinerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten modal akan dimuat di sini oleh AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                Peserta dan Fasilitator
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
                        <label for="indikator_kinerja" class="col-sm-3 col-form-label">Indikator Kinerja</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" name="indikator_kinerja" id="indikator_kinerja"
                                    class="form-control" placeholder="" required readonly />
                                <button type="button" id="pilihButton" class="input-group-text btn btn-success">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Pilih
                                </button>
                                <div class="invalid-feedback">
                                    Mohon diisi Indikator Kinerja.
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
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Kompetensi
                            </div>
                            <div id="kompetensi-description" class="mt-2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="topik_id" class="col-sm-3 col-form-label">{{ __('Program pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('topik_id') is-invalid @enderror"
                                name="topik_id" id="topik_id" required>
                                <option value="" selected disabled>-- {{ __('Select program pembelajaran') }} --
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih program pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="judul">{{ __('Judul Program Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="judul" id="judul"
                                class="form-control @error('judul') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->judul : old('judul') }}"
                                placeholder="{{ __('Judul Program Pembelajaran') }}" required />
                            <div class="invalid-feedback">
                                Mohon untuk diisi Judul Program Pembelajaran
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
                                        {{ (isset($pengajuanKap) && $pengajuanKap->prioritas_pembelajaran == "Prioritas $i") || old('prioritas_pembelajaran') == "Prioritas $i" ? 'selected' : '' }}>
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
                                    @if (isset($pengajuanKap))
                                        @foreach ($indikator_keberhasilan_kap as $row)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <input type="text" name="indikator_keberhasilan[]"
                                                        value="{{ $row->indikator_keberhasilan }}"
                                                        class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @for ($i = 1; $i <= 10; $i++)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <input type="text" name="indikator_keberhasilan[]"
                                                        class="form-control @error('indikator_keberhasilan') is-invalid @enderror" />
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
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
                    <div class="form-group row mb-1">
                        <label for="alokasi-waktu" class="col-sm-3 col-form-label">{{ __('Alokasi Waktu') }}</label>
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
                                    <tbody id="waktu_tempat_table">
                                        @if (isset($pengajuanKap))
                                            @foreach ($waktu_tempat as $row)
                                                <tr id="detail_file{{ $row->id }}">
                                                    <td>
                                                        <select name="tempat_acara[]"
                                                            class="form-control @error('lokasi') is-invalid @enderror"
                                                            required>
                                                            <option value="" selected disabled>-- Pilih --
                                                            </option>
                                                            @foreach ($lokasiData as $lokasi)
                                                                <option value="{{ $lokasi->id }}"
                                                                    {{ $lokasi->id == $row->lokasi_id ? 'selected' : '' }}>
                                                                    {{ $lokasi->nama_lokasi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="date" name="tanggal_mulai[]"
                                                            value="{{ $row->tanggal_mulai }}"
                                                            class="form-control @error('tanggal_mulai') is-invalid @enderror tanggal_mulai"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="date" name="tanggal_selesai[]"
                                                            value="{{ $row->tanggal_selesai }}"
                                                            class="form-control @error('tanggal_selesai') is-invalid @enderror tanggal_selesai"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <button type="button" id="{{ $row->id }}"
                                                            class="btn btn-danger btn_remove_data">X</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr id="placeholder_row">
                                            <td>
                                                <select name="tempat_acara[]"
                                                    class="form-control @error('lokasi') is-invalid @enderror"
                                                    @if (!isset($pengajuanKap)) required @endif>
                                                    <option value="" selected disabled>-- Pilih --</option>
                                                    @foreach ($lokasiData as $lokasi)
                                                        <option value="{{ $lokasi->id }}">
                                                            {{ $lokasi->nama_lokasi }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="tanggal_mulai[]"
                                                    class="form-control @error('tanggal_mulai') is-invalid @enderror tanggal_mulai"
                                                    @if (!isset($pengajuanKap)) required @endif />
                                            </td>
                                            <td>
                                                <input type="date" name="tanggal_selesai[]"
                                                    class="form-control @error('tanggal_selesai') is-invalid @enderror tanggal_selesai"
                                                    @if (!isset($pengajuanKap)) required @endif />
                                            </td>
                                            <td>
                                                <button type="button" name="add_waktu_tempat" id="add_waktu_tempat"
                                                    class="btn btn-success"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="number" name="alokasi_waktu" id="alokasi-waktu"
                                    class="form-control @error('alokasi_waktu') is-invalid @enderror"
                                    value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}"
                                    placeholder="{{ __('Alokasi Waktu') }}" required readonly />
                                <span class="input-group-text">Hari</span>
                                <div class="invalid-feedback">
                                    Mohon untuk diisi Alokasi Waktu
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="bentuk_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Bentuk Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('bentuk_pembelajaran') is-invalid @enderror"
                                name="bentuk_pembelajaran" id="bentuk_pembelajaran">
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
                                name="jalur_pembelajaran" id="jalur_pembelajaran">
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
                        <label for="jenjang_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Jenjang Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('jenjang_pembelajaran') is-invalid @enderror"
                                name="jenjang_pembelajaran" id="jenjang_pembelajaran">
                                <option value="" selected disabled>-- {{ __('Select jenjang pembelajaran') }} --
                                </option>
                                <option value="CPNS"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'CPNS' ? 'selected' : (old('jenjang_pembelajaran') == 'CPNS' ? 'selected' : '') }}>
                                    CPNS</option>
                                <option value="P3K"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'P3K' ? 'selected' : (old('jenjang_pembelajaran') == 'P3K' ? 'selected' : '') }}>
                                    P3K</option>
                                <option value="PKN I"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'PKN I' ? 'selected' : (old('jenjang_pembelajaran') == 'PKN I' ? 'selected' : '') }}>
                                    PKN I</option>
                                <option value="PKN II"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'PKN II' ? 'selected' : (old('jenjang_pembelajaran') == 'PKN II' ? 'selected' : '') }}>
                                    PKN II</option>
                                <option value="Kepemimpinan Administrator"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Kepemimpinan Administrator' ? 'selected' : (old('jenjang_pembelajaran') == 'Kepemimpinan Administrator' ? 'selected' : '') }}>
                                    Kepemimpinan Administrator</option>
                                <option value="Kepemimpinan Pengawas"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Kepemimpinan Pengawas' ? 'selected' : (old('jenjang_pembelajaran') == 'Kepemimpinan Pengawas' ? 'selected' : '') }}>
                                    Kepemimpinan Pengawas</option>
                                <option value="Penjenjangan Auditor Utama"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Penjenjangan Auditor Utama' ? 'selected' : (old('jenjang_pembelajaran') == 'Penjenjangan Auditor Utama' ? 'selected' : '') }}>
                                    Penjenjangan Auditor Utama</option>
                                <option value="Penjenjangan Auditor Madya"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Penjenjangan Auditor Madya' ? 'selected' : (old('jenjang_pembelajaran') == 'Penjenjangan Auditor Madya' ? 'selected' : '') }}>
                                    Penjenjangan Auditor Madya</option>
                                <option value="Penjenjangan Auditor Muda"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Penjenjangan Auditor Muda' ? 'selected' : (old('jenjang_pembelajaran') == 'Penjenjangan Auditor Muda' ? 'selected' : '') }}>
                                    Penjenjangan Auditor Muda</option>
                                <option value="Pembentukan Auditor Pertama"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Pembentukan Auditor Pertama' ? 'selected' : (old('jenjang_pembelajaran') == 'Pembentukan Auditor Pertama' ? 'selected' : '') }}>
                                    Pembentukan Auditor Pertama</option>
                                <option value="Pembentukan Auditor Terampil"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'Pembentukan Auditor Terampil' ? 'selected' : (old('jenjang_pembelajaran') == 'Pembentukan Auditor Terampil' ? 'selected' : '') }}>
                                    Pembentukan Auditor Terampil</option>
                                <option value="APIP"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'APIP' ? 'selected' : (old('jenjang_pembelajaran') == 'APIP' ? 'selected' : '') }}>
                                    APIP</option>
                                <option value="SPIP"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'SPIP' ? 'selected' : (old('jenjang_pembelajaran') == 'SPIP' ? 'selected' : '') }}>
                                    SPIP</option>
                                <option value="LSP BPKP"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'LSP BPKP' ? 'selected' : (old('jenjang_pembelajaran') == 'LSP BPKP' ? 'selected' : '') }}>
                                    LSP BPKP</option>
                                <option value="LSP Lainnya"
                                    {{ isset($pengajuanKap) && $pengajuanKap->jenjang_pembelajaran == 'LSP Lainnya' ? 'selected' : (old('jenjang_pembelajaran') == 'LSP Lainnya' ? 'selected' : '') }}>
                                    LSP Lainnya</option>
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Jenjang Pembelajaran
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="model_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Model Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('model_pembelajaran') is-invalid @enderror"
                                name="model_pembelajaran" id="model_pembelajaran">
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
                                name="jenis_pembelajaran" id="jenis_pembelajaran">
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
                                name="metode_pembelajaran" id="metode_pembelajaran">
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
                        <label for="peserta_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Peserta Pembelajaran') }}</label>
                        <div class="col-sm-6">
                            <select
                                class="form-control js-example-basic-multiple @error('peserta_pembelajaran') is-invalid @enderror"
                                name="peserta_pembelajaran" id="peserta_pembelajaran">
                                <option value="" selected disabled>-- {{ __('Select peserta pembelajaran') }} --
                                </option>
                                <option value="Internal"
                                    {{ isset($pengajuanKap) && $pengajuanKap->peserta_pembelajaran == 'Internal' ? 'selected' : (old('peserta_pembelajaran') == 'Internal' ? 'selected' : '') }}>
                                    Internal</option>
                                <option value="Eksternal"
                                    {{ isset($pengajuanKap) && $pengajuanKap->peserta_pembelajaran == 'Eksternal' ? 'selected' : (old('peserta_pembelajaran') == 'Eksternal' ? 'selected' : '') }}>
                                    Eksternal</option>
                                <option value="Internal dan Eksternal"
                                    {{ isset($pengajuanKap) && $pengajuanKap->peserta_pembelajaran == 'Internal dan Eksternal' ? 'selected' : (old('peserta_pembelajaran') == 'Internal dan Eksternal' ? 'selected' : '') }}>
                                    Internal dan Eksternal</option>
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Peserta Pembelajaran
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="sasaran_peserta"
                            class="col-sm-3 col-form-label">{{ __('Sasaran Peserta') }}</label>
                        <div class="col-sm-6">
                            <input type="text" name="sasaran_peserta" id="sasaran_peserta"
                                class="form-control @error('sasaran_peserta') is-invalid @enderror"
                                value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}"
                                placeholder="{{ __('Sasaran Peserta') }}" />
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
                                placeholder="{{ __('Sasaran Peserta') }}" />
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
                                placeholder="{{ __('Aktivitas Prapembelajaran') }}" />
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
                                name="penyelenggara_pembelajaran" id="penyelenggara_pembelajaran">
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
                                placeholder="{{ __('Sertifikat') }}" />
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
                                    @if (isset($pengajuanKap))
                                        @foreach ($level_evaluasi_instrumen_kap as $level)
                                            <tr>
                                                <td>{{ $level->level }}</td>
                                                <td>
                                                    <input type="hidden" name="no_level[]"
                                                        value="{{ $level->level }}"
                                                        class="form-control @error('no_level') is-invalid @enderror" />
                                                    <input type="text" name="level_evaluasi_instrumen[]"
                                                        value="{{ $level->keterangan }}"
                                                        class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <input type="hidden" name="no_level[]"
                                                        value="{{ $i }}"
                                                        class="form-control @error('no_level') is-invalid @enderror" />
                                                    <input type="text" name="level_evaluasi_instrumen[]"
                                                        class="form-control @error('level_evaluasi_instrumen') is-invalid @enderror" />
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
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
