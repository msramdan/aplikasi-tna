@extends('layouts.app')

@section('title', __('asrama\index.asrama'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('asrama\index.asrama') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('asrama\index.asrama') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('asrama create')
                                <a href="{{ route('asrama.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('asrama\index.create_new_asrama') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>{{ __('asrama\index.nama_asrama') }}</th>
                                            <th>{{ __('asrama\index.lokasi') }}</th>
                                            <th>{{ __('asrama\index.kuota') }}</th>
                                            <th>{{ __('asrama\index.status_asrama') }}</th>
                                            <th>{{ __('asrama\index.keterangan') }}</th>
                                            <th>{{ __('asrama\index.action') }}</th>
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
            ajax: "{{ route('asrama.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_asrama',
                    name: 'nama_asrama',
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
                    data: 'status_asrama',
                    name: 'status_asrama',
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
