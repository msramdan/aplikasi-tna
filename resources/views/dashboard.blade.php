@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel"
                aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="announcementModalLabel">Pengumuman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p style="text-align: justify">
                                @php
                                    $pengumuman = DB::table('pengumuman')->first();
                                    $tahun = session('jadwal_kap_tahunan')
                                        ? session('jadwal_kap_tahunan')->tahun
                                        : '{placeholder_tahun}';
                                @endphp

                                @if ($pengumuman)
                                    {{-- Ganti placeholder dengan tahun --}}
                                    {!! str_replace('{placeholder_tahun}', $tahun, $pengumuman->pengumuman) !!}
                                @else
                                    Tidak ada pengumuman saat ini.
                                @endif
                            </p>
                            @if (session('jadwal_kap_tahunan'))
                                <div class="text-center">
                                    <h5>
                                        Periode Pengisian: <br>
                                        {{ formatTanggalIndonesia(session('jadwal_kap_tahunan')->tanggal_mulai) }} -
                                        {{ formatTanggalIndonesia(session('jadwal_kap_tahunan')->tanggal_selesai) }}
                                    </h5>
                                </div>
                            @endif
                            <br>
                            <div class="text-center">
                                <p>
                                    <u><b>Klik link di bawah ini untuk pengajuan KAP</b></u>
                                </p>
                                <div class="row">
                                    <div class="col">
                                        <a href="/pengajuan-kap/BPKP/Tahunan" class="btn btn-primary">KAP TAHUNAN BPKP</a>
                                        <a href="/pengajuan-kap/Non BPKP/Tahunan" class="btn btn-primary">KAP TAHUNAN NON
                                            BPKP</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col">
                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">{{ trans('dashboard.welcome') }} {{ Auth::user()->name }}
                                        </h4>
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
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_work_order_modal">Total Lokasi</a>
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
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_equipment_modal">Total Ruang Kelas</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="-"></span>
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
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_employee_modal">Total Asrama</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="-"></span>
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
                                                    <a href="" style="color: #A8AAB5" role="button"
                                                        id="btn_vendor_modal">Total Pengguna</a>
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
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark"
                                                id="btn_wo_by_type_modal">Pengusulan Pembelajaran Berdasarkan Status</a>
                                        </h4>
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items: center;">
                                        <canvas id="myChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card" style="height: 500px">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                            <a href="" role="button" class="text-dark"
                                                id="btn_wo_by_type_modal">Pengusulan Pembelajaran / Tahun</a>
                                        </h4>
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items: center;">
                                        <canvas id="myChart2"></canvas>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('login_success'))
                var announcementModal = new bootstrap.Modal(document.getElementById('announcementModal'));
                announcementModal.show();
            @endif
        });
    </script>

    <script>
        var labels = @json($labels); // Kirim label dari PHP
        var data = @json($totals); // Kirim total data dari PHP

        // Chart 1
        var ctx1 = document.getElementById("myChart1").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels, // Label dinamis dari database
                datasets: [{
                    label: '# Total Data',
                    data: data, // Data dinamis dari database
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(128, 128, 128, 0.2)', // Revision (Gray)
                        'rgba(54, 162, 235, 0.2)', // Process (Blue)
                        'rgba(75, 192, 192, 0.2)', // Approved (Green)
                        'rgba(255, 99, 132, 0.2)' // Rejected (Red)
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)', // Pending (Orange)
                        'rgba(128, 128, 128, 1)', // Revision (Gray)
                        'rgba(54, 162, 235, 1)', // Process (Blue)
                        'rgba(75, 192, 192, 1)', // Approved (Green)
                        'rgba(255, 99, 132, 1)' // Rejected (Red)
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

    <script>
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['2023', '2024', '2025', '2026'], // Label tahun
                datasets: [{
                        label: 'BPKP',
                        data: [4, 8, 12, 5], // Data untuk BPKP
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true, // Mengisi area di bawah garis
                    },
                    {
                        label: 'Non BPKP',
                        data: [2, 3, 10, 15], // Data untuk Non BPKP
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true, // Mengisi area di bawah garis
                    }
                ]
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
