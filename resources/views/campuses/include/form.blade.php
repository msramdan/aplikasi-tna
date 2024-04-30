<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="nama-kampu">{{ __('Nama Kampus') }}</label>
            <input type="text" name="nama_kampus" id="nama-kampu" class="form-control @error('nama_kampus') is-invalid @enderror" value="{{ isset($campus) ? $campus->nama_kampus : old('nama_kampus') }}" placeholder="{{ __('Nama Kampus') }}" required />
            @error('nama_kampus')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>