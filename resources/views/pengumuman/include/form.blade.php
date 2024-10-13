<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="pengumuman">{{ __('Pengumuman') }}</label>
            <textarea name="pengumuman" rows="10" id="pengumuman" class="form-control @error('pengumuman') is-invalid @enderror"
                placeholder="{{ __('Pengumuman') }}" required>{{ isset($pengumuman) ? $pengumuman->pengumuman : old('pengumuman') }}</textarea>
            @error('pengumuman')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
