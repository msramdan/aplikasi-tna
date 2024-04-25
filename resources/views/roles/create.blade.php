@extends('layouts.app')

@section('title', __('Create Role'))

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('utilities/rolepermission/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('roles.index') }}">{{ trans('utilities/rolepermission/index.head') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Create') }}
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
                            <form action="{{ route('roles.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('roles.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#hospital_id_select').change(function() {
                var selectedValue = $(this).val();

                // Jika pemilihan adalah opsi tertentu, sembunyikan div
                if (selectedValue !== 'user_mta') {
                    $('#Nomenklaturs').hide();
                    $('#Hospitals').hide();
                    $('#Provinces').hide();
                    $('#Kabkots').hide();
                    $('#Kecamatans').hide();
                    $('#Kelurahans').hide();
                    $('#setting').hide();
                } else {
                    $('#Nomenklaturs').show();
                    $('#Hospitals').show();
                    $('#Provinces').show();
                    $('#Kabkots').show();
                    $('#Kecamatans').show();
                    $('#Kelurahans').show();
                    $('#setting').show();
                }
            });
        });
    </script>
@endpush
