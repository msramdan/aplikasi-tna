<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Indikator kinerja') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($type === 'renstra')
            @foreach ($data as $dt)
                <tr>
                    <td>{{ $dt['indikator_kinerja'] }}</td>
                </tr>
            @endforeach
        @elseif ($type === 'app' || $type === 'apep')
            @foreach ($data as $dt)
                <tr>
                    <td>{{ $dt['nama_topik'] }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
