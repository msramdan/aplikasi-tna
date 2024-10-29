<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Nama pembelajaran') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->nama_topik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
