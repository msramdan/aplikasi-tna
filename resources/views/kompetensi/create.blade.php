@extends('layouts.app')

@section('title', __('Create kompetensi'))

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
                                    {{ __('Create') }}
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
                                            <th style="width: 10px">Level</th>
                                            <th>Deskripsi level</th>
                                            <th>Indikator perilaku</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1
                                                <input type="hidden" name="level_1" value="1" readonly>
                                            </th>
                                            <td><input type="text" class="form-control" name="deskripsi_level_1" required></td>
                                            <td><input type="text" class="form-control" name="indikator_perilaku_1" required></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2
                                                <input type="hidden" name="level_2" value="2" readonly>
                                            </th>
                                            <td><input type="text" class="form-control" name="deskripsi_level_2" required></td>
                                            <td><input type="text" class="form-control" name="indikator_perilaku_2" required></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3
                                                <input type="hidden" name="level_3" value="3" readonly>
                                            </th>
                                            <td><input type="text" class="form-control" name="deskripsi_level_3" required></td>
                                            <td><input type="text" class="form-control" name="indikator_perilaku_3" required></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4
                                                <input type="hidden" name="level_4" value="4" readonly>
                                            </th>
                                            <td><input type="text" class="form-control" name="deskripsi_level_4" required></td>
                                            <td><input type="text" class="form-control" name="indikator_perilaku_4" required></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5
                                                <input type="hidden" name="level_5" value="5" readonly>
                                            </th>
                                            <td><input type="text" class="form-control" name="deskripsi_level_5" required></td>
                                            <td><input type="text" class="form-control" name="indikator_perilaku_5" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i>
                    {{ __('Back') }}</a>
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                    {{ __('Save') }}</button>
            </form>
        </div>
    </div>
@endsection
