@extends('layouts.app')

@section('title', __('ruang-kelas\edit.edit_ruang_kelass'))

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('ruang-kelas\edit.ruang_kelass') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('ruang-kelas.index') }}">{{ __('ruang-kelas\edit.ruang_kelass') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('ruang-kelas\edit.edit') }}
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
                            <form action="{{ route('ruang-kelas.update', $ruangKelas->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('ruang-kelas.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i> {{ __('ruang-kelas\edit.back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> {{ __('ruang-kelas\edit.update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
