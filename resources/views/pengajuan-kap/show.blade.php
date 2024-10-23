@extends('layouts.app')

@section('title', __('Detail of Pengusulan Pembelajaran'))

@section('content')

    <style>
        .btn-gray {
            background-color: gray;
            color: white;
            border-color: gray;
        }
    </style>

    <style>
        .wizard-container {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            max-width: 800px;
            background-color: white;
        }

        .wizard-steps {
            position: relative;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #ccc;
            width: 20%;
            min-width: 150px;
            background-color: #f0f0f0;
        }

        .step {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            cursor: pointer;
        }

        .step-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            margin-bottom: 10px;
            color: white;
            font-size: 18px;
            z-index: 1;
        }

        .step-label {
            font-size: 14px;
            color: #666;
            text-align: center;
            z-index: 1;
        }

        .step.active .step-icon {
            background-color: green;
        }

        .step.active .step-label {
            color: green;
        }

        .wizard-content {
            flex-grow: 1;
            padding: 20px;
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        /* Add the vertical line */
        .wizard-steps::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 100%;
            width: 4px;
            background-color: #ddd;
            z-index: -1;
            /* Z-index diperkecil untuk memastikan garis berada di belakang konten */
        }

        .step {
            position: relative;
            /* Pastikan step memiliki posisi relatif untuk referensi elemen ::after */
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateY(-50%);
            height: calc(100% + 20px);
            width: 4px;
            background-color: #ddd;
            z-index: 0;
            /* Z-index diperkecil untuk memastikan garis berada di belakang konten */
        }

        .step.active:not(:last-child)::after {
            background-color: green;
            opacity: 0.2;
        }


        /* Add animation for current step */
        .step.process .step-icon {
            background-color: gray;
            animation: pulse 1s infinite alternate;
        }

        .step.process .step-label {
            color: gray;
        }

        .step.rejected .step-icon {
            background-color: #f06548;
            animation: pulse-red 1s infinite alternate;
        }

        .step.rejected .step-label {
            color: #;
        }

        .step.skiped .step-icon {
            background-color: #ffbe0b;
            animation: pulse-orange 1s infinite alternate;
        }

        .step.skiped .step-label {
            color: #ffbe0b;
        }

        .step.skiped:not(:last-child)::after {
            background-color: #ffbe0b;
            opacity: 0.2;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(128, 128, 128, 0.7);
                /* Warna abu-abu dengan opacity 0.7 */
            }

            100% {
                box-shadow: 0 0 0 10px rgba(128, 128, 128, 0);
                /* Transparansi penuh untuk fade out */
            }
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7);
                /* Warna merah dengan opacity 0.7 */
            }

            100% {
                box-shadow: 0 0 0 10px rgba(255, 0, 0, 0);
                /* Transparansi penuh untuk fade out */
            }
        }
    </style>

    <style>
        /* CSS untuk textarea agar otomatis lebar ke bawah */
        .reply-textarea {
            min-height: 40px;
            /* Tinggi minimum */
            max-height: 200px;
            /* Batas tinggi maksimal */
            overflow-y: auto;
            /* Scroll vertikal jika melebihi batas */
            resize: none;
            /* Nonaktifkan pengaturan ulang manual */
        }
    </style>

    <style>
        .reply-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .user-avatar {
            margin-right: 10px;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .reply-content {
            background-color: #f0f2f5;
            text-align: justify;
            padding: 10px;
            border-radius: 18px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .full-message {
            display: none;
        }

        .d-none {
            display: none;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Pengusulan Pembelajaran') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('pengajuan-kap.index', [
                                        'is_bpkp' => $is_bpkp,
                                        'frekuensi' => $frekuensi,
                                    ]) }}">{{ __('Pengusulan Pembelajaran') }}</a>
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
                            <div class="col-md-12">
                                <a href="{{ route('pengajuan-kap.index', [
                                    'is_bpkp' => $is_bpkp,
                                    'frekuensi' => $frekuensi,
                                ]) }}"
                                    class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    {{ __('Kembali') }}</a>

                                @php
                                    $reviewExistsForUser = reviewExistsForUser();
                                @endphp
                                @if ($reviewExistsForUser)
                                    @if (
                                        $pengajuanKap->status_pengajuan == 'Rejected' ||
                                            $pengajuanKap->status_pengajuan == 'Approved' ||
                                            $pengajuanKap->status_pengajuan == 'Revision')
                                        <button type="button" disabled class="btn btn-success">
                                            <i class="fa fa-check" aria-hidden="true"></i> Approve
                                        </button>
                                        <button type="button" disabled class="btn btn-gray">
                                            <i class="fa fa-refresh" aria-hidden="true"></i> Revision
                                        </button>
                                        <button type="button" disabled class="btn btn-danger">
                                            <i class="fa fa-times" aria-hidden="true"></i> Reject
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#approveModal" {{ $userHasAccess ? '' : 'disabled' }}>
                                            <i class="fa fa-check" aria-hidden="true"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-gray" data-bs-toggle="modal"
                                            data-bs-target="#revisionModal" {{ $userHasAccess ? '' : 'disabled' }}>
                                            <i class="fa fa-refresh" aria-hidden="true"></i> Revision
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal" {{ $userHasAccess ? '' : 'disabled' }}>
                                            <i class="fa fa-times" aria-hidden="true"></i> Reject
                                        </button>
                                    @endif
                                @endif
                            </div>
                            <br>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="icon-tab-0" data-bs-toggle="tab" href="#icon-tabpanel-0"
                                        role="tab" aria-controls="icon-tabpanel-0" aria-selected="true"><i
                                            class="fa-solid fa-1 fa-fw"></i> Konteks Pembelajaran</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="icon-tab-1" data-bs-toggle="tab" href="#icon-tabpanel-1"
                                        role="tab" aria-controls="icon-tabpanel-1" aria-selected="false"><i
                                            class="fa-solid fa-2 fa-fw"></i> Detil Pembelajaran</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="icon-tab-2" data-bs-toggle="tab" href="#icon-tabpanel-2"
                                        role="tab" aria-controls="icon-tabpanel-2" aria-selected="false"><i
                                            class="fa-solid fa-3 fa-fw"></i> Peserta dan Fasilitator</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-5" id="tab-content">
                                <div class="tab-pane active" id="icon-tabpanel-0" role="tabpanel"
                                    aria-labelledby="icon-tab-0">
                                    <table class="table table-hover table-striped table-sm">
                                        <tr>
                                            <td class="fw-bold">{{ __('Kode Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->kode_pembelajaran ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Institusi') }}</td>
                                            <td>{{ $pengajuanKap->institusi_sumber ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Unit Pengusul') }}</td>
                                            <td>{{ $pengajuanKap->nama_unit ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Nama Pengusul') }}</td>
                                            <td>{{ $pengajuanKap->user_name ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Jenis Program') }}</td>
                                            <td>{{ $pengajuanKap->jenis_program ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Frekuensi pelaksanaan') }}</td>
                                            <td>{{ $pengajuanKap->frekuensi_pelaksanaan ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Indikator Kinerja') }}</td>
                                            <td>{{ $pengajuanKap->indikator_kinerja ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Kompetensi') }}</td>
                                            <td>{{ $pengajuanKap->nama_kompetensi ?: '-' }}
                                                @if (isset($gap_kompetensi_pengajuan_kap))
                                                    <table class="table table-bordered table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="text-center">Total pegawai</th>
                                                                <th scope="col" class="text-center">Pegawai kompeten
                                                                </th>
                                                                <th scope="col" class="text-center">Pegawai belum
                                                                    kompeten</th>
                                                                <th scope="col" class="text-center">Persentase
                                                                    kompetensi
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{ $gap_kompetensi_pengajuan_kap->total_pegawai }}</td>
                                                                <td class="text-center">
                                                                    {{ $gap_kompetensi_pengajuan_kap->pegawai_kompeten }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $gap_kompetensi_pengajuan_kap->pegawai_belum_kompeten }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $gap_kompetensi_pengajuan_kap->persentase_kompetensi }}
                                                                    %</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Program pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->nama_topik ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Judul Program pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->judul ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Arahan pimpinan/isu terkini/dll') }}</td>
                                            <td>{{ $pengajuanKap->arahan_pimpinan ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Prioritas Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->prioritas_pembelajaran ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Tujuan Program Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->tujuan_program_pembelajaran ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Indikator Keberhasilan') }}</td>
                                            <td>
                                                @if (!$indikator_keberhasilan_kap->isEmpty())
                                                    <table class="table table-bordered table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Peserta Mampu</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($indikator_keberhasilan_kap as $item)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $item->indikator_keberhasilan ?: '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}
                                            </td>
                                            <td>{{ $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi ?: '-' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}
                                            </td>
                                            <td>{{ $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Skill Group Owner') }}</td>
                                            <td>{{ $pengajuanKap->skill_group_owner ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Tanggal dibuat') }}</td>
                                            <td>{{ $pengajuanKap->tanggal_created ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Current step') }}</td>
                                            <td>Step {{ $pengajuanKap->current_step ?: '-' }} - {{ $currentStepRemark }}
                                            </td>
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
                                                @elseif ($pengajuanKap->status_pengajuan == 'Revision')
                                                    <button style="width:150px" class="btn btn-gray btn-sm btn-block">
                                                        <i class="fa fa-refresh" aria-hidden="true"></i> Revision
                                                    </button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Status Sync') }}</td>
                                            <td>
                                                @if ($pengajuanKap->status_sync == 'Waiting')
                                                    <button style="width:150px" class="btn btn-gray btn-sm btn-block">
                                                        <i class="fa fa-clock" aria-hidden="true"></i> Waiting
                                                    </button>
                                                @elseif ($pengajuanKap->status_sync == 'Success')
                                                    <button style="width:150px" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-check" aria-hidden="true"></i> Success
                                                    </button>
                                                @elseif ($pengajuanKap->status_sync == 'Failed')
                                                    <button style="width:150px" class="btn btn-danger btn-sm btn-block">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Failed
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('User created') }}</td>
                                            <td>{{ $pengajuanKap->user_name ?: '-' }}</td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="tab-pane" id="icon-tabpanel-1" role="tabpanel" aria-labelledby="icon-tab-1">
                                    <table class="table table-hover table-striped table-sm">
                                        <tr>
                                            <td class="fw-bold">{{ __('Metode Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->metodeName ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"></td>
                                            <td>
                                                @if ($waktu_pelaksanaan->isEmpty())
                                                    <span class="text-muted">-</span>
                                                @else
                                                    <table class="table table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Pelaksanaan</th>
                                                                <th scope="col">Tgl Mulai</th>
                                                                <th scope="col">Tgl Selesai</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($waktu_pelaksanaan as $row)
                                                            <tr>
                                                                <td>{{ $row->remarkMetodeName ?: '-' }}</td>
                                                                <td>{{ $row->tanggal_mulai ?: '-' }}</td>
                                                                <td>{{ $row->tanggal_selesai ?: '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Lokasi') }}</td>
                                            <td>{{ $pengajuanKap->diklatLocName ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Tempat / Alamat Rinci') }}</td>
                                            <td>{{ $pengajuanKap->detail_lokasi ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Jumlah Kelas') }}</td>
                                            <td>{{ $pengajuanKap->kelas ?: '-' }} Kelas</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Bentuk Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->bentuk_pembelajaran ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Jalur Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->jalur_pembelajaran ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Model Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->model_pembelajaran ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Jenis Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->diklatTypeName ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Sumber dana') }}</td>
                                            <td>{{ $pengajuanKap->biayaName ?: '-' }}</td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="tab-pane" id="icon-tabpanel-2" role="tabpanel" aria-labelledby="icon-tab-2">
                                    <table class="table table-hover table-striped table-sm">
                                        <tr>
                                            <td class="fw-bold">{{ __('Peserta Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->peserta_pembelajaran ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Sasaran Peserta') }}</td>
                                            <td>{{ $pengajuanKap->sasaran_peserta ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Kriteria Peserta') }}</td>
                                            <td>{{ $pengajuanKap->kriteria_peserta ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Aktivitas Prapembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->aktivitas_prapembelajaran ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">{{ __('Penyelenggara Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->penyelenggara_pembelajaran ?: '-' }}</td>
                                        </tr>

                                        @php
                                            $fasilitators = json_decode($pengajuanKap->fasilitator_pembelajaran);
                                        @endphp
                                        <tr>
                                            <td class="fw-bold">{{ __('Fasilitator Pembelajaran') }}</td>
                                            <td>
                                                @if ($fasilitators !== null && !empty($fasilitators))
                                                    @foreach ($fasilitators as $item)
                                                        <span class="badge bg-primary">{{ $item }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Sertifikat') }}</td>
                                            <td>{{ $pengajuanKap->sertifikat ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Level Evaluasi dan Instrumen') }}</td>
                                            <td>
                                                @if (!$level_evaluasi_instrumen_kap->isEmpty())
                                                    <table class="table table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Level</th>
                                                                <th scope="col">Instrumen</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($level_evaluasi_instrumen_kap as $item)
                                                            <tr>
                                                                <td>{{ $item->level ?: '-' }}</td>
                                                                <td>{{ $item->keterangan ?: '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card" style="position: relative;z-index: 10;">
                        <div class="wizard-container">
                            <div class="wizard-steps">

                                @foreach ($logReviews as $index => $log)
                                    <div
                                        class="step {{ $pengajuanKap->current_step == $index + 1 && in_array($log->status, ['Pending', 'Revision']) ? 'process' : '' }} {{ $log->status == 'Approved' ? 'active' : ($log->status == 'Rejected' ? 'rejected' : ($log->status == 'Skiped' ? 'skiped' : '')) }}">
                                        <div class="step-icon">{{ $index + 1 }}</div>
                                        <div class="step-label"><b>{{ $log->remark }}</b></div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="wizard-content">
                                @foreach ($logReviews as $index => $log)
                                    <div class="content {{ $log->step == $pengajuanKap->current_step ? 'active' : '' }}">
                                        <br>
                                        <h2>{{ $log->remark }}</h2>
                                        <div class="form-group">
                                            <p><strong>Pengguna:</strong> {{ $log->user_name ?? '-' }}</p>
                                            <p><strong>Status:</strong>
                                                @if ($log->status == 'Approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($log->status == 'Rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif ($log->status == 'Revision')
                                                    <span class="badge"
                                                        style="background-color: #6c757d; color: white;">Revisi</span>
                                                @else
                                                    -
                                                @endif
                                                . {{ $log->tanggal_review ?? '-' }}
                                            </p>
                                            <textarea id="notes-{{ $log->id }}" class="form-control" rows="10" readonly>Catatan: {{ $log->catatan }}</textarea>
                                        </div>

                                        <!-- Bagian balasan -->
                                        <div class="reply-section mt-3">
                                            <h5>Chat:</h5>

                                            <!-- Query langsung ke tabel replies -->
                                            @php
                                                $replies = \DB::table('log_review_pengajuan_kap_replies')
                                                    ->where('log_review_pengajuan_kap_id', $log->id)
                                                    ->get();
                                            @endphp

                                            <div class="reply-list" id="reply-list-{{ $log->id }}">
                                                @foreach ($replies as $reply)
                                                    @php
                                                        $maxLength = 100; // Maximum message length before truncation
                                                        $isLong = strlen($reply->message) > $maxLength;
                                                        $shortMessage = $isLong
                                                            ? substr($reply->message, 0, $maxLength) . '...'
                                                            : $reply->message;

                                                        // Fetch the user data based on the user name
                                                        $user = \App\Models\User::where(
                                                            'name',
                                                            $reply->user_name,
                                                        )->first();
                                                        $defaultAvatar = asset('path/to/default/avatar.jpg'); // Set your default avatar path here
                                                        $avatarPath = $defaultAvatar; // Default to the default avatar

                                                        if ($user) {
                                                            // If user exists, check for avatar
                                                            $avatarPath = $user->avatar
                                                                ? asset('uploads/images/avatars/' . $user->avatar)
                                                                : 'https://www.gravatar.com/avatar/' .
                                                                    md5(strtolower(trim($user->email))) .
                                                                    '?s=500';
                                                        }
                                                    @endphp

                                                    <div class="reply-item mb-2 d-flex">
                                                        <!-- Avatar -->
                                                        <div class="user-avatar">
                                                            <img src="{{ $avatarPath }}" alt="User Avatar"
                                                                class="avatar-img">
                                                        </div>

                                                        <!-- Pesan Balasan -->
                                                        <div class="reply-content">
                                                            <strong>{{ $reply->user_name }}:</strong>
                                                            <span class="short-message"
                                                                id="short-message-{{ $reply->id }}">{{ $shortMessage }}</span>
                                                            <span class="full-message"
                                                                id="full-message-{{ $reply->id }}"
                                                                style="display: none;">{{ $reply->message }}</span>

                                                            @if ($isLong)
                                                                <a href="javascript:void(0)" class="text-primary"
                                                                    id="toggle-link-{{ $reply->id }}"
                                                                    onclick="toggleMessage({{ $reply->id }})">Baca
                                                                    Selengkapnya</a>
                                                            @endif
                                                            <br>
                                                            <small>{{ $reply->created_at }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if ($pengajuanKap->current_step == $log->step && $log->status !== 'Approved')
                                                <div class="input-group mt-2">
                                                    <textarea id="reply-input-{{ $log->id }}" class="form-control reply-textarea" placeholder="Ketik balasan..."></textarea>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="submitReply({{ $log->id }})">Kirim</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">{{ __('Approve Pengusulan Pembelajaran') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="multiStepForm" action="{{ route('pengajuan-kap.approve', $pengajuanKap->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            @if ($pengajuanKap->current_step == 2)
                                <div class="form-step form-step-1">
                                    <div class="alert alert-info" role="alert">
                                        Detail Pembelajaran
                                    </div>
                                    <div class="mb-3">
                                        <label for="diklatLocID" class="form-label">{{ __('Lokasi') }}</label>
                                        <select class="form-control" name="diklatLocID" id="diklatLocID" required>
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach ($diklatLocation_data as $lokasi)
                                                <option value="{{ $lokasi['diklatLocID'] }}"
                                                    data-diklatlocname="{{ $lokasi['diklatLocName'] }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->diklatLocID == $lokasi['diklatLocID'] ? 'selected' : '' }}>
                                                    {{ $lokasi['diklatLocName'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="diklatLocName" id="diklatLocName"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->diklatLocName : '' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="detail_lokasi">{{ __('Tempat / Alamat Rinci') }}</label>
                                        <input type="text" name="detail_lokasi" id="detail_lokasi" required
                                            class="form-control"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->detail_lokasi : '' }}"
                                            placeholder="{{ __('Tempat / Alamat Rinci') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="kelas">{{ __('Jumlah Kelas') }}</label>
                                        <input type="number" name="kelas" id="kelas" class="form-control"
                                            required value="{{ isset($pengajuanKap) ? $pengajuanKap->kelas : '' }}"
                                            placeholder="{{ __('Jumlah Kelas') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="bentuk_pembelajaran"
                                            class="form-label">{{ __('Bentuk Pembelajaran') }}</label>
                                        <select class="form-control" name="bentuk_pembelajaran" id="bentuk_pembelajaran"
                                            required>
                                            <option value="" disabled>-- Pilih --</option>
                                            <option value="Klasikal"
                                                {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Klasikal' ? 'selected' : '' }}>
                                                Klasikal</option>
                                            <option value="Nonklasikal"
                                                {{ isset($pengajuanKap) && $pengajuanKap->bentuk_pembelajaran == 'Nonklasikal' ? 'selected' : '' }}>
                                                Nonklasikal</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jalur_pembelajaran"
                                            class="form-label">{{ __('Jalur Pembelajaran') }}</label>
                                        <select class="form-control" name="jalur_pembelajaran" id="jalur_pembelajaran"
                                            required>
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach ($jalur_pembelajaran as $row)
                                                <option value="{{ $row }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->jalur_pembelajaran == $row ? 'selected' : '' }}>
                                                    {{ $row }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="model_pembelajaran"
                                            class="form-label">{{ __('Model Pembelajaran') }}</label>
                                        <select class="form-control" required name="model_pembelajaran"
                                            id="model_pembelajaran">
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach (['Pembelajaran terstruktur', 'Pembelajaran kolaboratif', 'Pembelajaran di tempat kerja', 'Pembelajaran terintegrasi'] as $model)
                                                <option value="{{ $model }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->model_pembelajaran == $model ? 'selected' : '' }}>
                                                    {{ $model }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="diklatTypeID"
                                            class="form-label">{{ __('Jenis Pembelajaran') }}</label>
                                        <select class="form-control" name="diklatTypeID" id="diklatTypeID" required>
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach ($diklatType_data as $jenis)
                                                <option value="{{ $jenis['diklatTypeID'] }}"
                                                    data-diklattypename="{{ $jenis['diklatTypeName'] }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->diklatTypeID == $jenis['diklatTypeID'] ? 'selected' : '' }}>
                                                    {{ $jenis['diklatTypeName'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="diklatTypeName" id="diklatTypeName"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->diklatTypeName : '' }}">
                                    </div>
                                    <button type="button" class="btn btn-info btn-next">Next <i
                                            class="fa fa-arrow-right"></i></button>
                                </div>

                                <div class="form-step form-step-2" style="display: none;">
                                    <div class="alert alert-info" role="alert">
                                        Peserta dan Fasilitator
                                    </div>

                                    <div class="mb-3">
                                        <label for="peserta_pembelajaran"
                                            class="form-label">{{ __('Peserta Pembelajaran') }}</label>
                                        <select class="form-control" name="peserta_pembelajaran" required
                                            id="peserta_pembelajaran">
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach (['Internal', 'Eksternal', 'Internal dan Eksternal'] as $peserta)
                                                <option value="{{ $peserta }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->peserta_pembelajaran == $peserta ? 'selected' : '' }}>
                                                    {{ $peserta }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sasaran_peserta"
                                            class="form-label">{{ __('Sasaran Peserta') }}</label>
                                        <input type="text" name="sasaran_peserta" id="sasaran_peserta" required
                                            class="form-control"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->sasaran_peserta : '' }}"
                                            placeholder="{{ __('Sasaran Peserta') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="kriteria_peserta"
                                            class="form-label">{{ __('Kriteria Peserta') }}</label>
                                        <input type="text" name="kriteria_peserta" id="kriteria_peserta" required
                                            class="form-control"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->kriteria_peserta : '' }}"
                                            placeholder="{{ __('Kriteria Peserta') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="aktivitas_prapembelajaran"
                                            class="form-label">{{ __('Aktivitas Prapembelajaran') }}</label>
                                        <input type="text" name="aktivitas_prapembelajaran" required
                                            id="aktivitas_prapembelajaran" class="form-control"
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->aktivitas_prapembelajaran : '' }}"
                                            placeholder="{{ __('Aktivitas Prapembelajaran') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="penyelenggara_pembelajaran"
                                            class="form-label">{{ __('Penyelenggara Pembelajaran') }}</label>
                                        <select class="form-control" name="penyelenggara_pembelajaran" required
                                            id="penyelenggara_pembelajaran">
                                            <option value="" disabled>-- Pilih --</option>
                                            @foreach (['Pusdiklatwas BPKP', 'Unit kerja', 'Lainnya'] as $penyelenggara)
                                                <option value="{{ $penyelenggara }}"
                                                    {{ isset($pengajuanKap) && $pengajuanKap->penyelenggara_pembelajaran == $penyelenggara ? 'selected' : '' }}>
                                                    {{ $penyelenggara }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Fasilitator Pembelajaran') }}</label>
                                        @foreach (['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya'] as $fasilitator)
                                            <div class="form-check">
                                                <input class="form-check-input facilitator-checkbox" type="checkbox"
                                                    name="fasilitator_pembelajaran[]" value="{{ $fasilitator }}"
                                                    id="invalidCheck_{{ $fasilitator }}"
                                                    {{ in_array($fasilitator, $fasilitator_selected) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="invalidCheck_{{ $fasilitator }}">
                                                    {{ $fasilitator }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="invalid-feedback d-block" style="display: none;">
                                            Silakan pilih setidaknya satu fasilitator.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sertifikat" class="form-label">{{ __('Sertifikat') }}</label>
                                        <input type="text" name="sertifikat" id="sertifikat" class="form-control"
                                            required value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : '' }}"
                                            placeholder="{{ __('Sertifikat') }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="level_evaluasi_instrumen"
                                            class="form-label">{{ __('Level Evaluasi dan Instrumennya') }}</label>
                                        <table id="evaluationTable" class="table table-bordered table-sm text-center">
                                            <thead style="background-color: #cbccce">
                                                <tr>
                                                    <th>Level</th>
                                                    <th>Instrumen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php
                                                        // Temukan data keterangan untuk level saat ini
                                                        $instrumen = $level_evaluasi_instrumen_kap->firstWhere(
                                                            'level',
                                                            $i,
                                                        );
                                                        $keteranganValue = $instrumen ? $instrumen->keterangan : ''; // Jika ada, ambil nilai keterangan
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <input type="hidden" name="no_level[]"
                                                                value="{{ $i }}" class="form-control" />
                                                            <input type="text" required
                                                                name="level_evaluasi_instrumen[]" class="form-control"
                                                                value="{{ $keteranganValue }}" />
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>


                                    <button type="button" class="btn btn-info btn-prev"> <i
                                            class="fa fa-arrow-left"></i>
                                        Previous</button>
                                    <button type="button" class="btn btn-info btn-next">Next <i
                                            class="fa fa-arrow-right"></i></button>
                                </div>

                                <div class="form-step form-step-3" style="display: none;">
                                    <div class="alert alert-info" role="alert">
                                        Catatan
                                    </div>

                                    <div class="mb-3">
                                        <textarea class="form-control" id="approveNotes" name="approveNotes" rows="10" required></textarea>
                                    </div>

                                    <button type="button" class="btn btn-info btn-prev"> <i
                                            class="fa fa-arrow-left"></i>
                                        Previous</button>
                                    <button type="submit" class="btn btn-success"
                                        style="float: right">{{ __('Submit') }}</button>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="approveNotes" class="form-label">Catatan</label>
                                    <textarea required class="form-control" id="approveNotes" name="approveNotes" rows="10"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success"
                                    style="float: right">{{ __('Submit') }}</button>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revision Modal -->
        <div class="modal fade" id="revisionModal" tabindex="-1" aria-labelledby="rejectModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="revisionModalLabel">{{ __('Revision Pengusulan Pembelajaran') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kap.revisi', $pengajuanKap->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="revisiNotes" class="form-label">Catatan</label>
                                <textarea required class="form-control" id="revisiNotes" name="revisiNotes" rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn btn-gray"
                                style="float: right">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">{{ __('Reject Pengusulan Pembelajaran') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kap.reject', $pengajuanKap->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="rejectNotes" class="form-label">Catatan</label>
                                <textarea required class="form-control" id="rejectNotes" name="rejectNotes" rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger"
                                style="float: right">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
        <script>
            function toggleMessage(replyId) {
                const shortMessage = document.getElementById(`short-message-${replyId}`);
                const fullMessage = document.getElementById(`full-message-${replyId}`);
                const toggleLink = document.getElementById(`toggle-link-${replyId}`);

                // Periksa apakah fullMessage sedang disembunyikan
                if (fullMessage.style.display === 'none' || fullMessage.style.display === '') {
                    fullMessage.style.display = 'inline'; // Tampilkan pesan lengkap
                    shortMessage.style.display = 'none'; // Sembunyikan pesan pendek
                    toggleLink.innerHTML = 'Sembunyikan'; // Ubah teks link
                } else {
                    fullMessage.style.display = 'none'; // Sembunyikan pesan lengkap
                    shortMessage.style.display = 'inline'; // Tampilkan pesan pendek
                    toggleLink.innerHTML = 'Baca Selengkapnya'; // Ubah kembali teks link
                }
            }

            function submitReply(logReviewId) {
                var message = $('#reply-input-' + logReviewId).val();

                if (!message.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please enter a reply message.',
                    });
                    return;
                }

                $.ajax({
                    url: '{{ route('replies.store') }}',
                    type: 'POST',
                    data: {
                        log_review_id: logReviewId,
                        kode_pembelajaran: '{{ $pengajuanKap->kode_pembelajaran }}',
                        message: message,
                        full_url: window.location.href, // Mendapatkan URL penuh dari browser
                        _token: '{{ csrf_token() }}' // Sertakan CSRF token untuk keamanan
                    },
                    success: function(reply) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Chat Terkirim',
                            text: 'Chat berhasil dikirim!',
                        }).then(() => {
                            location.reload(); // Reload the page to show the new reply
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseText,
                        }); // Show error message
                    }
                });
            }
        </script>
        <script>
            // Fungsi untuk memperbesar textarea secara otomatis
            document.querySelectorAll('.reply-textarea').forEach(function(textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto'; // Reset tinggi textarea
                    this.style.height = (this.scrollHeight) + 'px'; // Set tinggi sesuai konten
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.wizard-steps .step').click(function() {
                    var index = $(this).index();
                    $('.wizard-content .content').removeClass('active');
                    $('.wizard-content .content').eq(index).addClass('active');
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                let currentStep = 1;

                function showStep(step) {
                    $('.form-step').hide();
                    $('.form-step-' + step).show();
                }

                function validateStep(step) {
                    let isValid = true;

                    // Validate required inputs in the current step
                    $('.form-step-' + step + ' :input[required]').each(function() {
                        if (!this.value) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    // Additional validation for the table and checkboxes (step 2)
                    if (step === 2) {
                        // Validation for the evaluation table
                        let filledInputs = 0;

                        // Count how many inputs are filled in the table
                        $('#evaluationTable input[name="level_evaluasi_instrumen[]"]').each(function() {
                            if ($(this).val()) {
                                filledInputs++;
                            }
                        });
                        // If at least one input is filled, remove 'required' from all and remove 'is-invalid' class
                        if (filledInputs > 0) {
                            $('#evaluationTable input[name="level_evaluasi_instrumen[]"]').each(function() {
                                $(this).prop('required', false).removeClass('is-invalid');
                            });
                        } else {
                            // If none are filled, mark them all as invalid
                            isValid = false;
                            $('#evaluationTable input[name="level_evaluasi_instrumen[]"]').each(function() {
                                $(this).prop('required', true).addClass('is-invalid');
                            });
                        }

                        let isAnyCheckboxChecked = false;
                        $('.facilitator-checkbox').each(function() {
                            if ($(this).is(':checked')) {
                                isAnyCheckboxChecked = true;
                            }
                        });
                        if (!isAnyCheckboxChecked) {
                            isValid = false;
                            $('.facilitator-checkbox').addClass('is-invalid');
                            $('.invalid-feedback').show();
                        } else {
                            $('.facilitator-checkbox').removeClass('is-invalid');
                            $('.invalid-feedback').hide();
                        }
                    }

                    return isValid;
                }


                $('.btn-next').on('click', function() {
                    if (validateStep(currentStep)) {
                        console.log('next');

                        currentStep++;
                        showStep(currentStep);
                    }
                });

                $('.btn-prev').on('click', function() {
                    currentStep--;
                    showStep(currentStep);
                });

                showStep(currentStep);
            });
        </script>

        <script>
            $(document).ready(function() {
                function updateDiklatTypeName() {
                    var selectedOption = $('#diklatTypeID option:selected');
                    var diklatTypeName = selectedOption.data('diklattypename');
                    $('#diklatTypeName').val(diklatTypeName);
                }
                $('#diklatTypeID').on('change', function() {
                    updateDiklatTypeName();
                });
                updateDiklatTypeName();
            });

            $(document).ready(function() {
                function updateDiklatLocName() {
                    var selectedOption = $('#diklatLocID option:selected');
                    var diklatLocName = selectedOption.data('diklatlocname');
                    $('#diklatLocName').val(diklatLocName);
                }
                $('#diklatLocID').on('change', function() {
                    updateDiklatLocName();
                });
                updateDiklatLocName();
            });
        </script>
    @endpush
