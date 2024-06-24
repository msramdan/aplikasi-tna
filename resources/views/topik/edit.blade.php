@extends('layouts.app')

@section('title', __('topik/edit.edit_topik'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('topik/edit.pembelajaran') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('topik.index') }}">{{ __('topik/edit.pembelajaran') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('topik/edit.edit') }}
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
                            <form action="{{ route('topik.update', $topik->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('topik.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left-thin"></i> {{ __('topik/edit.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> {{ __('topik/edit.update') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
