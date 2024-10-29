<td>
    <button type="button" class="btn btn-info btn-sm btn-detail-tagging"
        data-indikator_kinerja="{{ $type == 'renstra' ? $model['indikator_kinerja'] : $model['nama_topik'] }}"
        data-type="{{ $type }}">
        <i class="mdi mdi-format-list-bulleted"></i>
    </button>

    @can('tagging kompetensi ik edit')
        <a href="{{ route('tagging-ik-kompetensi.setting', ['indikator_kinerja' => str_replace('/', '-', $type == 'renstra' ? $model['indikator_kinerja'] : $model['nama_topik']), 'type' => $type]) }}"
            class="btn btn-success btn-sm">
            <i class="fa fa-tag"></i>
        </a>
    @endcan

    @can('tagging kompetensi ik delete')
        <form
            action="{{ route('tagging-ik-kompetensi.destroy', ['indikator_kinerja' => str_replace('/', '-', $type == 'renstra' ? $model['indikator_kinerja'] : $model['nama_topik']), 'type' => $type]) }}"
            method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan
</td>
