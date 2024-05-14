<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="tahun">{{ __('Tahun') }}</label>
        <select class="form-control js-example-basic-multiple @error('tahun') is-invalid @enderror" name="tahun" id="tahun" required>
            <option value="" selected disabled>-- {{ __('Select tahun') }} --</option>
            @php
                $startYear = 2023;
                $currentYear = date('Y');
                $endYear = $currentYear + 1;
            @endphp

            @foreach (range($startYear, $endYear) as $year)
                <option value="{{ $year }}"
                    {{ isset($jadwalKapTahunan) && $jadwalKapTahunan->tahun == $year ? 'selected' : (old('tahun') == $year ? 'selected' : '') }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
        @error('tahun')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="tanggal-mulai">{{ __('Tanggal Mulai') }}</label>
        <input type="date" name="tanggal_mulai" id="tanggal-mulai"
            class="form-control @error('tanggal_mulai') is-invalid @enderror"
            value="{{ isset($jadwalKapTahunan) && $jadwalKapTahunan->tanggal_mulai ? $jadwalKapTahunan->tanggal_mulai->format('Y-m-d') : old('tanggal_mulai') }}"
            placeholder="{{ __('Tanggal Mulai') }}" required />
        @error('tanggal_mulai')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="tanggal-selesai">{{ __('Tanggal Selesai') }}</label>
        <input type="date" name="tanggal_selesai" id="tanggal-selesai"
            class="form-control @error('tanggal_selesai') is-invalid @enderror"
            value="{{ isset($jadwalKapTahunan) && $jadwalKapTahunan->tanggal_selesai ? $jadwalKapTahunan->tanggal_selesai->format('Y-m-d') : old('tanggal_selesai') }}"
            placeholder="{{ __('Tanggal Selesai') }}" required />
        @error('tanggal_selesai')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
