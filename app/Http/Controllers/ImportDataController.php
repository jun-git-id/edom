<?php

namespace App\Http\Controllers;

use App\Imports\DosenImport;
use App\Imports\MatKulImport;
use App\Imports\MhsImport;
use App\Imports\MhsNonaktifImport;
use App\Imports\PengajaranImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function matkulStoreData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new MatKulImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function dosenStoreData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new DosenImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function mhsStoreData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new MhsImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function mhsNonaktifStoreData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new MhsNonaktifImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function pengajaranStoreData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);


        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new PengajaranImport($request->tahun_akademik_id), $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
