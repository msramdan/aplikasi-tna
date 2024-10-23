@extends('layouts.app')

@section('title', trans('profile.profile'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('profile.profile') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">{{ trans('profile.dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ trans('profile.profile') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile --}}
            <div class="row">
                <div class="col-md-3">
                    <h4>{{ trans('profile.data') }}</h4>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('user-profile-information.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label for="name">{{ trans('profile.name') }}</label>
                                    <input type="text" name="name" readonly
                                        class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror"
                                        id="name" placeholder="{{ trans('profile.name') }}"
                                        value="{{ old('name') ?? auth()->user()->name }}" required>
                                    @error('name', 'updateProfileInformation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">{{ trans('profile.email') }}</label>
                                    <input type="email" name="email" readonly
                                        class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror"
                                        id="email" placeholder="{{ trans('profile.email') }}"
                                        value="{{ old('email') ?? auth()->user()->email }}" required>
                                    @error('email', 'updateProfileInformation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone">No Wa</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone', 'updateProfileInformation') is-invalid @enderror"
                                        id="phone" placeholder="No Wa"
                                        value="{{ old('phone') ?? auth()->user()->phone }}" required>
                                    @error('phone', 'updateProfileInformation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div class="avatar avatar-xl mb-3">
                                            @if (auth()->user()->avatar == null)
                                                <img class="img-thumbnail" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=500" alt="Avatar">
                                            @else
                                                <img class="img-thumbnail" src="{{ asset('uploads/images/avatars/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 120px">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="avatar">{{ trans('profile.avatar') }}</label>
                                            <input type="file" name="avatar" class="form-control @error('avatar', 'updateProfileInformation') is-invalid @enderror" id="avatar">
                                            @error('avatar', 'updateProfileInformation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ trans('profile.update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
