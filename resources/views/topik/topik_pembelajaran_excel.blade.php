<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('topik/topik_pembelajaran_excel.no') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('topik/topik_pembelajaran_excel.pembelajaran') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->nama_topik }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
