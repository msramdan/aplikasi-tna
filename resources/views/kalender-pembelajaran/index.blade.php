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
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-4">
                                        <select name="tahun" id="tahun" class="form-control select2-form">
                                            @php
                                                $startYear = 2023;
                                                $currentYear = date('Y');
                                                $endYear = $currentYear + 1;
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
                            </div>
                            <hr>
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('kalender-pembelajaran/index.Daftar Pembelajaran') }}</h5>
                            <ul id="eventList"></ul>
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
                    <h5 class="modal-title" id="eventModalLabel">{{ __('kalender-pembelajaran/index.Detail pembelajaran') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">{{ __('kalender-pembelajaran/index.Judul') }}</th>
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

            function initializeCalendar() {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    editable: true,
                    eventClick: function(info) {
                        // Set nilai modal sesuai dengan acara yang diklik
                        $('#eventTitle').text(info.event.title);
                        $('#eventDateStart').text(moment(info.event.start).format("YYYY-MM-DD"));
                        $('#eventDateEnd').text(moment(info.event.end).format("YYYY-MM-DD"));
                        $('#eventDescription').text(info.event.extendedProps.description);

                        // Tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    },
                    dayMaxEventRows: true,
                    dateClick: function(info) {
                        var clickedDate = info.date;
                        var eventsOnDate = calendar.getEvents().filter(function(event) {
                            return moment(clickedDate).isBetween(event.start, event.end, null,
                                '[]');
                        });
                        var eventList = eventsOnDate.map(function(event) {
                            return "<li>" + event.title + "</li>";
                        });
                        $('#eventList').html(eventList.join(""));
                    }
                });

                var selectedYear = $('#tahun').val();
                console.log(selectedYear);
                fetchEvents(selectedYear);
                calendar.render();
            }

            $('#tahun').on('change', function() {
                var selectedYear = $(this).val();
                var url = '{{ route('kalender-pembelajaran.index', ':year') }}';
                url = url.replace(':year', selectedYear);
                window.location.href = url;
            });

            initializeCalendar();
        });
    </script>
@endpush
