@extends('layouts.app')

@section('title', __('ruang-kelas\index.ruang_kelass'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('ruang-kelas\index.ruang_kelass') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('ruang-kelas\index.ruang_kelass') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('ruang kelas create')
                                <a href="{{ route('ruang-kelas.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('ruang-kelas\index.create_new_ruang_kelas') }}</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>{{ __('ruang-kelas\index.nama_kelas') }}</th>
                                            <th>{{ __('ruang-kelas\index.lokasi') }}</th>
                                            <th>{{ __('ruang-kelas\index.kuota') }}</th>
                                            <th>{{ __('ruang-kelas\index.status') }}</th>
                                            <th>{{ __('ruang-kelas\index.keterangan') }}</th>
                                            <th>{{ __('ruang-kelas\index.action') }}</th>
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
            ajax: "{{ route('ruang-kelas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kelas',
                    name: 'nama_kelas',
                },
                {
                    data: 'nama_lokasi',
                    name: 'nama_lokasi'
                },
                {
                    data: 'kuota',
                    name: 'kuota',
                },
                {
                    data: 'status_ruang_kelas',
                    name: 'status_ruang_kelas',
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
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
