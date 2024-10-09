@extends('layouts.app')

@section('title', 'Daftar Lokasi')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Daftar Lokasi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">{{ __('roles/index.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Daftar Lokasi</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Lokasi</th>
                                            <th>Max Kapasitas</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        </div>
    @endsection

@push('js')
    <script>
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'diklatLocName',
                name: 'diklatLocName'
            },
            {
                data: 'MaxKelas',
                name: 'MaxKelas'
            }
        ];
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('lokasi.index') }}",
                data: function(s) {}
            },
            columns: columns
        })
    </script>
@endpush
