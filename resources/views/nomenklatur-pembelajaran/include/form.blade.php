<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="rumpun-pembelajaran-id">{{ __('Rumpun Pembelajaran') }}</label>
        <select class="form-control @error('rumpun_pembelajaran_id') is-invalid @enderror" name="rumpun_pembelajaran_id"
            id="rumpun-pembelajaran-id" required>
            <option value="" selected disabled>-- {{ __('Select rumpun pembelajaran') }} --</option>

            @foreach ($rumpunPembelajarans as $rumpunPembelajaran)
                <option value="{{ $rumpunPembelajaran->id }}"
                    {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->rumpun_pembelajaran_id == $rumpunPembelajaran->id ? 'selected' : (old('rumpun_pembelajaran_id') == $rumpunPembelajaran->id ? 'selected' : '') }}>
                    {{ $rumpunPembelajaran->id }}
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
        <label for="nama-topik">{{ __('Nama Topik') }}</label>
        <input type="text" name="nama_topik" id="nama-topik"
            class="form-control @error('nama_topik') is-invalid @enderror"
            value="{{ isset($nomenklaturPembelajaran) ? $nomenklaturPembelajaran->nama_topik : old('nama_topik') }}"
            placeholder="{{ __('Nama Topik') }}" required />
        @error('nama_topik')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-2">
        <label for="status">{{ __('Status') }}</label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
            <option value="" selected disabled>-- {{ __('Select status') }} --</option>
            <option value="Pending"
                {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->status == 'Pending' ? 'selected' : (old('status') == 'Pending' ? 'selected' : '') }}>
                Pending</option>
            <option value="Approved"
                {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->status == 'Approved' ? 'selected' : (old('status') == 'Approved' ? 'selected' : '') }}>
                Approved</option>
            <option value="Rejected"
                {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->status == 'Rejected' ? 'selected' : (old('status') == 'Rejected' ? 'selected' : '') }}>
                Rejected</option>
        </select>
        @error('status')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="user-created">{{ __('User') }}</label>
        <select class="form-control @error('user_created') is-invalid @enderror" name="user_created" id="user-created"
            required>
            <option value="" selected disabled>-- {{ __('Select user') }} --</option>

            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->user_created == $user->id ? 'selected' : (old('user_created') == $user->id ? 'selected' : '') }}>
                    {{ $user->user_nip }}
                </option>
            @endforeach
        </select>
        @error('user_created')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="tanggal-pengajuan">{{ __('Tanggal Pengajuan') }}</label>
        <input type="datetime-local" name="tanggal_pengajuan" id="tanggal-pengajuan"
            class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
            value="{{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->tanggal_pengajuan ? $nomenklaturPembelajaran->tanggal_pengajuan->format('Y-m-d\TH:i') : old('tanggal_pengajuan') }}"
            placeholder="{{ __('Tanggal Pengajuan') }}" required />
        @error('tanggal_pengajuan')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="catatan-user-created">{{ __('Catatan User Created') }}</label>
            <textarea name="catatan_user_created" id="catatan-user-created"
                class="form-control @error('catatan_user_created') is-invalid @enderror"
                placeholder="{{ __('Catatan User Created') }}" required>{{ isset($nomenklaturPembelajaran) ? $nomenklaturPembelajaran->catatan_user_created : old('catatan_user_created') }}</textarea>
            @error('catatan_user_created')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="user-review">{{ __('User') }}</label>
        <select class="form-control @error('user_review') is-invalid @enderror" name="user_review" id="user-review"
            required>
            <option value="" selected disabled>-- {{ __('Select user') }} --</option>

            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->user_review == $user->id ? 'selected' : (old('user_review') == $user->id ? 'selected' : '') }}>
                    {{ $user->user_nip }}
                </option>
            @endforeach
        </select>
        @error('user_review')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="col-md-6 mb-2">
        <label for="tanggal-review">{{ __('Tanggal Review') }}</label>
        <input type="datetime-local" name="tanggal_review" id="tanggal-review"
            class="form-control @error('tanggal_review') is-invalid @enderror"
            value="{{ isset($nomenklaturPembelajaran) && $nomenklaturPembelajaran->tanggal_review ? $nomenklaturPembelajaran->tanggal_review->format('Y-m-d\TH:i') : old('tanggal_review') }}"
            placeholder="{{ __('Tanggal Review') }}" required />
        @error('tanggal_review')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="catatan-user-review">{{ __('Catatan User Review') }}</label>
            <textarea name="catatan_user_review" id="catatan-user-review"
                class="form-control @error('catatan_user_review') is-invalid @enderror"
                placeholder="{{ __('Catatan User Review') }}" required>{{ isset($nomenklaturPembelajaran) ? $nomenklaturPembelajaran->catatan_user_review : old('catatan_user_review') }}</textarea>
            @error('catatan_user_review')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
