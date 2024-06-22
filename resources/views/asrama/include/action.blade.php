<td>
    @can('asrama edit')
        <a href="{{ route('asrama.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('asrama delete')
        <form action="{{ route('asrama.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('asrama\action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
