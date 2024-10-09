<td>
    <div>
        <a href="{{ route('pengajuan-kap.pdf', [
            'id' => $model->id,
            'is_bpkp' => $model->institusi_sumber,
            'frekuensi' => $model->frekuensi_pelaksanaan,
        ]) }}"
            class="btn btn-gray btn-sm">
            <i class="fa fa-print"></i>
        </a>

        <a href="{{ route('pengajuan-kap.show', [
            'id' => $model->id,
            'is_bpkp' => $model->institusi_sumber,
            'frekuensi' => $model->frekuensi_pelaksanaan,
        ]) }}"
            class="btn btn-info btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>

        @if ($model->status_pengajuan == 'Pending')
            @can('pengajuan kap edit')
                <a href="{{ route('pengajuan-kap.edit', [
                    'id' => $model->id,
                    'is_bpkp' => $model->institusi_sumber,
                    'frekuensi' => $model->frekuensi_pelaksanaan,
                ]) }}"
                    class="btn btn-success btn-sm">
                    <i class="mdi mdi-pencil"></i>
                </a>
            @endcan
            @can('pengajuan kap delete')
                <form
                    action="{{ route('pengajuan-kap.destroy', [
                        'id' => $model->id,
                        'is_bpkp' => $model->institusi_sumber,
                        'frekuensi' => $model->frekuensi_pelaksanaan,
                    ]) }}"
                    method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this record?')">
                    @csrf
                    @method('delete')

                    <button class="btn btn-danger btn-sm">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </button>
                </form>
            @endcan
        @else
            {{-- @can('pengajuan kap edit')
                <button disabled class="btn btn-success btn-sm">
                    <i class="mdi mdi-pencil"></i>
                </button>
            @endcan --}}
            @can('pengajuan kap delete')
                <button disabled class="btn btn-danger btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            @endcan
        @endif
    </div>
</td>
