<td>
    <div>
        <a href="{{ route('sync-info-diklat.pdf', [
            'id' => $model->id,
        ]) }}"
            class="btn btn-gray btn-sm">
            <i class="fa fa-print"></i>
        </a>

        <a href="{{ route('sync-info-diklat.show', [
            'id' => $model->id,
        ]) }}"
            class="btn btn-info btn-sm">
            <i class="mdi mdi-eye"></i>
        </a>
    </div>
</td>
