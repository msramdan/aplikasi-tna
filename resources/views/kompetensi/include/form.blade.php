<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama-kompetensi">{{ __('Nama Kompetensi') }}</label>
        <input type="text" name="nama_kompetensi" id="nama-kompetensi"
            class="form-control @error('nama_kompetensi') is-invalid @enderror"
            value="{{ isset($kompetensi) ? $kompetensi->nama_kompetensi : old('nama_kompetensi') }}"
            placeholder="{{ __('Nama Kompetensi') }}" required />
        @error('nama_kompetensi')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="deksripsi-kompetensi">{{ __('Deksripsi Kompetensi') }}</label>
            <textarea name="deksripsi_kompetensi" id="deksripsi-kompetensi"
                class="form-control @error('deksripsi_kompetensi') is-invalid @enderror"
                placeholder="{{ __('Deksripsi Kompetensi') }}" required>{{ isset($kompetensi) ? $kompetensi->deksripsi_kompetensi : old('deksripsi_kompetensi') }}</textarea>
            @error('deksripsi_kompetensi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
