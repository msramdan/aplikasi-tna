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

        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
@endpush
@section('content')
    <div id="loading-indicator" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

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
                                <div class="col-md-2">
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

                                <div class="col-md-2">
                                    <div class="input-group mb-2">
                                        <select name="topik" id="topik"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All topik --</option>
                                            @foreach ($topiks as $topik)
                                                <option value="{{ $topik->id }}"
                                                    {{ $selectedTopik == $topik->id ? 'selected' : '' }}>
                                                    {{ $topik->nama_topik }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group mb-2">
                                        <select name="sumber_dana" id="sumber_dana"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All Sumber dana --</option>
                                            <option value="RM" {{ $sumberDana == 'RM' ? 'selected' : '' }}>RM</option>
                                            <option value="PNBP" {{ $sumberDana == 'PNBP' ? 'selected' : '' }}>PNBP
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group mb-2">
                                        <button id="btnExport" class="btn btn-success">
                                            <i class='fas fa-file-excel'></i> Export
                                        </button>
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
                                                <th>{{ __('Program pembelajaran') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-form').select2();

            var calendarEl = document.getElementById('calendar');
            var calendar;

            function showLoading() {
                $('#loading-indicator').show();
            }

            function hideLoading() {
                $('#loading-indicator').hide();
            }

            function fetchEvents(year, topik, sumber_dana) {
                showLoading();
                $.ajax({
                    url: '{{ route('getEvents') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        topik: topik,
                        sumber_dana: sumber_dana,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        calendar.removeAllEvents();
                        calendar.addEventSource(data);

                        var tableBody = $('#data-table tbody');
                        tableBody.empty();
                        $.each(data, function(index, event) {
                            tableBody.append('<tr><td>' + (index + 1) + '</td><td>' + event
                                .start.split('T')[0] + ' - ' + event.end.split('T')[0] +
                                '</td><td>' + event.title + '</td></tr>');
                        });
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch events:', error);
                        hideLoading();
                    }
                });
            }

            function initializeCalendar(year, topik, sumber_dana) {
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

                fetchEvents(year, topik, sumber_dana);
                calendar.render();
            }

            function updateURL(year, topik, sumber_dana) {
                var newUrl = '{{ url('/kalender-pembelajaran') }}/' + year + '/' + topik + '/' + sumber_dana;
                window.history.replaceState({
                    path: newUrl
                }, '', newUrl);
            }

            $('#tahun, #topik,#sumber_dana').on('change', function() {
                var selectedYear = $('#tahun').val();
                var selectedTopik = $('#topik').val();
                var selectedSumberDana = $('#sumber_dana').val();
                fetchEvents(selectedYear, selectedTopik, selectedSumberDana);
                updateURL(selectedYear, selectedTopik, selectedSumberDana);
            });

            // Initialize the calendar with the current year and topic or the selected year and topic from the controller
            var initialYear = $('#tahun').val();
            var initialTopik = $('#topik').val();
            var initialSumberDana = $('#sumber_dana').val();
            initializeCalendar(initialYear, initialTopik, initialSumberDana);
        });
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            var initialYear = $('#tahun').val();
            var initialTopik = $('#topik').val();
            var initialSumberDana = $('#sumber_dana').val();
            exportData(initialYear, initialTopik, initialSumberDana);
        });

        var exportData = function(year, topik, sumberDana) {
            var url = '/exportKalenderPembelajaran';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    year: year,
                    topik: topik,
                    sumber_dana: sumberDana
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan proses export data',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'Kalender pembelajaran tahun 2024 pola dana RM.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Data export failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endpush
