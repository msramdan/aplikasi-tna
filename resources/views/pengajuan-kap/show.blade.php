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
        }

        .step.active:not(:last-child)::after {
            background-color: green;
            opacity: 0.5;
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
            background-color: red;
            animation: pulse-red 1s infinite alternate;
        }

        .step.rejected .step-label {
            color: red;
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

                            <a href="{{ route('pengajuan-kap.index', [
                                'is_bpkp' => $is_bpkp,
                                'frekuensi' => $frekuensi,
                            ]) }}"
                                class="btn btn-secondary">{{ __('Back') }}</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#approveModal">
                                Approved
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                Rejected
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="wizard-container">
                            <div class="wizard-steps">
                                <div class="step active">
                                    <div class="step-icon">1</div>
                                    <div class="step-label"><b>Team pusdiklat</b> </div>
                                </div>
                                <div class="step active">
                                    <div class="step-icon">2</div>
                                    <div class="step-label"><b>Biro keuangan</b></div>
                                </div>
                                <div class="step rejected">
                                    <div class="step-icon">3</div>
                                    <div class="step-label"><b>Inspektorat</b></div>
                                </div>
                                <div class="step ">
                                    <div class="step-icon">4</div>
                                    <div class="step-label"><b>Subkor</b></div>
                                </div>
                                <div class="step">
                                    <div class="step-icon">5</div>
                                    <div class="step-label"><b>Koordinator</b></div>
                                </div>
                                <div class="step">
                                    <div class="step-icon">6</div>
                                    <div class="step-label"><b>Kepala pusat</b></div>
                                </div>
                            </div>
                            <div class="wizard-content">
                                <div class="content active">
                                    <br>
                                    <h2>Team pusdiklat</h2>
                                    <div class="form-group">
                                        <label for="notes-team-pusdiklat">Catatan:</label>
                                        <textarea id="notes-team-pusdiklat" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> Muhammad Saeful Ramdan</p>
                                        <p><strong>Status:</strong> Approved</p>
                                        <p><strong>Tanggal:</strong> July 4, 2024</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <br>
                                    <h2>Biro keuangan</h2>
                                    <div class="form-group">
                                        <label for="notes-biro-keuangan">Catatan:</label>
                                        <textarea id="notes-biro-keuangan" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> -</p>
                                        <p><strong>Status:</strong> Pending</p>
                                        <p><strong>Tanggal:</strong> -</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <br>
                                    <h2>Inspektorat</h2>
                                    <div class="form-group">
                                        <label for="notes-inspektorat">Catatan:</label>
                                        <textarea id="notes-inspektorat" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> -</p>
                                        <p><strong>Status:</strong> Pending</p>
                                        <p><strong>Tanggal:</strong> -</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <br>
                                    <h2>Subkor</h2>
                                    <div class="form-group">
                                        <label for="notes-subkor">Catatan:</label>
                                        <textarea id="notes-subkor" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> -</p>
                                        <p><strong>Status:</strong> -</p>
                                        <p><strong>Tanggal:</strong> -</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <br>
                                    <h2>Koordinator</h2>
                                    <div class="form-group">
                                        <label for="notes-koordinator">Catatan:</label>
                                        <textarea id="notes-koordinator" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> -</p>
                                        <p><strong>Status:</strong> -</p>
                                        <p><strong>Tanggal:</strong> -</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <br>
                                    <h2>Kepala pusat</h2>
                                    <div class="form-group">
                                        <label for="notes-kepala-pusat">Catatan:</label>
                                        <textarea id="notes-kepala-pusat" class="form-control" rows="4" readonly></textarea>
                                    </div>
                                    <div class="notes" style="margin-top: 10px">
                                        <p><strong>User:</strong> -</p>
                                        <p><strong>Status:</strong> -</p>
                                        <p><strong>Tanggal:</strong> -</p>
                                    </div>
                                </div>
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
                        <h5 class="modal-title" id="approveModalLabel">{{ __('Approve Pengajuan Kap') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kap.approve', $pengajuanKap->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="approveNotes" class="form-label">{{ __('Notes') }}</label>
                                <textarea class="form-control" id="approveNotes" name="approveNotes" rows="3"></textarea>
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
                        <h5 class="modal-title" id="rejectModalLabel">{{ __('Reject Pengajuan Kap') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kap.reject', $pengajuanKap->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="rejectNotes" class="form-label">{{ __('Notes') }}</label>
                                <textarea class="form-control" id="rejectNotes" name="rejectNotes" rows="3"></textarea>
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
