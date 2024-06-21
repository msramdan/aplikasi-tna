<div class="row">
    <div class="col-md-12 mb-3">
        <div class="form-group">
            <label for="name">{{ trans('users\form.name') }}</label>
            <input readonly type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ trans('users\form.name') }}"
                value="{{ isset($user) ? $user->name : old('name') }}" required autofocus>
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="form-group">
            <label for="email">{{ trans('users\form.email') }}</label>
            <input readonly type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="{{ trans('users\form.email') }}"
                value="{{ isset($user) ? $user->email : old('email') }}" required>
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($user)
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="role">{{ trans('users\form.role') }}</label>
                <select class="form-select js-example-basic-multiple" name="role" id="role" class="form-control"
                    required>
                    <option value="" selected disabled>{{ trans('users\form.select_role') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ $user->getRoleNames()->toArray() !== [] && $user->getRoleNames()[0] == $role->name ? 'selected' : '-' }}>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    @isset($user)
        <div class="col-md-4 text-center mb-3">
            <div class="avatar avatar-xl">
                @if ($user->avatar == null)
                    <img class="img-thumbnail"
                        src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}&s=450"
                        alt="avatar">
                @else
                    <img style="70px" class="img-thumbnail" src="{{ asset("uploads/images/avatars/$user->avatar") }}"
                        alt="avatar">
                @endif
            </div>
        </div>

        <div class="col-md-8 mb-3">
            <div class="form-group">
                <label for="avatar">{{ trans('users\form.avatar') }}</label>
                <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                    id="avatar">
                @error('avatar')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
                @if ($user->avatar == null)
                    <div id="passwordHelpBlock" class="form-text">
                        {{ trans('users\form.note_avatar') }}
                    </div>
                @endif
            </div>
        </div>
    @endisset
</div>


@push('js')
    <script>
        function toggleShowPassword() {
            const type = $('input#password').attr('type');
            if (type === "password") {
                $('input#password').attr('type', 'text');
                $('input#password-confirmation').attr('type', 'text');
            } else {
                $('input#password').attr('type', 'password');
                $('input#password-confirmation').attr('type', 'password');
            }
        }

        function generatePassword() {
            let password = "";
            let passwordLength = 1;

            const lowerCase = 'abcdefghijklmnopqrstuvwxyz'
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * lowerCase.length);
                password += lowerCase.substring(randomNumber, randomNumber + 1);
            }

            passwordLength = 1;
            const number = '0123456789'
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * number.length);
                password += number.substring(randomNumber, randomNumber + 1);
            }

            passwordLength = 1;
            const upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * upperCase.length);
                password += upperCase.substring(randomNumber, randomNumber + 1);
            }

            passwordLength = 1;
            const character = '!@#$%^&*()'
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * character.length);
                password += character.substring(randomNumber, randomNumber + 1);
            }

            const allChars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            passwordLength = 4;
            for (let i = 0; i < passwordLength; i++) {
                const randomNumber = Math.floor(Math.random() * allChars.length);
                password += allChars.substring(randomNumber, randomNumber + 1);
            }

            const shuffled = password.split('').sort(function() {
                return 0.5 - Math.random()
            }).join('');
            $('input#password').val(shuffled);
            $('input#password').attr('type', 'text')

            $('input#password-confirmation').val(shuffled);
            $('input#password-confirmation').attr('type', 'text')
        }
    </script>
@endpush
