@extends('layouts.app')

@section('title', __('Create Pengusulan Pembelajaran'))
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
@endpush


@section('content')
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Transparan white background */
            z-index: 1000;
            text-align: center;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Pengusulan Pembelajaran ') . $is_bpkp . ' - ' . $frekuensi }}</h4>
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
                                        ]) }}">{{ __('Pengusulan Pembelajaran ') . $is_bpkp . ' - ' . $frekuensi }}</a>
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
                    'metode_pembelajaran', 'penyelenggara_pembelajaran', 'prioritas_pembelajaran',
                    'jenjang_pembelajaran', 'peserta_pembelajaran'
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


    {{-- get Kompetensi Dasar --}}
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
                                    '<strong>Kompetensi Dasar:</strong><br>' +
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


    <script>
        $(document).ready(function() {
            var i = 1;

            // Function to calculate the total allocated time in days, excluding Sundays
            function calculateAlokasiWaktu() {
                var totalDays = 0;

                $('#waktu_tempat_table tr').each(function() {
                    var tanggalMulai = $(this).find('input[name="tanggal_mulai[]"]').val();
                    var tanggalSelesai = $(this).find('input[name="tanggal_selesai[]"]').val();

                    if (tanggalMulai && tanggalSelesai) {
                        var startDate = new Date(tanggalMulai);
                        var endDate = new Date(tanggalSelesai);

                        if (endDate >= startDate) {
                            var currentDate = startDate;
                            while (currentDate <= endDate) {
                                if (currentDate.getDay() !== 0) { // Exclude Sundays
                                    totalDays++;
                                }
                                currentDate.setDate(currentDate.getDate() + 1);
                            }
                        } else {
                            alert('Tanggal Selesai harus lebih besar atau sama dengan Tanggal Mulai');
                            $(this).find('input[name="tanggal_selesai[]"]').val('');
                        }
                    }
                });

                $('#alokasi-waktu').val(totalDays);
            }

            // Function to update the minimum date for tanggal_selesai
            function updateTanggalSelesaiMinDate(tanggalMulaiInput) {
                var tanggalMulai = tanggalMulaiInput.val();
                var tanggalSelesaiInput = tanggalMulaiInput.closest('tr').find('input[name="tanggal_selesai[]"]');

                if (tanggalMulai) {
                    tanggalSelesaiInput.attr('min', tanggalMulai);
                } else {
                    tanggalSelesaiInput.removeAttr('min');
                }
            }

            // Event listener for dynamically added tanggal_mulai and tanggal_selesai inputs
            $(document).on('change', 'input[name="tanggal_mulai[]"], input[name="tanggal_selesai[]"]', function() {
                if ($(this).attr('name') === 'tanggal_mulai[]') {
                    updateTanggalSelesaiMinDate($(this));
                }
                calculateAlokasiWaktu();
            });

            $('#add_waktu_tempat').click(function() {
                i++;
                var newRow = '<tr id="row' + i + '">' +
                    '<td>' +
                    '<select name="tempat_acara[]" class="form-control" required>' +
                    '<option value="" selected disabled>-- Pilih --</option>' +
                    '@foreach ($lokasiData as $lokasi)' +
                    '<option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="date" name="tanggal_mulai[]" class="form-control tanggal_mulai" required /></td>' +
                    '<td><input type="date" name="tanggal_selesai[]" class="form-control tanggal_selesai" required /></td>' +
                    '<td><button type="button" name="remove" id="' + i +
                    '" class="btn btn-danger btn_remove">X</button></td>' +
                    '</tr>';
                $('#dynamic_field').append(newRow);
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                calculateAlokasiWaktu();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#pilihButton').prop('disabled', true);
            $('#pilihButtonKompetensi').prop('disabled', true);

            $('#jenis_program').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue !== '') {
                    $('#pilihButton').prop('disabled', false);
                } else {
                    $('#pilihButton').prop('disabled', true);
                }
            });

            $('#pilihButton').click(function() {
                var jenisProgram = $('#jenis_program').val();
                $('#loading-overlay').show();
                $.ajax({
                    url: '{{ route('getIndikator', ['jenisProgram' => ':jenisProgram']) }}'
                        .replace(':jenisProgram', jenisProgram),
                    type: 'GET',
                    success: function(response) {
                        var modalBody = $('#indikatorModal .modal-body');
                        modalBody.empty();

                        var table =
                            '<div class="table-responsive"><table class="table table-sm table-striped" style="font-size:14px"><thead><tr>';
                        var tableBody = '<tbody>';

                        if (jenisProgram === 'Renstra') {
                            table +=
                                '<th>Indikator</th><th>Satuan Target</th><th>Target</th><th>Realisasi TW1</th><th>Realisasi TW2</th><th>Realisasi TW3</th><th>Realisasi TW4</th><th>Persen Realisasi</th><th>Aksi</th></tr></thead>';
                            $.each(response.data, function(key, value) {
                                tableBody += '<tr>';
                                tableBody += '<td>' + value.indikator_kinerja + '</td>';
                                tableBody += '<td>' + value.satuan_target + '</td>';
                                tableBody += '<td>' + value.target + '</td>';
                                tableBody += '<td>' + value.realisasi_tw1 + '</td>';
                                tableBody += '<td>' + value.realisasi_tw2 + '</td>';
                                tableBody += '<td>' + value.realisasi_tw3 + '</td>';
                                tableBody += '<td>' + value.realisasi_tw4 + '</td>';
                                tableBody += '<td>' + value.persen_realisasi + '</td>';
                                tableBody +=
                                    '<td><button type="button" class="btn btn-primary pilihIndikator btn-sm" data-indikator="' +
                                    value.indikator_kinerja + '">Pilih</button></td>';
                                tableBody += '</tr>';
                            });
                        } else if (jenisProgram === 'APEP') {
                            table +=
                                '<th>Kategori</th><th>Nama Sektor</th><th>Nama Tema</th><th>Nama Topik</th><th>PJ APP</th><th>ID Unit PJ</th><th>Nama PJ APP</th><th>Unit Kontributor</th><th>TW APP</th><th>Tahun</th><th>Stat Nilai</th><th>Nilai T</th><th>Peran</th><th>Aksi</th></tr></thead>';
                            $.each(response.data, function(key, value) {
                                tableBody += '<tr>';
                                tableBody += '<td>' + value.kategori + '</td>';
                                tableBody += '<td>' + value.nama_sektor + '</td>';
                                tableBody += '<td>' + value.nama_tema + '</td>';
                                tableBody += '<td>' + value.nama_topik + '</td>';
                                tableBody += '<td>' + value.pj_app + '</td>';
                                tableBody += '<td>' + value.id_unit_pj + '</td>';
                                tableBody += '<td>' + value.nama_pj_app + '</td>';
                                tableBody += '<td>' + value.unit_kontributor + '</td>';
                                tableBody += '<td>' + value.tw_app + '</td>';
                                tableBody += '<td>' + value.tahun + '</td>';
                                tableBody += '<td>' + value.stat_nilai + '</td>';
                                tableBody += '<td>' + value.nilai_t + '</td>';
                                tableBody += '<td>' + value.peran + '</td>';
                                tableBody +=
                                    '<td><button type="button" class="btn btn-primary pilihIndikator btn-sm" data-topik="' +
                                    value.nama_topik + '">Pilih</button></td>';
                                tableBody += '</tr>';
                            });
                        } else {
                            $('#loading-overlay').hide();
                            alert('API belum fix. Data tidak dapat dimuat.');
                            return;
                        }

                        table += tableBody + '</tbody></table></div>';
                        modalBody.append(table);

                        $('#indikatorModal').modal('show');
                        $('#loading-overlay').hide();

                        $('.pilihIndikator').click(function() {
                            $('#pilihButtonKompetensi').prop('disabled', false);
                        });
                    },
                    error: function() {
                        $('#loading-overlay').hide();
                        alert('Terjadi kesalahan saat memuat data.');
                    }
                });
            });

            $('#pilihButtonKompetensi').click(function() {
                var indikator = $('#indikator_kinerja').val();
                $('#loading-overlay').show();
                $.ajax({
                    url: '{{ route('getKompetensiSupportIK') }}',
                    type: 'GET',
                    data: {
                        indikator: indikator
                    },
                    success: function(response) {
                        console.log(response);

                        var modalBody = $('#kompetensiModal .modal-body');
                        modalBody.empty();
                        var table =
                            '<div class="table-responsive"><table class="table table-sm table-striped" style="font-size:14px"><thead><tr>';
                        var tableBody = '<tbody>';
                        table +=
                            '<th>Kompetensi</th><th>Aksi</th></tr></thead>';
                        $.each(response.data, function(key, value) {
                            tableBody += '<tr>';
                            tableBody += '<td>' + value.nama_kompetensi + '</td>';
                            tableBody +=
                                '<td><button type="button" class="btn btn-primary pilihKompetensi btn-sm" data-kompetensi="' +
                                value.kompetensi + '">Pilih</button></td>';
                            tableBody += '</tr>';
                        });

                        table += tableBody + '</tbody></table></div>';
                        modalBody.append(table);

                        $('#kompetensiModal').modal('show');
                        $('#loading-overlay').hide();
                    },
                    error: function() {
                        $('#loading-overlay').hide();
                        alert('Terjadi kesalahan saat memuat data.');
                    }
                });
            });



            const options_temp = '<option value="" selected disabled>-- Select --</option>';
            $(document).on('click', '.pilihIndikator', function() {
                $('#kompetensi_id').html(options_temp);
                var indikator = $(this).data('indikator');
                $('#indikator_kinerja').val(indikator);
                $('#indikatorModal').modal('hide');
            });

            $('#kompetensi_id').change(function() {
                $('#topik_id').html(options_temp);
                if ($(this).val() != "") {
                    getDataTopikSupportKompetensi($(this).val());
                }
            })

            function getDataTopikSupportKompetensi(kompetensi_id) {
                $.ajax({
                    url: '{{ route('getTopikSupportKompetensi') }}',
                    type: 'GET',
                    data: {
                        kompetensi_id: kompetensi_id
                    },
                    beforeSend: function() {
                        $('#topik_id').prop('disabled', true);
                    },
                    success: function(res) {
                        const options = res.data.map(value => {
                            return `<option value="${value.topik_id}">${value.nama_topik}</option>`;
                        });
                        $('#topik_id').html(options_temp + options);
                        $('#topik_id').prop('disabled', false);
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat data topik.');
                    }
                });
            }
        });
    </script>
@endpush
1
