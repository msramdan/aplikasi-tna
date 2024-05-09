<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="campus-id">{{ __('Kampus') }}</label>
        <select class="form-control select2-form @error('campus_id') is-invalid @enderror" name="campus_id" id="campus-id"
            required>
            <option value="" selected disabled>-- {{ __('Select kampus') }} --</option>

            @foreach ($campuses as $campus)
                <option value="{{ $campus->id }}"
                    {{ isset($ruangKela) && $ruangKela->campus_id == $campus->id ? 'selected' : (old('campus_id') == $campus->id ? 'selected' : '') }}>
                    {{ $campus->nama_kampus }}
                </option>
            @endforeach
        </select>
        @error('campus_id')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="nama-kela">{{ __('Nama Kelas') }}</label>
        <input type="text" name="nama_kelas" id="nama-kela"
            class="form-control @error('nama_kelas') is-invalid @enderror"
            value="{{ isset($ruangKela) ? $ruangKela->nama_kelas : old('nama_kelas') }}"
            placeholder="{{ __('Nama Kelas') }}" required />
        @error('nama_kelas')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="kuotum">{{ __('Kuota') }}</label>
        <input type="number" name="kuota" id="kuotum" class="form-control @error('kuota') is-invalid @enderror"
            value="{{ isset($ruangKela) ? $ruangKela->kuota : old('kuota') }}" placeholder="{{ __('Kuota') }}"
            required />
        @error('kuota')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="status">{{ __('Status') }}</label>
        <select class="form-select select2-form" name="status" aria-label="Default select example">
            <option value="" selected disabled>-- {{ __('Select status') }} --</option>
            <option value="Available"
                {{ isset($ruangKela) && $ruangKela->status == 'Available' ? 'selected' : (old('status') == 'Available' ? 'selected' : '') }}>
                Available</option>
            <option value="Not available"
                {{ isset($ruangKela) && $ruangKela->status == 'Not available' ? 'selected' : (old('status') == 'Not available' ? 'selected' : '') }}>
                Not available</option>
        </select>
        @error('status')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="{{ __('Keterangan') }}" required>{{ isset($ruangKela) ? $ruangKela->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
