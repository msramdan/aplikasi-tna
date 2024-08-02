<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="rumpun_pembelajaran_id">Rumpun pembelajaran</label>
        <select class="form-control js-example-basic-multiple @error('rumpun_pembelajaran_id') is-invalid @enderror"
            name="rumpun_pembelajaran_id" id="rumpun_pembelajaran_id" required>
            <option value="" selected disabled>-- Rumpun pembelajaran --</option>
            @foreach ($rumpunPembelajaran as $row)
                <option value="{{ $row->id }}"
                    {{ isset($topik) && $topik->rumpun_pembelajaran_id == $row->id ? 'selected' : (old('rumpun_pembelajaran_id') == $row->id ? 'selected' : '') }}>
                    {{ $row->rumpun_pembelajaran }}
                </option>
            @endforeach
        </select>
        @error('rumpun_pembelajaran_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="nama-topik">{{ __('topik/form.nama_pembelajaran') }}</label>
        <input type="text" name="nama_topik" id="nama-topik"
            class="form-control @error('nama_topik') is-invalid @enderror"
            value="{{ isset($topik) ? $topik->nama_topik : old('nama_topik') }}"
            placeholder="{{ __('topik/form.nama_pembelajaran') }}" required />
        @error('nama_topik')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
