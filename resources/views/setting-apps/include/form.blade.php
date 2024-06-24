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
        </div>
    </div>
</div>
