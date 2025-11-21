<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\dosenModel;
use App\Models\pengelompokanModel;
use App\Models\projectModel;
use Illuminate\Http\Request;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $status_project = projectModel::where('nip', session('nip'))->first();
        return view('dashboard.dosen.dashboard',compact('status_project'));
    }
    public function formPengajuanProject(Request $request)
    {
        $nip = $request->session()->get('nip');
        $data_diri = dosenModel::where('nip', $nip)->first();
        $data_pengelompokan = pengelompokanModel::where('nip',$nip)->first();

        return view('dashboard.dosen.form_pengajuan_project', compact('data_diri','data_pengelompokan'));
    }

    public function penilaianLogbook(){
       return view('dashboard.dosen.penilaian_logbook');
    }
}
