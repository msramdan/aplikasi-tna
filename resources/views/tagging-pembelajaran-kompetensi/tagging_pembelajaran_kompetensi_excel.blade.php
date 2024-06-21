<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>
            <th style="background-color:#D3D3D3 ">Pembelajaran</th>
            <th style="background-color:#D3D3D3 ">Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->nama_topik }}</td>
            <td>{{ $row->nama_kompetensi }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
