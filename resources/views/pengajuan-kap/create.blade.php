@extends('layouts.app')

@section('title', __('Create Pengajuan Kaps'))
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Pengajuan Kap ') . $is_bpkp . ' - ' . $frekuensi }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('pengajuan-kap.index', [
                                            'is_bpkp' => $is_bpkp,
                                            'frekuensi' => $frekuensi,
                                        ]) }}">{{ __('Pengajuan Kap ') . $is_bpkp . ' - ' . $frekuensi }}</a>
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
                        <div class="card-header">
                            <a href="{{ route('pengajuan-kap.index', [
                                'is_bpkp' => $is_bpkp,
                                'frekuensi' => $frekuensi,
                            ]) }}"
                                class="btn btn-secondary"><i class="mdi mdi-arrow-left-thin"></i>
                                {{ __('Back') }}</a>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @include('pengajuan-kap.include.form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('pengajuan-kap.store', ['is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}" id="form-laporan"
        method="POST" hidden enctype="multipart/form-data">
        @csrf
        @method('POST')
    </form>
@endsection

@push('js')
    <script src="https://techlaboratory.net/projects/demo/jquery-smart-wizard/v6/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
    </script>
    <script type="text/javascript">
        function onConfirm() {
            let form = document.getElementById('form-3');
            if (form) {
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    $('#smartwizard').smartWizard("setState", [2], 'error');
                    $("#smartwizard").smartWizard('fixHeight');
                    return false;
                }
                $('#form-laporan').html(''); // Pastikan form-laporan kosong sebelum menambahkan elemen baru

                var csrf = "{{ csrf_token() }}";
                $('#form-laporan').append(`<input type="hidden" name="_token" value="${csrf}"/>`);
                $('#form-laporan').append('@method('POST')'); // Spoofing metode PUT

                var forms = ['form-1', 'form-2', 'form-3'];
                forms.forEach(formId => {
                    var formElements = document.getElementById(formId).elements;
                    [...formElements].forEach(item => {
                        $('#form-laporan').append(item.cloneNode(true));
                    });
                });

                var inputFields = [
                    'jenis_program', 'kompetensi_id', 'topik_id', 'bentuk_pembelajaran',
                    'jalur_pembelajaran', 'model_pembelajaran', 'jenis_pembelajaran',
                    'metode_pembelajaran', 'penyelenggara_pembelajaran'
                ];

                inputFields.forEach(field => {
                    var fieldValue = $(`#${field}`).val();
                    $('#form-laporan').append(`<input type="hidden" name="${field}" value="${fieldValue}"/>`);
                });

                $('#form-laporan').submit();
            }
        }

        function closeModal() {
            // Reset wizard
            $('#smartwizard').smartWizard("reset");

            // Reset form
            document.getElementById("form-1").reset();
            document.getElementById("form-2").reset();
            document.getElementById("form-3").reset();
            myModal.hide();
        }

        $(function() {
            // Leave step event is used for validating the forms
            $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIdx, nextStepIdx,
                stepDirection) {
                // Validate only on forward movement
                if (stepDirection == 'forward') {
                    let form = document.getElementById('form-' + (currentStepIdx + 1));
                    if (form) {
                        if (!form.checkValidity()) {
                            form.classList.add('was-validated');
                            $('#smartwizard').smartWizard("setState", [currentStepIdx], 'error');
                            $("#smartwizard").smartWizard('fixHeight');
                            return false;
                        }
                        $('#smartwizard').smartWizard("unsetState", [currentStepIdx], 'error');
                    }
                }
            });

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
                $("#prev-btn").removeClass('disabled').prop('disabled', false);
                $("#next-btn").removeClass('disabled').prop('disabled', false);
                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled').prop('disabled', true);
                } else if (stepPosition === 'last') {
                    $("#next-btn").addClass('disabled').prop('disabled', true);
                } else {
                    $("#prev-btn").removeClass('disabled').prop('disabled', false);
                    $("#next-btn").removeClass('disabled').prop('disabled', false);
                }

                // Get step info from Smart Wizard
                let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
                $("#sw-current-step").text(stepInfo.currentStep + 1);
                $("#sw-total-step").text(stepInfo.totalSteps);

                if (stepPosition == 'last') {
                    $("#btnFinish").prop('disabled', false);
                } else {
                    $("#btnFinish").prop('disabled', true);
                }

                // Focus first name
                if (stepIndex == 1) {
                    setTimeout(() => {
                        $('#first-name').focus();
                    }, 0);
                }
            });

            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                // autoAdjustHeight: false,
                theme: 'arrows', // basic, arrows, square, round, dots
                transition: {
                    animation: 'none'
                },
                toolbar: {
                    showNextButton: true, // show/hide a Next button
                    showPreviousButton: true, // show/hide a Previous button
                    position: 'bottom', // none/ top/ both bottom
                    extraHtml: `<button class="btn btn-success" id="btnFinish" disabled onclick="onConfirm()">Submit</button>`
                },
                anchor: {
                    enableNavigation: true, // Enable/Disable anchor navigation
                    enableNavigationAlways: false, // Activates all anchors clickable always
                    enableDoneState: true, // Add done state on visited steps
                    markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    unDoneOnBackNavigation: true, // While navigate back, done state will be cleared
                    enableDoneStateNavigation: true // Enable/Disable the done state navigation
                },
            });

            $("#state_selector").on("change", function() {
                $('#smartwizard').smartWizard("setState", [$('#step_to_style').val()], $(this).val(), !$(
                    '#is_reset').prop("checked"));
                return true;
            });

            $("#style_selector").on("change", function() {
                $('#smartwizard').smartWizard("setStyle", [$('#step_to_style').val()], $(this).val(), !$(
                    '#is_reset').prop("checked"));
                return true;
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            function checkInputs() {
                let allEmpty = true;

                $('input[name="keterangan[]"]').each(function() {
                    if ($(this).val() !== '') {
                        allEmpty = false;
                        return false; // Break out of the loop
                    }
                });

                if (allEmpty) {
                    $('input[name="keterangan[]"]').attr('required', 'required');
                } else {
                    $('input[name="keterangan[]"]').removeAttr('required');
                }
            }

            $('input[name="keterangan[]"]').on('input', function() {
                checkInputs();
            });

            checkInputs(); // Initial check on page load
        });
    </script>
@endpush
