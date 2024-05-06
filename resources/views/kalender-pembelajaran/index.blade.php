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
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Detail Acara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="eventTitle"></p>
                    <p id="eventDate"></p>
                    <p id="eventDescription"></p>
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
                        title: 'Pelatihan akuntansi',
                        start: '2024-05-01',
                        end: '2024-05-02',
                        allDay: true,
                        description: 'Deskripsi Event 1'
                    },
                    {
                        title: 'Pelatihan IT',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan IT'
                    },
                    {
                        title: 'Pelatihan Programmer 1',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 1'
                    },
                    {
                        title: 'Pelatihan Programmer 2',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 2'
                    },
                    {
                        title: 'Pelatihan Programmer 3',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 3'
                    },
                    {
                        title: 'Pelatihan Programmer 4',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 4'
                    },
                    {
                        title: 'Pelatihan Programmer 5',
                        start: '2024-05-05',
                        end: '2024-05-07',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 5'
                    },
                    {
                        title: 'Pelatihan Programmer 6',
                        start: '2024-05-08',
                        end: '2024-05-10',
                        allDay: true,
                        description: 'Deskripsi Pelatihan Programmer 6'
                    }
                ],
                editable: true,
                eventClick: function(info) {
                    // Set nilai modal sesuai dengan acara yang diklik
                    document.getElementById('eventTitle').innerText = info.event.title;
                    document.getElementById('eventDate').innerText = info.event.start
                        .toLocaleDateString();
                    document.getElementById('eventDescription').innerText = info.event.extendedProps
                        .description;

                    // Tampilkan modal
                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();
                },
                dayMaxEventRows: true, // Membuat tombol "more"
            });
            calendar.render();
        });
    </script>
@endpush
