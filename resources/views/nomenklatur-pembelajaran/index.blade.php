@extends('layouts.app')

@section('title', __('Usulan Nomenklatur Pembelajaran'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Usulan Nomenklatur Pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Usulan Nomenklatur Pembelajaran') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Rumpun Pembelajaran') }}</th>
                                            <th>{{ __('Nama Topik') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Tanggal Pengajuan') }}</th>
                                            <th>{{ __('Catatan User') }}</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('nomenklatur-pembelajaran.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rumpun_pembelajaran',
                    name: 'rumpun_pembelajaran.rumpun_pembelajaran'
                },
                {
                    data: 'nama_topik',
                    name: 'nama_topik',
                },
                {
                    data: 'user_created',
                    name: 'user_created.name'
                },
                {
                    data: 'nama_unit',
                    name: 'user_created.nama_unit'
                },
                {
                    data: 'tanggal_pengajuan',
                    name: 'tanggal_pengajuan',
                },
                {
                    data: 'catatan_user_created',
                    name: 'catatan_user_created',
                },
                {
                    data: 'status',
                    name: 'status',
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
