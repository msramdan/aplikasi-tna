<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.no') }}</th>
            <th style="background-color:#D3D3D3 ">Kelompok besar</th>
            <th style="background-color:#D3D3D3 ">Kategori</th>
            <th style="background-color:#D3D3D3 ">Akademi</th>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.nama_kompetensi') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.deskripsi_kompetensi') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.level') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.deskripsi_level') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('kompetensi\kamus_kompetensi_excel.indikator_perilaku') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->nama_kelompok_besar }}</td>
            <td>{{ $row->nama_akademi }}</td>
            <td>{{ $row->nama_kategori_kompetensi }}</td>
            <td>{{ $row->nama_kompetensi }}</td>
            <td>{{ $row->deskripsi_kompetensi }}</td>
            <td>{{ $row->level }}</td>
            <td>{{ $row->deskripsi_level }}</td>
            <td>{{ $row->indikator_perilaku }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
