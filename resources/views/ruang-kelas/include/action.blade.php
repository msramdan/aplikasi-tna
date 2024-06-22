<td>
    @can('ruang kelas edit')
        <a href="{{ route('ruang-kelas.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('ruang kelas delete')
        <form action="{{ route('ruang-kelas.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('ruang-kelas\action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
