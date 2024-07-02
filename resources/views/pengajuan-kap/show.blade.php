@extends('layouts.app')

@section('title', __('Detail of Pengajuan Kaps'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Pengajuan Kaps') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('pengajuan-kap.index') }}">{{ __('Pengajuan Kaps') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('Detail') }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                            <td class="fw-bold">{{ __('Kode Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->kode_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Type Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->type_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Indikator Kinerja') }}</td>
                                            <td>{{ $pengajuanKap->indikator_kinerja }}</td>
                                        </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Kompetensi') }}</td>
                                        <td>{{ $pengajuanKap->kompetensi ? $pengajuanKap->kompetensi->id : '' }}</td>
                                    </tr>
									<tr>
                                        <td class="fw-bold">{{ __('Topik') }}</td>
                                        <td>{{ $pengajuanKap->topik ? $pengajuanKap->topik->id : '' }}</td>
                                    </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Concern Program Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->concern_program_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Alokasi Waktu') }}</td>
                                            <td>{{ $pengajuanKap->alokasi_waktu }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</td>
                                            <td>{{ $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Skill Group Owner') }}</td>
                                            <td>{{ $pengajuanKap->skill_group_owner }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Jalur Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->jalur_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Model Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->model_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Jenis Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->jenis_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Metode Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->metode_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Sasaran Peserta') }}</td>
                                            <td>{{ $pengajuanKap->sasaran_peserta }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Kriteria Peserta') }}</td>
                                            <td>{{ $pengajuanKap->kriteria_peserta }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Aktivitas Prapembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->aktivitas_prapembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Penyelenggara Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->penyelenggara_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Fasilitator Pembelajaran') }}</td>
                                            <td>{{ $pengajuanKap->fasilitator_pembelajaran }}</td>
                                        </tr>
									<tr>
                                            <td class="fw-bold">{{ __('Sertifikat') }}</td>
                                            <td>{{ $pengajuanKap->sertifikat }}</td>
                                        </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Created at') }}</td>
                                                <td>{{ $pengajuanKap->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('Updated at') }}</td>
                                                <td>{{ $pengajuanKap->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
@endsection
