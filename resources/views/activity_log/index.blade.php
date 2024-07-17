@extends('layouts.app')
@section('title', __('activity_log/index.Activity Log'))
@push('css')
    <link href="{{ asset('material/assets/css/daterangepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('activity_log/index.Activity Log') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard') }}">{{ __('activity_log/index.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('activity_log/index.Activity Log') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-4">
                                        <span class="input-group-text" id="addon-wrapping"><i
                                                class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                            id="daterange-btn" value="">
                                        <input type="hidden" name="start_date" id="start_date"
                                            value="{{ $microFrom ?? '' }}">
                                        <input type="hidden" name="end_date" id="end_date" value="{{ $microTo ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group mb-4">
                                        <select name="log_name" id="log_name" class="form-control js-example-basic-multiple">
                                            <option value="All" {{ $log_name == 'All' ? 'selected' : '' }}>-- All Type Log --</option>
                                            @foreach ($arrLog as $log)
                                                <option value="{{ $log }}" {{ $log_name == $log ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $log)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="dataTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th></th>
                                            <th>{{ __('activity_log/index.No') }}</th>
                                            <th>{{ __('activity_log/index.Log Name') }}</th>
                                            <th>{{ __('activity_log/index.Description') }}</th>
                                            <th>{{ __('activity_log/index.Event') }}</th>
                                            <th>{{ __('activity_log/index.User') }}</th>
                                            <th>{{ __('activity_log/index.Date') }}</th>
                                            <th>{{ __('activity_log/index.Time') }}</th>
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
        <script type="text/javascript" src="{{ asset('material/assets/js/moment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('material/assets/js/daterangepicker.min.js') }}"></script>


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


            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('activity-log.index') }}",
                    data: function(s) {
                        s.start_date = $("#start_date").val();
                        s.end_date = $("#end_date").val();
                        s.log_name = $('select[name=log_name] option').filter(':selected').val()
                    }
                },
                columns: columns,
                order: [
                    [1, 'asc']
                ]
            });

            function replaceURLParams() {
                var params = new URLSearchParams();
                var startDate = $("#start_date").val();
                var endDate = $("#end_date").val();
                var logName = $('select[name=log_name]').val();
                if (startDate) params.set('start_date', startDate);
                if (endDate) params.set('end_date', endDate);
                if (logName) params.set('log_name', logName);
                var newURL = "{{ route('activity-log.index') }}" + '?' + params.toString();
                history.replaceState(null, null, newURL);
            }

            $('#daterange-btn').change(function() {
                table.draw();
                replaceURLParams()
            })

            $('#log_name').change(function() {
                table.draw();
                replaceURLParams()
            })
        </script>
        <script>
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
                        <label for="form-label">{{ __('activity_log/index.Old Value') }}</label>
                        <textarea name="" id="" cols="30" class="form-control" style="height: 100%;" disabled>${d.old_value}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="form-label">{{ __('activity_log/index.New Value') }}</label>
                        <textarea rows="" name="" id="" cols="30" class="form-control" style="height: 100%;" disabled>${d.new_value}</textarea>
                    </div>`
                );
            }
        </script>
        <script>
            var start = {{ $microFrom }}
            var end = {{ $microTo }}
            var label = '';
            $('#daterange-btn').daterangepicker({
                    locale: {
                        format: 'DD MMM YYYY'
                    },
                    startDate: moment(start),
                    endDate: moment(end),
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                            'month')],
                    }
                },
                function(start, end, label) {
                    $('#start_date').val(Date.parse(start));
                    $('#end_date').val(Date.parse(end));
                    if (isDate(start)) {
                        $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                    }
                });

            function isDate(val) {
                var d = Date.parse(val);
                return Date.parse(val);
            }
        </script>
    @endpush
