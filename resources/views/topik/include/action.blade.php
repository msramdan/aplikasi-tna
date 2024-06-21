<td>
    @can('topik edit')
        <a href="{{ route('topik.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('topik delete')
        <form action="{{ route('topik.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('topik\action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
