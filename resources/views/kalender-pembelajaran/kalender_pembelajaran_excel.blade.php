<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>
            <th style="background-color:#D3D3D3 ">Tanggal</th>
            <th style="background-color:#D3D3D3 ">Program pembelajaran</th>

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
