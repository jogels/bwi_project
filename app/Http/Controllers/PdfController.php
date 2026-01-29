<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function show($type)
    {
       try {
        $pdfFiles = [
            'undang-undang-wakaf' => 'pdf/Undang-undang-No.-41-2004-Tentang-Wakaf.pdf',
            'peraturan-pemerintah' => 'pdf/Peraturan-mentri-agama.pdf',
            'peraturan-bwi' => 'pdf/Peraturan-BWI-No.-01-Th-2020-.pdf',
            'peraturan-mentri-agama' => 'pdf/Buku-Undang-Undang-Wakaf-.pdf',
        ];


        // Dapatkan URL file PDF
        $pdfUrl = 'assets/'.$pdfFiles[$type];

        return view('pdf_view', compact('pdfUrl'));
       } catch (\Exception $e) {
        return abort(404);
       }
    }
}
