<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama-kota">{{ __('kota\form.nama_kota') }}</label>
        <input type="text" name="nama_kota" id="nama-kota" class="form-control @error('nama_kota') is-invalid @enderror" value="{{ isset($kota) ? $kota->nama_kota : old('nama_kota') }}" placeholder="{{ __('kota\form.nama_kota') }}" required />
        @error('nama_kota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
