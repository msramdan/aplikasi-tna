<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="campus-id">{{ __('Kampus') }}</label>
        <select class="form-control @error('campus_id') is-invalid @enderror" name="campus_id" id="campus-id" required>
            <option value="" selected disabled>-- {{ __('Select kampus') }} --</option>
            @foreach ($campuses as $campus)
                <option value="{{ $campus->id }}"
                    {{ isset($asrama) && $asrama->campus_id == $campus->id ? 'selected' : (old('campus_id') == $campus->id ? 'selected' : '') }}>
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
        <label for="nama-asrama">{{ __('Nama Asrama') }}</label>
        <input type="text" name="nama_asrama" id="nama-asrama"
            class="form-control @error('nama_asrama') is-invalid @enderror"
            value="{{ isset($asrama) ? $asrama->nama_asrama : old('nama_asrama') }}"
            placeholder="{{ __('Nama Asrama') }}" required />
        @error('nama_asrama')
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
        <label for="status-asrama">{{ __('Status Asrama') }}</label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status-asrama" required>
            <option value="" selected disabled>-- {{ __('Select status asrama') }} --</option>
            <option value="Available"
                {{ isset($asrama) && $asrama->status == 'Available' ? 'selected' : (old('status') == 'Available' ? 'selected' : '') }}>
                Available</option>
            <option value="Not available"
                {{ isset($asrama) && $asrama->status == 'Not available' ? 'selected' : (old('status') == 'Not available' ? 'selected' : '') }}>
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
                placeholder="{{ __('Keterangan') }}" required>{{ isset($asrama) ? $asrama->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
