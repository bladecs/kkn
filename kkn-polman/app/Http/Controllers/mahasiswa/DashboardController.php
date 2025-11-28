<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\pendaftaranKkn;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $session = $request->session()->get('id');
        $data = Mahasiswa::where('id', $session)->first();
        $status_pendaftaran = pendaftaranKkn::where('nim', $data->nim)->first();

        return view('dashboard.mahasiswa.dashboard', compact('session', 'status_pendaftaran'));
    }

    public function dataAkademik(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_akademik = pendaftaranKkn::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.data_akademik', compact('data_akademik'));
    }

    public function dataDiri(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_diri = User::where('nim', $nim)->first();
        $data_pendaftaran = pendaftaranKkn::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.data_diri', compact('data_diri', 'data_pendaftaran'));
    }

    public function formPengajuanProject(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_diri = User::where('nim', $nim)->first();
        $data_pendaftaran = pendaftaranKkn::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.form_pengajuan_project', compact('data_pendaftaran', 'data_diri'));
    }
}
