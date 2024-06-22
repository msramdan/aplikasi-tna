<td>
    @can('kota edit')
        <a href="{{ route('kota.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('kota delete')
        <form action="{{ route('kota.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('kota\delete.confirm') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
