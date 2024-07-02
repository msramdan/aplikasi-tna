<td>
    {{-- <a href="#" class="btn btn-light btn-sm" >
        <i class="fa fa-print"></i>
    </a>

    <button type="button" class="btn btn-info btn-sm btn-detail-kompetensi"
    data-id="{{ $model->id }}"
    ><i class="mdi mdi-eye"></i></button> --}}

    {{-- @can('pengajuan kap edit')
        <a href="{{ route('pengajuan-kap.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('pengajuan kap delete')
        <form action="{{ route('pengajuan-kap.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan --}}
</td>
