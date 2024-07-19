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
            <tr>

                <td>
                    <center>
                        <div class="placeholder-img">1</div>
                    </center>
                </td>
                <td>
                    <center>
                        Tim Unit Pengelola Pembelajaran
                    </center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_1[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <div class="placeholder-img">2</div>
                    </center>
                </td>
                <td>
                    <center>
                        Keuangan
                    </center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_2[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <div class="placeholder-img">3</div>
                    </center>
                </td>
                <td>
                    <center>
                        Penjaminan Mutu
                    </center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_3[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <div class="placeholder-img">4</div>
                    </center>
                </td>
                <td>
                    <center>
                        Subkoordinator
                    </center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_4[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <div class="placeholder-img">5</div>
                    </center>
                </td>
                <td>
                    <center>Koordinator</center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_5[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <div class="placeholder-img">6</div>
                    </center>
                </td>
                <td>
                    <center>Kepala Unit Pengelola Pembelajaran</center>
                </td>
                <td>
                    <select class="form-control js-example-basic-multiple" name="reviewer_6[]" multiple="multiple">
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                        <option value="4">User 4</option>
                        <option value="5">User 5</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>
