<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xs">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="form-wakaf" enctype="multipart/form-data" method="POST">
                <div class="modal-header bg-gradient-info">
                    <h4 class="modal-title">Form Wakaf</h4>
                    <button type="button" class="close" id="modal-close-x" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="table table_modal">
                            <tr>
                                <td>No Register</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext register_no"
                                        name="register_no" required>
                                    <div class="invalid-feedback">Silakan masukkan nomor registrasi</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>
                                    <select class="form-control select2" name="city_id" id="city_id" required>
                                        <option value="">-- Pilih Kota --</option>
                                        @foreach ($city as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih kota</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>
                                    <select class="form-control select2" name="subdistrict_id" id="subdistrict_id">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($sub as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Desa</td>
                                <td>
                                    <select class="form-control select2" name="village_id" id="village_id">
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach ($village as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Luas Area</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm inputtext area_size"
                                        name="area_size" required min="0">
                                    <div class="invalid-feedback">Silakan masukkan luas area yang valid</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Penggunaan</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext used"
                                        name="used">
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Objek</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext object_name"
                                        name="object_name">
                                </td>
                            </tr>
                            <tr>
                                <td>No Sertifikat</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext certificate_no"
                                        name="certificate_no">
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Sertifikat</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext datepicker"
                                        id="certificate_date" name="certificate_date">
                                </td>
                            </tr>
                            <tr>
                                <td>No AIW</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext aiw_no"
                                        name="aiw_no">
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal AIW</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext datepicker"
                                        id="aiw_date" name="aiw_date">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        <button type="button" data-toggle="modal" data-target="#mapmodal"
                                            class="btn btn-primary">
                                            <i class="fa fa-map-marker"></i>
                                            Pilih Lokasi
                                        </button>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm inputtext address"
                                        name="address">
                                </td>
                            </tr>
                            <tr>
                                <td>Latitude</td>
                                <td>
                                    <input type="number" 
                                           class="form-control form-control-sm inputtext latitude"
                                           name="latitude"
                                           step="any"
                                           pattern="[0-9.-]+"
                                           onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46 || event.charCode === 45">
                                </td>
                            </tr>
                            <tr>
                                <td>Longitude</td>
                                <td>
                                    <input type="number" 
                                           class="form-control form-control-sm inputtext longitude"
                                           name="longitude"
                                           step="any"
                                           pattern="[0-9.-]+"
                                           onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46 || event.charCode === 45">
                                </td>
                            </tr>
                            <tr>
                                <td>Wakif</td>
                                <td>
                                    <input type="text" 
                                           class="form-control form-control-sm inputtext wakif_name" 
                                           name="wakif_name" 
                                           required>
                                    <div class="invalid-feedback">Silakan masukkan nama wakif</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nadzir</td>
                                <td>
                                    <input type="text" 
                                           class="form-control form-control-sm inputtext nadzir_name" 
                                           name="nadzir_name" 
                                           required>
                                    <div class="invalid-feedback">Silakan masukkan nama nadzir</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Foto</td>
                                <td>
                                    <input type="file" 
                                           class="form-control form-control-sm" 
                                           name="photos[]" 
                                           id="photos"
                                           multiple 
                                           accept="image/*">
                                    <small class="text-muted">Anda dapat memilih beberapa gambar</small>
                                    <div id="selected-files"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="simpan" type="button">Proses</button>
                        <button type="button" class="btn btn-warning" id="modal-close" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
