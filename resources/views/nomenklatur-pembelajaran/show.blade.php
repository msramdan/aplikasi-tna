@extends('layouts.app')

@section('title', __('Detail of Nomenklatur Pembelajaran'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Nomenklatur Pembelajaran') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('nomenklatur-pembelajarans.index') }}">{{ __('Nomenklatur Pembelajaran') }}</a>
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
                                        <td class="fw-bold">{{ __('Rumpun Pembelajaran') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->rumpun_pembelajaran ? $nomenklaturPembelajaran->rumpun_pembelajaran->id : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama Topik') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->nama_topik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->user ? $nomenklaturPembelajaran->user->user_nip : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Pengajuan') }}</td>
                                        <td>{{ isset($nomenklaturPembelajaran->tanggal_pengajuan) ? $nomenklaturPembelajaran->tanggal_pengajuan->format('d/m/Y H:i') : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Catatan User Created') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->catatan_user_created }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->user ? $nomenklaturPembelajaran->user->user_nip : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Review') }}</td>
                                        <td>{{ isset($nomenklaturPembelajaran->tanggal_review) ? $nomenklaturPembelajaran->tanggal_review->format('d/m/Y H:i') : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Catatan User Review') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->catatan_user_review }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $nomenklaturPembelajaran->updated_at->format('d/m/Y H:i') }}</td>
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
