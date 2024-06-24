<td>
    @can('role & permission edit')
        <a href="{{ route('roles.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('role & permission delete')
        <form action="{{ route('roles.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('roles/action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
