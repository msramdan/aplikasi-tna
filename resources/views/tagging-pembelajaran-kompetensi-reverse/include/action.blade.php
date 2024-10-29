<td>
    <button type="button" class="btn btn-info btn-sm btn-detail-tagging" data-id="{{ $model->id }}"
        data-kompetensi="{{ $model->nama_kompetensi }}"><i class="mdi mdi-format-list-bulleted"></i></button>
    @can('tagging pembelajaran kompetensi edit')
        <a href="{{ route('tagging-kompetensi-pembelajaran.setting', $model->id) }}" class="btn btn-success btn-sm">
            <i class="fa fa-tag"></i>
        </a>
    @endcan

    @can('tagging pembelajaran kompetensi delete')
        <form action="{{ route('tagging-kompetensi-pembelajaran.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('tagging-kompetensi-pembelajaran/include.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
