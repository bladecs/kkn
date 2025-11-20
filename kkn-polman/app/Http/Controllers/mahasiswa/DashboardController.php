<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\pendaftaraModel;
use App\Models\projectModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $nim = $request->session()->get('nim');
        $pendaftaran = pendaftaraModel::where('nim', $nim)->first();
        $project = projectModel::where('nim', $nim)->first();

        $status_pendaftaran = $pendaftaran ? $pendaftaran->status : null;
        $status_project = $project ? $project->status : null;
        $tanggal_daftar = $pendaftaran ? $pendaftaran->created_at->format('d M Y') : '-';
        $tanggal_update = $pendaftaran ? $pendaftaran->updated_at->format('d M Y') : '-';

        return view('dashboard.mahasiswa.dashboard', compact(
            'status_pendaftaran',
            'tanggal_daftar',
            'tanggal_update',
            'status_project'
        ));
    }

    public function dataAkademik(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_akademik = pendaftaraModel::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.data_akademik', compact('data_akademik'));
    }

    public function dataDiri(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_diri = User::where('nim', $nim)->first();
        $data_pendaftaran = pendaftaraModel::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.data_diri', compact('data_diri', 'data_pendaftaran'));
    }

    public function formPengajuanProject(Request $request)
    {
        $nim = $request->session()->get('nim');
        $data_diri = User::where('nim', $nim)->first();
        $data_pendaftaran = pendaftaraModel::where('nim', $nim)->first();

        return view('dashboard.mahasiswa.form_pengajuan_project', compact('data_pendaftaran', 'data_diri'));
    }
}
