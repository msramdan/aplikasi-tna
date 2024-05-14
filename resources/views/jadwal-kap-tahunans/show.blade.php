@extends('layouts.app')

@section('title', __('Detail of Jadwal Kap Tahunans'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Jadwal Kap Tahunans') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('jadwal-kap-tahunans.index') }}">{{ __('Jadwal Kap Tahunans') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('Detail') }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                            <td class="fw-bold">{{ __('Tahun') }}</td>
                                            <td>{{ $jadwalKapTahunan->tahun }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tanggal Mulai') }}</td>
                                            <td>{{ isset($jadwalKapTahunan->tanggal_mulai) ? $jadwalKapTahunan->tanggal_mulai->format('d/m/Y') : ''  }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Tanggal Selesai') }}</td>
                                            <td>{{ isset($jadwalKapTahunan->tanggal_selesai) ? $jadwalKapTahunan->tanggal_selesai->format('d/m/Y') : ''  }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $jadwalKapTahunan->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $jadwalKapTahunan->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
@endsection
