@extends('layouts.app')

@section('title', __('jadwal-kap-tahunan/index.Jadwal Kap Tahunan'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('jadwal-kap-tahunan/index.Jadwal Kap Tahunan') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">{{ __('jadwal-kap-tahunan/index.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('jadwal-kap-tahunan/index.Jadwal Kap Tahunan') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @can('jadwal kap tahunan create')
                                <a href="{{ route('jadwal-kap-tahunan.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('jadwal-kap-tahunan/index.Create a new jadwal kap tahunan') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>{{ __('jadwal-kap-tahunan/index.Tahun') }}</th>
                                            <th>{{ __('jadwal-kap-tahunan/index.Tanggal Mulai') }}</th>
                                            <th>{{ __('jadwal-kap-tahunan/index.Tanggal Selesai') }}</th>
                                            <th>{{ __('jadwal-kap-tahunan/index.Action') }}</th>
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
            ajax: "{{ route('jadwal-kap-tahunan.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tahun',
                    name: 'tahun',
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai',
                },
                {
                    data: 'tanggal_selesai',
                    name: 'tanggal_selesai',
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
