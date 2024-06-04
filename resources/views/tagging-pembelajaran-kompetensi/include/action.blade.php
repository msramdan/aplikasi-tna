<td>
    @can('tagging pembelajaran kompetensi edit')
        <a href="{{ route('tagging-pembelajaran-kompetensi.edit', $model->id) }}" class="btn btn-secondary btn-sm">
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
