@extends('layouts.app')

@section('title', __('jadwal-kap-tahunan\edit.Edit Jadwal Kap Tahunan'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('jadwal-kap-tahunan\edit.Edit Jadwal Kap Tahunan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('jadwal-kap-tahunan\edit.Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('jadwal-kap-tahunan.index') }}">{{ __('jadwal-kap-tahunan\edit.Jadwal Kap Tahunan') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('jadwal-kap-tahunan\edit.Edit') }}
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
                            <form action="{{ route('jadwal-kap-tahunan.update', $jadwalKapTahunan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('jadwal-kap-tahunan.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('jadwal-kap-tahunan\edit.Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('jadwal-kap-tahunan\edit.Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
