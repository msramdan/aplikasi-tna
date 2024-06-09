<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="topik-id">{{ __('Topik') }}</label>
        <select class="form-control @error('topik_id') is-invalid @enderror" name="topik_id" id="topik-id" required>
            <option value="" selected disabled>-- {{ __('Select topik') }} --</option>
        </select>
        @error('topik_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
