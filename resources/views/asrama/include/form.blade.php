<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama-asrama">{{ __('Nama Asrama') }}</label>
        <input type="text" name="nama_asrama" id="nama-asrama"
            class="form-control @error('nama_asrama') is-invalid @enderror"
            value="{{ isset($asrama) ? $asrama->nama_asrama : old('nama_asrama') }}" placeholder="{{ __('Nama Asrama') }}"
            required />
        @error('nama_asrama')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="lokasi-id">{{ __('Lokasi') }}</label>
        <select class="form-control js-example-basic-multiple @error('lokasi_id') is-invalid @enderror" name="lokasi_id" id="lokasi-id" required>
            <option value="" selected disabled>-- {{ __('Select lokasi') }} --</option>

            @foreach ($lokasis as $lokasi)
                <option value="{{ $lokasi->id }}"
                    {{ isset($asrama) && $asrama->lokasi_id == $lokasi->id ? 'selected' : (old('lokasi_id') == $lokasi->id ? 'selected' : '') }}>
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
        <label for="kuotum">{{ __('Kuota') }}</label>
        <input type="number" name="kuota" id="kuotum" class="form-control @error('kuota') is-invalid @enderror"
            value="{{ isset($asrama) ? $asrama->kuota : old('kuota') }}" placeholder="{{ __('Kuota') }}" required />
        @error('kuota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="starus-asrama">{{ __('Starus Asrama') }}</label>
        <select class="form-control js-example-basic-multiple @error('starus_asrama') is-invalid @enderror" name="starus_asrama"
            id="starus-asrama" required>
            <option value="" selected disabled>-- {{ __('Select starus asrama') }} --</option>
            <option value="Available"
                {{ isset($asrama) && $asrama->starus_asrama == 'Available' ? 'selected' : (old('starus_asrama') == 'Available' ? 'selected' : '') }}>
                Available</option>
            <option value="Not available"
                {{ isset($asrama) && $asrama->starus_asrama == 'Not available' ? 'selected' : (old('starus_asrama') == 'Not available' ? 'selected' : '') }}>
                Not available</option>
        </select>
        @error('starus_asrama')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('Keterangan') }}" required>{{ isset($asrama) ? $asrama->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
