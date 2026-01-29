<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WakafLandImport;
use Illuminate\Support\Facades\Validator;
use App\WakafLand;
use App\Village;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ImportController extends Controller
{
    public function importExcel(Request $request)
    {
        // Ambil city_id dan subdistrict_id dari form
        $city_id = $request->input('city_id_import');
        $subdistrict_id = $request->input('subdistrict_id_import');

        if($request->hasFile('excelFile')) {
            $path = $request->file('excelFile')->getRealPath();
            
            // Membaca file Excel menggunakan PhpSpreadsheet
            $reader = new Xlsx();
            $spreadsheet = $reader->load($path);  // Memuat file Excel
            $sheet = $spreadsheet->getActiveSheet();  // Mendapatkan sheet aktif
            $data = $sheet->toArray();  // Mengkonversi sheet ke array

            if(!empty($data)) {
                foreach ($data as $key => $value) {
                    if ($key === 0) {
                        // Lewati baris pertama (header)
                        continue;
                    }

                    // Skip if row is empty
                    if (empty(array_filter($value))) {
                        continue;
                    }

                    // Ambil nama kelurahan dari kolom di Excel (sesuaikan indeks kolom jika perlu)
                    $villageName = strtolower(trim($value[1]));

                    // Cek apakah kelurahan sudah ada di tabel villages dengan subdistrict_id yang sesuai
                    $village = Village::whereRaw('LOWER(name) = ?', [$villageName])
                                    ->where('subdistrict_id', $subdistrict_id)
                                    ->first();

                    if (!$village) {
                        // Jika tidak ditemukan, tambahkan ke tabel villages dengan subdistrict_id
                        $village = new Village();
                        $village->name = $villageName;
                        $village->subdistrict_id = $subdistrict_id;
                        $village->save();
                    }

                    // Check if register_no exists
                    $wakafLand = WakafLand::where('register_no', $value[0])->first();
                    
                    if ($wakafLand) {
                        // Update existing record
                        $wakafLand->city_id = $city_id;
                        $wakafLand->subdistrict_id = $subdistrict_id;
                        $wakafLand->village_id = $village->id;
                        $wakafLand->area_size = $value[2];
                        $wakafLand->used = $value[3];
                        $wakafLand->object_name = $value[4];
                        $wakafLand->address = $value[5];
                        $wakafLand->status = $value[6];
                        $wakafLand->certificate_no = $value[7];
                        $wakafLand->certificate_date = $value[8];
                        $wakafLand->aiw_no = $value[9];
                        $wakafLand->aiw_date = $value[10];
                        $wakafLand->latitude = $value[11];
                        $wakafLand->longitude = $value[12];
                        $wakafLand->wakif_name = $value[13];
                        $wakafLand->nadzir_name = $value[14];
                        $wakafLand->save();
                    } else {
                        // Create new record
                        $wakafLand = new WakafLand();
                        $wakafLand->register_no = $value[0];
                        $wakafLand->city_id = $city_id;
                        $wakafLand->subdistrict_id = $subdistrict_id;
                        $wakafLand->village_id = $village->id;
                        $wakafLand->area_size = $value[2];
                        $wakafLand->used = $value[3];
                        $wakafLand->object_name = $value[4];
                        $wakafLand->address = $value[5];
                        $wakafLand->status = $value[6];
                        $wakafLand->certificate_no = $value[7];
                        $wakafLand->certificate_date = $value[8];
                        $wakafLand->aiw_no = $value[9];
                        $wakafLand->aiw_date = $value[10];
                        $wakafLand->latitude = $value[11];
                        $wakafLand->longitude = $value[12];
                        $wakafLand->wakif_name = $value[13];
                        $wakafLand->nadzir_name = $value[14];
                        $wakafLand->save();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
