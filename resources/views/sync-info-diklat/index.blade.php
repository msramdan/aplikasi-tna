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
                            {{ __('Sync info diklat ') }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                    {{ __('Sync info diklat ') }}
                                </li>
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
                                    <div class="input-group mb-2">
                                        <select name="tahun" id="tahun"
                                            class="form-control js-example-basic-multiple">
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
                                        <button id="sync-selected" class="btn btn-md btn-danger" disabled> <i
                                                class="fas fa-sync"></i>
                                            {{ __('Sync data') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>#</th>
                                            <th>{{ __('Kode') }}</th>
                                            <th>{{ __('Indikator kinerja') }}</th>
                                            <th>{{ __('Kompetensi') }}</th>
                                            <th>{{ __('Program pembelajaran') }}</th>
                                            <th>{{ __('Sumber dana') }}</th>
                                            <th>{{ __('Status sync') }}</th>
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
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let columns = [{
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    let isDisabled = full.sync_data === 'Success' ? 'disabled' : '';
                    return '<input type="checkbox" class="select-item" value="' + full.id + '" ' + isDisabled + '>';
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
                name: 'topik.nama_topik'
            },
            {
                data: 'biayaName',
                name: 'biayaName'
            },
            {
                data: 'status_sync',
                name: 'status_sync'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];

        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sync-info-diklat.index') }}",
                    data: function(d) {
                        d.checkboxAll = $('#select-all').prop('checked') ? 1 : 0;
                        d.tahun = $('select[name=tahun] option').filter(':selected').val();
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
                if (tahunSelected) params.set('tahun', tahunSelected);
                var newURL = "{{ route('sync-info-diklat.index') }}" + '?' + params.toString();
                history.replaceState(null, null, newURL);
            }

            $('#tahun').change(function() {
                table.draw();
                replaceURLParams()
            });

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
                $('#sync-selected').prop('disabled', selectedCount === 0);
            });

            // Handle Sync Data button click
            $('#sync-selected').on('click', function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin melakukan sinkronisasi data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Sinkronkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var selectedIds = $('.select-item:checked').map(function() {
                            return $(this).val();
                        }).get();

                        $.ajax({
                            url: "{{ route('sync-info-diklat.syncSelected') }}",
                            type: 'POST',
                            data: {
                                ids: selectedIds,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                $('#loading-overlay').show();
                            },
                            success: function(response) {
                                $('#loading-overlay').hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message
                                }).then(() => {
                                    $('#select-all').prop('checked', false)
                                        .trigger('change');
                                    table.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                $('#loading-overlay').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat sinkronisasi. Silakan coba lagi.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
