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
            /* Transparan white background */
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
                            {{ __('Pengusulan Pembelajaran ') . strtoupper(Request::segment(2) . ' - ' . strtoupper(Request::segment(3))) }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                    {{ __('Pengusulan Pembelajaran ') . strtoupper(Request::segment(2) . ' - ' . strtoupper(Request::segment(3))) }}
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
                            @can('pengajuan kap create')
                                <a href="{{ route('pengajuan-kap.create', [
                                    'is_bpkp' => $is_bpkp,
                                    'frekuensi' => $frekuensi,
                                ]) }}"
                                    class="btn btn-md btn-primary"> <i class="mdi mdi-plus"></i>
                                    {{ __('Create a new Pengusulan Pembelajaran') }}</a>
                            @endcan
                            <button id="approve-selected" class="btn btn-md btn-success" disabled>
                                {{ __('Approve Selected') }}
                            </button>
                            <button id="reject-selected" class="btn btn-md btn-danger" disabled>
                                {{ __('Reject Selected') }}
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>#</th>
                                            <th>{{ __('Kode') }}</th>
                                            <th>{{ __('Indikator Kinerja') }}</th>
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Topik') }}</th>
                                            <th>{{ __('User created') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
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
                    <h5 class="modal-title" id="approveModalLabel">Approved</h5>
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
                    <h5 class="modal-title" id="rejectModalLabel">Rejected</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectionNote" class="form-label">Catatan</label>
                        <textarea class="form-control" id="rejectionNote" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btn-confirm-reject">Reject</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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
                    }
                },
                columns: [{
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            if (full.status_kap === 'Approved' || full.status_kap ===
                                'Rejected') {
                                return '<input type="checkbox" class="select-item" value="' + full
                                    .id + '" disabled>';
                            } else {
                                return '<input type="checkbox" class="select-item" value="' + full
                                    .id + '">';
                            }
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'kode_pembelajaran',
                        name: 'kode_pembelajaran'
                    },
                    {
                        data: 'indikator_kinerja',
                        name: 'indikator_kinerja'
                    },
                    {
                        data: 'nama_kompetensi',
                        name: 'nama_kompetensi'
                    },
                    {
                        data: 'nama_topik',
                        name: 'nama_topik'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'status_pengajuan',
                        name: 'status_pengajuan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

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
                $('#approve-selected, #reject-selected').prop('disabled', selectedCount === 0);
            });

            // Handle approve button click
            $('#approve-selected').on('click', function() {
                $('#approveModal').modal('show');
            });

            // Handle reject button click
            $('#reject-selected').on('click', function() {
                $('#rejectModal').modal('show');
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
                            alert(response.message);
                            $('#approveModal').modal('hide'); // Close modal
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Something went wrong.');
                        }
                    });
                } else {
                    alert('Catatan approved perlu diisi');
                }
            });

            // Handle reject confirm
            $('#btn-confirm-reject').on('click', function() {
                var selectedIds = $('.select-item:checked').map(function() {
                    return $(this).val();
                }).get();
                var rejectionNote = $('#rejectionNote').val().trim();

                if (selectedIds.length > 0 && rejectionNote !== '') {
                    $.ajax({
                        url: "{{ route('pengajuan-kap-selected.reject') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            note: rejectionNote,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);
                            $('#rejectModal').modal('hide'); // Close modal
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Something went wrong.');
                        }
                    });
                } else {
                    alert('Catatan rejected perlu diisi');
                }
            });
        });
    </script>
@endpush
