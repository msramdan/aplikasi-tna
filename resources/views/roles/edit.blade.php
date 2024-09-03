@extends('layouts.app')

@section('title', __('roles/edit.Edit Role'))

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('roles/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">{{ __('roles/edit.Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('roles.index') }}">{{ trans('roles/index.head') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('roles/edit.Edit') }}
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
                            <form action="{{ route('roles.update', $role->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('roles.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('roles/edit.Back') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('roles/edit.Update') }}</button>
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
            // Jika pemilihan adalah opsi tertentu, sembunyikan div
            @if (isset($role) && $role->hospital_id)
                $('#Nomenklaturs').hide();
                $('#Hospitals').hide();
                $('#Provinces').hide();
                $('#Kabkots').hide();
                $('#Kecamatans').hide();
                $('#Kelurahans').hide();
                $('#setting').hide();
            @else
                $('#Nomenklaturs').show();
                $('#Hospitals').show();
                $('#Provinces').show();
                $('#Kabkots').show();
                $('#Kecamatans').show();
                $('#Kelurahans').show();
                $('#setting').show();
            @endif
            $('#hospital_id_select').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue !== 'user_mta') {
                    $('#Nomenklaturs').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#Hospitals').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#Provinces').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#Kabkots').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#Kecamatans').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#Kelurahans').hide().find(':checkbox')
                        .prop('checked', false);
                    $('#setting').hide().find(':checkbox')
                        .prop('checked', false);
                } else {
                    $('#Nomenklaturs').show().find(':checkbox')
                        .prop('checked', true);
                    $('#Hospitals').show().find(':checkbox')
                        .prop('checked', true);
                    $('#Provinces').show().find(':checkbox')
                        .prop('checked', true);
                    $('#Kabkots').show().find(':checkbox')
                        .prop('checked', true);
                    $('#Kecamatans').show().find(':checkbox')
                        .prop('checked', true);
                    $('#Kelurahans').show().find(':checkbox')
                        .prop('checked', true);
                    $('#setting').show().find(':checkbox')
                        .prop('checked', true);
                }
            });
        });
    </script>
@endpush
