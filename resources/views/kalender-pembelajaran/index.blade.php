@extends('layouts.app')

@section('title', __('kalender-pembelajaran/index.Kalender Pembelajaran'))
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
    <style>
        #calendar {
            width: 100%;
            margin: 0 auto;
        }
    </style>
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('kalender-pembelajaran/index.Kalender Pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="/">{{ __('kalender-pembelajaran/index.Dashboard') }}</a></li>
                                <li class="breadcrumb-item active">
                                    {{ __('kalender-pembelajaran/index.Kalender Pembelajaran') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-4">
                                        <select name="tahun" id="tahun" class="form-control select2-form">
                                            @php
                                                $startYear = 2023;
                                                $currentYear = date('Y');
                                                $endYear = $currentYear + 2;
                                            @endphp
                                            @foreach (range($startYear, $endYear) as $yearOption)
                                                <option value="{{ $yearOption }}"
                                                    {{ $yearOption == $year ? 'selected' : '' }}>
                                                    {{ $yearOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <select name="tahun" id="tahun"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All topik --</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id='calendar'></div>
                                </div>

                                <div class="col-sm-6">
                                    <table class="table table-striped" id="data-table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Tanggal') }}</th>
                                                <th>{{ __('Topik') }}</th>
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
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">
                        {{ __('kalender-pembelajaran/index.Detail pembelajaran') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Kode Pembelajaran</th>
                                <td id="eventKode"></td>
                            </tr>
                            <tr>
                                <th scope="row">Institusi Sumber</th>
                                <td id="eventSumber"></td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Progran</th>
                                <td id="eventJenis"></td>
                            </tr>
                            <tr>
                                <th scope="row">Frekuensi pelaksanaan</th>
                                <td id="eventFrekuensi"></td>
                            </tr>

                            <tr>
                                <th scope="row">Topik pembelajaran</th>
                                <td id="eventTitle"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('kalender-pembelajaran/index.Tanggal mulai') }}</th>
                                <td id="eventDateStart"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('kalender-pembelajaran/index.Tanggal selesai') }}</th>
                                <td id="eventDateEnd"></td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('kalender-pembelajaran/index.Deksripsi') }}</th>
                                <td id="eventDescription"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.select2-form').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');
            var calendar;

            function fetchEvents(year) {
                $.ajax({
                    url: '{{ route('getEvents') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch events:', error);
                    }
                });
            }

            function initializeCalendar(year) {
                var startOfYear = moment(year + '-01-01').format('YYYY-MM-DD');
                var endOfYear = moment(year + '-12-31').format('YYYY-MM-DD');

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    editable: true,
                    validRange: {
                        start: startOfYear,
                        end: endOfYear
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    eventClick: function(info) {
                        console.log(info.event);
                        $('#eventKode').text(info.event.extendedProps.kode_pembelajaran);
                        $('#eventSumber').text(info.event.extendedProps.institusi_sumber);
                        $('#eventJenis').text(info.event.extendedProps.jenis_program);
                        $('#eventFrekuensi').text(info.event.extendedProps.frekuensi_pelaksanaan);
                        $('#eventTitle').text(info.event.title);
                        $('#eventDateStart').text(moment(info.event.start).format("YYYY-MM-DD"));
                        $('#eventDateEnd').text(moment(info.event.end).format("YYYY-MM-DD"));
                        $('#eventDescription').text(info.event.extendedProps.description);
                        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    },
                    dayMaxEventRows: true,
                });

                fetchEvents(year);
                calendar.render();
            }

            $('#tahun').on('change', function() {
                var selectedYear = $(this).val();
                var url = '{{ route('kalender-pembelajaran.index', ':year') }}';
                url = url.replace(':year', selectedYear);
                window.location.href = url;
            });

            // Initialize the calendar with the current year or the selected year from the controller
            var initialYear = $('#tahun').val();
            initializeCalendar(initialYear);
        });
    </script>
@endpush
