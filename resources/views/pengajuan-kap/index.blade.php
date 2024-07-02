@extends('layouts.app')

@section('title', __('Pengajuan Kaps'))

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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('kompetensi/index.detail_kompetensi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
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
                        <h4 class="mb-sm-0">{{ __('Pengajuan Kaps') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Pengajuan Kaps') }}</li>
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
                                <a href="{{ route('pengajuan-kap.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new pengajuan kap') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Kode Pembelajaran') }}</th>
                                            <th>{{ __('Type Pembelajaran') }}</th>
                                            <th>{{ __('Indikator Kinerja') }}</th>
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Topik') }}</th>
                                            <th>{{ __('Concern Program Pembelajaran') }}</th>
                                            {{-- <th>{{ __('Alokasi Waktu') }}</th>
											<th>{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</th>
											<th>{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</th>
											<th>{{ __('Skill Group Owner') }}</th>
											<th>{{ __('Jalur Pembelajaran') }}</th>
											<th>{{ __('Model Pembelajaran') }}</th>
											<th>{{ __('Jenis Pembelajaran') }}</th>
											<th>{{ __('Metode Pembelajaran') }}</th>
											<th>{{ __('Sasaran Peserta') }}</th>
											<th>{{ __('Kriteria Peserta') }}</th>
											<th>{{ __('Aktivitas Prapembelajaran') }}</th>
											<th>{{ __('Penyelenggara Pembelajaran') }}</th>
											<th>{{ __('Fasilitator Pembelajaran') }}</th>
											<th>{{ __('Sertifikat') }}</th> --}}
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pengajuan-kap.index') }}",
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
                    data: 'concern_program_pembelajaran',
                    name: 'concern_program_pembelajaran',
                },
                // {
                //     data: 'alokasi_waktu',
                //     name: 'alokasi_waktu',
                // },
                // {
                //     data: 'indikator_dampak_terhadap_kinerja_organisasi',
                //     name: 'indikator_dampak_terhadap_kinerja_organisasi',
                // },
                // {
                //     data: 'penugasan_yang_terkait_dengan_pembelajaran',
                //     name: 'penugasan_yang_terkait_dengan_pembelajaran',
                // },
                // {
                //     data: 'skill_group_owner',
                //     name: 'skill_group_owner',
                // },
                // {
                //     data: 'jalur_pembelajaran',
                //     name: 'jalur_pembelajaran',
                // },
                // {
                //     data: 'model_pembelajaran',
                //     name: 'model_pembelajaran',
                // },
                // {
                //     data: 'jenis_pembelajaran',
                //     name: 'jenis_pembelajaran',
                // },
                // {
                //     data: 'metode_pembelajaran',
                //     name: 'metode_pembelajaran',
                // },
                // {
                //     data: 'sasaran_peserta',
                //     name: 'sasaran_peserta',
                // },
                // {
                //     data: 'kriteria_peserta',
                //     name: 'kriteria_peserta',
                // },
                // {
                //     data: 'aktivitas_prapembelajaran',
                //     name: 'aktivitas_prapembelajaran',
                // },
                // {
                //     data: 'penyelenggara_pembelajaran',
                //     name: 'penyelenggara_pembelajaran',
                // },
                // {
                //     data: 'fasilitator_pembelajaran',
                //     name: 'fasilitator_pembelajaran',
                // },
                // {
                //     data: 'sertifikat',
                //     name: 'sertifikat',
                // },
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
