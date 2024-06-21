@extends('layouts.app')

@section('title', __('kompetensi\create.create_kompetensi'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('kompetensi\create.kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('kompetensi.index') }}">{{ __('kompetensi\create.kompetensi') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('kompetensi\create.create') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('kompetensi.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @include('kompetensi.include.form')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">{{ __('kompetensi\create.level') }}</th>
                                            <th>{{ __('kompetensi\create.deskripsi_level') }}</th>
                                            <th>{{ __('kompetensi\create.indikator_perilaku') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <tr>
                                                <th scope="row">{{ $i }}
                                                    <input type="hidden" name="level[]" value="{{ $i }}" readonly>
                                                </th>
                                                <td><input type="text" class="form-control" name="deskripsi_level[]" required></td>
                                                <td><input type="text" class="form-control" name="indikator_perilaku[]" required></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i>
                    {{ __('kompetensi\create.back') }}</a>
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                    {{ __('kompetensi\create.save') }}</button>
            </form>
        </div>
    </div>
@endsection
