@extends('layouts.app')

@section('title', __('master-data.kompetensi.kompetensi'))

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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('master-data.kompetensi.import_kompetensi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('importKompetensi') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_kompetensi" name="import_kompetensi"
                                aria-describedby="import_kompetensi" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text"> <a
                                    href="{{ asset('format_import/format_import_kompetensi.xlsx') }}"><i
                                        class="fa fa-download" aria-hidden="true"></i>
                                    {{ __('master-data.kompetensi.unduh_format') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('master-data.kompetensi.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('master-data.kompetensi.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailKompetensi" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('master-data.kompetensi.detail_kompetensi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
                            <tr>
                                <th scope="row">Kelompok besar</th>
                                <td>:</td>
                                <td><span id="modalDetailKategoriBesar"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Kategori</th>
                                <td>:</td>
                                <td><span id="modalDetailKategori"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama akademi</th>
                                <td>:</td>
                                <td><span id="modalDetailNamaAkademi"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('master-data.kompetensi.nama_kompetensi') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiNama"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('master-data.kompetensi.deskripsi_kompetensi') }}</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiDeskripsi"></span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="modal-body-detail" style="text-align: justify">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('master-data.kompetensi.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('master-data.kompetensi.kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="/">{{ __('master-data.kompetensi.dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('master-data.kompetensi.kompetensi') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ __('master-data.kompetensi.failed') }}</strong>
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
                                <a href="{{ route('kompetensi.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i>
                                    {{ trans('master-data/kompetensi/kompetensi.create_new') }}</a>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                    {{ __('master-data.kompetensi.import') }}
                                </button>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('master-data.kompetensi.export') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Kategori besar') }}</th>
                                            <th>{{ __('Kategori') }}</th>
                                            <th>{{ __('Nama akademi') }}</th>
                                            <th>{{ __('Nama kompetensi') }}</th>
                                            <th>{{ __('Deskripsi Kompetensi') }}</th>
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
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kompetensi.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                                $('#modalDetailKategoriBesar').text(
                                    nama_kelompok_besar);
                                $('#modalDetailKategori').text(
                                    nama_kategori_kompetensi);
                                $('#modalDetailNamaAkademi').text(
                                    nama_akademi);
                                $('#modalDetailKompetensiNama').text(
                                    nama_kompetensi);
                                $('#modalDetailKompetensiDeskripsi').text(
                                    deskripsi_kompetensi);
                                var tableHtml =
                                    '<div class="table-responsive p-1"><table class="table table-striped">';
                                tableHtml += '<thead>';
                                tableHtml += '<tr>';
                                tableHtml +=
                                    '<th>{{ __('master-data.kompetensi.level') }}</th>';
                                tableHtml +=
                                    '<th>{{ __('master-data.kompetensi.deskripsi_level') }}</th>';
                                tableHtml +=
                                    '<th>{{ __('master-data.kompetensi.indikator_perilaku') }}</th>';
                                tableHtml += '</tr>';
                                tableHtml += '</thead>';
                                tableHtml += '<tbody></div>';

                                $.each(response.data, function(index, item) {
                                    tableHtml += '<tr>';
                                    tableHtml += '<td>' + item.level +
                                        '</td>';
                                    tableHtml += '<td>' + item
                                        .deskripsi_level + '</td>';
                                    tableHtml += '<td>' + item
                                        .indikator_perilaku + '</td>';
                                    tableHtml += '</tr>';
                                });

                                tableHtml += '</tbody>';
                                tableHtml += '</table>';

                                $('.modal-body-detail').html(tableHtml);
                            },
                            error: function(error) {
                                $('#loading-overlay').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('master-data.kompetensi.error_fetching_data') }}',
                                    text: '{{ __('master-data.kompetensi.check_error') }}',
                                });
                                console.error('Error:', error);
                            },
                        });

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
                        title: '{{ __('master-data.kompetensi.please_wait') }}',
                        html: '{{ __('master-data.kompetensi.exporting_data') }}',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = '{{ __('master-data.kompetensi.filename') }}'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('master-data.kompetensi.export_failed') }}',
                        text: '{{ __('master-data.kompetensi.check_error') }}',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
