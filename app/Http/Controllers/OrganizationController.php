<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    // Menampilkan halaman Struktur Organisasi
    public function showStructure()
    {
        return view('organization.structure');
    }
}
