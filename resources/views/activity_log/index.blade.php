@extends('layouts.app')
@section('title', __('activity_log\index.Activity Log'))
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('activity_log\index.Activity Log') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('activity_log\index.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('activity_log\index.Activity Log') }}</li>
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
                                <table class="table table-striped" id="dataTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th></th>
                                            <th>{{ __('activity_log\index.No') }}</th>
                                            <th>{{ __('activity_log\index.Log Name') }}</th>
                                            <th>{{ __('activity_log\index.Description') }}</th>
                                            <th>{{ __('activity_log\index.Event') }}</th>
                                            <th>{{ __('activity_log\index.User') }}</th>
                                            <th>{{ __('activity_log\index.Date') }}</th>
                                            <th>{{ __('activity_log\index.Time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            let columns = [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'log_name',
                    name: 'log_name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'event',
                    name: 'event'
                },
                {
                    data: 'causer',
                    name: 'causer'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'time',
                    name: 'time'
                },
            ];

            const table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('activity-log.index') }}",
                columns: columns,
                order: [
                    [1, 'asc']
                ]
            });

            $('#dataTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
                tr.closest('tbody').find('textarea').each(function() {
                    this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
                    this.style.height = 0;
                    this.style.height = (this.scrollHeight) + "px";
                })
            });

            function format(d) {
                return (
                    `<div class="mb-4">
                        <label for="form-label">{{ __('activity_log\index.Old Value') }}</label>
                        <textarea name="" id="" cols="30" class="form-control" style="height: 100%;" disabled>${d.old_value}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="form-label">{{ __('activity_log\index.New Value') }}</label>
                        <textarea rows="" name="" id="" cols="30" class="form-control" style="height: 100%;" disabled>${d.new_value}</textarea>
                    </div>`
                );
            }
        </script>
    @endpush
