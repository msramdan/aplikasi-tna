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
                                <a href="{{ route('sync-info-diklat.index') }}">{{ __('Sync info diklat') }}</a>
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
                                <a href="{{ route('sync-info-diklat.index') }}" class="btn btn-secondary"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i>
                                    {{ __('Kembali') }}</a>
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
                                            <td>
                                                @foreach ($pengajuan_kap_indikator_kinerja as $indikatorKinerja)
                                                    - {{ $indikatorKinerja->indikator_kinerja ?: '-' }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ __('Kompetensi') }}</td>
                                            <td>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Nama Kompetensi') }}</th>
                                                            <th>{{ __('Total Pegawai') }}</th>
                                                            <th>{{ __('Pegawai Kompeten') }}</th>
                                                            <th>{{ __('Pegawai Belum Kompeten') }}</th>
                                                            <th>{{ __('Persentase Kompetensi') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengajuan_kap_gap_kompetensi as $data)
                                                            <tr>
                                                                <td>{{ $data->nama_kompetensi }}</td>
                                                                <td>{{ $data->total_pegawai ?: '-' }}</td>
                                                                <td>{{ $data->pegawai_kompeten ?: '-' }}</td>
                                                                <td>{{ $data->pegawai_belum_kompeten ?: '-' }}</td>
                                                                <td>{{ $data->persentase_kompetensi ?: '-' }}%</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
                        <form action="{{ route('pengajuan-kap.approve', $pengajuanKap->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="approveNotes" class="form-label">{{ __('Notes') }}</label>
                                <textarea required class="form-control" id="approveNotes" name="approveNotes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
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
                                <label for="rejectNotes" class="form-label">{{ __('Notes') }}</label>
                                <textarea required class="form-control" id="rejectNotes" name="rejectNotes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">{{ __('Submit') }}</button>
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
    @endpush
