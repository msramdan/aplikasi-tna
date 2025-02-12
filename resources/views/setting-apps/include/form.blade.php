<div class="row mb-2">
    <div class="col-md-6">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="aplication-name">{{ trans('setting-apps/form.appname') }}</label>
                <input type="text" name="aplication_name" id="aplication-name"
                    class="form-control @error('aplication_name') is-invalid @enderror"
                    value="{{ isset($settingApp) ? $settingApp->aplication_name : old('aplication_name') }}"
                    placeholder="{{ trans('setting-apps/form.appname') }}" required />
                @error('aplication_name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="col-12 mb-3">
                @if ($settingApp->logo)
                    <img style="width: 180px;" src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}">
                    <p style="color: red">* {{ trans('setting-apps/form.change_logo') }}</p>
                @endif
                <label class="form-label" for="logo"> {{ trans('setting-apps/form.logo') }}</label>
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                <p class="text-muted">* Format yang diperbolehkan: JPG, JPEG, PNG, WEBP</p>
                @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-12 mb-3">
                @if ($settingApp->favicon)
                    <img style="width:100px;height:90px" src="{{ Storage::url('public/img/setting_app/') . $settingApp->favicon }}">
                    <p style="color: red">* {{ trans('setting-apps/form.change_favicon') }}</p>
                @endif
                <label class="form-label" for="favicon"> {{ trans('setting-apps/form.favicon') }}</label>
                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon">
                <p class="text-muted">* Format yang diperbolehkan: JPG, JPEG, PNG, WEBP</p>
                @error('favicon')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="is_maintenance">Is Maintenance</label>
                <select class="form-control js-example-basic-multiple @error('is_maintenance') is-invalid @enderror" name="is_maintenance"
                    id="is_maintenance" required>
                    <option value="" selected disabled>-- Pilih --</option>
                    <option value="Yes"
                        {{ isset($settingApp) && $settingApp->is_maintenance == 'Yes' ? 'selected' : (old('is_maintenance') == 'Yes' ? 'selected' : '') }}>
                        Yes</option>
                    <option value="No"
                        {{ isset($settingApp) && $settingApp->is_maintenance == 'No' ? 'selected' : (old('is_maintenance') == 'No' ? 'selected' : '') }}>
                        No</option>
                </select>
                @error('is_maintenance')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="otomatis_sync_info_diklat">Otomatis Sync Info Diklat</label>
                <select class="form-control js-example-basic-multiple @error('otomatis_sync_info_diklat') is-invalid @enderror" name="otomatis_sync_info_diklat"
                    id="otomatis_sync_info_diklat" required>
                    <option value="" selected disabled>-- Pilih --</option>
                    <option value="Yes"
                        {{ isset($settingApp) && $settingApp->otomatis_sync_info_diklat == 'Yes' ? 'selected' : (old('otomatis_sync_info_diklat') == 'Yes' ? 'selected' : '') }}>
                        Yes</option>
                    <option value="No"
                        {{ isset($settingApp) && $settingApp->otomatis_sync_info_diklat == 'No' ? 'selected' : (old('otomatis_sync_info_diklat') == 'No' ? 'selected' : '') }}>
                        No</option>
                </select>
                @error('otomatis_sync_info_diklat')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="reverse_atur_tagging">Reverse Atur Tagging</label>
                <select class="form-control js-example-basic-multiple @error('reverse_atur_tagging') is-invalid @enderror" name="reverse_atur_tagging"
                    id="reverse_atur_tagging" required>
                    <option value="" selected disabled>-- Pilih --</option>
                    <option value="Yes"
                        {{ isset($settingApp) && $settingApp->reverse_atur_tagging == 'Yes' ? 'selected' : (old('reverse_atur_tagging') == 'Yes' ? 'selected' : '') }}>
                        Yes</option>
                    <option value="No"
                        {{ isset($settingApp) && $settingApp->reverse_atur_tagging == 'No' ? 'selected' : (old('reverse_atur_tagging') == 'No' ? 'selected' : '') }}>
                        No</option>
                </select>
                @error('reverse_atur_tagging')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <div id="reverse-info" class="col-md-12 mb-3" style="display: none;">
                    <div id="yes-info" style="display: none;">
                        <ul>
                            <li>Tagging IK & Kompetensi</li>
                            <li>Tagging Kompetensi & Pembelajaran</li>
                        </ul>
                    </div>
                    <div id="no-info" style="display: none;">
                        <ul>
                            <li>Tagging Pembelajaran & Kompetensi</li>
                            <li>Tagging Kompetensi & IK</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
