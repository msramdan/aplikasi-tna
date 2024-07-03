@extends('layouts.app')

@section('title', __('Detail of Pengajuan Kap'))

@section('content')

    <style>
        .btn-gray {
            background-color: gray;
            color: white;
            border-color: gray;
        }
    </style>

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Pengajuan Kap') }}</h3>
                        <ol class="breadcrumb">
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm">
                                    <tr>
                                        <td class="fw-bold">{{ __('Kode Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->kode_pembelajaran }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Institusi Sumber') }}</td>
                                        <td>{{ $pengajuanKap->institusi_sumber }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Jenis Progran') }}</td>
                                        <td>{{ $pengajuanKap->jenis_program }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Frekuensi pelaksanaan') }}</td>
                                        <td>{{ $pengajuanKap->frekuensi_pelaksanaan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Indikator Kinerja') }}</td>
                                        <td>{{ $pengajuanKap->indikator_kinerja }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kompetensi') }}</td>
                                        <td>{{ $pengajuanKap->nama_kompetensi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Topik') }}</td>
                                        <td>{{ $pengajuanKap->nama_topik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Concern Program Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->concern_program_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Alokasi Waktu') }}</td>
                                        <td>{{ $pengajuanKap->alokasi_waktu }} Hari</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</td>
                                        <td>{{ $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Skill Group Owner') }}</td>
                                        <td>{{ $pengajuanKap->skill_group_owner }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jalur Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->jalur_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Model Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->model_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jenis Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->jenis_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Metode Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->metode_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Sasaran Peserta') }}</td>
                                        <td>{{ $pengajuanKap->sasaran_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kriteria Peserta') }}</td>
                                        <td>{{ $pengajuanKap->kriteria_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Aktivitas Prapembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->aktivitas_prapembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Penyelenggara Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->penyelenggara_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Fasilitator Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->fasilitator_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Sertifikat') }}</td>
                                        <td>{{ $pengajuanKap->sertifikat }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal dibuat') }}</td>
                                        <td>{{ $pengajuanKap->tanggal_created }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status pengajuan') }}</td>
                                        <td>
                                            @if ($pengajuanKap->status_pengajuan == 'Pending')
                                                <button style="width:150px" class="btn btn-gray btn-sm btn-block">
                                                    <i class="fa fa-clock" aria-hidden="true"></i> Pending
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Approved')
                                                <button style="width:150px" class="btn btn-success btn-sm btn-block">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Approved
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Rejected')
                                                <button style="width:150px" class="btn btn-danger btn-sm btn-block">
                                                    <i class="fa fa-times" aria-hidden="true"></i> Rejected
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Process')
                                                <button style="width:150px" class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-spinner" aria-hidden="true"></i> Process
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('User created') }}</td>
                                        <td>{{ $pengajuanKap->user_name }}</td>
                                    </tr>

                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <br>
        </div>
    </div>
@endsection
