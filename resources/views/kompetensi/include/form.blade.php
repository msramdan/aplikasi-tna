<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="kelompok_besar_id">{{ __('kompetensi\form.kelompok_besar') }}</label>
        <select class="form-control js-example-basic-multiple @error('kelompok_besar_id') is-invalid @enderror"
            name="kelompok_besar_id" id="kelompok_besar_id" required>
            <option value="" selected disabled>-- {{ __('kompetensi\form.select_kelompok_besar') }} --</option>

            @foreach ($kelompokBesar as $row)
                <option value="{{ $row->id }}"
                    {{ isset($kompetensi) && $kompetensi->kelompok_besar_id == $row->id ? 'selected' : (old('kelompok_besar_id') == $row->id ? 'selected' : '') }}>
                    {{ $row->nama_kelompok_besar }}
                </option>
            @endforeach
        </select>
        @error('kelompok_besar_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="kategori_kompetensi_id">{{ __('kompetensi\form.kategori') }}</label>
        <select class="form-control js-example-basic-multiple @error('kategori_kompetensi_id') is-invalid @enderror"
            name="kategori_kompetensi_id" id="kategori_kompetensi_id" required>
            <option value="" selected disabled>-- {{ __('kompetensi\form.select_kategori') }} --</option>

            @foreach ($kategoriKompetensi as $row)
                <option value="{{ $row->id }}"
                    {{ isset($kompetensi) && $kompetensi->kategori_kompetensi_id == $row->id ? 'selected' : (old('kategori_kompetensi_id') == $row->id ? 'selected' : '') }}>
                    {{ $row->nama_kategori_kompetensi }}
                </option>
            @endforeach
        </select>
        @error('kategori_kompetensi_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="akademi_id">{{ __('Kategori') }}</label>
        <select class="form-control js-example-basic-multiple @error('akademi_id') is-invalid @enderror"
            name="akademi_id" id="akademi_id" required>
            <option value="" selected disabled>-- {{ __('kompetensi\form.select_nama_akademi') }} --</option>

            @foreach ($namaAkademi as $row)
                <option value="{{ $row->id }}"
                    {{ isset($kompetensi) && $kompetensi->akademi_id == $row->id ? 'selected' : (old('akademi_id') == $row->id ? 'selected' : '') }}>
                    {{ $row->nama_akademi }}
                </option>
            @endforeach
        </select>
        @error('akademi_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="nama-kompetensi">{{ __('kompetensi\form.nama_kompetensi') }}</label>
        <input type="text" name="nama_kompetensi" id="nama-kompetensi"
            class="form-control @error('nama_kompetensi') is-invalid @enderror"
            value="{{ isset($kompetensi) ? $kompetensi->nama_kompetensi : old('nama_kompetensi') }}"
            placeholder="{{ __('kompetensi\form.nama_kompetensi') }}" required />
        @error('nama_kompetensi')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="deskripsi-kompetensi">{{ __('kompetensi\form.deskripsi_kompetensi') }}</label>
            <textarea name="deskripsi_kompetensi" id="deskripsi-kompetensi"
                class="form-control @error('deskripsi_kompetensi') is-invalid @enderror"
                placeholder="{{ __('kompetensi\form.deskripsi_kompetensi') }}" required>{{ isset($kompetensi) ? $kompetensi->deskripsi_kompetensi : old('deskripsi_kompetensi') }}</textarea>
            @error('deskripsi_kompetensi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
