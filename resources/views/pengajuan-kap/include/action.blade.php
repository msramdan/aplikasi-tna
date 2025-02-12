<td>
    <div>
        @if (Auth::user()->kode_unit == $model->kode_unit && $model->prioritas_pembelajaran == null)
            <button title="Update Prioritas" class="btn btn-warning btn-sm btn-update-prioritas"
                data-id="{{ $model->id }}">
                <i class="fa fa-refresh"></i>
            </button>
        @endif

        <a title="Cetak Pengajuan KAP" target="_blank"
            href="{{ route('pengajuan-kap.pdf', [
                'id' => $model->id,
                'is_bpkp' => $model->institusi_sumber,
                'frekuensi' => $model->frekuensi_pelaksanaan,
            ]) }}"
            class="btn btn-gray btn-sm">
            <i class="fa fa-print"></i>
        </a>
        <a title="View Detail Pengajuan KAP"
            href="{{ route('pengajuan-kap.show', [
                'id' => $model->id,
                'is_bpkp' => $model->institusi_sumber,
                'frekuensi' => $model->frekuensi_pelaksanaan,
            ]) }}"
            class="btn btn-info btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>
        @can('pengajuan kap edit')
            @if (
                // $model->current_step < 5 &&
                    !in_array($model->status_pengajuan, ['Rejected', 'Approved']) &&
                    $model->user_created == Auth::id())
                <a title="Edit Pengajuan KAP"
                    href="{{ route('pengajuan-kap.edit', [
                        'id' => $model->id,
                        'is_bpkp' => $model->institusi_sumber,
                        'frekuensi' => $model->frekuensi_pelaksanaan,
                    ]) }}"
                    class="btn btn-success btn-sm">
                    <i class="mdi mdi-pencil"></i>
                </a>
            @else
                <a title="Edit Pengajuan KAP" href="javascript:void(0);" class="btn btn-success btn-sm disabled"
                    aria-disabled="true">
                    <i class="mdi mdi-pencil"></i>
                </a>
            @endif
        @endcan
        @if (Auth::user()->kode_unit == $model->kode_unit)
            <a title="Duplikat Pengajuan KAP"
                href="{{ route('pengajuan-kap.duplikat', [
                    'id' => $model->id,
                    'is_bpkp' => $model->institusi_sumber,
                    'frekuensi' => $model->frekuensi_pelaksanaan,
                ]) }}"
                class="btn btn-light btn-sm btn-duplikat">
                <i class="fa fa-copy"></i>
            </a>
        @endif
        @can('pengajuan kap delete')
            @if ($model->status_pengajuan == 'Pending' && Auth::id() == $model->user_created)
                <form id="delete-form-{{ $model->id }}"
                    action="{{ route('pengajuan-kap.destroy', [
                        'id' => $model->id,
                        'is_bpkp' => $model->institusi_sumber,
                        'frekuensi' => $model->frekuensi_pelaksanaan,
                    ]) }}"
                    method="POST" class="d-inline">
                    @csrf
                    @method('delete')

                    <button type="button" title="Delete Pengajuan KAP" class="btn btn-danger btn-sm btn-delete"
                        data-id="{{ $model->id }}">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </button>
                </form>
            @else
                <button title="Delete Pengajuan KAP" disabled class="btn btn-danger btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            @endif
        @endcan
    </div>
</td>
