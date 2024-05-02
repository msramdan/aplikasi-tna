@extends('layouts.app')

@section('title', __('Edit kompetensi'))

@section('content')


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('kompetensi') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('kompetensi.index') }}">{{ __('kompetensi') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <form action="{{ route('kompetensi.update', $kompetensi->id) }}" method="POST">
                @csrf
                @method('PUT')
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
                                            <th style="width: 10px">Level</th>
                                            <th>Deskripsi level</th>
                                            <th>Indikator perilaku</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kompetensiDetail as $index => $detail)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}
                                                    <input type="hidden" name="kompetensi_detail_id[]"
                                                        value="{{ $detail->id }}" readonly>
                                                    <input type="hidden" name="level[]" value="{{ $detail->level }}"
                                                        readonly>
                                                </th>
                                                <td><input type="text" class="form-control" name="deskripsi_level[]"
                                                        value="{{ $detail->deskripsi_level }}" required></td>
                                                <td><input type="text" class="form-control" name="indikator_perilaku[]"
                                                        value="{{ $detail->indikator_perilaku }}" required></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i>
                    {{ __('Back') }}</a>
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                    {{ __('Update') }}</button>
            </form>
        </div>
    </div>
@endsection
