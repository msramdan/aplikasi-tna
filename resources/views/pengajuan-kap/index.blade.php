@extends('layouts.app')

@section('title', __('Pengajuan Kap ') . strtoupper(Request::segment(2)) . ' - ' . strtoupper(Request::segment(3)))

@section('content')
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Transparan white background */
            z-index: 1000;
            text-align: center;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>



    {{-- modal detail --}}
    <div class="modal fade" id="modalDetailKompetensi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail pengajuan KAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
                            <tr>
                                <th scope="row">Kode pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Type pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Indikator kinerja</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Kompetensi</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Topik</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Concern Program Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Alokasi Waktu</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Indikator Dampak Terhadap Kinerja Organisasi</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Penugasan Yang Terkait Dengan Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Skill Group Owner</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Jalur Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Model Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Metode Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Sasaran Peserta</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Kriteria Peserta</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Aktivitas Prapembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Penyelenggara Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Fasilitator Pembelajaran</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Sertifikat</th>
                                <td>:</td>
                                <td><span id="modal-kode-pembelajaran"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-body-detail" style="text-align: justify"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ trans('kompetensi/index.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            {{ __('Pengajuan Kap ') . strtoupper(Request::segment(2) . ' - ' . strtoupper(Request::segment(3))) }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                    {{ __('Pengajuan Kap ') . strtoupper(Request::segment(2) . ' - ' . strtoupper(Request::segment(3))) }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('pengajuan kap create')
                                <a href="{{ route('pengajuan-kap.create', [
                                    'is_bpkp' => $is_bpkp,
                                    'frekuensi' => $frekuensi,
                                ]) }}"
                                    class="btn btn-md btn-primary"> <i class="mdi mdi-plus"></i>
                                    {{ __('Create a new pengajuan kap') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Kode Pembelajaran') }}</th>
                                            <th>{{ __('Type Pembelajaran') }}</th>
                                            <th>{{ __('Indikator Kinerja') }}</th>
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Topik') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        var is_bpkp = window.location.pathname.split('/')[2];
        var frekuensi = window.location.pathname.split('/')[3];
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pengajuan-kap.index', ['is_bpkp' => ':is_bpkp', 'frekuensi' => ':frekuensi']) }}"
                .replace(':is_bpkp', is_bpkp)
                .replace(':frekuensi', frekuensi),
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_pembelajaran',
                    name: 'kode_pembelajaran',
                },
                {
                    data: 'type_pembelajaran',
                    name: 'type_pembelajaran',
                },
                {
                    data: 'indikator_kinerja',
                    name: 'indikator_kinerja',
                },
                {
                    data: 'kompetensi',
                    name: 'kompetensi.id'
                },
                {
                    data: 'topik',
                    name: 'topik.id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],

            drawCallback: function() {
                $('.btn-detail-kompetensi').click(function() {
                    var id = $(this).data('id');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $('#loading-overlay').show();
                    $.ajax({
                        type: "GET",
                        url: '{{ route('detailKompetensi') }}',
                        data: {
                            id: id,
                            _token: csrfToken
                        },
                        success: function(response) {
                            $('#loading-overlay').hide();

                            if (!response.success) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Alert',
                                    text: response.message,
                                });
                                return;
                            }

                            $('#modalDetailKompetensi').modal('show');
                        },
                        error: function(error) {
                            $('#loading-overlay').hide();
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trans('kompetensi/index.error_fetching_data') }}',
                                text: '{{ trans('kompetensi/index.check_error') }}',
                            });
                            console.error('Error:', error);
                        },
                    });

                });
            }

        });
    </script>
@endpush
