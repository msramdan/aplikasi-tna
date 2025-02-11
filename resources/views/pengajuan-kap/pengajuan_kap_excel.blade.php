<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3">No</th>
            <th style="background-color:#D3D3D3">Institusi</th>
            <th style="background-color:#D3D3D3">Jenis Program</th>
            <th style="background-color:#D3D3D3">Unit Pengusul</th>
            <th style="background-color:#D3D3D3">Nama Pengusul</th>
            <th style="background-color:#D3D3D3">Frekuensi pelaksanaan</th>
            <th style="background-color:#D3D3D3">Kode pembelajaran</th>
            <th style="background-color:#D3D3D3">Indikator Kinerja</th>
            <th style="background-color:#D3D3D3 ">Kompetensi</th>
            <th style="background-color:#D3D3D3">Program pembelajaran</th>
            <th style="background-color:#D3D3D3">Judul Program pembelajaran</th>
            <th style="background-color:#D3D3D3">Arahan pimpinan/isu terkini/dll</th>
            <th style="background-color:#D3D3D3">Prioritas Pembelajaran</th>
            <th style="background-color:#D3D3D3">Tujuan Program Pembelajaran</th>
            <th style="background-color:#D3D3D3">Indikator Dampak Terhadap Kinerja Organisasi</th>
            <th style="background-color:#D3D3D3">Penugasan Yang Terkait Dengan Pembelajaran</th>
            <th style="background-color:#D3D3D3">Skill Group Owner</th>
            <th style="background-color:#D3D3D3">Lokasi</th>
            <th style="background-color:#D3D3D3">Tempat / Alamat Rinci</th>
            <th style="background-color:#D3D3D3">Jumlah Kelas</th>
            <th style="background-color:#D3D3D3">Bentuk Pembelajaran</th>
            <th style="background-color:#D3D3D3">Jalur Pembelajaran</th>
            <th style="background-color:#D3D3D3">Model Pembelajaran</th>
            <th style="background-color:#D3D3D3">Jenis Pembelajaran</th>
            <th style="background-color:#D3D3D3">Sumber dana</th>
            <th style="background-color:#D3D3D3">Peserta Pembelajaran</th>
            <th style="background-color:#D3D3D3">Sasaran Peserta</th>
            <th style="background-color:#D3D3D3">Kriteria Peserta</th>
            <th style="background-color:#D3D3D3">Aktivitas Prapembelajaran</th>
            <th style="background-color:#D3D3D3">Penyelenggara Pembelajaran</th>
            <th style="background-color:#D3D3D3">Sertifikat</th>
            <th style="background-color:#D3D3D3">Current step</th>
            <th style="background-color:#D3D3D3">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->institusi_sumber }}</td>
                <td>{{ $row->jenis_program }}</td>
                <td>{{ $row->nama_unit }}</td>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->frekuensi_pelaksanaan }}</td>
                <td>{{ $row->kode_pembelajaran }}</td>
                <td>
                    <ul>
                        {!! $row->nama_indikator !!}
                    </ul>
                </td>
                <td>
                    <ul>
                        {!! $row->nama_kompetensi !!}
                    </ul>
                </td>
                <td>{{ $row->nama_topik }}</td>
                <td>{{ $row->judul }}</td>
                <td>{{ $row->arahan_pimpinan }}</td>
                <td>{{ $row->prioritas_pembelajaran }}</td>
                <td>{{ $row->tujuan_program_pembelajaran }}</td>
                <td>{{ $row->indikator_dampak_terhadap_kinerja_organisasi }}</td>
                <td>{{ $row->penugasan_yang_terkait_dengan_pembelajaran }}</td>
                <td>{{ $row->skill_group_owner }}</td>
                <td>{{ $row->diklatLocName }}</td>
                <td>{{ $row->detail_lokasi }}</td>
                <td>{{ $row->kelas }} Kelas</td>
                <td>{{ $row->bentuk_pembelajaran }}</td>
                <td>{{ $row->jalur_pembelajaran }}</td>
                <td>{{ $row->model_pembelajaran }}</td>
                <td>{{ $row->diklatTypeName }}</td>
                <td>{{ $row->biayaName }}</td>
                <td>{{ $row->peserta_pembelajaran }}</td>
                <td>{{ $row->sasaran_peserta }}</td>
                <td>{{ $row->kriteria_peserta }}</td>
                <td>{{ $row->aktivitas_prapembelajaran }}</td>
                <td>{{ $row->penyelenggara_pembelajaran }}</td>
                <td>{{ $row->sertifikat }}</td>
                <td>{{ $row->remark }}</td>
                <td>{{ $row->status_pengajuan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
