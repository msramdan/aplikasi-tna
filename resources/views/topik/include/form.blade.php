<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="nama-topik">{{ __('topik\form.nama_pembelajaran') }}</label>
        <input type="text" name="nama_topik" id="nama-topik" class="form-control @error('nama_topik') is-invalid @enderror" value="{{ isset($topik) ? $topik->nama_topik : old('nama_topik') }}" placeholder="{{ __('topik\form.nama_pembelajaran') }}" required />
        @error('nama_topik')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
