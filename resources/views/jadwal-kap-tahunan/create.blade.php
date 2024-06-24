@extends('layouts.app')

@section('title', __('jadwal-kap-tahunan/create.Create Jadwal Kap Tahunan'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('jadwal-kap-tahunan/create.Jadwal Kap Tahunan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('jadwal-kap-tahunan/create.Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('jadwal-kap-tahunan.index') }}">{{ __('jadwal-kap-tahunan/create.Jadwal Kap Tahunan') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('jadwal-kap-tahunan/create.Create') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('jadwal-kap-tahunan.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('jadwal-kap-tahunan.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('jadwal-kap-tahunan/create.Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('jadwal-kap-tahunan/create.Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
