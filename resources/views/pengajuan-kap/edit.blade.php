@extends('layouts.app')

@section('title', __('Edit Pengajuan Kap'))

@section('content')


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Pengajuan Kap') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('pengajuan-kap.index', [
                                            'is_bpkp' => $is_bpkp,
                                            'frekuensi' => $frekuensi,
                                        ]) }}">{{ __('Pengajuan Kap') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <form
                action="{{ route('pengajuan-kap.update', ['id' => $pengajuanKap->id, 'is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                @include('pengajuan-kap.include.form')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-info" role="alert">
                                    Waktu pelaksanaan
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        <label for="alokasi-waktu">{{ __('Alokasi Waktu') }}</label>

                                        <div class="input-group">
                                            <input type="number" name="alokasi_waktu" id="alokasi-waktu"
                                                class="form-control @error('alokasi_waktu') is-invalid @enderror"
                                                value="{{ isset($pengajuanKap) ? $pengajuanKap->alokasi_waktu : old('alokasi_waktu') }}"
                                                placeholder="{{ __('Alokasi Waktu') }}" required />
                                            <span class="input-group-text" id="basic-addon2">Hari</span>
                                        </div>
                                        @error('alokasi_waktu')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('pengajuan-kap.index', [
                    'is_bpkp' => $is_bpkp,
                    'frekuensi' => $frekuensi,
                ]) }}"
                    class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i>
                    {{ __('Back') }}</a>

                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                    {{ __('Update') }}</button>
            </form>
        </div>
    </div>
@endsection
