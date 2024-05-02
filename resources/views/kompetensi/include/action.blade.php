<td>
    <a href="" class="btn btn-info btn-sm" title="Detail Kompetensi">
        <i class="mdi mdi-format-list-bulleted"></i>
    </a>

    @can('kompetensi edit')
        <a href="{{ route('kompetensi.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('kompetensi delete')
        <form action="{{ route('kompetensi.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
