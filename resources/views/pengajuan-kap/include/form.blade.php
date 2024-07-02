<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="kode-pembelajaran">{{ __('Kode Pembelajaran') }}</label>
            <input type="text" name="kode_pembelajaran" id="kode-pembelajaran" class="form-control @error('kode_pembelajaran') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->kode_pembelajaran : old('kode_pembelajaran') }}" placeholder="{{ __('Kode Pembelajaran') }}" required />
            @error('kode_pembelajaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="type-pembelajaran">{{ __('Type Pembelajaran') }}</label>
                                    <select class="form-control @error('type_pembelajaran') is-invalid @enderror" name="type_pembelajaran" id="type-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select type pembelajaran') }} --</option>
                                        <option value="Tahunan" {{ isset($pengajuanKap) && $pengajuanKap->type_pembelajaran == 'Tahunan' ? 'selected' : (old('type_pembelajaran') == 'Tahunan' ? 'selected' : '') }}>Tahunan</option>
		<option value="Insidentil" {{ isset($pengajuanKap) && $pengajuanKap->type_pembelajaran == 'Insidentil' ? 'selected' : (old('type_pembelajaran') == 'Insidentil' ? 'selected' : '') }}>Insidentil</option>			
                                    </select>
                                    @error('type_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="indikator-kinerja">{{ __('Indikator Kinerja') }}</label>
            <input type="text" name="indikator_kinerja" id="indikator-kinerja" class="form-control @error('indikator_kinerja') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_kinerja : old('indikator_kinerja') }}" placeholder="{{ __('Indikator Kinerja') }}" required />
            @error('indikator_kinerja')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="kompetensi-id">{{ __('Kompetensi') }}</label>
                                    <select class="form-control @error('kompetensi_id') is-invalid @enderror" name="kompetensi_id" id="kompetensi-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select kompetensi') }} --</option>
                                        
                        @foreach ($kompetensis as $kompetensi)
                            <option value="{{ $kompetensi->id }}" {{ isset($pengajuanKap) && $pengajuanKap->kompetensi_id == $kompetensi->id ? 'selected' : (old('kompetensi_id') == $kompetensi->id ? 'selected' : '') }}>
                                {{ $kompetensi->id }}
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
                                    <select class="form-control @error('topik_id') is-invalid @enderror" name="topik_id" id="topik-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select topik') }} --</option>
                                        
                        @foreach ($topiks as $topik)
                            <option value="{{ $topik->id }}" {{ isset($pengajuanKap) && $pengajuanKap->topik_id == $topik->id ? 'selected' : (old('topik_id') == $topik->id ? 'selected' : '') }}>
                                {{ $topik->id }}
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
            <input type="text" name="concern_program_pembelajaran" id="concern-program-pembelajaran" class="form-control @error('concern_program_pembelajaran') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->concern_program_pembelajaran : old('concern_program_pembelajaran') }}" placeholder="{{ __('Concern Program Pembelajaran') }}" required />
            @error('concern_program_pembelajaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="alokasi-waktu">{{ __('Alokasi Waktu') }}</label>
            <input type="text" name="alokasi_waktu" id="alokasi-waktu" class="form-control @error('alokasi_waktu') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}" placeholder="{{ __('Alokasi Waktu') }}" required />
            @error('alokasi_waktu')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="indikator-dampak-terhadap-kinerja-organisasi">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</label>
            <input type="text" name="indikator_dampak_terhadap_kinerja_organisasi" id="indikator-dampak-terhadap-kinerja-organisasi" class="form-control @error('indikator_dampak_terhadap_kinerja_organisasi') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi : old('indikator_dampak_terhadap_kinerja_organisasi') }}" placeholder="{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}" required />
            @error('indikator_dampak_terhadap_kinerja_organisasi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="penugasan-yang-terkait-dengan-pembelajaran">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</label>
            <input type="text" name="penugasan_yang_terkait_dengan_pembelajaran" id="penugasan-yang-terkait-dengan-pembelajaran" class="form-control @error('penugasan_yang_terkait_dengan_pembelajaran') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran : old('penugasan_yang_terkait_dengan_pembelajaran') }}" placeholder="{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}" required />
            @error('penugasan_yang_terkait_dengan_pembelajaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="skill-group-owner">{{ __('Skill Group Owner') }}</label>
            <input type="text" name="skill_group_owner" id="skill-group-owner" class="form-control @error('skill_group_owner') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->skill_group_owner : old('skill_group_owner') }}" placeholder="{{ __('Skill Group Owner') }}" required />
            @error('skill_group_owner')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="jalur-pembelajaran">{{ __('Jalur Pembelajaran') }}</label>
                                    <select class="form-control @error('jalur_pembelajaran') is-invalid @enderror" name="jalur_pembelajaran" id="jalur-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select jalur pembelajaran') }} --</option>
                                        <option value="Pelatihan" {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == 'Pelatihan' ? 'selected' : (old('jalur_pembelajaran') == 'Pelatihan' ? 'selected' : '') }}>Pelatihan</option>
		<option value="Sertifikasi" {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == 'Sertifikasi' ? 'selected' : (old('jalur_pembelajaran') == 'Sertifikasi' ? 'selected' : '') }}>Sertifikasi</option>
		<option value="Pelatihan di kantor sendiri" {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == 'Pelatihan di kantor sendiri' ? 'selected' : (old('jalur_pembelajaran') == 'Pelatihan di kantor sendiri' ? 'selected' : '') }}>Pelatihan di kantor sendiri</option>
		<option value="Belajar mandiri" {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == 'Belajar mandiri' ? 'selected' : (old('jalur_pembelajaran') == 'Belajar mandiri' ? 'selected' : '') }}>Belajar mandiri</option>			
                                    </select>
                                    @error('jalur_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="model-pembelajaran">{{ __('Model Pembelajaran') }}</label>
                                    <select class="form-control @error('model_pembelajaran') is-invalid @enderror" name="model_pembelajaran" id="model-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select model pembelajaran') }} --</option>
                                        <option value="Terstruktur" {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Terstruktur' ? 'selected' : (old('model_pembelajaran') == 'Terstruktur' ? 'selected' : '') }}>Terstruktur</option>
		<option value="Social learning" {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Social learning' ? 'selected' : (old('model_pembelajaran') == 'Social learning' ? 'selected' : '') }}>Social learning</option>
		<option value="Experiential learning" {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == 'Experiential learning' ? 'selected' : (old('model_pembelajaran') == 'Experiential learning' ? 'selected' : '') }}>Experiential learning</option>			
                                    </select>
                                    @error('model_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="jenis-pembelajaran">{{ __('Jenis Pembelajaran') }}</label>
                                    <select class="form-control @error('jenis_pembelajaran') is-invalid @enderror" name="jenis_pembelajaran" id="jenis-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select jenis pembelajaran') }} --</option>
                                        <option value="Fungsional" {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Fungsional' ? 'selected' : (old('jenis_pembelajaran') == 'Fungsional' ? 'selected' : '') }}>Fungsional</option>
		<option value="Teknis substansi" {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Teknis substansi' ? 'selected' : (old('jenis_pembelajaran') == 'Teknis substansi' ? 'selected' : '') }}>Teknis substansi</option>
		<option value="Kedinasan" {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Kedinasan' ? 'selected' : (old('jenis_pembelajaran') == 'Kedinasan' ? 'selected' : '') }}>Kedinasan</option>
		<option value="Sertifikasi non JFA" {{ isset($pengajuanKap) && $pengajuanKap->jenis_pembelajaran == 'Sertifikasi non JFA' ? 'selected' : (old('jenis_pembelajaran') == 'Sertifikasi non JFA' ? 'selected' : '') }}>Sertifikasi non JFA</option>			
                                    </select>
                                    @error('jenis_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="metode-pembelajaran">{{ __('Metode Pembelajaran') }}</label>
                                    <select class="form-control @error('metode_pembelajaran') is-invalid @enderror" name="metode_pembelajaran" id="metode-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select metode pembelajaran') }} --</option>
                                        <option value="Tatap muka" {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'Tatap muka' ? 'selected' : (old('metode_pembelajaran') == 'Tatap muka' ? 'selected' : '') }}>Tatap muka</option>
		<option value="PJJ" {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'PJJ' ? 'selected' : (old('metode_pembelajaran') == 'PJJ' ? 'selected' : '') }}>PJJ</option>
		<option value="E-learning" {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'E-learning' ? 'selected' : (old('metode_pembelajaran') == 'E-learning' ? 'selected' : '') }}>E-learning</option>
		<option value="Blended" {{ isset($pengajuanKap) && $pengajuanKap->metode_pembelajaran == 'Blended' ? 'selected' : (old('metode_pembelajaran') == 'Blended' ? 'selected' : '') }}>Blended</option>			
                                    </select>
                                    @error('metode_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="sasaran-pesertum">{{ __('Sasaran Peserta') }}</label>
            <input type="text" name="sasaran_peserta" id="sasaran-pesertum" class="form-control @error('sasaran_peserta') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : old('sasaran_peserta') }}" placeholder="{{ __('Sasaran Peserta') }}" required />
            @error('sasaran_peserta')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="kriteria-pesertum">{{ __('Kriteria Peserta') }}</label>
            <input type="text" name="kriteria_peserta" id="kriteria-pesertum" class="form-control @error('kriteria_peserta') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : old('kriteria_peserta') }}" placeholder="{{ __('Kriteria Peserta') }}" required />
            @error('kriteria_peserta')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
    <div class="col-md-6 mb-2">
                <label for="aktivitas-prapembelajaran">{{ __('Aktivitas Prapembelajaran') }}</label>
            <input type="text" name="aktivitas_prapembelajaran" id="aktivitas-prapembelajaran" class="form-control @error('aktivitas_prapembelajaran') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->aktivitas_prapembelajaran : old('aktivitas_prapembelajaran') }}" placeholder="{{ __('Aktivitas Prapembelajaran') }}" required />
            @error('aktivitas_prapembelajaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
<div class="col-md-6 mb-2">
                               <label for="penyelenggara-pembelajaran">{{ __('Penyelenggara Pembelajaran') }}</label>
                                    <select class="form-control @error('penyelenggara_pembelajaran') is-invalid @enderror" name="penyelenggara_pembelajaran" id="penyelenggara-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select penyelenggara pembelajaran') }} --</option>
                                        <option value="Pusdiklatwas BPKP" {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Pusdiklatwas BPKP' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Pusdiklatwas BPKP' ? 'selected' : '') }}>Pusdiklatwas BPKP</option>
		<option value="Unit kerja" {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Unit kerja' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Unit kerja' ? 'selected' : '') }}>Unit kerja</option>
		<option value="Lainnya" {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == 'Lainnya' ? 'selected' : (old('penyelenggara_pembelajaran') == 'Lainnya' ? 'selected' : '') }}>Lainnya</option>			
                                    </select>
                                    @error('penyelenggara_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="fasilitator-pembelajaran">{{ __('Fasilitator Pembelajaran') }}</label>
                                    <select class="form-control @error('fasilitator_pembelajaran') is-invalid @enderror" name="fasilitator_pembelajaran" id="fasilitator-pembelajaran"  required>
                                        <option value="" selected disabled>-- {{ __('Select fasilitator pembelajaran') }} --</option>
                                        <option value="Widyaiswara" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Widyaiswara' ? 'selected' : (old('fasilitator_pembelajaran') == 'Widyaiswara' ? 'selected' : '') }}>Widyaiswara</option>
		<option value="Instruktur" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Instruktur' ? 'selected' : (old('fasilitator_pembelajaran') == 'Instruktur' ? 'selected' : '') }}>Instruktur</option>
		<option value="Praktisi" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Praktisi' ? 'selected' : (old('fasilitator_pembelajaran') == 'Praktisi' ? 'selected' : '') }}>Praktisi</option>
		<option value="Pakar" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Pakar' ? 'selected' : (old('fasilitator_pembelajaran') == 'Pakar' ? 'selected' : '') }}>Pakar</option>
		<option value="Tutor" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Tutor' ? 'selected' : (old('fasilitator_pembelajaran') == 'Tutor' ? 'selected' : '') }}>Tutor</option>
		<option value="Coach" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Coach' ? 'selected' : (old('fasilitator_pembelajaran') == 'Coach' ? 'selected' : '') }}>Coach</option>
		<option value="Mentor" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Mentor' ? 'selected' : (old('fasilitator_pembelajaran') == 'Mentor' ? 'selected' : '') }}>Mentor</option>
		<option value="Narasumber lainnya" {{ isset($pengajuanKap) && $pengajuanKap->fasilitator_pembelajaran == 'Narasumber lainnya' ? 'selected' : (old('fasilitator_pembelajaran') == 'Narasumber lainnya' ? 'selected' : '') }}>Narasumber lainnya</option>			
                                    </select>
                                    @error('fasilitator_pembelajaran')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

    <div class="col-md-6 mb-2">
                <label for="sertifikat">{{ __('Sertifikat') }}</label>
            <input type="text" name="sertifikat" id="sertifikat" class="form-control @error('sertifikat') is-invalid @enderror" value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}" placeholder="{{ __('Sertifikat') }}" required />
            @error('sertifikat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>