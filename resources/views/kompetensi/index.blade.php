@extends('layouts.app')

@section('title', __('kompetensi'))

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
                    <h5 class="modal-title" id="exampleModalLabel">Import Kompetensi</h5>
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
                                        class="fa fa-download" aria-hidden="true"></i> Unduh Format</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Detail Kompetensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
                            <tr>
                                <th scope="row">Nama Kompetensi</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiNama"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Deskripsi Kompetensi</th>
                                <td>:</td>
                                <td><span id="modalDetailKompetensiDeskripsi"></span></td>
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
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('kompetensi') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong>
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
                                        class="mdi mdi-plus"></i> {{ __('Create a new kompetensi') }}</a>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                    {{ __('Import') }}
                                </button>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i>
                                {{ __('Export') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Nama Kompetensi') }}</th>
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
                                $('#modalDetailKompetensiNama').text(
                                    nama_kompetensi);
                                $('#modalDetailKompetensiDeskripsi').text(
                                    deskripsi_kompetensi);

                                // Mendefinisikan variabel untuk menyimpan HTML tabel
                                var tableHtml =
                                    '<div class="table-responsive p-1"><table class="table table-striped">';
                                tableHtml += '<thead>';
                                tableHtml += '<tr>';
                                tableHtml += '<th>Level</th>';
                                tableHtml += '<th>Deskripsi Level</th>';
                                tableHtml += '<th>Indikator Perilaku</th>';
                                tableHtml += '</tr>';
                                tableHtml += '</thead>';
                                tableHtml += '<tbody></div>';

                                // Iterasi melalui data dan membangun baris-baris tabel
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
                        title: 'Please Wait !',
                        html: 'Sedang melakukan proses export data', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'Kamus kompetensi.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Data export failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
