@extends('layouts.app')

@section('title', __('Reporting'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Reporting') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Reporting') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="tahun" id="tahun" class="form-control select2-form">
                                            @php
                                                $startYear = 2023;
                                                $currentYear = date('Y');
                                                $endYear = $currentYear + 1;
                                            @endphp
                                            @foreach (range($startYear, $endYear) as $year)
                                                <option value="{{ $year }}">
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="sumber_dana" id="sumber_dana" class="form-control select2-form">
                                            <option value="">All sumber dana</option>
                                            <option value="">RM</option>
                                            <option value="">START</option>
                                            <option value="">PNBP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-4">
                                        <select name="peserta" id="peserta" class="form-control select2-form">
                                            <option value="">All peserta</option>
                                            <option value="">BPKP</option>
                                            <option value="">APIP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
