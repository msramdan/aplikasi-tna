<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="rumpun-pembelajaran">{{ __('Rumpun Pembelajaran') }}</label>
            <textarea name="rumpun_pembelajaran" id="rumpun-pembelajaran" class="form-control @error('rumpun_pembelajaran') is-invalid @enderror" placeholder="{{ __('Rumpun Pembelajaran') }}" required>{{ isset($rumpunPembelajaran) ? $rumpunPembelajaran->rumpun_pembelajaran : old('rumpun_pembelajaran') }}</textarea>
            @error('rumpun_pembelajaran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
