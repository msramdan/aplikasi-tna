<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>
            <th style="background-color:#D3D3D3 ">Kode pembelajaran</th>
            <th style="background-color:#D3D3D3 ">Bentuk</th>
            <th style="background-color:#D3D3D3 ">Jalur</th>
            <th style="background-color:#D3D3D3 ">Model</th>
            <th style="background-color:#D3D3D3 ">Jenis</th>
            <th style="background-color:#D3D3D3 ">Metode</th>
            <th style="background-color:#D3D3D3 ">Kompetensi</th>
            <th style="background-color:#D3D3D3 ">Judul</th>
            <th style="background-color:#D3D3D3 ">Jadwal</th>
            <th style="background-color:#D3D3D3 ">Lokasi</th>
            <th style="background-color:#D3D3D3 ">Penyelenggara</th>
            <th style="background-color:#D3D3D3 ">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->start }} - {{ $row->end }}</td>
                <td>{{ $row->nama_topik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
