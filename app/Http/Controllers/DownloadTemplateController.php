<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class DownloadTemplateController extends Controller
{
    public function index() {
        $filePath = storage_path('app/public/excel/template.xlsx');
    
        // Pastikan file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Kirim file ke pengguna
        return Response::download($filePath, 'template.xlsx');
    }
}