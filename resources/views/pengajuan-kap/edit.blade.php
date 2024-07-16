@extends('layouts.app')

@section('title', __('Edit Pengusulan Pembelajaran'))
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
                        <h4 class="mb-sm-0">{{ __('Pengusulan Pembelajaran') }}</h4>
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
                                        ]) }}">{{ __('Pengusulan Pembelajaran') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
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

    <form
        action="{{ route('pengajuan-kap.update', ['id' => $pengajuanKap->id, 'is_bpkp' => $is_bpkp, 'frekuensi' => $frekuensi]) }}"
        id="form-laporan" method="POST" hidden enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                $('#form-laporan').append('@method('PUT')'); // Spoofing metode PUT

                var forms = ['form-1', 'form-2', 'form-3'];
                forms.forEach(formId => {
                    var formElements = document.getElementById(formId).elements;
                    [...formElements].forEach(item => {
                        $('#form-laporan').append(item.cloneNode(true));
                    });
                });

                $('select[name^="tempat_acara"]').each(function(index, element) {
                    var selectedValue = $(element).val();
                    if (selectedValue !== null && selectedValue !== '') {
                        $('#form-laporan').append(
                            `<input type="hidden" name="${$(element).attr('name')}" value="${selectedValue}"/>`
                        );
                    }
                });

                var inputFields = [
                    'jenis_program', 'kompetensi_id', 'topik_id', 'bentuk_pembelajaran',
                    'jalur_pembelajaran', 'model_pembelajaran', 'jenis_pembelajaran',
                    'metode_pembelajaran', 'penyelenggara_pembelajaran', 'prioritas_pembelajaran'
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

                $('input[name="indikator_keberhasilan[]"]').each(function() {
                    if ($(this).val() !== '') {
                        allEmpty = false;
                        return false; // Break out of the loop
                    }
                });

                if (allEmpty) {
                    $('input[name="indikator_keberhasilan[]"]').attr('required', 'required');
                } else {
                    $('input[name="indikator_keberhasilan[]"]').removeAttr('required');
                }
            }

            $('input[name="indikator_keberhasilan[]"]').on('input', function() {
                checkInputs();
            });

            checkInputs(); // Initial check on page load
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            function checkCheckboxes() {
                let anyChecked = $('input[name="fasilitator_pembelajaran[]"]:checked').length > 0;

                if (anyChecked) {
                    $('input[name="fasilitator_pembelajaran[]"]').removeAttr('required');
                    $('#invalid-fasilitator').hide();
                } else {
                    $('input[name="fasilitator_pembelajaran[]"]').attr('required', 'required');
                    if ($('input[name="fasilitator_pembelajaran[]"]').is(':focus')) {
                        $('#invalid-fasilitator').show();
                    }
                }
            }

            $('input[name="fasilitator_pembelajaran[]"]').on('change', function() {
                checkCheckboxes();
            });

            // Remove required attribute on load to ensure the message is not displayed initially
            $('input[name="fasilitator_pembelajaran[]"]').removeAttr('required');

            // Initial check to handle pre-checked checkboxes
            checkCheckboxes();
        });
    </script>

    <script>
        $(document).ready(function() {
            function checkInputInstrumen() {
                let allEmptyInstrumen = true;

                $('input[name="level_evaluasi_instrumen[]"]').each(function() {
                    if ($(this).val() !== '') {
                        allEmptyInstrumen = false;
                        return false; // Break out of the loop
                    }
                });

                if (allEmptyInstrumen) {
                    $('input[name="level_evaluasi_instrumen[]"]').attr('required', 'required');
                } else {
                    $('input[name="level_evaluasi_instrumen[]"]').removeAttr('required');
                }
            }

            $('input[name="level_evaluasi_instrumen[]"]').on('input', function() {
                checkInputInstrumen();
            });

            checkInputInstrumen();
        });
    </script> --}}

    <script>
        $(document).on('click', '.btn_remove_data', function() {
            var bid = this.id;
            console.log(bid)
            var trid = $(this).closest('tr').attr('id');
            $('#' + trid + '').remove();
        });
    </script>

    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_waktu_tempat').click(function() {
                i++;
                var newRow = '<tr id="row' + i + '">' +
                    '<td>' +
                    '<select name="tempat_acara[]" class="form-control">' +
                    '<option value="" selected disabled>-- Pilih --</option>' +
                    '@foreach ($lokasiData as $lokasi)' +
                    '<option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="date" name="tanggal_mulai[]" class="form-control" /></td>' +
                    '<td><input type="date" name="tanggal_selesai[]" class="form-control" /></td>' +
                    '<td><button type="button" name="remove" id="' + i +
                    '" class="btn btn-danger btn_remove">X</button></td>' +
                    '</tr>';
                $('#dynamic_field').append(newRow);
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
    {{-- get Kompetensi Dasari --}}
    <script>
        $(document).ready(function() {
            $('#kompetensi_id').on('change', function() {
                var kompetensiId = $(this).val();
                if (kompetensiId) {
                    // Show spinner
                    $('#kompetensi-description').html(
                        '<div class="spinner-border text-primary" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div>'
                    );

                    $.ajax({
                        url: '/getKompetensiById/' + kompetensiId,
                        type: 'GET',
                        success: function(data) {
                            if (data.error) {
                                $('#kompetensi-description').html(
                                    '<div class="alert alert-danger mt-2" role="alert">' +
                                    data.error + '</div>');
                            } else {
                                $('#kompetensi-description').html(
                                    '<div class="alert alert-primary mt-2" role="alert">' +
                                    '<strong>Kompetensi Dasari:</strong><br>' +
                                    '<div style="text-align: justify">' + data
                                    .deskripsi_kompetensi + '</div>' +
                                    '</div>'
                                );
                            }
                        },
                        error: function() {
                            $('#kompetensi-description').html(
                                '<div class="alert alert-danger mt-2" role="alert">Error fetching data.</div>'
                            );
                        }
                    });
                } else {
                    $('#kompetensi-description').empty();
                }
            });
        });
    </script>
@endpush
