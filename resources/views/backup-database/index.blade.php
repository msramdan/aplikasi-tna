@extends('layouts.app')

@section('title', __('Backup database'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Backup database</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('setting-apps/edit.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('backup.index') }}">Backup database</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="col-md-12" style="padding:20px;">
                            <div class="panel box-v3">
                                <div class="panel-body">
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert"
                                        id="alert-box" style="display: none;">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <p>Berhasil mencadangkan database</p>
                                    </div>
                                    <center>
                                        <a href="{{ route('backup.download') }}" class="btn btn-primary btn-raised btn-lg"
                                            onclick="alert()"><i class="fa fa-download"></i> Backup Database</a>
                                    </center>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-styles')
    <style>
        .select2-container .select2-selection--multiple .select2-selection__choice {
            color: #000 !important;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        function alert() {
            $("#alert-box").css({
                "display": "block"
            });
        }
    </script>
@endpush
