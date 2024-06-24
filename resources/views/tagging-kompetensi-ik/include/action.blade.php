<td>
    <button type="button" class="btn btn-info btn-sm btn-detail-tagging" data-id="{{ $model->id }}"
        data-nama_kompetensi="{{ $model->nama_kompetensi }}"><i class="mdi mdi-format-list-bulleted"></i></button>
    @can('tagging kompetensi ik edit')
        <a href="{{ route('tagging-kompetensi-ik.setting', ['id' => $model->id, 'type' => request()->segment(2)]) }}"
            class="btn btn-success btn-sm">
            <i class="fa fa-tag"></i>
        </a>
    @endcan
    @can('tagging kompetensi ik delete')
        <form action="{{ route('tagging-kompetensi-ik.destroy', ['id' => $model->id, 'type' => request()->segment(2)]) }}"
            method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
