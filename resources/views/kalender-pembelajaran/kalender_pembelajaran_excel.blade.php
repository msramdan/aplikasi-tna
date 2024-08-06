<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">No</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
