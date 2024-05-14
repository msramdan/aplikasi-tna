@extends('layouts.app')

@section('title', __('Detail of Asramas'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Asramas') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('asramas.index') }}">{{ __('Asramas') }}</a>
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
                                            <td class="fw-bold">{{ __('Nama Asrama') }}</td>
                                            <td>{{ $asrama->nama_asrama }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Lokasi') }}</td>
                                        <td>{{ $asrama->lokasi ? $asrama->lokasi->id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Kuota') }}</td>
                                            <td>{{ $asrama->kuota }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Starus Asrama') }}</td>
                                            <td>{{ $asrama->starus_asrama }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Keterangan') }}</td>
                                            <td>{{ $asrama->keterangan }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $asrama->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $asrama->updated_at->format('d/m/Y H:i') }}</td>
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
