@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">{{ trans('dashboard.welcome') }} {{ Auth::user()->name }}</h4>
                                    </div>
                                    <div class="mt-3 mt-lg-0"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button" id="btn_work_order_modal">{{ trans('dashboard.total_location') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $totalLokasi }}"></span>
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning rounded fs-3">
                                                    <i class="fa fa-bank"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button" id="btn_equipment_modal">{{ trans('dashboard.total_classrooms') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $totalKelas }}"></span>
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded fs-3">
                                                    <i class="fa fa-list"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button" id="btn_employee_modal">{{ trans('dashboard.total_dormitories') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $totalAsrama }}"></span>
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info rounded fs-3">
                                                    <i class="fa fa-home" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    <a href="" style="color: #A8AAB5" role="button" id="btn_vendor_modal">{{ trans('dashboard.total_users') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $totalUser }}"></span>
                                                </h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-danger rounded fs-3">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Grafik Total --}}
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark" id="btn_wo_by_status_modal">{{ trans('dashboard.training_by_funding_source') }}</a>
                                        </h4>
                                    </div>
                                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                        <div style="height: 300px;">
                                            <canvas id="myChart1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark" id="btn_wo_by_category_modal">{{ trans('dashboard.training_by_participants') }}</a>
                                        </h4>
                                    </div>
                                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                        <div style="height: 300px;">
                                            <canvas id="myChart2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark" id="btn_wo_by_type_modal">{{ trans('dashboard.training_by_status') }}</a>
                                        </h4>
                                    </div>
                                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                        <div style="height: 300px;">
                                            <canvas id="myChart3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 450px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">{{ trans('dashboard.classroom_status_by_status') }}</h4>
                                    </div>
                                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                        <div style="height: 300px;">
                                            <canvas id="myChart4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 450px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">{{ trans('dashboard.dormitory_status_by_status') }}</h4>
                                    </div>
                                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                                        <div style="height: 300px;">
                                            <canvas id="myChart5"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Chart Scripts --}}
    <script>
        // Chart 1
        var ctx1 = document.getElementById("myChart1").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ["RM", "Star", "PNBP"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Chart 2
        var ctx2 = document.getElementById("myChart2").getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["BPKP", "APIP Lainya"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart 3
        var ctx3 = document.getElementById("myChart3").getContext('2d');
        var myChart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ["Rejected", "Approved", "Pending"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Chart 4
        var ctx4 = document.getElementById("myChart4").getContext('2d');
        var myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ["Not available", "Available"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart 5
        var ctx5 = document.getElementById("myChart5").getContext('2d');
        var myChart5 = new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: ["Not available", "Available"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
