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

                <div class="col-md-8">
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
                                    @if ($pengajuanKap->status_pengajuan == 'Rejected' || $pengajuanKap->status_pengajuan == 'Approved')
                                        <button type="button" disabled class="btn btn-success">
                                            <i class="fa fa-check" aria-hidden="true"></i> Approved
                                        </button>
                                        <button type="button" disabled class="btn btn-danger">
                                            <i class="fa fa-times" aria-hidden="true"></i> Rejected
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#approveModal" {{ $userHasAccess ? '' : 'disabled' }}>
                                            <i class="fa fa-check" aria-hidden="true"></i> Approved
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal" {{ $userHasAccess ? '' : 'disabled' }}>
                                            <i class="fa fa-times" aria-hidden="true"></i> Rejected
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
                                            <td class="fw-bold">{{ __('Institusi Sumber') }}</td>
                                            <td>{{ $pengajuanKap->institusi_sumber ?: '-' }}</td>
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
                                                                <th scope="col" class="text-center">Pegawai kompeten</th>
                                                                <th scope="col" class="text-center">Pegawai belum
                                                                    kompeten</th>
                                                                <th scope="col" class="text-center">Persentase kompetensi
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
                                            <td class="fw-bold">{{ __('Jenjang Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->jenjang_pembelajaran ?: '-' }}</td>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="wizard-container">
                            <div class="wizard-steps">

                                @foreach ($logReviews as $index => $log)
                                    <div
                                        class="step {{ $pengajuanKap->current_step == $index + 1 && $log->status == 'Pending' ? 'process' : '' }} {{ $log->status == 'Approved' ? 'active' : ($log->status == 'Rejected' ? 'rejected' : ($log->status == 'Skiped' ? 'skiped' : '')) }}">
                                        <div class="step-icon">{{ $index + 1 }}</div>
                                        <div class="step-label"><b>{{ $log->remark }}</b></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="wizard-content">
                                @foreach ($logReviews as $index => $log)
                                    <div class="content {{ $index == 0 ? 'active' : '' }}">
                                        <br>
                                        <h2>{{ $log->remark }}</h2>
                                        <div class="form-group">
                                            <label for="notes-{{ $log->step }}">Catatan:</label>
                                            <textarea id="notes-{{ $log->step }}" class="form-control" rows="4" readonly>{{ $log->catatan }}</textarea>
                                        </div>
                                        <div class="notes" style="margin-top: 10px">
                                            <p><strong>User:</strong> {{ $log->user_name ?? '-' }}</p>
                                            <p><strong>Status:</strong> {{ $log->status }}</p>
                                            <p><strong>Tanggal:</strong> {{ $log->tanggal_review ?? '-' }}</p>
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
                                            <option value="" selected disabled>-- Pilih --</option>
                                            @foreach ($diklatLocation_data as $lokasi)
                                                <option value="{{ $lokasi['diklatLocID'] }}"
                                                    data-diklatlocname="{{ $lokasi['diklatLocName'] }}">
                                                    {{ $lokasi['diklatLocName'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="diklatLocName" id="diklatLocName"
                                        value="">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="detail_lokasi">{{ __('Tempat / Alamat Rinci') }}</label>
                                        <input type="text" name="detail_lokasi" id="detail_lokasi" required
                                            class="form-control" value=""
                                            placeholder="{{ __('Tempat / Alamat Rinci') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="kelas">{{ __('Jumlah Kelas') }}</label>
                                        <input type="number" name="kelas" id="kelas" class="form-control"
                                            required value="" placeholder="{{ __('Jumlah Kelas') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="bentuk_pembelajaran"
                                            class="form-label">{{ __('Bentuk Pembelajaran') }}</label>
                                        <select class="form-control" name="bentuk_pembelajaran" id="bentuk_pembelajaran"
                                            required>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="Klasikal">Klasikal</option>
                                            <option value="Nonklasikal">Nonklasikal</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jalur_pembelajaran"
                                            class="form-label">{{ __('Jalur Pembelajaran') }}</label>
                                        <select class="form-control" name="jalur_pembelajaran" id="jalur_pembelajaran"
                                            required>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            @foreach ($jalur_pembelajaran as $row)
                                                <option value="{{ $row }}">
                                                    {{ $row }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenjang_pembelajaran"
                                            class="form-label">{{ __('Jenjang Pembelajaran') }}</label>
                                        <select class="form-control" name="jenjang_pembelajaran" required
                                            id="jenjang_pembelajaran">
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="CPNS">
                                                CPNS</option>
                                            <option value="P3K">
                                                P3K</option>
                                            <option value="PKN I">
                                                PKN I</option>
                                            <option value="PKN II">
                                                PKN II</option>
                                            <option value="Kepemimpinan Administrator">
                                                Kepemimpinan Administrator</option>
                                            <option value="Kepemimpinan Pengawas">
                                                Kepemimpinan Pengawas</option>
                                            <option value="Penjenjangan Auditor Utama">
                                                Penjenjangan Auditor Utama</option>
                                            <option value="Penjenjangan Auditor Madya">
                                                Penjenjangan Auditor Madya</option>
                                            <option value="Penjenjangan Auditor Muda">
                                                Penjenjangan Auditor Muda</option>
                                            <option value="Pembentukan Auditor Pertama">
                                                Pembentukan Auditor Pertama</option>
                                            <option value="Pembentukan Auditor Terampil">
                                                Pembentukan Auditor Terampil</option>
                                            <option value="APIP">
                                                APIP</option>
                                            <option value="SPIP">
                                                SPIP</option>
                                            <option value="LSP BPKP">
                                                LSP BPKP</option>
                                            <option value="LSP Lainnya">
                                                LSP Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="model_pembelajaran"
                                            class="form-label">{{ __('Model Pembelajaran') }}</label>
                                        <select class="form-control " required name="model_pembelajaran"
                                            id="model_pembelajaran">
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="Pembelajaran terstruktur">
                                                Pembelajaran terstruktur</option>
                                            <option value="Pembelajaran kolaboratif">
                                                Pembelajaran kolaboratif</option>
                                            <option value="Pembelajaran di tempat kerja">
                                                Pembelajaran di tempat kerja</option>
                                            <option value="Pembelajaran terintegrasi">
                                                Pembelajaran terintegrasi</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="diklatTypeID"
                                            class="form-label">{{ __('Jenis Pembelajaran') }}</label>
                                        <select class="form-control" name="diklatTypeID" id="diklatTypeID" required>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            @foreach ($diklatType_data as $jenis)
                                                <option value="{{ $jenis['diklatTypeID'] }}"
                                                    data-diklattypename="{{ $jenis['diklatTypeName'] }}">
                                                    {{ $jenis['diklatTypeName'] }}
                                                </option>
                                            @endforeach

                                        </select>

                                        <input type="hidden" name="diklatTypeName" id="diklatTypeName" value="">

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
                                            <option value="" selected disabled>-- Pilih --
                                            </option>
                                            <option value="Internal">
                                                Internal</option>
                                            <option value="Eksternal">
                                                Eksternal</option>
                                            <option value="Internal dan Eksternal">
                                                Internal dan Eksternal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sasaran_peserta"
                                            class="form-label">{{ __('Sasaran Peserta') }}</label>
                                        <input type="text" name="sasaran_peserta" id="sasaran_peserta" required
                                            class="form-control" value=""
                                            placeholder="{{ __('Sasaran Peserta') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="kriteria_peserta"
                                            class="form-label">{{ __('Kriteria Peserta') }}</label>
                                        <input type="text" name="kriteria_peserta" id="kriteria_peserta" required
                                            class="form-control" value=""
                                            placeholder="{{ __('Sasaran Peserta') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="aktivitas_prapembelajaran"
                                            class="form-label">{{ __('Aktivitas Prapembelajaran') }}</label>
                                        <input type="text" name="aktivitas_prapembelajaran" required
                                            id="aktivitas_prapembelajaran" class="form-control" value=""
                                            placeholder="{{ __('Aktivitas Prapembelajaran') }}" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="penyelenggara_pembelajaran"
                                            class="form-label">{{ __('Penyelenggara Pembelajaran') }}</label>
                                        <select class="form-control" name="penyelenggara_pembelajaran" required
                                            id="penyelenggara_pembelajaran">
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="Pusdiklatwas BPKP">
                                                Pusdiklatwas BPKP</option>
                                            <option value="Unit kerja">
                                                Unit kerja</option>
                                            <option value="Lainnya">
                                                Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Fasilitator Pembelajaran') }}</label>
                                        @foreach (['Widyaiswara', 'Instruktur', 'Praktisi', 'Pakar', 'Tutor', 'Coach', 'Mentor', 'Narasumber lainnya'] as $fasilitator)
                                            <div class="form-check">
                                                <input class="form-check-input facilitator-checkbox" type="checkbox"
                                                    name="fasilitator_pembelajaran[]" value="{{ $fasilitator }}"
                                                    id="invalidCheck_{{ $fasilitator }}">
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
                                            required
                                            value="{{ isset($pengajuanKap) ? $pengajuanKap->sertifikat : old('sertifikat') }}"
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
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <input type="hidden" name="no_level[]"
                                                                value="{{ $i }}" class="form-control" />
                                                            <input type="text" required
                                                                name="level_evaluasi_instrumen[]" class="form-control" />
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
                                        <textarea class="form-control" id="approveNotes" name="approveNotes" rows="3" required></textarea>
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
                                    <textarea required class="form-control" id="approveNotes" name="approveNotes" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success"
                                    style="float: right">{{ __('Submit') }}</button>
                            @endif

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
                                <textarea required class="form-control" id="rejectNotes" name="rejectNotes" rows="3"></textarea>
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
