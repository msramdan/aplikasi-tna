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
                                class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                {{ __('Kembali') }}</a>
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
                            @include('pengajuan-kap.include.form-apip')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
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
                    'topik_id', 'bentuk_pembelajaran',
                    'jalur_pembelajaran', 'model_pembelajaran', 'diklatLocID',
                    'metodeID', 'penyelenggara_pembelajaran', 'prioritas_pembelajaran', 'diklatLocID', 'diklatTypeID',
                    'peserta_pembelajaran'
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
    <script>
        $(document).ready(function() {
            const options_temp = '<option value="" selected disabled>-- Select --</option>';
            $('#pilihButtonKompetensi').prop('disabled', false);

            // get data kompetensi APIP yg 6 itu
            $('#pilihButtonKompetensi').click(function() {
                $('#loading-overlay').show();
                $.ajax({
                    url: '{{ route('getKompetensiApip') }}',
                    type: 'GET',
                    data: {},
                    success: function(response) {
                        var modalBody = $('#kompetensiModal .modal-body');
                        modalBody.empty();

                        var table =
                            '<div class="table-responsive"><table class="table table-sm table-striped" style="font-size:14px"><thead><tr>';
                        var tableBody = '<tbody>';

                        // Update table headers to include the new columns
                        table +=
                            '<th>Kompetensi</th><th>Target</th><th>Capaian</th><th>Aksi</th></tr></thead>';

                        // Assuming 'response.data' contains the kompetensi data from the API
                        $.each(response.data, function(key, value) {
                            tableBody += '<tr>';
                            tableBody += '<td>' + value.nama_kompetensi +
                                '</td>'; // Nama Kompetensi
                            tableBody += '<td>' + (value.target !== null ? value
                                .target : 'N/A') + '</td>'; // Target
                            tableBody += '<td>' + (value.capaian !== null ? value
                                .capaian : 'N/A') + '</td>'; // Capaian
                            tableBody +=
                                '<td><button type="button" class="btn btn-primary pilihKompetensi btn-sm" ' +
                                'data-kompetensi="' + value.nama_kompetensi + '" ' +
                                'data-id="' + value.id_kompetensi + '" ' +
                                'data-target="' + (value.target !== null ? value
                                    .target : 'N/A') + '" ' +
                                'data-capaian="' + (value.capaian !== null ? value
                                    .capaian : 'N/A') + '">' +
                                'Pilih</button></td>';
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

            $(document).on('click', '.pilihKompetensi', function() {
                $('#topik_id').html(options_temp);
                $('#judul').val('');
                var kompetensi = $(this).data('kompetensi');
                var kompetensi_id = $(this).data('id');
                var total_employees = $(this).data('total-employees');
                var count_100 = $(this).data('count-100');
                var count_less_than_100 = $(this).data('count-less-than-100');
                var average_persentase = $(this).data('average-persentase');
                getDataTopikSupportKompetensi(kompetensi_id);
                $('#kompetensi_text').val(kompetensi);
                $('#kompetensi_id').val(kompetensi_id);
                $('#total_pegawai').val(total_employees);
                $('#pegawai_kompeten').val(count_100);
                $('#pegawai_belum_kompeten').val(count_less_than_100);
                $('#persentase_kompetensi').val(average_persentase);
                $('#kompetensiModal').modal('hide');
            });

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
                            return `<option value="${value.topik_id}" data-nama-topik="${value.nama_topik}">${value.nama_topik}</option>`;
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

        $(document).ready(function() {
            $('#topik_id').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const namaTopik = selectedOption.data('nama-topik');

                if (namaTopik) {
                    $('#judul').val(namaTopik);
                } else {
                    $('#judul').val('');
                }
            });
        });
    </script>

    {{-- auto fill name  --}}
    <script>
        $(document).ready(function() {
            function updateDiklatTypeName() {
                var selectedOption = $('#diklatTypeID option:selected');
                var diklatTypeName = selectedOption.data('diklattypename');
                $('#diklatTypeName').val(diklatTypeName);
            }
            $('#diklatTypeID').on('change', function() {
                updateDiklatTypeName();
            });
            updateDiklatTypeName();
        });
        $(document).ready(function() {
            function updateDiklatLocName() {
                var selectedOption = $('#diklatLocID option:selected');
                var diklatLocName = selectedOption.data('diklatlocname');
                $('#diklatLocName').val(diklatLocName);
            }
            $('#diklatLocID').on('change', function() {
                updateDiklatLocName();
            });
            updateDiklatLocName();
        });
        $(document).ready(function() {
            function updateMetodeName() {
                var selectedOption = $('#metodeID option:selected');
                var metodeName = selectedOption.data('metode-name');
                $('#metodeName').val(metodeName);
            }
            $('#metodeID').on('change', function() {
                updateMetodeName();
            });
            updateMetodeName();
        });

        $(document).ready(function() {
            $('#metodeID').on('change', function() {
                var value = $(this).val();
                $('#additional_fields').show();

                // Reset values and hide fields, except for remark_1, remark_2, and remark_3
                $('#tatap_muka_fields').hide().find('input:not([name="remark_1"])').val('').removeAttr(
                    'required');
                $('#hybrid_fields').hide().find('input:not([name="remark_2"], [name="remark_3"])').val('')
                    .removeAttr('required');
                $('#elearning_fields').hide().find('input:not([name="remark_4"])').val('').removeAttr(
                    'required');

                // Show relevant fields and set required attribute
                if (value == '1') {
                    $('#tatap_muka_fields').show().find(
                        'input[name="tatap_muka_start"], input[name="tatap_muka_end"]').attr('required',
                        true);
                } else if (value == '2') {
                    $('#hybrid_fields').show().find(
                        'input[name="hybrid_elearning_start"], input[name="hybrid_elearning_end"], input[name="hybrid_tatap_muka_start"], input[name="hybrid_tatap_muka_end"]'
                    ).attr('required', true);
                } else if (value == '4') {
                    $('#elearning_fields').show().find(
                        'input[name="elearning_start"], input[name="elearning_end"]').attr('required',
                        true);
                }
            });
        });
    </script>


    {{-- Usulan program pembelajaran --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Ketika modal ditampilkan
            $('#usulanModal').on('shown.bs.modal', function() {
                // Memuat data dropdown saat modal ditampilkan
                $.ajax({
                    url: '{{ route('getRumpunPembelajaran') }}',
                    type: 'GET',
                    success: function(data) {
                        const select = $('#rumpunPembelajaran');
                        select.empty(); // Kosongkan dropdown
                        select.append(
                            '<option value="" disabled selected>-- Pilih --</option>'
                        );
                        data.forEach(function(item) {
                            select.append(
                                `<option value="${item.id}">${item.rumpun_pembelajaran}</option>`
                            );
                        });
                        validateForm(); // Validasi saat modal ditampilkan
                    },
                    error: function(xhr) {
                        console.error('Error loading rumpun pembelajaran:', xhr.responseText);
                    }
                });

                validateForm(); // Validasi saat modal ditampilkan
            });

            // Fungsi untuk memvalidasi form
            function validateForm() {
                const form = $('#usulanForm');
                const rumpunPembelajaranSelect = $('#rumpunPembelajaran');
                const namaTopikInput = $('#namaTopik');
                const catatanUserCreatedTextarea = $('#catatanUserCreated');
                const kirimUsulanButton = $('#kirimUsulan');

                // Ambil data dari form
                const rumpunPembelajaranSelected = rumpunPembelajaranSelect.val();
                const namaTopikFilled = namaTopikInput.val().trim() !== '';
                const catatanUserCreatedFilled = catatanUserCreatedTextarea.val().trim() !== '';

                // Periksa setiap field untuk memastikan semua field terisi
                if (rumpunPembelajaranSelected && namaTopikFilled && catatanUserCreatedFilled) {
                    kirimUsulanButton.prop('disabled', false);
                } else {
                    kirimUsulanButton.prop('disabled', true);
                }
            }

            // Tangani perubahan pada input field untuk validasi live
            $('#usulanForm').on('input change', function() {
                validateForm();
            });

            // Tangani klik tombol Kirim Usulan
            $('#kirimUsulan').on('click', function() {
                if ($(this).is(':disabled')) {
                    // Jika tombol dinonaktifkan, tidak lakukan apa-apa
                    return;
                }

                const form = $('#usulanForm');

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Tanggapan sukses dengan SweetAlert
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Usulan berhasil dikirim!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Refresh halaman setelah konfirmasi
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Tangani error dengan SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengirim usulan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    {{-- Disable selec tahun --}}
    <script>
        $(document).ready(function() {
            var tahun = {{ $tahun }}; // Ambil tahun dari controller

            // Fungsi untuk set batas tanggal
            function setDateLimits(fieldName, year) {
                // Set batas min dan max berdasarkan tahun
                var startDate = year + "-01-01"; // Awal tahun
                var endDate = year + "-12-31"; // Akhir tahun

                // Set batas min dan max untuk input date
                $('input[name="' + fieldName + '"]').attr('min', startDate);
                $('input[name="' + fieldName + '"]').attr('max', endDate);
            }

            // Panggil fungsi setDateLimits untuk setiap field input tanggal
            setDateLimits('tatap_muka_start', tahun);
            setDateLimits('tatap_muka_end', tahun);
            setDateLimits('hybrid_elearning_start', tahun);
            setDateLimits('hybrid_elearning_end', tahun);
            setDateLimits('hybrid_tatap_muka_start', tahun);
            setDateLimits('hybrid_tatap_muka_end', tahun);
            setDateLimits('elearning_start', tahun);
            setDateLimits('elearning_end', tahun);

            // Menambahkan logika tambahan jika ada interaksi lain
        });
    </script>
@endpush
