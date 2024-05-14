<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="kota-id">{{ __('Kota') }}</label>
        <select class="form-control js-example-basic-multiple @error('kota_id') is-invalid @enderror" name="kota_id"
            id="kota-id" required>
            <option value="" selected disabled>-- {{ __('Select kota') }} --</option>

            @foreach ($kotas as $kotum)
                <option value="{{ $kotum->id }}"
                    {{ isset($lokasi) && $lokasi->kota_id == $kotum->id ? 'selected' : (old('kota_id') == $kotum->id ? 'selected' : '') }}>
                    {{ $kotum->nama_kota }}
                </option>
            @endforeach
        </select>
        @error('kota_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="type">{{ __('Type') }}</label>
        <select class="form-control js-example-basic-multiple @error('type') is-invalid @enderror" name="type"
            id="type" required>
            <option value="" selected disabled>-- {{ __('Select type') }} --</option>
            <option value="Kampus"
                {{ isset($lokasi) && $lokasi->type == 'Kampus' ? 'selected' : (old('type') == 'Kampus' ? 'selected' : '') }}>
                Kampus</option>
            <option value="Hotel"
                {{ isset($lokasi) && $lokasi->type == 'Hotel' ? 'selected' : (old('type') == 'Hotel' ? 'selected' : '') }}>
                Hotel</option>
        </select>
        @error('type')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="nama-lokasi">{{ __('Nama Lokasi') }}</label>
        <input type="text" name="nama_lokasi" id="nama-lokasi"
            class="form-control @error('nama_lokasi') is-invalid @enderror"
            value="{{ isset($lokasi) ? $lokasi->nama_lokasi : old('nama_lokasi') }}"
            placeholder="{{ __('Nama Lokasi') }}" required />
        @error('nama_lokasi')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
