<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">Rumpun pembelajaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->rumpun_pembelajaran }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
