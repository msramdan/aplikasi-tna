<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('tagging-pembelajaran-kompetensi/tagging_pembelajaran_kompetensi_excel.no') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('tagging-pembelajaran-kompetensi/tagging_pembelajaran_kompetensi_excel.learning') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('tagging-pembelajaran-kompetensi/tagging_pembelajaran_kompetensi_excel.competency') }}</th>
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
