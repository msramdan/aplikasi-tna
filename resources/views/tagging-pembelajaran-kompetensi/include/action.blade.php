<td>
    <button type="button" class="btn btn-info btn-sm btn-detail-kompetensi" data-id="{{ $model->id }}"
        data-nama_kompetensi="" data-deskripsi_kompetensi=""><i class="mdi mdi-format-list-bulleted"></i></button>
    @can('tagging pembelajaran kompetensi edit')
        <a href="{{ route('tagging-pembelajaran-kompetensi.setting', $model->id) }}" class="btn btn-success btn-sm">
            <i class="fa fa-tag"></i>
        </a>
    @endcan

    @can('tagging pembelajaran kompetensi delete')
        <form action="{{ route('tagging-pembelajaran-kompetensi.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
