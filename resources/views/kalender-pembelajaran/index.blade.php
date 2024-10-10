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
                                        <select name="waktu_pelaksanaan" id="waktu_pelaksanaan"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All waktu pelaksanaan --</option>
                                            <option value="Tahunan" {{ $waktuPelaksanaan == 'Tahunan' ? 'selected' : '' }}>
                                                Tahunan</option>
                                            <option value="Insidentil"
                                                {{ $waktuPelaksanaan == 'Insidentil' ? 'selected' : '' }}>Insidentil
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group mb-2">
                                        <select name="sumber_dana" id="sumber_dana"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All sumber dana --</option>
                                            <option value="RM" {{ $sumberDana == 'RM' ? 'selected' : '' }}>RM</option>
                                            <option value="PNBP" {{ $sumberDana == 'PNBP' ? 'selected' : '' }}>PNBP
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group mb-2">
                                        <select name="topik" id="topik"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All program pembelajaran --</option>
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
                                                <th>{{ __('Metode') }}</th>
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
                                <th scope="row">Institusi</th>
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

            function fetchEvents(year, waktu_pelaksanaan, sumber_dana, topik) {
                showLoading();
                $.ajax({
                    url: '{{ route('getEvents') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        waktu_pelaksanaan: waktu_pelaksanaan,
                        sumber_dana: sumber_dana,
                        topik: topik,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(data);

                        var tableBody = $('#data-table tbody');
                        tableBody.empty();
                        $.each(data, function(index, event) {
                            var endDate = moment(event.end.split('T')[0]).subtract(1, 'days')
                                .format('YYYY-MM-DD'); // Mengurangi 1 hari dari event.end
                            tableBody.append('<tr><td>' + (index + 1) + '</td><td>' + event
                                .start.split('T')[0] +
                                ' - ' + endDate + '</td><td>' + event.remarkMetodeName +
                                '</td><td>' + event.title +
                                '</td></tr>');
                        });

                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch events:', error);
                        hideLoading();
                    }
                });
            }

            function initializeCalendar(year, waktu_pelaksanaan, sumber_dana, topik) {
                var startOfYear = moment(year + '-01-01').format('YYYY-MM-DD');
                var endOfYear = moment(year + '-12-31').format('YYYY-MM-DD');

                if (calendar) {
                    calendar.destroy(); // Destroy existing calendar before reinitializing
                }

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
                        $('#eventDateEnd').text(moment(info.event.end).subtract(1, 'days').format(
                            "YYYY-MM-DD"));
                        $('#eventDescription').text(info.event.extendedProps.description);
                        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                    },
                    dayMaxEventRows: true,
                });

                fetchEvents(year, waktu_pelaksanaan, sumber_dana, topik);
                calendar.render();
            }

            function updateURL(year, waktu_pelaksanaan, sumber_dana, topik) {
                var newUrl = '{{ url('/kalender-pembelajaran') }}/' + year + '/' + waktu_pelaksanaan + '/' +
                    sumber_dana + '/' + topik;
                window.history.replaceState({
                    path: newUrl
                }, '', newUrl);
            }

            $('#tahun, #topik,#sumber_dana,#waktu_pelaksanaan').on('change', function() {
                var selectedYear = $('#tahun').val();
                var selectedWaktuPelaksanaan = $('#waktu_pelaksanaan').val();
                var selectedSumberDana = $('#sumber_dana').val();
                var selectedTopik = $('#topik').val();
                initializeCalendar(selectedYear, selectedWaktuPelaksanaan, selectedSumberDana,
                    selectedTopik); // Reinitialize calendar
                updateURL(selectedYear, selectedWaktuPelaksanaan, selectedSumberDana, selectedTopik);
            });

            // Initialize the calendar with the current year and topic or the selected year and topic from the controller
            var initialYear = $('#tahun').val();
            var initialWaktuPelaksanaan = $('#waktu_pelaksanaan').val();
            var initialSumberDana = $('#sumber_dana').val();
            var initialTopik = $('#topik').val();
            initializeCalendar(initialYear, initialWaktuPelaksanaan, initialSumberDana, initialTopik);
        });
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            var initialYear = $('#tahun').val();
            var initialWaktuPelaksanaan = $('#waktu_pelaksanaan').val();
            var initialSumberDana = $('#sumber_dana').val();
            var initialTopik = $('#topik').val();
            exportData(initialYear, initialWaktuPelaksanaan, initialSumberDana, initialTopik);
        });

        var exportData = function(year, waktuPelaksanaan, sumberDana, topik) {
            var url = '/exportKalenderPembelajaran';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    year: year,
                    waktu_pelaksanaan: waktuPelaksanaan,
                    sumber_dana: sumberDana,
                    topik: topik
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
                    var nameFile;
                    if (topik === 'All' && sumberDana === 'All') {
                        nameFile = `Daftar rencana pembelajaran ${waktuPelaksanaan} ${year}.xlsx`;
                    } else {
                        var sumberDanaPart = sumberDana !== 'All' ? `pola dana ${sumberDana}` : '';
                        nameFile =
                            `Daftar rencana pembelajaran ${waktuPelaksanaan} ${year} ${sumberDanaPart}.xlsx`;
                    }

                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    link.download = nameFile;
                    link.click();
                    Swal.close();
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
