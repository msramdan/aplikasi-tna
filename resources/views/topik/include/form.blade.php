<div class="row mb-2">
    <div class="col-md-6 mb-2">
                <label for="nama-topik">{{ __('Nama Pembelajaran') }}</label>
            <input type="text" name="nama_topik" id="nama-topik" class="form-control @error('nama_topik') is-invalid @enderror" value="{{ isset($topik) ? $topik->nama_topik : old('nama_topik') }}" placeholder="{{ __('Nama Pembelajaran') }}" required />
            @error('nama_topik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
    </div>
</div>
