@extends('layouts.app')

@section('title', __('setting-apps/edit.title'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Config step review</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('setting-apps/edit.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="{{ route('config-step-review.index') }}">Config step review</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('config-step-review.update', $settingApp->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('config-step-review.include.form')
                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>Update</button>
                            </form>
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
