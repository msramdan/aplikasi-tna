@extends('layouts.app')

@section('title', __('Edit Usulan Nomenklatur Pembelajaran'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title and Breadcrumb -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Usulan Nomenklatur Pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('nomenklatur-pembelajaran.index') }}">{{ __('Usulan Nomenklatur Pembelajaran') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <td class="fw-bold">{{ __('Rumpun Pembelajaran') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->rumpun_pembelajaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Nama Topik') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->nama_topik }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Status') }}</td>
                                    <td>
                                        @if ($nomenklaturPembelajaran->status == 'Pending')
                                            <button style="width:90px" class="btn btn-gray btn-sm btn-block">
                                                <i class="fa fa-clock" aria-hidden="true"></i> Pending
                                            </button>
                                        @elseif ($nomenklaturPembelajaran->status == 'Approved')
                                            <button style="width:90px" class="btn btn-success btn-sm btn-block">
                                                <i class="fa fa-check" aria-hidden="true"></i> Approved
                                            </button>
                                        @elseif ($nomenklaturPembelajaran->status == 'Rejected')
                                            <button style="width:90px" class="btn btn-danger btn-sm btn-block">
                                                <i class="fa fa-times" aria-hidden="true"></i> Rejected
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('User Pembuat') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->user_created_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Tanggal Pengajuan') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->tanggal_pengajuan }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Catatan User Created') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->catatan_user_created }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('User Review') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->user_review_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Tanggal Review') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->tanggal_review ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Catatan User Review') }}</td>
                                    <td>{{ $nomenklaturPembelajaran->catatan_user_review ?? '-' }}</td>
                                </tr>
                            </table>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <a href="{{ route('nomenklatur-pembelajaran.index') }}"
                                        class="btn btn-secondary">Back</a>
                                    @can('nomenklatur pembelajaran edit')
                                        @if ($nomenklaturPembelajaran->status == 'Pending')
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#approvalModal">Approved</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectionModal">Rejected</button>
                                        @else
                                            <button type="button" class="btn btn-success" disabled>Approved</button>
                                            <button type="button" class="btn btn-danger" disabled>Rejected</button>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('nomenklatur-pembelajaran.approve', $nomenklaturPembelajaran->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalModalLabel">Konfirmasi Persetujuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan_user_review">Catatan User</label>
                            <textarea name="catatan_user_review" id="catatan_user_review" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('nomenklatur-pembelajaran.reject', $nomenklaturPembelajaran->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Konfirmasi Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan_user_review">Catatan User</label>
                            <textarea name="catatan_user_review" id="catatan_user_review" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
