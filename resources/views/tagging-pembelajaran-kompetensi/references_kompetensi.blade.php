<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Nama kompetensi') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->nama_kompetensi }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
