@extends('layouts.app')

@section('title', __('Detail of ruang kelass'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('ruang kelass') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('ruang-kelas.index') }}">{{ __('ruang kelass') }}</a>
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
                                            <td class="fw-bold">{{ __('Nama Kelas') }}</td>
                                            <td>{{ $ruangKela->nama_kelas }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Lokasi') }}</td>
                                        <td>{{ $ruangKela->lokasi ? $ruangKela->lokasi->id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Kuota') }}</td>
                                            <td>{{ $ruangKela->kuota }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Status') }}</td>
                                            <td>{{ $ruangKela->status }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                                            <td>{{ $ruangKela->keterangan }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $ruangKela->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $ruangKela->updated_at->format('d/m/Y H:i') }}</td>
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
