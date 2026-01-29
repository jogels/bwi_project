<!-- Modal Import -->
<div id="importModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header py-3 px-4">
                <h5 class="modal-title" id="importModalLabel">Import Excel Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <a href="{{ route('download.template') }}" class="w-100">
                        <button type="submit" class="btn btn-primary w-100">Download Template Excel</button>
                    </a>
                </div>

                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                    <div class="row mb-4 ml-1 mr-1">
                        <table class="table table_modal">
                            <tr>
                                <td class="py-3">Kabupaten / Kota</td>
                                <td class="py-3">
                                    <select class="form-control select2" name="city_id_import" id="city_id_import" required>
                                        <option value="">-- Pilih Kota --</option>
                                        @foreach ($city as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3">Kecamatan</td>
                                <td class="py-3">
                                    <select class="form-control" name="subdistrict_id_import" id="subdistrict_id_import" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group mb-4">
                        <label for="excelFile" class="mb-2">Upload Excel File</label>
                        <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
