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
        <table style="font-size:12px; padding:15px;line-height:17px">
            <tr>
                <td style="width: 200px; vertical-align: top;">{{ __('Kode Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->kode_pembelajaran }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Institusi Sumber') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->institusi_sumber }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Jenis Program') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->jenis_program }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Frekuensi pelaksanaan') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->frekuensi_pelaksanaan }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Indikator Kinerja') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->indikator_kinerja }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Kompetensi') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->nama_kompetensi }}
                    @if (isset($gap_kompetensi_pengajuan_kap))
                        <table style="width: 450px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="background-color: #f2f2f2; ; padding: 2px;text-align: center;">Total
                                        pegawai</th>
                                    <th style="background-color: #f2f2f2; ; padding: 2px;text-align: center;">Pegawai
                                        kompeten</th>
                                    <th style="background-color: #f2f2f2; ; padding: 2px;text-align: center;">Pegawai
                                        belum
                                        kompeten</th>
                                    <th style="background-color: #f2f2f2; ; padding: 2px;text-align: center;">Persentase
                                        kompetensi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: center">
                                        {{ $gap_kompetensi_pengajuan_kap->total_pegawai }}</td>
                                    <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: center">
                                        {{ $gap_kompetensi_pengajuan_kap->pegawai_kompeten }}
                                    </td>
                                    <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: center">
                                        {{ $gap_kompetensi_pengajuan_kap->pegawai_belum_kompeten }}
                                    </td>
                                    <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: center">
                                        {{ $gap_kompetensi_pengajuan_kap->persentase_kompetensi }}
                                        %</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Program pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->nama_topik }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Judul Program pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->judul }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Tujuan Program Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->tujuan_program_pembelajaran }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Indikator Keberhasilan') }}</td>
                <td style="vertical-align: top;">:</td>
                <td>
                    <table style="width: 450px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    #</th>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Peserta Mampu</th>
                            </tr>
                        </thead>
                        @foreach ($indikator_keberhasilan_kap as $item)
                            <tr>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $loop->index + 1 }}</td>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $item->indikator_keberhasilan }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Indikator Dampak Terhadap Kinerja Organisasi') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->indikator_dampak_terhadap_kinerja_organisasi }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Penugasan Yang Terkait Dengan Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="text-align: justify; vertical-align: top;">
                    {{ $pengajuanKap->penugasan_yang_terkait_dengan_pembelajaran }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Skill Group Owner') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="text-align: justify; vertical-align: top;">{{ $pengajuanKap->skill_group_owner }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Tanggal dibuat') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->tanggal_created }}</td>
            </tr>
        </table>

        <br>
        <strong>II. Detail Pembelajaran</strong>
        <table style="font-size:12px; padding:15px;line-height:17px">
            <tr>
                <td style="vertical-align: top;">{{ __('Lokasi') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->diklatLocName ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Tempat / Alamat Rinci') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->detail_lokasi ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Jumlah Kelas') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->kelas ?: '-' }} Kelas</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Bentuk Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->bentuk_pembelajaran ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Jalur Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->jalur_pembelajaran ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Model Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->model_pembelajaran ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Jenis Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->diklatTypeName ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Metode Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->metodeName ?: '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <table style="width: 450px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Pelaksanaan</th>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Tanggal Mulai</th>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Tanggal Selesai</th>
                            </tr>
                        </thead>
                        @foreach ($waktu_pelaksanaan as $row)
                            <tr>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $row->remarkMetodeName }}</td>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $row->tanggal_mulai }}</td>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $row->tanggal_selesai }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <br>
        <strong>III. Penyelenggaraan Pembelajaran</strong>
        <table style="font-size:12px; padding:15px;line-height:17px">
            <tr>
                <td style="width: 200px; vertical-align: top;">{{ __('Peserta Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->peserta_pembelajaran ?: '-' }}</td>
            </tr>
            <tr>
                <td style="width: 200px; vertical-align: top;">{{ __('Sasaran Peserta') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->sasaran_peserta ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Kriteria Peserta') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->kriteria_peserta ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Aktivitas Prapembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->aktivitas_prapembelajaran ?: '-' }}</td>
            </tr>

            <tr>
                <td style="vertical-align: top;">{{ __('Penyelenggara Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->penyelenggara_pembelajaran ?: '-' }}</td>
            </tr>
            @php
                $fasilitators = json_decode($pengajuanKap->fasilitator_pembelajaran);
            @endphp

            <tr>
                <td style="vertical-align: top;">{{ __('Fasilitator Pembelajaran') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    @if ($fasilitators !== null && !empty($fasilitators))
                        @foreach ($fasilitators as $item)
                            <span class="badge bg-primary" style="vertical-align: top;">{{ $item }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">-</span>
                    @endif

                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __('Sertifikat') }}</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ $pengajuanKap->sertifikat ?: '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">{{ __(' Level Evaluasi dan Instrumennya') }}</td>
                <td style="vertical-align: top;">:</td>
                <td>
                    <table style="width: 450px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Level</th>
                                <th style="background-color: #f2f2f2; ; padding: 2px;text-align: left;">
                                    Instrumen</th>
                            </tr>
                        </thead>
                        @foreach ($level_evaluasi_instrumen_kap as $item)
                            <tr>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $item->level ?: '-' }}</td>
                                <td style="padding: 2px; border-bottom: 1px solid #ddd;text-align: justify">
                                    {{ $item->keterangan ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <br>
        <strong>IV. History Review</strong>
        <table style="font-size:12px; padding:15px;line-height:17px; width:100%;border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #f2f2f2;width:15%;text-align:center">Remark</th>
                    <th style="background-color: #f2f2f2;width:45%;text-align:center">Catatan</th>
                    <th style="background-color: #f2f2f2;width:20%;text-align:center">User</th>
                    <th style="background-color: #f2f2f2;width:10%;text-align:center">Status</th>
                    <th style="background-color: #f2f2f2;width:10%;text-align:center">Tgl Review</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logReviews as $log)
                    <tr>
                        <td style=" border-bottom: 1px solid #ddd;text-align:center">
                            {{ $log->remark }}
                        </td>
                        <td style=" border-bottom: 1px solid #ddd;text-align:center">
                            <textarea rows="8" readonly>{{ $log->catatan }}</textarea>
                        </td>
                        <td style=" border-bottom: 1px solid #ddd;text-align:center">{{ $log->user_name ?? '-' }}</td>
                        <td style=" border-bottom: 1px solid #ddd;text-align:center">{{ $log->status }}</td>
                        <td style=" border-bottom: 1px solid #ddd;text-align:center">{{ $log->tanggal_review ?? '-' }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" style="border: 1px solid #ddd; text-align: center;">
                        Hasil cetak Kerangka Acuan Pembelajaran ini dibuat secara otomatis oleh sistem. Untuk detail
                        Kerangka Acuan Pembelajaran, silakan pindai kode QR.
                    </td>
                    <td colspan="3" style="border: 1px solid #ddd; text-align: center;">
                        <img loading="lazy" src="https://quickchart.io/qr?text=Here's my text">
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</body>

</html>
