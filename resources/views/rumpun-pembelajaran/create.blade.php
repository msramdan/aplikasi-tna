@extends('layouts.app')

@section('title', __('Create Rumpun Pembelajaran'))

@section('content')
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ __('Rumpun Pembelajaran') }}</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('rumpun-pembelajaran.index') }}">{{ __('Rumpun Pembelajaran') }}</a>
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
                            <form action="{{ route('rumpun-pembelajaran.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('rumpun-pembelajaran.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Kembali') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> {{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
