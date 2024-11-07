<div class="modal fade" id="kompetensiModal" tabindex="-1" aria-labelledby="kompetensiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kompetensiModalLabel">Pilih Kompetensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="usulanModal" tabindex="-1" aria-labelledby="usulanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usulanModalLabel">Usulan Program Pembelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alertContainer" class="alert alert-danger" role="alert">
                    Jika program pembelajaran yang Anda pilih tidak tersedia, silakan ajukan program pembelajaran baru
                    dengan mengisi formulir di bawah ini. Usulan Anda akan ditinjau dan disetujui oleh admin sebelum
                    ditambahkan.
                </div>
                <form id="usulanForm" method="POST" action="{{ route('usulanProgramPembelajaran') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="rumpunPembelajaran" class="form-label">Rumpun Pembelajaran</label>
                        <select id="rumpunPembelajaran" required name="rumpun_pembelajaran_id" class="form-select"
                            aria-label="Rumpun Pembelajaran">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="namaTopik" class="form-label">Nama Program Pembelajaran</label>
                        <input type="text" required name="nama_topik" class="form-control" id="namaTopik">
                    </div>
                    <div class="mb-3">
                        <label for="catatanUserCreated" class="form-label">Catatan</label>
                        <textarea required name="catatan_user_created" id="catatanUserCreated" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="kirimUsulan" disabled>Kirim Usulan</button>
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

    <div class="tab-content" style="padding-bottom: 20px">
        <p style="color: red; padding:10px">Note : * Wajib diisi</p>
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="padding-bottom: 20px">
            <form id="form-1">
                <input type="hidden" name="tahun" id="tahun" class="form-control" value="{{ $tahun }}"
                    required readonly />
                <div class="row" style="padding: 20px">
                    <input type="hidden" name="jenis_program" id="jenis_program" class="form-control"
                        value="APIP" required readonly />
                    <div class="form-group row mb-3">
                        <label for="kompetensi_id" class="col-sm-3 col-form-label">Kompetensi <span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <div class="input-group mb-2">
                                <button type="button" id="pilihButtonKompetensi"
                                    class="input-group-text btn btn-success" style="width: 180px;">
                                    <i class="fa fa-search"></i> Cari Kompetensi
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="selectedCompetenciesTable">
                                    <thead>
                                        <tr class="table-success">
                                            <th>Kompetensi</th>
                                            <th style="width: 50px; text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($pengajuanKap))
                                            @foreach ($pengajuan_kap_gap_kompetensi as $row)
                                                <tr>
                                                    <td>{{ $row->nama_kompetensi }}
                                                        <input type="hidden" name="kompetensi_id[]"
                                                            value="{{ $row->kompetensi_id }}">
                                                        <input type="hidden" name="total_employees[]"
                                                            value="{{ $row->total_pegawai }}">
                                                        <input type="hidden" name="count_100[]"
                                                            value="{{ $row->pegawai_kompeten }}">
                                                        <input type="hidden" name="count_less_than_100[]"
                                                            value="{{ $row->pegawai_belum_kompeten }}">
                                                        <input type="hidden" name="average_persentase[]"
                                                            value="{{ $row->persentase_kompetensi }}">
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm deleteRowCompetency"
                                                            data-id="{{ $row->kompetensi_id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="topik_id" class="col-sm-3 col-form-label">
                            {{ __('Program pembelajaran') }} <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <select
                                    class="form-control  js-example-basic-multiple  @error('topik_id') is-invalid @enderror"
                                    name="topik_id" id="topik_id" required>
                                    <option value="" selected disabled>--
                                        {{ __('Select program pembelajaran') }} --</option>
                                    @if (isset($pengajuanKap))
                                        @foreach ($topikOptions as $topik)
                                            <option value="{{ $topik->id }}"
                                                data-nama-topik="{{ $topik->nama_topik }}"
                                                {{ $topik->id == $pengajuanKap->topik_id ? 'selected' : '' }}>
                                                {{ $topik->nama_topik }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($topikOptions as $topik)
                                            <option value="{{ $topik->id }}"
                                                data-nama-topik="{{ $topik->nama_topik }}">
                                                {{ $topik->nama_topik }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="button" id="usulanButton" class="btn btn-danger ms-2"
                                    data-bs-toggle="modal" data-bs-target="#usulanModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                                <div class="invalid-feedback">
                                    Mohon untuk pilih Program pembelajaran
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label" for="judul">{{ __('Judul Program Pembelajaran') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" autocomplete="off"
                                data-bs-toggle="tooltip" title="{{ config('form_tooltips.judul') }}" required rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->judul : old('judul') }}</textarea>
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
                        <label for="arahan_pimpinan" style="padding-left: 40px" class="col-sm-3 col-form-label">
                            {{ __('A. Arahan pimpinan/isu terkini/dll') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="arahan_pimpinan" id="arahan_pimpinan"
                                class="form-control @error('arahan_pimpinan') is-invalid @enderror" autocomplete="off" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.arahan_pimpinan') }}" required rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->arahan_pimpinan : old('arahan_pimpinan') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Arahan pimpinan/isu terkini/dll
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="prioritas_pembelajaran" style="padding-left: 40px"
                            class="col-sm-3 col-form-label">
                            {{ __('B. Prioritas Pembelajaran') }} <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <select name="prioritas_pembelajaran" id="prioritas_pembelajaran"
                                class="form-control  @error('prioritas_pembelajaran') is-invalid @enderror" required>
                                <option value="" disabled selected>
                                    {{ __('-- Select Prioritas Pembelajaran --') }}
                                </option>
                                @for ($i = 1; $i <= 50; $i++)
                                    @php
                                        $prioritasValue = "Prioritas $i";
                                        $isUsed = in_array($prioritasValue, $usedPrioritas);
                                        $kodePemb = $isUsed ? $kodePembelajaran[$prioritasValue] : '';

                                        // Cek nama route saat ini
                                        $currentRouteName = Route::currentRouteName();

                                        // Default nilai isSelected untuk semua route
                                        $isSelected = false;

                                        if ($currentRouteName == 'pengajuan-kap.edit') {
                                            // Logika di route 'pengajuan-kap.edit'
                                            $isSelected =
                                                (isset($pengajuanKap) &&
                                                    $pengajuanKap->prioritas_pembelajaran == $prioritasValue) ||
                                                old('prioritas_pembelajaran') == $prioritasValue;
                                        } elseif ($currentRouteName == 'pengajuan-kap.duplikat') {
                                            // Logika di route 'pengajuan-kap.duplikat', tidak ada yang terpilih
                                            $isSelected = false;
                                        }

                                        // Disabled jika prioritas sudah digunakan atau di route 'pengajuan-kap.duplikat' untuk prioritas dari $pengajuanKap
                                        $isDisabled =
                                            ($isUsed &&
                                                (!isset($pengajuanKap) ||
                                                    $pengajuanKap->prioritas_pembelajaran != $prioritasValue)) ||
                                            ($currentRouteName == 'pengajuan-kap.duplikat' &&
                                                isset($pengajuanKap) &&
                                                $pengajuanKap->prioritas_pembelajaran == $prioritasValue);
                                    @endphp
                                    <option value="{{ $prioritasValue }}" {{ $isSelected ? 'selected' : '' }}
                                        {{ $isDisabled ? 'disabled' : '' }}>
                                        {{ $prioritasValue }} {{ $kodePemb ? ' - Kode: ' . $kodePemb : '' }}
                                    </option>
                                @endfor
                            </select>

                            <div class="invalid-feedback">
                                Mohon untuk diisi Prioritas Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label" for="tujuan_program_pembelajaran">
                            {{ __('Tujuan Program Pembelajaran') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="tujuan_program_pembelajaran" id="tujuan_program_pembelajaran"
                                class="form-control @error('tujuan_program_pembelajaran') is-invalid @enderror" autocomplete="off"
                                data-bs-toggle="tooltip" title="{{ config('form_tooltips.tujuan_program_pembelajaran') }}" required
                                rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->tujuan_program_pembelajaran : old('tujuan_program_pembelajaran') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Tujuan Program Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="tujuan_program_pembelajaran">{{ __('Indikator Keberhasilan') }} <span
                                style="color: red">*</span></label>
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
                                                        value="{{ $row->indikator_keberhasilan }}" autocomplete="off"
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
                                                        autocomplete="off"
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
                        <label class="col-sm-3 col-form-label" for="indikator-dampak-terhadap-kinerja-organisasi">
                            {{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="indikator_dampak_terhadap_kinerja_organisasi" id="indikator-dampak-terhadap-kinerja-organisasi"
                                class="form-control @error('indikator_dampak_terhadap_kinerja_organisasi') is-invalid @enderror"
                                autocomplete="off" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.indikator_dampak_terhadap_kinerja_organisasi') }}" required rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi : old('indikator_dampak_terhadap_kinerja_organisasi') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Indikator Dampak Terhadap Kinerja Organisasi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label" for="penugasan-yang-terkait-dengan-pembelajaran">
                            {{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="penugasan_yang_terkait_dengan_pembelajaran" id="penugasan-yang-terkait-dengan-pembelajaran"
                                class="form-control @error('penugasan_yang_terkait_dengan_pembelajaran') is-invalid @enderror" autocomplete="off"
                                data-bs-toggle="tooltip" title="{{ config('form_tooltips.penugasan_yang_terkait_dengan_pembelajaran') }}"
                                required rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran : old('penugasan_yang_terkait_dengan_pembelajaran') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Penugasan Yang Terkait Dengan Pembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label" for="skill-group-owner">
                            {{ __('Skill Group Owner') }}
                            <span style="color: red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name="skill_group_owner" id="skill-group-owner"
                                class="form-control @error('skill_group_owner') is-invalid @enderror" autocomplete="off" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.skill_group_owner') }}" required rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->skill_group_owner : old('skill_group_owner') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Skill Group Owner
                            </div>
                        </div>
                    </div>



                </div>
            </form>
        </div>

        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" style="padding-bottom: 20px">
            <form id="form-2">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="metodeID" class="col-sm-3 col-form-label">{{ __('Metode Pembelajaran') }} <span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control @error('metodeID') is-invalid @enderror" name="metodeID"
                                id="metodeID" required>
                                <option value="" selected disabled>-- {{ __('Select metode pembelajaran') }} --
                                </option>
                                @foreach ($metode_data as $metode)
                                    <option value="{{ $metode['metodeID'] }}"
                                        data-metode-name="{{ $metode['metodeName'] }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->metodeID == $metode['metodeID'] ? 'selected' : (old('metodeID') == $metode['metodeID'] ? 'selected' : '') }}>
                                        {{ $metode['metodeName'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Metode Pembelajaran
                            </div>
                        </div>
                        <input type="hidden" name="metodeName" id="metodeName"
                            value="{{ isset($pengajuanKap) ? $pengajuanKap->metodeName : old('metodeName') }}">
                    </div>

                    <div class="form-group row mb-3" id="additional_fields" style="display: none;">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                            <!-- Tatap Muka Fields -->
                            <div id="tatap_muka_fields" style="display: none;">
                                <label>Tanggal Tatap Muka:</label>
                                <div class="row">
                                    <input type="hidden" name="remark_1" class="form-control" value="Tatap Muka">
                                    <div class="col-sm-6">
                                        <input type="date" name="tatap_muka_start" class="form-control" required
                                            placeholder="Mulai">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="date" name="tatap_muka_end" class="form-control"
                                            placeholder="Selesai">
                                    </div>
                                </div>
                            </div>

                            <!-- Hybrid Fields -->
                            <div id="hybrid_fields" style="display: none;">
                                <label>Tanggal E-Learning:</label>
                                <div class="row">
                                    <input type="hidden" name="remark_2" class="form-control" value="E-Learning">
                                    <div class="col-sm-6">
                                        <input type="date" name="hybrid_elearning_start" class="form-control"
                                            placeholder="Mulai">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="date" name="hybrid_elearning_end" class="form-control"
                                            placeholder="Selesai">
                                    </div>
                                </div>
                                <label>Tanggal Tatap Muka:</label>
                                <div class="row mb-2">
                                    <input type="hidden" name="remark_3" class="form-control" value="Tatap Muka">
                                    <div class="col-sm-6">
                                        <input type="date" name="hybrid_tatap_muka_start" class="form-control"
                                            placeholder="Mulai">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="date" name="hybrid_tatap_muka_end" class="form-control"
                                            placeholder="Selesai">
                                    </div>
                                </div>
                            </div>

                            <!-- E-Learning Fields -->
                            <div id="elearning_fields" style="display: none;">
                                <label>Tanggal E-Learning:</label>
                                <div class="row">
                                    <input type="hidden" name="remark_4" class="form-control" value="E-Learning">
                                    <div class="col-sm-6">
                                        <input type="date" name="elearning_start" class="form-control"
                                            placeholder="Mulai">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="date" name="elearning_end" class="form-control"
                                            placeholder="Selesai">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="diklatLocID" class="col-sm-3 col-form-label">{{ __('Lokasi') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select required
                                class="form-control js-example-basic-multiple  @error('diklatLocID') is-invalid @enderror"
                                name="diklatLocID" id="diklatLocID">
                                <option value="" selected disabled>-- {{ __('Select lokasi') }} --</option>
                                @foreach ($diklatLocation_data as $lokasi)
                                    <option value="{{ $lokasi['diklatLocID'] }}"
                                        data-diklatlocname="{{ $lokasi['diklatLocName'] }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->diklatLocID == $lokasi['diklatLocID'] ? 'selected' : (old('lokasi') == $lokasi['diklatLocID'] ? 'selected' : '') }}>
                                        {{ $lokasi['diklatLocName'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Lokasi
                            </div>
                        </div>
                        <input type="hidden" name="diklatLocName" id="diklatLocName"
                            value="{{ isset($pengajuanKap) ? $pengajuanKap->diklatLocName : old('diklatLocName') }}">
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label"
                            for="detail_lokasi">{{ __('Tempat / Alamat Rinci') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <textarea name="detail_lokasi" id="detail_lokasi" required
                                class="form-control @error('detail_lokasi') is-invalid @enderror" autocomplete="off" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.detail_lokasi') }}" rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->detail_lokasi : old('detail_lokasi') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Tempat / Alamat Rinci
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label" for="kelas">{{ __('Jumlah Kelas') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="number" name="kelas" id="kelas" required
                                    class="form-control @error('kelas') is-invalid @enderror"
                                    value="{{ isset($pengajuanKap) ? $pengajuanKap->kelas : old('kelas') }}"
                                    autocomplete="off" data-bs-toggle="tooltip"
                                    title="{{ config('form_tooltips.kelas') }}" />
                                <label class="input-group-text" for="inputGroupFile02">Kelas</label>
                                <div class="invalid-feedback">
                                    Mohon untuk diisi Jumlah Kelas
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="bentuk_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Bentuk Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control  @error('bentuk_pembelajaran') is-invalid @enderror" required
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
                            class="col-sm-3 col-form-label">{{ __('Jalur Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control  @error('jalur_pembelajaran') is-invalid @enderror" required
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
                        <label for="model_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Model Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select required class="form-control  @error('model_pembelajaran') is-invalid @enderror"
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
                        <label for="diklatTypeID" class="col-sm-3 col-form-label">{{ __('Jenis Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control  @error('diklatTypeID') is-invalid @enderror" required
                                name="diklatTypeID" id="diklatTypeID">
                                <option value="" selected disabled>-- {{ __('Select jenis pembelajaran') }} --
                                </option>
                                @foreach ($diklatType_data as $jenis)
                                    <option value="{{ $jenis['diklatTypeID'] }}"
                                        data-diklattypename="{{ $jenis['diklatTypeName'] }}"
                                        {{ isset($pengajuanKap) && $pengajuanKap->diklatTypeID == $jenis['diklatTypeID'] ? 'selected' : (old('diklatTypeID') == $jenis['diklatTypeID'] ? 'selected' : '') }}>
                                        {{ $jenis['diklatTypeName'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Mohon untuk pilih Jenis Pembelajaran
                            </div>
                        </div>
                        <input type="hidden" name="diklatTypeName" id="diklatTypeName"
                            value="{{ isset($pengajuanKap) ? $pengajuanKap->diklatTypeName : old('diklatTypeName') }}">
                    </div>
                </div>
            </form>
        </div>

        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3" style="padding-bottom: 20px">
            <form id="form-3">
                <div class="row" style="padding: 20px">
                    <div class="form-group row mb-3">
                        <label for="peserta_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Peserta Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select required class="form-control  @error('peserta_pembelajaran') is-invalid @enderror"
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
                        <label for="sasaran_peserta" class="col-sm-3 col-form-label">{{ __('Sasaran Peserta') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <textarea name="sasaran_peserta" id="sasaran_peserta" required
                                class="form-control @error('sasaran_peserta') is-invalid @enderror" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.sasaran_peserta') }}" rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sasaran Peserta
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kriteria_peserta"
                            class="col-sm-3 col-form-label">{{ __('Kriteria Peserta') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <textarea name="kriteria_peserta" id="kriteria_peserta" required
                                class="form-control @error('kriteria_peserta') is-invalid @enderror" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.kriteria_peserta') }}" rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : old('kriteria_peserta') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Kriteria Peserta
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="aktivitas_prapembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Aktivitas Prapembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <textarea name="aktivitas_prapembelajaran" id="aktivitas_prapembelajaran" required
                                class="form-control @error('aktivitas_prapembelajaran') is-invalid @enderror" data-bs-toggle="tooltip"
                                title="{{ config('form_tooltips.aktivitas_prapembelajaran') }}" rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->aktivitas_prapembelajaran : old('aktivitas_prapembelajaran') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Aktivitas Prapembelajaran
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="penyelenggara_pembelajaran"
                            class="col-sm-3 col-form-label">{{ __('Penyelenggara Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <select required
                                class="form-control  @error('penyelenggara_pembelajaran') is-invalid @enderror"
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
                        <label class="col-sm-3 col-form-label">{{ __('Fasilitator Pembelajaran') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            @php
                                $fasilitatorPembelajaran = isset($pengajuanKap)
                                    ? json_decode($pengajuanKap->fasilitator_pembelajaran, true)
                                    : old('fasilitator_pembelajaran', []);
                                $fasilitatorPembelajaran = is_array($fasilitatorPembelajaran)
                                    ? $fasilitatorPembelajaran
                                    : [];
                            @endphp
                            @foreach (['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya'] as $fasilitator)
                                <div class="form-check">
                                    <input class="form-check-input fasilitator-checkbox" type="checkbox"
                                        name="fasilitator_pembelajaran[]" id="fasilitator_{{ $fasilitator }}"
                                        value="{{ $fasilitator }}"
                                        {{ in_array($fasilitator, $fasilitatorPembelajaran) ? 'checked' : '' }}>
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
                        <label for="sertifikat" class="col-sm-3 col-form-label">{{ __('Sertifikat') }}<span
                                style="color: red">*</span></label>
                        <div class="col-sm-6">
                            <textarea name="sertifikat" id="sertifikat" required class="form-control @error('sertifikat') is-invalid @enderror"
                                data-bs-toggle="tooltip" title="{{ config('form_tooltips.sertifikat') }}" rows="2">{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}</textarea>
                            <div class="invalid-feedback">
                                Mohon untuk diisi Sertifikat
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="level_evaluasi_instrumen"
                            class="col-sm-3 col-form-label">{{ __('Level Evaluasi dan Instrumennya') }}<span
                                style="color: red">*</span></label>
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
                                                        value="{{ $level->level }}" autocomplete="off"
                                                        class="form-control @error('no_level') is-invalid @enderror" />
                                                    <input type="text" name="level_evaluasi_instrumen[]"
                                                        value="{{ $level->keterangan }}" autocomplete="off"
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
                                                        value="{{ $i }}" autocomplete="off"
                                                        class="form-control @error('no_level') is-invalid @enderror" />
                                                    <input type="text" name="level_evaluasi_instrumen[]"
                                                        autocomplete="off"
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
