<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>
            <th style="background-color:#D3D3D3 ">Kode pembelajaran</th>
            <th style="background-color:#D3D3D3 ">Unit Kerja</th>
            <th style="background-color:#D3D3D3 ">Kompetensi</th>
            <th style="background-color:#D3D3D3 ">Program pembelajaran</th>
            <th style="background-color:#D3D3D3 ">Sumber dana</th>
            <th style="background-color:#D3D3D3 ">Prioritas</th>
            <th style="background-color:#D3D3D3 ">Jumlah Kelas</th>
            <th style="background-color:#D3D3D3 ">Current step</th>
            <th style="background-color:#D3D3D3 ">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->kode_pembelajaran }}</td>
                <td>{{ $row->nama_unit }}</td>
                <td>{{ $row->nama_kompetensi }}</td>
                <td>{{ $row->nama_topik }}</td>
                <td>{{ $row->biayaName }}</td>
                <td>{{ $row->prioritas_pembelajaran }}</td>
                <td>{{ $row->kelas }}</td>
                <td>{{ $row->remark }}</td>
                <td>{{ $row->status_pengajuan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
