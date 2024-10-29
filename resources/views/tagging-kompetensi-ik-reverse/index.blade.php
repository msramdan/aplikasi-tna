@extends('layouts.app')

@section('title', __('Tagging IK - Kompetensi ') . strtoupper(Request::segment(2)))

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush
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

        .badge-width {
            display: inline-block;
            /* Memastikan span memiliki lebar tetap */
            width: 120px;
            /* Atur lebar sesuai kebutuhan */
            text-align: center;
            /* Untuk memastikan teks berada di tengah */
            font-size: 0.9em;
            /* Ukuran font lebih kecil */
            line-height: 1.5;
            /* Mengatur tinggi garis untuk vertikal center */
        }
    </style>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Modal import-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Tagging IK - Kompetensi </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('importTaggingIkKompetensi', ['type' => request()->segment(2)]) }}"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_tagging_kompetensi_ik"
                                name="import_tagging_kompetensi_ik" aria-describedby="import_tagging_kompetensi_ik"
                                accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text">
                                <a href="#">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Unduh format
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ trans('kompetensi/index.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('kompetensi/index.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal fade" id="modalDetailTagging" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tagging IK {{ strtoupper(Request::segment(2)) }} -
                        Kompetensi
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
                            <tr>
                                <th scope="row"><b>Indikator Kinerja</b></th>
                                <td><span id="modalIndikatorKinerja"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-body-detail" style="text-align: justify">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ __('topik/index.failed') }}</strong>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tagging IK {{ strtoupper(Request::segment(2)) }} - Kompetensi </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">Tagging IK {{ strtoupper(Request::segment(2)) }} - Kompetensi</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class='fa fa-upload'></i> Import data
                            </button>

                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('Export data') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('IK') }} {{ strtoupper(Request::segment(2)) }}</th>
                                            <th>{{ __('Tagging Kompetensi') }}</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-form').select2();
        });
    </script>
    <script>
        var type = window.location.pathname.split('/')[2];
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tagging-ik-kompetensi', ['type' => ':type']) }}".replace(':type', type),
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'indikator_kinerja',
                    name: 'indikator_kinerja'
                },
                {
                    data: 'jumlah_tagging',
                    name: 'jumlah_tagging'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],

            drawCallback: function() {
                $('.btn-detail-tagging').click(function() {
                    var indikator_kinerja = $(this).data('indikator_kinerja');
                    var type = $(this).data('type');

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $('#loading-overlay').show();
                    $.ajax({
                        type: "GET",
                        url: '{{ route('detailTaggingIkKompetensi') }}',
                        data: {
                            indikator_kinerja: indikator_kinerja,
                            type: type,
                            _token: csrfToken
                        },
                        success: function(response) {
                            $('#loading-overlay').hide();

                            // Cek apakah response success bernilai false
                            if (!response.success) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Alert',
                                    text: `Tagging IK ${type} - kompetensi tidak ditemukan`,
                                });
                                return;
                            }

                            $('#modalDetailTagging').modal('show');
                            $('#modalIndikatorKinerja').text(indikator_kinerja);

                            // Mendefinisikan variabel untuk menyimpan HTML tabel
                            var tableHtml =
                                '<div class="table-responsive p-1"><table class="table table-striped">';
                            tableHtml += '<thead>';
                            tableHtml += '<tr>';
                            tableHtml += '<th>No</th>'; // Kolom untuk nomor urut
                            tableHtml += '<th>Kompetensi</th>';
                            tableHtml += '</tr>';
                            tableHtml += '</thead>';
                            tableHtml += '<tbody></div>';

                            // Iterasi melalui data dan membangun baris-baris tabel
                            $.each(response.data, function(index, item) {
                                tableHtml += '<tr>';
                                tableHtml += '<td>' + (index + 1) +
                                    '</td>'; // Menampilkan nomor urut
                                tableHtml += '<td>' + item.nama_kompetensi +
                                    '</td>';
                                tableHtml += '</tr>';
                            });

                            tableHtml += '</tbody>';
                            tableHtml += '</table>';

                            // Menambahkan HTML tabel ke dalam modal body
                            $('.modal-body-detail').html(tableHtml);
                        },
                        error: function(error) {
                            $('#loading-overlay').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengambil data.',
                            });
                            console.error('Error:', error);
                        },
                    });
                });
            }

        });
    </script>

    {{-- Export data --}}
    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();
        });

        var exportData = function() {
            var type = window.location.pathname.split('/')[2];
            $.ajax({
                url: "{{ route('export-tagging-ik-kompetensi', ['type' => ':type']) }}".replace(':type', type),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: '{{ __('topik/index.please_wait') }}',
                        html: '{{ __('topik/index.exporting_data') }}',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'tagging_indikator_kerja_' + type + '_kompetensi.xlsx';
                    console.log(nameFile);
                    link.download = nameFile;
                    link.click();
                    swal.close();
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('topik/index.export_failed') }}",
                        text: "{{ __('topik/index.check_data') }}",
                        allowOutsideClick: false,
                    });
                }
            });
        }
    </script>

    {{-- download format import --}}
    <script>
        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();
        });

        var downloadFormat = function() {
            var type = window.location.pathname.split('/')[2];
            $.ajax({
                url: "{{ route('download-format-tagging-ik-kompetensi', ['type' => ':type']) }}".replace(
                    ':type', type),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan download format import',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'format_import_tagging_indikator_kerja_' + type + '_kompetensi.xlsx';
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Download Format Import failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
