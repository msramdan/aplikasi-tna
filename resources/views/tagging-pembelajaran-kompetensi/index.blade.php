@extends('layouts.app')

@section('title', __('Tagging Pembelajaran Kompetensi'))

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
    </style>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="modal fade" id="modalDetailTagging" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAGGING PEMBELAJARAN KOMPETENSI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <div class="modal-body">
                    <table class="table" style="text-align: justify">
                        <tbody>
                            <tr>
                                <th scope="row"><b>Pembelajaran</b></th>
                                <td><span id="modalPembelajaran"></span></td>
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
                        <h4 class="mb-sm-0">{{ __('Tagging Pembelajaran Kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/panel">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Tagging Pembelajaran Kompetensi') }}</li>
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
                                data-bs-target="#exampleModal"><i class='fa fa-upload'></i>
                                {{ __('Import') }}
                            </button>
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
                                            <th>{{ __('Pembelajaran') }}</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tagging-pembelajaran-kompetensi.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_topik',
                    name: 'nama_topik'
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
                    var id = $(this).data('id');
                    var pembelajaran = $(this).data('pembelajaran');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $('#loading-overlay').show();
                    $.ajax({
                        type: "GET",
                        url: '{{ route('detailTaggingPembelajaranKompetensi') }}',
                        data: {
                            id: id,
                            _token: csrfToken
                        },
                        success: function(response) {
                            $('#loading-overlay').hide();

                            // Cek apakah response success bernilai false
                            if (!response.success) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Alert',
                                    text: response.message,
                                });
                                return;
                            }

                            $('#modalDetailTagging').modal('show');
                            $('#modalPembelajaran').text(pembelajaran);

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

<script>
    $(document).on('click', '#btnExport', function(event) {
        event.preventDefault();
        exportData();

    });

    var exportData = function() {
        var url = '/exportTagPembelajaranKompetensi';
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
                var nameFile = 'tagging_pembelajaran_kompetensi.xlsx'
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
