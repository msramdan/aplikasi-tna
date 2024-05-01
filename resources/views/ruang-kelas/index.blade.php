@extends('layouts.app')

@section('title', __('Ruang kelas'))

@section('content')
                <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Ruang kelas') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{ __('Ruang kelas') }}</li>
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
                                        class="mdi mdi-plus"></i> {{ __('Create a new ruang kelas') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Kampus') }}</th>
											<th>{{ __('Nama Kelas') }}</th>
											<th>{{ __('Kuota') }}</th>
											<th>{{ __('Status') }}</th>
											<th>{{ __('Keterangan') }}</th>
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
            ajax: "{{ route('ruang-kelas.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'campus',
                    name: 'campus.nama_kampus'
                },
				{
                    data: 'nama_kelas',
                    name: 'nama_kelas',
                },
				{
                    data: 'kuota',
                    name: 'kuota',
                },
				{
                    data: 'status',
                    name: 'status',
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
