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
                @if ($settingApp->logo != '' || $settingApp->logo != null)
                    <img style="width: 180px;" src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}" class="">
                    <p style="color: red">* {{ trans('setting-apps/form.change_logo') }}</p>
                @endif
                <label class="form-label" for="logo"> {{ trans('setting-apps/form.logo') }}</label>
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                    name="logo" onchange="previewImg()" value="{{ $settingApp->logo }}">
                @error('logo')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-12 mb-3">
                @if ($settingApp->favicon != '' || $settingApp->favicon != null)
                    <img style="width:100px;height:90px"
                        src="{{ Storage::url('public/img/setting_app/') . $settingApp->favicon }}" class="">
                    <p style="color: red">* {{ trans('setting-apps/form.change_favicon') }}</p>
                @endif
                <label class="form-label" for="favicon"> {{ trans('setting-apps/form.favicon') }}</label>
                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon"
                    name="favicon" onchange="previewImg()" value="{{ $settingApp->favicon }}">
                @error('favicon')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
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
        </div>
    </div>
</div>
