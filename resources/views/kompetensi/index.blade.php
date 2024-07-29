@extends('layouts.app')

@section('title', trans('kompetensi/index.kompetensi'))

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

    <!-- Modal import-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('kompetensi/index.import_kompetensi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('importKompetensi') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_kompetensi" name="import_kompetensi"
                                aria-describedby="import_kompetensi" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text">
                                <a href="#">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    {{ trans('kompetensi/index.unduh_format') }}
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
    <div class="modal fade" id="modalDetailKompetensi" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                            <tr>
                                <th scope="row">{{ trans('kompetensi/index.kategori_besar') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKategoriBesar"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('kompetensi/index.kategori') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKategori"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('kompetensi/index.akademi') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailNamaAkademi"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('kompetensi/index.nama_kompetensi') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiNama"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('kompetensi/index.deskripsi_kompetensi') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiDeskripsi"></span></td>
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
                        <h4 class="mb-sm-0">{{ trans('kompetensi/index.kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">{{ trans('kompetensi/index.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ trans('kompetensi/index.kompetensi') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ trans('kompetensi/index.failed') }}</strong>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('kompetensi create')
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class='fa fa-upload'></i>
                                    {{ trans('kompetensi/index.import') }}
                                </button>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ trans('kompetensi/index.export') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ trans('kompetensi/index.kelompok_besar') }}</th>
                                            <th>{{ trans('kompetensi/index.kategori') }}</th>
                                            <th>{{ trans('kompetensi/index.akademi') }}</th>
                                            <th>{{ trans('kompetensi/index.nama_kompetensi') }}</th>
                                            <th>{{ trans('kompetensi/index.deskripsi_kompetensi') }}</th>
                                            <th>{{ trans('kompetensi/index.action') }}</th>
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
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kompetensi.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'nama_kelompok_besar',
                        name: 'nama_kelompok_besar',
                    },
                    {
                        data: 'nama_kategori_kompetensi',
                        name: 'nama_kategori_kompetensi',
                    },
                    {
                        data: 'nama_akademi',
                        name: 'nama_akademi',
                    },
                    {
                        data: 'nama_kompetensi',
                        name: 'nama_kompetensi',
                    },
                    {
                        data: 'deskripsi_kompetensi',
                        name: 'deskripsi_kompetensi',
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
                        var nama_kelompok_besar = $(this).data('nama_kelompok_besar');
                        var nama_kategori_kompetensi = $(this).data('nama_kategori_kompetensi');
                        var nama_akademi = $(this).data('nama_akademi');
                        var nama_kompetensi = $(this).data('nama_kompetensi');
                        var deskripsi_kompetensi = $(this).data('deskripsi_kompetensi');
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $('#modalDetailKompetensi').modal('show');
                        $('#modalDetailKategoriBesar').text(
                            nama_kelompok_besar);
                        $('#modalDetailKategori').text(
                            nama_kategori_kompetensi);
                        $('#modalDetailNamaAkademi').text(nama_akademi);
                        $('#modalDetailKompetensiNama').text(
                            nama_kompetensi);
                        $('#modalDetailKompetensiDeskripsi').text(
                            deskripsi_kompetensi);
                        // $('#loading-overlay').show();
                        // $.ajax({
                        //     type: "GET",
                        //     url: '{{ route('detailKompetensi') }}',
                        //     data: {
                        //         id: id,
                        //         _token: csrfToken
                        //     },
                        //     success: function(response) {
                        //         $('#loading-overlay').hide();

                        //         if (!response.success) {
                        //             Swal.fire({
                        //                 icon: 'warning',
                        //                 title: 'Alert',
                        //                 text: response.message,
                        //             });
                        //             return;
                        //         }

                        //         $('#modalDetailKompetensi').modal('show');
                        //         $('#modalDetailKategoriBesar').text(
                        //             nama_kelompok_besar);
                        //         $('#modalDetailKategori').text(
                        //             nama_kategori_kompetensi);
                        //         $('#modalDetailNamaAkademi').text(nama_akademi);
                        //         $('#modalDetailKompetensiNama').text(
                        //             nama_kompetensi);
                        //         $('#modalDetailKompetensiDeskripsi').text(
                        //             deskripsi_kompetensi);
                        //         var tableHtml =
                        //             '<div class="table-responsive p-1"><table class="table table-striped">';
                        //         tableHtml += '<thead>';
                        //         tableHtml += '<tr>';
                        //         tableHtml +=
                        //             '<th>{{ trans('kompetensi/index.level') }}</th>';
                        //         tableHtml +=
                        //             '<th>{{ trans('kompetensi/index.deskripsi_level') }}</th>';
                        //         tableHtml +=
                        //             '<th>{{ trans('kompetensi/index.indikator_perilaku') }}</th>';
                        //         tableHtml += '</tr>';
                        //         tableHtml += '</thead>';
                        //         tableHtml += '<tbody></div>';

                        //         $.each(response.data, function(index, item) {
                        //             tableHtml += '<tr>';
                        //             tableHtml += '<td>' + item.level +
                        //                 '</td>';
                        //             tableHtml += '<td>' + item
                        //                 .deskripsi_level + '</td>';
                        //             tableHtml += '<td>' + item
                        //                 .indikator_perilaku + '</td>';
                        //             tableHtml += '</tr>';
                        //         });

                        //         tableHtml += '</tbody>';
                        //         tableHtml += '</table>';

                        //         $('.modal-body-detail').html(tableHtml);
                        //     },
                        //     error: function(error) {
                        //         $('#loading-overlay').hide();
                        //         Swal.fire({
                        //             icon: 'error',
                        //             title: '{{ trans('kompetensi/index.error_fetching_data') }}',
                        //             text: '{{ trans('kompetensi/index.check_error') }}',
                        //         });
                        //         console.error('Error:', error);
                        //     },
                        // });

                    });
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();
        });

        var exportData = function() {
            var url = '/exportKompetensi';
            $.ajax({
                url: url,
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
                        title: '{{ trans('kompetensi/index.please_wait') }}',
                        html: '{{ trans('kompetensi/index.exporting_data') }}',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = '{{ trans('kompetensi/index.filename') }}'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trans('kompetensi/index.export_failed') }}',
                        text: '{{ trans('kompetensi/index.check_error') }}',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>

    <script>
        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();
        });

        var downloadFormat = function() {
            var url = '../download-format-kompetensi';
            $.ajax({
                url: url,
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
                    var nameFile = 'format_import_kompetensi.xlsx'
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
