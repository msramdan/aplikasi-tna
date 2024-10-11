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
                    'jenis_program', 'topik_id', 'bentuk_pembelajaran',
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
            $('#pilihButton').prop('disabled', false);
            $('#pilihButtonKompetensi').prop('disabled', false);
            $('#jenis_program').change(function() {
                $('#indikator_kinerja').val('');
                $('#kompetensi_id').val('');
                $('#kompetensi_text').val('');
                $('#total_pegawai').val('');
                $('#pegawai_kompeten').val('');
                $('#pegawai_belum_kompeten').val('');
                $('#persentase_kompetensi').val('');
                $('#topik_id').html(options_temp);
                $('#judul').val('');
                $('#pilihButtonKompetensi').prop('disabled', true);
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
                        if (response.data.length === 0) {
                            $('#loading-overlay').hide();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Tidak Ditemukan',
                                text: 'Tidak ada data yang ditemukan untuk Indikator Kinerja',
                            });
                            return;
                        }

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
                                    '<td><button type="button" class="btn btn-primary pilihIndikator btn-sm" data-indikator=\'' +
                                    value.indikator_kinerja + '\'>Pilih</button></td>';
                                tableBody += '</tr>';
                            });
                        } else if (jenisProgram === 'APP') {
                            table +=
                                '<th>Nama Sektor</th><th>Nama Tema</th><th>Nama Topik</th><th>Nama PJ APP</th><th>TW APP</th><th>Tahun</th><th>Stat Nilai</th><th>Nilai T</th><th>Aksi</th></tr></thead>';
                            $.each(response.data, function(key, value) {
                                tableBody += '<tr>';
                                tableBody += '<td>' + value.nama_sektor + '</td>';
                                tableBody += '<td>' + value.nama_tema + '</td>';
                                tableBody += '<td>' + value.nama_topik + '</td>';
                                tableBody += '<td>' + value.nama_pj_app + '</td>';
                                tableBody += '<td>' + value.tw_app + '</td>';
                                tableBody += '<td>' + value.tahun + '</td>';
                                tableBody += '<td>' + value.stat_nilai + '</td>';
                                tableBody += '<td>' + value.nilai_t + '</td>';
                                tableBody +=
                                    '<td><button type="button" class="btn btn-primary pilihIndikator btn-sm" data-indikator=\'' +
                                    value.nama_topik + '\'>Pilih</button></td>';
                                tableBody += '</tr>';
                            });

                        } else if (jenisProgram === 'APEP') {
                            table +=
                                '<th>Nama Sektor</th><th>Nama Tema</th><th>Nama Topik</th><th>Nama PJ APP</th><th>TW APP</th><th>Tahun</th><th>Stat Nilai</th><th>Nilai T</th><th>Aksi</th></tr></thead>';
                            $.each(response.data, function(key, value) {
                                tableBody += '<tr>';
                                tableBody += '<td>' + value.nama_sektor + '</td>';
                                tableBody += '<td>' + value.nama_tema + '</td>';
                                tableBody += '<td>' + value.nama_topik + '</td>';
                                tableBody += '<td>' + value.nama_pj_app + '</td>';
                                tableBody += '<td>' + value.tw_app + '</td>';
                                tableBody += '<td>' + value.tahun + '</td>';
                                tableBody += '<td>' + value.stat_nilai + '</td>';
                                tableBody += '<td>' + value.nilai_t + '</td>';
                                tableBody +=
                                    '<td><button type="button" class="btn btn-primary pilihIndikator btn-sm" data-indikator=\'' +
                                    value.nama_topik + '\'>Pilih</button></td>';
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
                console.log(indikator);

                $('#loading-overlay').show();
                $.ajax({
                    url: '{{ route('getKompetensiSupportIK') }}',
                    type: 'GET',
                    data: {
                        indikator: indikator
                    },
                    success: function(response) {
                        if (response.kompetensi_summary.length === 0) {
                            $('#loading-overlay').hide();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Tidak Ditemukan',
                                text: 'Tidak ada data yang ditemukan untuk Kompetensi',
                            });
                            return;
                        }

                        var modalBody = $('#kompetensiModal .modal-body');
                        modalBody.empty();
                        var table =
                            '<div class="table-responsive"><table class="table table-sm table-striped" style="font-size:14px"><thead><tr>';
                        var tableBody = '<tbody>';
                        var table =
                            '<div class="table-responsive"><table class="table table-sm table-striped" style="font-size:14px"><thead><tr>';
                        var tableBody = '<tbody>';

                        // Update table headers to include the new columns
                        table +=
                            '<th>Kompetensi</th><th>Total pegawai</th><th>Pegawai kompeten</th><th>Pegawai belum kompeten</th><th>Persentase kompetensi</th><th>Aksi</th></tr></thead>';

                        $.each(response.kompetensi_summary, function(key, value) {
                            tableBody += '<tr>';
                            tableBody += '<td>' + value.nama_kompetensi + '</td>';
                            tableBody += '<td>' + value.total_employees +
                                '</td>'; // Total Karyawan
                            tableBody += '<td>' + value.count_100 +
                                '</td>'; // Count 100%
                            tableBody += '<td>' + value.count_less_than_100 +
                                '</td>'; // Count < 100%
                            tableBody += '<td>' + value.average_persentase + '%</td>';
                            tableBody +=
                                '<td><button type="button" class="btn btn-primary pilihKompetensi btn-sm" ' +
                                'data-kompetensi="' + value.nama_kompetensi + '" ' +
                                'data-id="' + value.kompetensi_id + '" ' +
                                'data-total-employees="' + value.total_employees +
                                '" ' +
                                'data-count-100="' + value.count_100 + '" ' +
                                'data-count-less-than-100="' + value
                                .count_less_than_100 + '" ' +
                                'data-average-persentase="' + value.average_persentase +
                                '">' +
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

            $(document).on('click', '.pilihIndikator', function() {
                $('#kompetensi_id').html(options_temp);
                $('#kompetensi_id').val('');
                $('#kompetensi_text').val('');
                $('#total_pegawai').val('');
                $('#pegawai_kompeten').val('');
                $('#pegawai_belum_kompeten').val('');
                $('#persentase_kompetensi').val('');
                $('#topik_id').html(options_temp);
                $('#judul').val('');
                var indikator = $(this).data('indikator');
                $('#indikator_kinerja').val(indikator);
                console.log(indikator);

                $('#indikatorModal').modal('hide');
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
                console.log(namaTopik);
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
    </script>

    <!-- Add script for waktuPelaksanaanData -->
    <script>
        // Ambil data waktu_pelaksanaan dari controller
        var waktuPelaksanaanData = {!! $waktuPelaksanaanData !!};
    </script>

    <!-- Include your existing JavaScript for form handling -->
    <script>
        $(document).ready(function() {
            // Saat halaman pertama kali di-load, cek metodeID yang ada
            var metodeID = $('#metodeID').val(); // Ambil value dari metodeID yang disimpan di form
            handleMetodeFields(metodeID); // Jalankan fungsi untuk menampilkan fields sesuai metode yang ada

            // Event listener untuk handle change pada metodeID
            $('#metodeID').on('change', function() {
                var metodeID = $(this).val();
                handleMetodeFields(metodeID); // Panggil fungsi handleMetodeFields saat ada perubahan metode
            });

            // Fungsi untuk menampilkan dan mengisi field sesuai metode yang dipilih
            function handleMetodeFields(metodeID) {
                var pengajuanMetodeID = "{{ $pengajuanKap->metodeID }}";
                $('#additional_fields').show();
                $('#tatap_muka_fields').hide().find('input:not([name="remark_1"])').val('').removeAttr('required');
                $('#hybrid_fields').hide().find('input:not([name="remark_2"], [name="remark_3"])').val('')
                    .removeAttr('required');
                $('#elearning_fields').hide().find('input:not([name="remark_4"])').val('').removeAttr('required');
                if (metodeID == '1') {
                    $('#tatap_muka_fields').show().find(
                        'input[name="tatap_muka_start"], input[name="tatap_muka_end"]').attr('required', true);
                    if (waktuPelaksanaanData.length > 0 && pengajuanMetodeID == '1') {
                        $('input[name="tatap_muka_start"]').val(waktuPelaksanaanData[0].tanggal_mulai);
                        $('input[name="tatap_muka_end"]').val(waktuPelaksanaanData[0].tanggal_selesai);
                    }
                } else if (metodeID == '2') {
                    $('#hybrid_fields').show().find(
                        'input[name="hybrid_elearning_start"], input[name="hybrid_elearning_end"], input[name="hybrid_tatap_muka_start"], input[name="hybrid_tatap_muka_end"]'
                    ).attr('required', true);
                    if (waktuPelaksanaanData.length > 0 && pengajuanMetodeID == '2') {
                        $('input[name="hybrid_elearning_start"]').val(waktuPelaksanaanData[0].tanggal_mulai);
                        $('input[name="hybrid_elearning_end"]').val(waktuPelaksanaanData[0].tanggal_selesai);
                        $('input[name="hybrid_tatap_muka_start"]').val(waktuPelaksanaanData[1]?.tanggal_mulai ||
                            '');
                        $('input[name="hybrid_tatap_muka_end"]').val(waktuPelaksanaanData[1]?.tanggal_selesai ||
                            '');
                    }
                } else if (metodeID == '4') {
                    $('#elearning_fields').show().find(
                        'input[name="elearning_start"], input[name="elearning_end"]').attr('required', true);
                    if (waktuPelaksanaanData.length > 0 && pengajuanMetodeID == '4') {
                        $('input[name="elearning_start"]').val(waktuPelaksanaanData[0].tanggal_mulai);
                        $('input[name="elearning_end"]').val(waktuPelaksanaanData[0].tanggal_selesai);
                    }
                }
            }
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
@endpush
