<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama-kela">{{ __('ruang-kelas/form.nama_kelas') }}</label>
        <input type="text" name="nama_kelas" id="nama-kela"
            class="form-control @error('nama_kelas') is-invalid @enderror"
            value="{{ isset($ruangKelas) ? $ruangKelas->nama_kelas : old('nama_kelas') }}"
            placeholder="{{ __('ruang-kelas/form.nama_kelas') }}" required />
        @error('nama_kelas')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="lokasi-id">{{ __('ruang-kelas/form.lokasi') }}</label>
        <select class="form-control js-example-basic-multiple @error('lokasi_id') is-invalid @enderror" name="lokasi_id" id="lokasi-id" required>
            <option value="" selected disabled>-- {{ __('ruang-kelas/form.select_lokasi') }} --</option>
            @foreach ($lokasis as $lokasi)
                <option value="{{ $lokasi->id }}"
                    {{ isset($ruangKelas) && $ruangKelas->lokasi_id == $lokasi->id ? 'selected' : (old('lokasi_id') == $lokasi->id ? 'selected' : '') }}>
                    {{ $lokasi->nama_lokasi }}
                </option>
            @endforeach
        </select>
        @error('lokasi_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="kuotum">{{ __('ruang-kelas/form.kuota') }}</label>
        <input type="number" name="kuota" id="kuotum" class="form-control @error('kuota') is-invalid @enderror"
            value="{{ isset($ruangKelas) ? $ruangKelas->kuota : old('kuota') }}" placeholder="{{ __('ruang-kelas/form.kuota') }}"
            required />
        @error('kuota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="status_ruang_kelas">{{ __('ruang-kelas/form.status') }}</label>
        <select class="form-control js-example-basic-multiple @error('status_ruang_kelas') is-invalid @enderror" name="status_ruang_kelas" id="status_ruang_kelas" required>
            <option value="" selected disabled>-- {{ __('ruang-kelas/form.select_status') }} --</option>
            <option value="Available"
                {{ isset($ruangKelas) && $ruangKelas->status_ruang_kelas == 'Available' ? 'selected' : (old('status_ruang_kelas') == 'Available' ? 'selected' : '') }}>
                Available</option>
            <option value="Not available"
                {{ isset($ruangKelas) && $ruangKelas->status_ruang_kelas == 'Not available' ? 'selected' : (old('status_ruang_kelas') == 'Not available' ? 'selected' : '') }}>
                Not available</option>
        </select>
        @error('status_ruang_kelas')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('ruang-kelas/form.keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('ruang-kelas/form.keterangan') }}" required>{{ isset($ruangKelas) ? $ruangKelas->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
