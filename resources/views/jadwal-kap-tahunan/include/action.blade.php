<td>
    @can('jadwal kap tahunan edit')
        <a href="{{ route('jadwal-kap-tahunan.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('jadwal kap tahunan delete')
        <form action="{{ route('jadwal-kap-tahunan.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('jadwal-kap-tahunan/action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
