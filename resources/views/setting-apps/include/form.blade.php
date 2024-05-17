<div class="row mb-2">
    <div class="col-md-6">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="aplication-name">{{ trans('utilities/setting/setting.appname') }}</label>
                <input type="text" name="aplication_name" id="aplication-name"
                    class="form-control @error('aplication_name') is-invalid @enderror"
                    value="{{ isset($settingApp) ? $settingApp->aplication_name : old('aplication_name') }}"
                    placeholder="{{ trans('utilities/setting/setting.appname') }}" required />
                @error('aplication_name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="col-12 mb-3">
                @if ($settingApp->logo != '' || $settingApp->logo != null)
                    <img style="width: 180px;" src="{{ Storage::url('public/img/setting_app/') . $settingApp->logo }}"
                        class="">
                    <p style="color: red">* {{ trans('utilities/setting/setting.change_logo') }}</p>
                @endif
                <label class="form-label" for="logo"> {{ trans('utilities/setting/setting.logo') }}</label>
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
                    <p style="color: red">* {{ trans('utilities/setting/setting.change_favicon') }}</p>
                @endif
                <label class="form-label" for="favicon"> {{ trans('utilities/setting/setting.favicon') }}</label>
                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon"
                    name="favicon" onchange="previewImg()" value="{{ $settingApp->favicon }}">
                @error('favicon')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="col-12 mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Is Hit E-Sakip ?</label>
                </div>
                <div class="alert alert-primary" role="alert">
                    A simple primary alert—check it out!
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
