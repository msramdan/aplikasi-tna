@extends('layouts.app')

@section('title', __('Detail of Pengajuan Kap'))

@section('content')

    <style>
        .btn-gray {
            background-color: gray;
            color: white;
            border-color: gray;
        }
    </style>
    <style>
        #heading {
            text-transform: uppercase;
            color: #673AB7;
            font-weight: normal
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform input,
        #msform textarea {
            padding: 8px 15px 8px 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 25px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            background-color: #ECEFF1;
            font-size: 16px;
            letter-spacing: 1px
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #673AB7;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #673AB7;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #311B92
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #673AB7;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #673AB7;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #673AB7
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #673AB7
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #673AB7
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
    </style>


    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Pengajuan Kap') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('pengajuan-kap.index', [
                                        'is_bpkp' => $is_bpkp,
                                        'frekuensi' => $frekuensi,
                                    ]) }}">{{ __('Pengajuan Kap') }}</a>
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm">
                                    <tr>
                                        <td class="fw-bold">{{ __('Kode Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->kode_pembelajaran }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Institusi Sumber') }}</td>
                                        <td>{{ $pengajuanKap->institusi_sumber }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Jenis Progran') }}</td>
                                        <td>{{ $pengajuanKap->jenis_program }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('Frekuensi pelaksanaan') }}</td>
                                        <td>{{ $pengajuanKap->frekuensi_pelaksanaan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Indikator Kinerja') }}</td>
                                        <td>{{ $pengajuanKap->indikator_kinerja }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kompetensi') }}</td>
                                        <td>{{ $pengajuanKap->nama_kompetensi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Topik') }}</td>
                                        <td>{{ $pengajuanKap->nama_topik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Concern Program Pembelajaran') }}</td>
                                        <td>{{ $pengajuanKap->concern_program_pembelajaran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Alokasi Waktu') }}</td>
                                        <td>{{ $pengajuanKap->alokasi_waktu }} Hari</td>
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
                                        <td class="fw-bold">{{ __('Tanggal dibuat') }}</td>
                                        <td>{{ $pengajuanKap->tanggal_created }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status pengajuan') }}</td>
                                        <td>
                                            @if ($pengajuanKap->status_pengajuan == 'Pending')
                                                <button style="width:150px" class="btn btn-gray btn-sm btn-block">
                                                    <i class="fa fa-clock" aria-hidden="true"></i> Pending
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Approved')
                                                <button style="width:150px" class="btn btn-success btn-sm btn-block">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Approved
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Rejected')
                                                <button style="width:150px" class="btn btn-danger btn-sm btn-block">
                                                    <i class="fa fa-times" aria-hidden="true"></i> Rejected
                                                </button>
                                            @elseif ($pengajuanKap->status_pengajuan == 'Process')
                                                <button style="width:150px" class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-spinner" aria-hidden="true"></i> Process
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __('User created') }}</td>
                                        <td>{{ $pengajuanKap->user_name }}</td>
                                    </tr>

                                </table>
                            </div>

                            <a href="{{ route('pengajuan-kap.index', [
                                'is_bpkp' => $is_bpkp,
                                'frekuensi' => $frekuensi,
                            ]) }}"
                                class="btn btn-secondary">{{ __('Back') }}</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#approveModal">
                                Approved
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                Rejected
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <!-- Assuming this is in a Blade template file like resources/views/wizard.blade.php -->

                    <div class="card">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Account</strong></li>
                                <li id="personal"><strong>Personal</strong></li>
                                <li id="payment"><strong>Image</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div> <br> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Account Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 1 - 4</h2>
                                        </div>
                                    </div> <label class="fieldlabels">Email: *</label> <input type="email" name="email"
                                        placeholder="Email Id" /> <label class="fieldlabels">Username: *</label> <input
                                        type="text" name="uname" placeholder="UserName" /> <label
                                        class="fieldlabels">Password: *</label> <input type="password" name="pwd"
                                        placeholder="Password" /> <label class="fieldlabels">Confirm Password: *</label>
                                    <input type="password" name="cpwd" placeholder="Confirm Password" />
                                </div> <input type="button" name="next" class="next action-button" value="Next" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Personal Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 2 - 4</h2>
                                        </div>
                                    </div> <label class="fieldlabels">First Name: *</label> <input type="text"
                                        name="fname" placeholder="First Name" /> <label class="fieldlabels">Last Name:
                                        *</label> <input type="text" name="lname" placeholder="Last Name" /> <label
                                        class="fieldlabels">Contact No.: *</label> <input type="text" name="phno"
                                        placeholder="Contact No." /> <label class="fieldlabels">Alternate Contact No.:
                                        *</label> <input type="text" name="phno_2"
                                        placeholder="Alternate Contact No." />
                                </div> <input type="button" name="next" class="next action-button" value="Next" />
                                <input type="button" name="previous" class="previous action-button-previous"
                                    value="Previous" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Image Upload:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 3 - 4</h2>
                                        </div>
                                    </div> <label class="fieldlabels">Upload Your Photo:</label> <input type="file"
                                        name="pic" accept="image/*"> <label class="fieldlabels">Upload Signature
                                        Photo:</label> <input type="file" name="pic" accept="image/*">
                                </div> <input type="button" name="next" class="next action-button" value="Submit" />
                                <input type="button" name="previous" class="previous action-button-previous"
                                    value="Previous" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Finish:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 4 - 4</h2>
                                        </div>
                                    </div> <br><br>
                                    <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png"
                                                class="fit-image"> </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>

            <br>
            <br>
            <br>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">{{ __('Approve Pengajuan Kap') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengajuan-kap.approve', $pengajuanKap->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="approveNotes" class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control" id="approveNotes" name="approveNotes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">{{ __('Reject Pengajuan Kap') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengajuan-kap.reject', $pengajuanKap->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="rejectNotes" class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control" id="rejectNotes" name="rejectNotes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var current = 1;
            var steps = $("fieldset").length;
            setProgressBar(current);
            $(".next").click(function() {
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });
                setProgressBar(++current);
            });
            $(".previous").click(function() {
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();
                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
                //show the previous fieldset
                previous_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });
                setProgressBar(--current);
            });

            function setProgressBar(curStep) {
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                    .css("width", percent + "%")
            }
            $(".submit").click(function() {
                return false;
            })
        });
    </script>
@endpush
