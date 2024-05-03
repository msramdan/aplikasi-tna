<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>
            <th style="background-color:#D3D3D3 ">Nama kompetensi</th>
            <th style="background-color:#D3D3D3 ">Deksripsi kompetensi</th>
            <th style="background-color:#D3D3D3 ">Level</th>
            <th style="background-color:#D3D3D3 ">Deskripsi level</th>
            <th style="background-color:#D3D3D3 ">Indikator perilaku</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->nama_kompetensi }}</td>
            <td>{{ $row->deskripsi_kompetensi }}</td>
            <td>{{ $row->level }}</td>
            <td>{{ $row->deskripsi_level }}</td>
            <td>{{ $row->indikator_perilaku }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
