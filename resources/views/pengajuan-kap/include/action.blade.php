<td>
    <div>
        <a target="_blank"
            href="{{ route('pengajuan-kap.pdf', [
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

        @can('pengajuan kap edit')
            @if ($model->current_step < 5 && !in_array($model->status_pengajuan, ['Rejected', 'Approved']))
                <a href="{{ route('pengajuan-kap.edit', [
                    'id' => $model->id,
                    'is_bpkp' => $model->institusi_sumber,
                    'frekuensi' => $model->frekuensi_pelaksanaan,
                ]) }}"
                    class="btn btn-success btn-sm">
                    <i class="mdi mdi-pencil"></i>
                </a>
            @else
                <a href="javascript:void(0);" class="btn btn-success btn-sm disabled" aria-disabled="true">
                    <i class="mdi mdi-pencil"></i>
                </a>
            @endif
        @endcan


        @if ($model->status_pengajuan == 'Pending')
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
            @can('pengajuan kap delete')
                <button disabled class="btn btn-danger btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            @endcan
        @endif
    </div>
</td>
