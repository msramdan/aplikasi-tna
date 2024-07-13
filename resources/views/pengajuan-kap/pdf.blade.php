<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .header {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .header img {
            height: 55px;
            margin-right: 10px;
        }

        .header .text {
            display: inline-block;
            text-align: left;
        }

        .header .address {
            font-size: 12px;
        }

        .header .contact {
            font-size: 10px;
            font-style: italic;
        }

        .divider {
            border-top: 2px solid #000;
            /* Adjusted to make the underline thicker */
            margin-top: 5px;
            width: 100%;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .points {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <div class="header">
            <img src="https://static.wikia.nocookie.net/logopedia/images/6/60/Badan_Pengawasan_Keuangan_dan_Pembangunan.png/revision/latest/scale-to-width-down/1200?cb=20190907043126"
                alt="BPKP Logo">
            <div class="text">
                <center>
                    <strong>BADAN PENGAWASAN KEUANGAN DAN PEMBANGUNAN</strong><br>
                    <strong>PUSAT PENDIDIKAN DAN PELATIHAN PENGAWASAN</strong>
                    <div class="address">
                        Jalan Beringin II, Pandansari, Ciawi, Kabupaten Bogor 16720<br>
                        Telepon (0251) 824900-05, Faksimile (0251) 824986<br>
                        E-mail: pusdiklatwas@bpkp.go.id, Website: pusdiklatwas.bpkp.go.id
                    </div>
                </center>
            </div>
        </div>
        <div class="divider"></div>
        <div class="title"><u>KERANGKA ACUAN PEMBELAJARAN</u></div>
    </div>

    <!-- Points Section -->
    <div class="points">
        <strong>I. Konteks Pembelajaran</strong>
        <table class="table" style=" font-size:13px; padding:15px">
            <tr>
                <td style="width: 200px">{{ __('Kode Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->kode_pembelajaran }}</td>
            </tr>

            <tr>
                <td>{{ __('Institusi Sumber') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->institusi_sumber }}</td>
            </tr>

            <tr>
                <td>{{ __('Jenis Progran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->jenis_program }}</td>
            </tr>

            <tr>
                <td>{{ __('Frekuensi pelaksanaan') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->frekuensi_pelaksanaan }}</td>
            </tr>
            <tr>
                <td>{{ __('Indikator Kinerja') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->indikator_kinerja }}</td>
            </tr>
            <tr>
                <td>{{ __('Kompetensi') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->nama_kompetensi }}</td>
            </tr>
            <tr>
                <td>{{ __('Topik') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->nama_topik }}</td>
            </tr>

            <tr>
                <td>{{ __('Tujuan Program Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->tujuan_program_pembelajaran }}</td>
            </tr>
            <tr>
                <td>{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}
                </td>
                <td>:</td>
                <td>{{ $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi }}</td>
            </tr>
            <tr>
                <td>{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</td>
                <td>:</td>
                <td style="text-align: justify">{{ $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran }}</td>
            </tr>
            <tr>
                <td>{{ __('Skill Group Owner') }}</td>
                <td>:</td>
                <td style="text-align: justify">{{ $pengajuanKap->skill_group_owner }}</td>
            </tr>

            <tr>
                <td>{{ __('Tanggal dibuat') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->tanggal_created }}</td>
            </tr>
        </table>

        <br>
        <strong>II. Detail Pembelajaran</strong>
        <table class="table" style=" font-size:13px; padding:15px">
            <tr>
                <td style="width: 200px">{{ __('Alokasi Waktu') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->alokasi_waktu }} Hari</td>
            </tr>
            <tr>
                <td>{{ __('Bentuk Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->bentuk_pembelajaran }} Hari</td>
            </tr>
            <tr>
                <td>{{ __('Jalur Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->jalur_pembelajaran }} Hari</td>
            </tr>
            <tr>
                <td>{{ __('Model Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->model_pembelajaran }}</td>
            </tr>
            <tr>
                <td>{{ __('Jenis Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->jenis_pembelajaran }}</td>
            </tr>
            <tr>
                <td>{{ __('Metode Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->metode_pembelajaran }}</td>
            </tr>
        </table>

        <br>
        <strong>III. Penyelenggaraan Pembelajaran</strong>
        <table class="table" style=" font-size:13px; padding:15px">
            <tr>
                <td style="width: 200px">{{ __('Sasaran Peserta') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->sasaran_peserta }}</td>
            </tr>
            <tr>
                <td>{{ __('Kriteria Peserta') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->kriteria_peserta }}</td>
            </tr>
            <tr>
                <td>{{ __('Aktivitas Prapembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->aktivitas_prapembelajaran }}</td>
            </tr>

            <tr>
                <td>{{ __('Penyelenggara Pembelajaran') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->penyelenggara_pembelajaran }}</td>
            </tr>
            @php
                $fasilitators = json_decode($pengajuanKap->fasilitator_pembelajaran);
            @endphp

            <tr>
                <td>{{ __('Fasilitator Pembelajaran') }}</td>
                <td>:</td>
                <td>
                    @foreach ($fasilitators as $item)
                        <span class="badge bg-primary">{{ $item }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>{{ __('Sertifikat') }}</td>
                <td>:</td>
                <td>{{ $pengajuanKap->sertifikat }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
