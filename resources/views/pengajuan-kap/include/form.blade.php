<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="kode-pembelajaran">{{ __('Kode Pembelajaran') }}</label>
        <input type="text" name="kode_pembelajaran" id="kode-pembelajaran"
            class="form-control @error('kode_pembelajaran') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->kode_pembelajaran : old('kode_pembelajaran') }}"
            placeholder="{{ __('Kode Pembelajaran') }}" required />
        @error('kode_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="institusi-sumber">{{ __('Institusi Sumber') }}</label>
        <select class="form-control @error('institusi_sumber') is-invalid @enderror" name="institusi_sumber"
            id="institusi-sumber" required>
            <option value="" selected disabled>-- {{ __('Select institusi sumber') }} --</option>
            <option value="BPKP"
                {{ isset($pengajuanKap) && $pengajuanKap->institusi_sumber == 'BPKP' ? 'selected' : (old('institusi_sumber') == 'BPKP' ? 'selected' : '') }}>
                BPKP</option>
            <option value="Non BPKP"
                {{ isset($pengajuanKap) && $pengajuanKap->institusi_sumber == 'Non BPKP' ? 'selected' : (old('institusi_sumber') == 'Non BPKP' ? 'selected' : '') }}>
                Non BPKP</option>
        </select>
        @error('institusi_sumber')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="jenis-program">{{ __('Jenis Program') }}</label>
        <select class="form-control @error('jenis_program') is-invalid @enderror" name="jenis_program"
            id="jenis-program" required>
            <option value="" selected disabled>-- {{ __('Select jenis program') }} --</option>
            <option value="Renstra"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == 'Renstra' ? 'selected' : (old('jenis_program') == 'Renstra' ? 'selected' : '') }}>
                Renstra</option>
            <option value="APP"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == 'APP' ? 'selected' : (old('jenis_program') == 'APP' ? 'selected' : '') }}>
                APP</option>
            <option value="APEP"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == 'APEP' ? 'selected' : (old('jenis_program') == 'APEP' ? 'selected' : '') }}>
                APEP</option>
            <option value="APIP"
                {{ isset($pengajuanKap) && $pengajuanKap->jenis_program == 'APIP' ? 'selected' : (old('jenis_program') == 'APIP' ? 'selected' : '') }}>
                APIP</option>
        </select>
        @error('jenis_program')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="frekuensi-pelaksanaan">{{ __('Frekuensi Pelaksanaan') }}</label>
        <select class="form-control @error('frekuensi_pelaksanaan') is-invalid @enderror" name="frekuensi_pelaksanaan"
            id="frekuensi-pelaksanaan" required>
            <option value="" selected disabled>-- {{ __('Select frekuensi pelaksanaan') }} --</option>
            <option value="Tahunan"
                {{ isset($pengajuanKap) && $pengajuanKap->frekuensi_pelaksanaan == 'Tahunan' ? 'selected' : (old('frekuensi_pelaksanaan') == 'Tahunan' ? 'selected' : '') }}>
                Tahunan</option>
            <option value="Insidentil"
                {{ isset($pengajuanKap) && $pengajuanKap->frekuensi_pelaksanaan == 'Insidentil' ? 'selected' : (old('frekuensi_pelaksanaan') == 'Insidentil' ? 'selected' : '') }}>
                Insidentil</option>
        </select>
        @error('frekuensi_pelaksanaan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
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
    <div class="col-md-6 mb-2">
        <label for="kompetensi-id">{{ __('Kompetensi') }}</label>
        <select class="form-control @error('kompetensi_id') is-invalid @enderror" name="kompetensi_id"
            id="kompetensi-id" required>
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

    <div class="col-md-6 mb-2">
        <label for="topik-id">{{ __('Topik') }}</label>
        <select class="form-control @error('topik_id') is-invalid @enderror" name="topik_id" id="topik-id" required>
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
        <label for="alokasi-waktu">{{ __('Alokasi Waktu') }}</label>
        <input type="number" name="alokasi_waktu" id="alokasi-waktu"
            class="form-control @error('alokasi_waktu') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}"
            placeholder="{{ __('Alokasi Waktu') }}" required />
        @error('alokasi_waktu')
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
        <label for="bentuk-pembelajaran">{{ __('Bentuk Pembelajaran') }}</label>
        <select class="form-control @error('bentuk_pembelajaran') is-invalid @enderror" name="bentuk_pembelajaran"
            id="bentuk-pembelajaran" required>
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

    <div class="col-md-6 mb-2">
        <label for="jalur-pembelajaran">{{ __('Jalur Pembelajaran') }}</label>
        <select class="form-control @error('jalur_pembelajaran') is-invalid @enderror" name="jalur_pembelajaran"
            id="jalur-pembelajaran" multiple required>
            <option value="" disabled>-- {{ __('Select jalur pembelajaran') }} --</option>
            @foreach (['Pelatihan', 'Seminar/konferensi/sarasehan', 'Kursus', 'Lokakarya (workshop)', 'Belajar mandiri', 'Coaching', 'Mentoring', 'Bimbingan teknis', 'Sosialisasi', 'Detasering (secondment)', 'Job shadowing', 'Outbond', 'Benchmarking', 'Pertukaran PNS', 'Community of practices', 'Pelatihan di kantor sendiri', 'Library café', 'Magang/praktik kerja'] as $jalur)
                <option value="{{ $jalur }}"
                    {{ isset($pengajuanKap) && in_array($jalur, explode(',', $pengajuanKap->jalur_pembelajaran)) ? 'selected' : (in_array($jalur, old('jalur_pembelajaran', [])) ? 'selected' : '') }}>
                    {{ $jalur }}
                </option>
            @endforeach
        </select>
        @error('jalur_pembelajaran')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="model-pembelajaran">{{ __('Model Pembelajaran') }}</label>
        <select class="form-control @error('model_pembelajaran') is-invalid @enderror" name="model_pembelajaran"
            id="model-pembelajaran" required>
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

    <div class="col-md-6 mb-2">
        <label for="jenis-pembelajaran">{{ __('Jenis Pembelajaran') }}</label>
        <select class="form-control @error('jenis_pembelajaran') is-invalid @enderror" name="jenis_pembelajaran"
            id="jenis-pembelajaran" required>
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

    <div class="col-md-6 mb-2">
        <label for="metode-pembelajaran">{{ __('Metode Pembelajaran') }}</label>
        <select class="form-control @error('metode_pembelajaran') is-invalid @enderror" name="metode_pembelajaran"
            id="metode-pembelajaran" required>
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
        <label for="penyelenggara-pembelajaran">{{ __('Penyelenggara Pembelajaran') }}</label>
        <select class="form-control @error('penyelenggara_pembelajaran') is-invalid @enderror"
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

    <div class="col-md-6 mb-2">
        <label for="fasilitator-pembelajaran">{{ __('Fasilitator Pembelajaran') }}</label>
        <select class="form-control @error('fasilitator_pembelajaran') is-invalid @enderror"
            name="fasilitator_pembelajaran" id="fasilitator-pembelajaran" required>
            <option value="" selected disabled>-- {{ __('Select fasilitator pembelajaran') }} --</option>
            <option value="Widyaiswara"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Widyaiswara' ? 'selected' : (old('fasilitator_pembelajaran') == 'Widyaiswara' ? 'selected' : '') }}>
                Widyaiswara</option>
            <option value="Instruktur"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Instruktur' ? 'selected' : (old('fasilitator_pembelajaran') == 'Instruktur' ? 'selected' : '') }}>
                Instruktur</option>
            <option value="Praktisi"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Praktisi' ? 'selected' : (old('fasilitator_pembelajaran') == 'Praktisi' ? 'selected' : '') }}>
                Praktisi</option>
            <option value="Pakar"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Pakar' ? 'selected' : (old('fasilitator_pembelajaran') == 'Pakar' ? 'selected' : '') }}>
                Pakar</option>
            <option value="Tutor"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Tutor' ? 'selected' : (old('fasilitator_pembelajaran') == 'Tutor' ? 'selected' : '') }}>
                Tutor</option>
            <option value="Coach"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Coach' ? 'selected' : (old('fasilitator_pembelajaran') == 'Coach' ? 'selected' : '') }}>
                Coach</option>
            <option value="Mentor"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Mentor' ? 'selected' : (old('fasilitator_pembelajaran') == 'Mentor' ? 'selected' : '') }}>
                Mentor</option>
            <option value="Narasumber lainnya"
                {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Narasumber lainnya' ? 'selected' : (old('fasilitator_pembelajaran') == 'Narasumber lainnya' ? 'selected' : '') }}>
                Narasumber lainnya</option>
        </select>
        @error('fasilitator_pembelajaran')
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

    <!-- Tanggal Created -->
    <div class="col-md-6 mb-2">
        <label for="tanggal-created">{{ __('Tanggal Created') }}</label>
        <input type="datetime-local" id="tanggal-created" name="tanggal_created"
            class="form-control @error('tanggal_created') is-invalid @enderror"
            value="{{ isset($pengajuanKap) ? \Carbon\Carbon::parse($pengajuanKap->tanggal_created)->format('Y-m-d\TH:i') : old('tanggal_created') }}"
            required>
        @error('tanggal_created')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <!-- Status Pengajuan -->
    <div class="col-md-6 mb-2">
        <label for="status-pengajuan">{{ __('Status Pengajuan') }}</label>
        <select class="form-control @error('status_pengajuan') is-invalid @enderror" name="status_pengajuan"
            id="status-pengajuan" required>
            <option value="" selected disabled>-- {{ __('Select status pengajuan') }} --</option>
            <option value="Pending"
                {{ isset($pengajuanKap) && $pengajuanKap->status_pengajuan == 'Pending' ? 'selected' : (old('status_pengajuan') == 'Pending' ? 'selected' : '') }}>
                Pending</option>
            <option value="Approved"
                {{ isset($pengajuanKap) && $pengajuanKap->status_pengajuan == 'Approved' ? 'selected' : (old('status_pengajuan') == 'Approved' ? 'selected' : '') }}>
                Approved</option>
            <option value="Rejected"
                {{ isset($pengajuanKap) && $pengajuanKap->status_pengajuan == 'Rejected' ? 'selected' : (old('status_pengajuan') == 'Rejected' ? 'selected' : '') }}>
                Rejected</option>
        </select>
        @error('status_pengajuan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <!-- User Created (Foreign Key) -->
    {{-- <div class="col-md-6 mb-2">
        <label for="user-created">{{ __('User Created') }}</label>
        <select class="form-control @error('user_created') is-invalid @enderror" name="user_created"
            id="user-created" required>
            <option value="" selected disabled>-- {{ __('Select user created') }} --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($pengajuanKap) && $pengajuanKap->user_created == $user->id ? 'selected' : (old('user_created') == $user->id ? 'selected' : '') }}>
                    {{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_created')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div> --}}
</div>
