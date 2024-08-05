@extends('layouts.app')

@section('title', __('topik/index.pembelajaran'))

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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('topik/index.import_pembelajaran') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('importTopik') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_topik" name="import_topik"
                                aria-describedby="import_topik" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text">
                                <a href="#">
                                    <i class="fa fa-download" aria-hidden="true"></i> {{ __('topik/index.unduh_format') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('topik/index.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('topik/index.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('topik/index.pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('topik/index.pembelajaran') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('topik create')
                                <a href="{{ route('topik.create') }}" class="btn btn-md btn-primary">
                                    <i class="mdi mdi-plus"></i> {{ __('topik/index.create_new') }}
                                </a>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class='fa fa-upload'></i> {{ __('topik/index.import') }}
                                </button>
                            @endcan
                            <button id="btnExport" class="btn btn-success">
                                <i class='fas fa-file-excel'></i> {{ __('topik/index.export') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Rumpun pembelajaran</th>
                                            <th>{{ __('topik/index.nama_pembelajaran') }}</th>
                                            <th>{{ __('topik/index.action') }}</th>
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
            ajax: "{{ route('topik.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'rumpun_pembelajaran',
                    name: 'rumpun_pembelajaran',
                },
                {
                    data: 'nama_topik',
                    name: 'nama_topik',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            exportData();
        });

        var exportData = function() {
            var url = '/exportTopik';
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
                        title: '{{ __('topik/index.please_wait') }}',
                        html: '{{ __('topik/index.exporting_data') }}', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'Program pembelajaran.xlsx';
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

<script>
    $(document).on('click', '#downloadFormat', function(event) {
        event.preventDefault();
        downloadFormat();
    });

    var downloadFormat = function() {
        var url = '../download-format-topik';
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
                var nameFile = 'format_import_topik.xlsx'
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
