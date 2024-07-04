@extends('layouts.app')

@section('title', __('Pengajuan Kap ') . strtoupper(Request::segment(2)) . ' - ' . strtoupper(Request::segment(3)))

@section('content')
    <style>
        .btn-gray {
            background-color: gray;
            color: white;
            border-color: gray;
        }

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
                                            <th>{{ __('Kode') }}</th>
                                            <th>{{ __('Indikator Kinerja') }}</th>
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Topik') }}</th>
                                            <th>{{ __('User created') }}</th>
                                            <th>{{ __('Status') }}</th>
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
                    data: 'indikator_kinerja',
                    name: 'indikator_kinerja',
                },
                {
                    data: 'nama_kompetensi',
                    name: 'nama_kompetensi'
                },
                {
                    data: 'nama_topik',
                    name: 'nama_topik'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'status_pengajuan',
                    name: 'status_pengajuan'
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
@endpush