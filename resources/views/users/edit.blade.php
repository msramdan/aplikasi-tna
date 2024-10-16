@extends('layouts.app')

@section('title', __('users/edit.Edit User'))

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('users/edit.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('users/edit.Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('users.index') }}">{{ trans('users/edit.head') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('users/edit.Edit') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('users.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>

                                <button type="submit" class="btn btn-primary"> <i class="mdi mdi-content-save"></i> Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
