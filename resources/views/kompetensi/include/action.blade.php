<td>
    <button type="button" class="btn btn-info btn-sm btn-detail-kompetensi"
    data-id="{{ $model->id }}"
    data-nama_kelompok_besar="{{ $model->nama_kelompok_besar }}"
    data-nama_kategori_kompetensi="{{ $model->nama_kategori_kompetensi }}"
    data-nama_akademi="{{ $model->nama_akademi }}"
    data-nama_kompetensi="{{ $model->nama_kompetensi }}"
    data-deskripsi_kompetensi="{{ $model->deskripsi_kompetensi }}"
    ><i class="mdi mdi-eye"></i></button>

    {{-- @can('kompetensi edit')
        <a href="{{ route('kompetensi.edit', $model->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-pencil"></i>
        </a>
    @endcan

    @can('kompetensi delete')
        <form action="{{ route('kompetensi.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('{{ __('kompetensi.action.confirm_delete') }}')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-sm">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </form>
    @endcan --}}
</td>
