@extends('layouts.app')

@section('title', __('Pengusulan Pembelajaran ') . strtoupper(Request::segment(2)) . ' - ' .
    strtoupper(Request::segment(3)))

@section('content')
    <style>
        .btn-gray {
            background-color: gray;
            color: white;
            border-color: gray;
        }
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            text-align: center;
        }
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        .select2-container--default .select2-selection--multiple {
            height: 70px;
            overflow-y: auto;
        }
        .badge-width {
            display: inline-block;
            width: 120px;
            text-align: center;
            font-size: 0.9em;
            line-height: 1.5;
        }
    </style>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            {{ __('Pengusulan Pembelajaran ') . strtoupper(Request::segment(2)) . ' - ' . strtoupper(Request::segment(3)) }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                    {{ __('Pengusulan Pembelajaran ') . strtoupper(Request::segment(2)) . ' - ' . strtoupper(Request::segment(3)) }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($is_bpkp == 'BPKP' && $frekuensi == 'Tahunan')
                                @can('pengajuan kap tahunan bpkp')
                                    <a href="{{ route('pengajuan-kap.create', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                                        class="btn btn-md btn-primary">
                                        <i class="mdi mdi-plus"></i> {{ __('Tambah pengusulan pembelajaran') }}
                                    </a>
                                @endcan
                            @elseif($is_bpkp == 'Non BPKP' && $frekuensi == 'Tahunan')
                                @can('pengajuan kap tahunan non bpkp')
                                    <a href="{{ route('pengajuan-kap.create', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                                        class="btn btn-md btn-primary">
                                        <i class="mdi mdi-plus"></i> {{ __('Tambah pengusulan pembelajaran') }}
                                    </a>
                                @endcan
                            @elseif($is_bpkp == 'BPKP' && $frekuensi == 'Insidentil')
                                @can('pengajuan kap insidentil bpkp')
                                    <a href="{{ route('pengajuan-kap.create', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                                        class="btn btn-md btn-primary">
                                        <i class="mdi mdi-plus"></i> {{ __('Tambah pengusulan pembelajaran') }}
                                    </a>
                                @endcan
                            @elseif($is_bpkp == 'Non BPKP' && $frekuensi == 'Insidentil')
                                @can('pengajuan kap insidentil non bpkp')
                                    <a href="{{ route('pengajuan-kap.create', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
                                        class="btn btn-md btn-primary">
                                        <i class="mdi mdi-plus"></i> {{ __('Tambah pengusulan pembelajaran') }}
                                    </a>
                                @endcan
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-2">
                                        <select name="topik" id="topik"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All Program pembelajaran --</option>
                                            @foreach ($topiks as $topik)
                                                <option value="{{ $topik->id }}"
                                                    {{ $topik_id == $topik->id ? 'selected' : '' }}>
                                                    {{ $topik->nama_topik }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-2">
                                        <select name="step" id="step"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All Step --</option>
                                            <option value="1" {{ $curretnStep == 1 ? 'selected' : '' }}>Biro SDM
                                            </option>
                                            <option value="2" {{ $curretnStep == 2 ? 'selected' : '' }}>Tim Unit
                                                Pengelola Pembelajaran</option>
                                            <option value="3" {{ $curretnStep == 3 ? 'selected' : '' }}>Penjaminan
                                                Mutu</option>
                                            <option value="4" {{ $curretnStep == 4 ? 'selected' : '' }}>Subkoordinator
                                            </option>
                                            <option value="5" {{ $curretnStep == 5 ? 'selected' : '' }}>Koordinator
                                            </option>
                                            <option value="6" {{ $curretnStep == 6 ? 'selected' : '' }}>Kepala Unit
                                                Pengelola Pembelajaran</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-2">
                                        <select name="status_pengajuan" id="status_pengajuan"
                                            class="form-control js-example-basic-multiple">
                                            <option value="All">-- All Status --</option>
                                            <option value="Pending" {{ $statusPengajuan == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="Revision"
                                                {{ $statusPengajuan == 'Revision' ? 'selected' : '' }}>Revision</option>
                                            <option value="Process" {{ $statusPengajuan == 'Process' ? 'selected' : '' }}>
                                                Process</option>
                                            <option value="Approved"
                                                {{ $statusPengajuan == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected"
                                                {{ $statusPengajuan == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <select class="form-control js-example-basic-multiple" name="unit_kerja[]"
                                            multiple="multiple" id="unit-kerja-select">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->nama_unit }}"
                                                    {{ in_array($unit->nama_unit, (array) $unit_kerja) ? 'selected' : '' }}>
                                                    {{ $unit->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <select class="form-control js-example-basic-multiple" name="prioritas[]"
                                            multiple="multiple" id="prioritas-select">
                                            @for ($i = 1; $i <= 50; $i++)
                                                <option value="Prioritas {{ $i }}"
                                                    {{ in_array("Prioritas {$i}", (array) $prioritas) ? 'selected' : '' }}>
                                                    Prioritas {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $reviewExistsForUser = reviewExistsForUser();
                                @endphp
                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <button id="btnExport" class="btn btn-success">
                                            <i class='fas fa-file-excel'></i>
                                            Export
                                        </button>
                                        &nbsp;
                                        @if ($reviewExistsForUser)
                                            <button id="approve-selected" class="btn btn-md btn-success" disabled>
                                                {{ __('Approve') }}
                                            </button>
                                            &nbsp;
                                            <button id="reject-selected" class="btn btn-md btn-danger" disabled>
                                                {{ __('Reject') }}
                                            </button>
                                            @can('pengajuan kap skiped')
                                                &nbsp;
                                                <button id="skiped-selected" class="btn btn-md btn-warning" disabled>
                                                    {{ __('Skip') }}
                                                </button>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            @if ($reviewExistsForUser)
                                                <th><input type="checkbox" id="select-all"></th>
                                            @endif
                                            <th>#</th>
                                            <th>{{ __('Kode') }}</th>
                                            @if ($is_bpkp == 'BPKP')
                                                <th>{{ __('Indikator kinerja') }}</th>
                                            @endif
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Program pembelajaran') }}</th>
                                            <th>{{ __('Judul') }}</th>
                                            <th>{{ __('Current step') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Prioritas') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th style="width:80px">{{ __('Action') }}</th>
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

    <!-- Modal for Approve -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approvalNote" class="form-label">Catatan</label>
                        <textarea class="form-control" id="approvalNote" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-confirm-approve">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectedNote" class="form-label">Catatan</label>
                        <textarea class="form-control" id="rejectedNote" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btn-confirm-reject">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Skiped -->
    <div class="modal fade" id="skipedModal" tabindex="-1" role="dialog" aria-labelledby="skipedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="skipedModalLabel">Skiped Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="skipedNote" class="form-label">Catatan</label>
                        <textarea class="form-control" id="skipedNote" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="btn-confirm-skiped">Skiped</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    <script>
        let reviewRemarks = @json($reviewRemarks);
        let columns = [
            @if ($reviewExistsForUser)
                {
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (full.status_kap === 'Approved' || full.status_kap === 'Rejected' || full
                            .current_step === 2) {
                            return '<input type="checkbox" class="select-item" value="' + full
                                .id + '" disabled>';
                        } else {
                            let isDisabled = !reviewRemarks.includes(full.remark);
                            if (isDisabled) {
                                return '<input type="checkbox" class="select-item" value="' + full.id +
                                    '" disabled>';
                            } else {
                                return '<input type="checkbox" class="select-item" value="' + full.id + '">';
                            }
                        }
                    }
                },
            @endif {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
            },
            {
                data: 'kode_pembelajaran',
                name: 'kode_pembelajaran'
            },
            @if ($is_bpkp == 'BPKP')
                {
                    data: 'indikator_kinerja',
                    name: 'indikator_kinerja'
                },
            @endif {
                data: 'nama_kompetensi',
                name: 'kompetensi.nama_kompetensi'
            },
            {
                data: 'nama_topik',
                name: 'topik.nama_topik'
            },
            {
                data: 'judul',
                name: 'judul'
            },
            {
                data: 'remark',
                name: 'log_review_pengajuan_kap.remark'
            },
            {
                data: 'status_pengajuan',
                name: 'status_pengajuan'
            },
            {
                data: 'prioritas_pembelajaran',
                name: 'pengajuan_kap.prioritas_pembelajaran'
            },
            {
                data: 'user_name',
                name: 'users.name'
            },
            {
                data: 'nama_unit',
                name: 'users.nama_unit'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];

        $(document).ready(function() {
            var is_bpkp = window.location.pathname.split('/')[2];
            var frekuensi = window.location.pathname.split('/')[3];

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengajuan-kap.index', ['is_bpkp' => ':is_bpkp', 'frekuensi' => ':frekuensi']) }}"
                        .replace(':is_bpkp', is_bpkp)
                        .replace(':frekuensi', frekuensi),
                    data: function(d) {
                        d.checkboxAll = $('#select-all').prop('checked') ? 1 : 0;
                        d.tahun = $('select[name=tahun] option').filter(':selected').val()
                        d.topik = $('select[name=topik] option').filter(':selected').val()
                        d.step = $('select[name=step] option').filter(':selected').val()
                        d.status_pengajuan = $('select[name=status_pengajuan] option').filter(
                            ':selected').val()
                        d.unit_kerja = $('#unit-kerja-select').val(); // Tambahkan ini
                        d.prioritas = $('#prioritas-select').val(); // Tambahkan ini
                    }
                },
                columns: columns,
                order: [
                    [1, 'asc']
                ]
            });

            function replaceURLParams() {
                var params = new URLSearchParams();
                var tahunSelected = $('select[name=tahun]').val();
                var currentStep = $('select[name=step]').val();
                var statusPengajuan = $('select[name=status_pengajuan]').val();
                var topikSelected = $('select[name=topik]').val();
                var unitKerjaSelected = $('#unit-kerja-select').val(); // Tambahkan ini
                var prioritasSelected = $('#prioritas-select').val(); // Tambahkan ini

                if (tahunSelected) params.set('tahun', tahunSelected);
                if (topikSelected) params.set('topik', topikSelected);
                if (currentStep) params.set('step', currentStep);
                if (statusPengajuan) params.set('status_pengajuan', statusPengajuan);
                if (unitKerjaSelected) params.set('unit_kerja', unitKerjaSelected.join(',')); // Tambahkan ini
                if (prioritasSelected) params.set('prioritas', prioritasSelected.join(',')); // Tambahkan ini

                var newURL =
                    "{{ route('pengajuan-kap.index', ['is_bpkp' => ':is_bpkp', 'frekuensi' => ':frekuensi']) }}"
                    .replace(':is_bpkp', is_bpkp)
                    .replace(':frekuensi', frekuensi) + '?' + params.toString();
                history.replaceState(null, null, newURL);
            }

            // Handler untuk unit_kerja dan prioritas
            $('#unit-kerja-select').change(function() {
                table.draw();
                replaceURLParams();
            });

            $('#prioritas-select').change(function() {
                table.draw();
                replaceURLParams();
            });

            $('#tahun').change(function() {
                table.draw();
                replaceURLParams()
            })

            $('#topik').change(function() {
                table.draw();
                replaceURLParams()
            })


            $('#step').change(function() {
                table.draw();
                replaceURLParams()
            })

            $('#status_pengajuan').change(function() {
                table.draw();
                replaceURLParams()
            })

            // Handle select all checkbox
            $('#select-all').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.select-item').each(function() {
                    if (!$(this).is(':disabled')) {
                        $(this).prop('checked', isChecked);
                    }
                }).trigger('change');
            });

            // Handle individual checkboxes
            $('#data-table tbody').on('change', '.select-item', function() {
                var selectedCount = $('.select-item:checked').length;
                $('#approve-selected, #reject-selected, #skiped-selected').prop('disabled',
                    selectedCount === 0);
            });

            // Handle approve button click
            $('#approve-selected').on('click', function() {
                $('#approveModal').modal('show');
            });

            // Handle reject button click
            $('#reject-selected').on('click', function() {
                $('#rejectModal').modal('show');
            });

            // Handle skiped button click
            $('#skiped-selected').on('click', function() {
                $('#skipedModal').modal('show');
            });

            // Handle approve confirm
            $('#btn-confirm-approve').on('click', function() {
                var selectedIds = $('.select-item:checked').map(function() {
                    return $(this).val();
                }).get();
                var approvalNote = $('#approvalNote').val().trim();

                if (selectedIds.length > 0 && approvalNote !== '') {
                    $.ajax({
                        url: "{{ route('pengajuan-kap-selected.approve') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            note: approvalNote,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#approveModal').modal('hide'); // Close modal
                                    $('#approvalNote').val(''); // Clear note
                                    $('#select-all').prop('checked', false).trigger(
                                        'change'); // Uncheck all
                                    table.ajax.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong.'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Catatan approved perlu diisi'
                    });
                }
            });

            // Handle reject confirm
            $('#btn-confirm-reject').on('click', function() {
                var selectedIds = $('.select-item:checked').map(function() {
                    return $(this).val();
                }).get();
                var rejectedNote = $('#rejectedNote').val().trim();

                if (selectedIds.length > 0 && rejectedNote !== '') {
                    $.ajax({
                        url: "{{ route('pengajuan-kap-selected.reject') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            note: rejectedNote,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#rejectModal').modal('hide'); // Close modal
                                    $('#rejectedNote').val(''); // Clear note
                                    $('#select-all').prop('checked', false).trigger(
                                        'change'); // Uncheck all
                                    table.ajax.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong.'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Catatan rejected perlu diisi'
                    });
                }
            });

            // Handle skiped confirm
            $('#btn-confirm-skiped').on('click', function() {
                var selectedIds = $('.select-item:checked').map(function() {
                    return $(this).val();
                }).get();
                var skipedNote = $('#skipedNote').val().trim();
                if (selectedIds.length > 0 && skipedNote !== '') {
                    $.ajax({
                        url: "{{ route('pengajuan-kap-selected.skip') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            note: skipedNote,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#skipedModal').modal('hide'); // Close modal
                                    $('#skipedNote').val(''); // Clear note
                                    $('#select-all').prop('checked', false).trigger(
                                        'change'); // Uncheck all
                                    table.ajax.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong.'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Catatan skiped perlu diisi'
                    });
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#unit-kerja-select').select2({
                placeholder: "All Unit Kerja",
                allowClear: true,
                width: '100%' // Mengatur lebar select agar sesuai
            });

            $('#prioritas-select').select2({
                placeholder: "All Prioritas",
                allowClear: true,
                width: '100%' // Mengatur lebar select agar sesuai
            });
        });
    </script>

    <script>
        $(document).on('click', '#btnExport', function(event) {
            event.preventDefault();
            var initialYear = $('#tahun').val();
            var initialTopik = $('#topik').val();
            var initialStep = $('#step').val();
            var initialStatusPengajuan = $('#status_pengajuan').val();
            var initialFrekuensi = "{{ $frekuensi }}";
            var initialBpkp = "{{ $is_bpkp }}";
            var unitKerja = $('#unit-kerja-select').val(); // array
            var prioritas = $('#prioritas-select').val(); // array
            exportData(initialYear, initialTopik, initialStep, initialStatusPengajuan, initialBpkp,
                initialFrekuensi,
                unitKerja, prioritas);
        });

        var exportData = function(initialYear, initialTopik, initialStep, initialStatusPengajuan, initialBpkp,
            initialFrekuensi,
            unitKerja, prioritas) {
            var url = '/exportPengajuanKap';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    year: initialYear,
                    topik: initialTopik,
                    step: initialStep,
                    status_pengajuan: initialStatusPengajuan,
                    is_bpkp: initialBpkp,
                    frekuensi: initialFrekuensi,
                    unit_kerja: unitKerja,
                    prioritas: prioritas
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Harap Tunggu',
                        html: 'Mengekspor data',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = `pengajuan_kap_${initialBpkp}_${initialFrekuensi}_${initialYear}.xlsx`;
                    link.download = nameFile;
                    link.click();
                    swal.close();
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: 'Ekspor Gagal',
                        text: 'Periksa kesalahan',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
    <script>
        $(document).on('click', '.btn-duplikat', function(e) {
            e.preventDefault(); // Mencegah link default
            var href = $(this).attr('href'); // Ambil URL dari href

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menduplikat Pengajuan KAP ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, duplikat!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var formId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data ini setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + formId).submit(); // Submit form delete
                }
            });
        });
    </script>
@endpush
