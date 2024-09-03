@extends('layouts.app')

@section('title', __('Rumpun Pembelajaran'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Rumpun Pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Rumpun Pembelajaran') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        @can('rumpun pembelajaran create')
                            <div class="card-header">
                                <a href="{{ route('rumpun-pembelajaran.create') }}" class="btn btn-md btn-primary"> <i
                                        class="mdi mdi-plus"></i> {{ __('Create a new rumpun pembelajaran') }}</a>
                            </div>
                        @endcan

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Rumpun Pembelajaran') }}</th>
                                            @canany(['rumpun pembelajaran edit', 'rumpun pembelajaran delete'])
                                                <th>{{ __('Action') }}</th>
                                            @endcanany
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
        $(document).ready(function() {
            let columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rumpun_pembelajaran',
                    name: 'rumpun_pembelajaran',
                }
            ];

            @canany(['rumpun pembelajaran edit', 'rumpun pembelajaran delete'])
                columns.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });
            @endcanany

            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rumpun-pembelajaran.index') }}",
                columns: columns,
            });
        });
    </script>
@endpush
