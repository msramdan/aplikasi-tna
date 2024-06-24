@extends('layouts.app')

@section('title', __('tagging-pembelajaran-kompetensi/edit.title'))

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('tagging-pembelajaran-kompetensi/edit.heading') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('tagging-pembelajaran-kompetensi.index') }}">{{ __('tagging-pembelajaran-kompetensi/edit.heading') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('tagging-pembelajaran-kompetensi/edit.edit') }}
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
                            <div class="alert alert-primary" role="alert">
                                <b>{{ __('tagging-pembelajaran-kompetensi/edit.learning') }} :</b><br>
                                {{ $topik->nama_topik }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('tagging-pembelajaran-kompetensi.update', ['id' => $topik->id]) }}"
                                onsubmit="selectAllAssigned()">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" id="search-available" class="form-control mb-2"
                                            placeholder="{{ __('tagging-pembelajaran-kompetensi/edit.search_available') }}">
                                        <select id="available" class="form-control" multiple size="20">
                                            @foreach ($availableItems as $id => $nama_kompetensi)
                                                <option value="{{ $id }}">{{ $nama_kompetensi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex flex-column justify-content-center align-items-center">
                                        <button type="button" onclick="moveToAssigned()"
                                            class="btn btn-success mb-2">>></button>
                                        <button type="button" onclick="moveToAvailable()" class="btn btn-danger">
                                            << </button>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="search-assigned"
                                            class="form-control mb-2 @error('message') is-invalid @enderror"
                                            placeholder="{{ __('tagging-pembelajaran-kompetensi/edit.search_assigned') }}">
                                        <select id="assigned" class="form-control @error('message') is-invalid @enderror"
                                            multiple size="20" name="assigned[]">
                                            @foreach ($assignedItems as $id => $nama_kompetensi)
                                                <option value="{{ $id }}">{{ $nama_kompetensi }}</option>
                                            @endforeach
                                        </select>
                                        @error('message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('tagging-pembelajaran-kompetensi.index') }}"
                                        class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left-thin"></i> {{ __('tagging-pembelajaran-kompetensi/edit.back') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save"></i> {{ __('tagging-pembelajaran-kompetensi/edit.update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAllAssigned() {
            const assigned = document.getElementById('assigned');
            for (let i = 0; i < assigned.options.length; i++) {
                assigned.options[i].selected = true;
            }
        }

        function moveToAssigned() {
            const available = document.getElementById('available');
            const assigned = document.getElementById('assigned');
            const selectedOptions = Array.from(available.selectedOptions);
            selectedOptions.forEach(option => {
                assigned.appendChild(option);
            });
        }

        function moveToAvailable() {
            const available = document.getElementById('available');
            const assigned = document.getElementById('assigned');
            const selectedOptions = Array.from(assigned.selectedOptions);
            selectedOptions.forEach(option => {
                available.appendChild(option);
            });
        }

        // Optional: Add search functionality
        document.getElementById('search-available').addEventListener('input', function() {
            filterList('available', this.value);
        });

        document.getElementById('search-assigned').addEventListener('input', function() {
            filterList('assigned', this.value);
        });

        function filterList(listId, query) {
            const list = document.getElementById(listId);
            const options = list.options;
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.text.toLowerCase().includes(query.toLowerCase())) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
        }
    </script>
@endsection
