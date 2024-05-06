<!-- resources/views/calendar.blade.php -->

@extends('layouts.app')

@section('title', __('Kalender Pembelajaran'))
@push('css')
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
                        <h4 class="mb-sm-0">{{ __('Kalender Pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ __('Kalender Pembelajaran') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pembelajaran</h5>
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
                    <h5 class="modal-title" id="eventModalLabel">Detail pembelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Judul</th>
                                <td id="eventTitle"></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal mulai</th>
                                <td id="eventDateStart"></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal selesai</th>
                                <td id="eventDateEnd"></td>
                            </tr>
                            <tr>
                                <th scope="row">Deksripsi</th>
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
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [{
                        title: 'Pelatihan akuntansi 1',
                        start: '2024-05-06T00:00:00',
                        end: '2024-05-06T23:59:59',
                        description: 'Deskripsi Event 1'
                    },
                    {
                        title: 'Pelatihan akuntansi 2',
                        start: '2024-05-06T00:00:00',
                        end: '2024-05-06T23:59:59',
                        description: 'Deskripsi Event 1'
                    },
                    {
                        title: 'Pelatihan akuntansi 3',
                        start: '2024-05-06T00:00:00',
                        end: '2024-05-06T23:59:59',
                        description: 'Deskripsi Event 1'
                    },
                    {
                        title: 'Pelatihan IT',
                        start: '2024-05-10T00:00:00',
                        end: '2024-05-11T23:59:59',
                        description: 'Deskripsi Event 1'
                    }
                ],
                editable: true,
                eventClick: function(info) {
                    // Set nilai modal sesuai dengan acara yang diklik
                    document.getElementById('eventTitle').innerText = info.event.title;
                    document.getElementById('eventDateStart').innerText = moment(info.event.start)
                        .format("YYYY-MM-DD");
                    document.getElementById('eventDateEnd').innerText = moment(info.event.end)
                        .format("YYYY-MM-DD");
                    document.getElementById('eventDescription').innerText = info.event.extendedProps
                        .description;

                    // Tampilkan modal
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();
                },
                dayMaxEventRows: true, // Membuat tombol "more"
                dateClick: function(info) {
                    var clickedDate = info.date;
                    var eventsOnDate = calendar.getEvents().filter(function(event) {
                        return moment(clickedDate).isBetween(event.start, event.end, null,
                            '[]');
                    });
                    var eventList = eventsOnDate.map(function(event) {
                        return "<li>" + event.title + "</li>";
                    });
                    document.getElementById('eventList').innerHTML = eventList.join("");
                }
            });
            calendar.render();
        });
    </script>
@endpush
