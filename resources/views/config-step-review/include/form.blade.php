@push('css')
    <style>
        .placeholder-img {
            width: 50px;
            height: 50px;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            font-weight: bold;
            color: #555;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 50px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .select2-container .select2-search--inline .select2-search__field {
            width: auto !important;
        }

        table td {
            vertical-align: middle;
        }
    </style>
@endpush
<div class="row mb-2">
    <table class="table table-striped" id="data-table">
        <thead class="table-dark">
            <tr>
                <th style="width: 20%;text-align: center;">Step</th>
                <th style="width: 30%;text-align: center;">Remark</th>
                <th style="width: 50%;text-align: center;">User Reviewer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($steps as $index => $remark)
                <tr>
                    <td>
                        <center>
                            <div class="placeholder-img">{{ $index + 1 }}</div>
                        </center>
                    </td>
                    <td>
                        <center>{{ $remark }}</center>
                    </td>
                    <td>
                        <select class="form-control js-example-basic-multiple" name="reviewer_{{ $index + 1 }}[]" multiple="multiple">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    @if(isset($stepReviewers[$remark]) && in_array($user->id, $stepReviewers[$remark]))
                                        selected
                                    @endif
                                >{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
