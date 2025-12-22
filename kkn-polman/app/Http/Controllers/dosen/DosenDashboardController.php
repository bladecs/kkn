<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\dosenModel;
use App\Models\KelompokKkn;
use App\Models\LaporanAkhir;
use App\Models\LogbookKegiatan;
use App\Models\pengelompokanModel;
use App\Models\ProjectKkn;
use Illuminate\Http\Request;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $session = session('id');
        $dosen = Dosen::where('id', $session)->first();

        $kelompokKkn = KelompokKkn::with(['detailKelompok', 'anggotaKelompok'])
            ->where('pembimbing', $dosen->nip)
            ->first();

        // Ambil semua project dosen
        $projects = ProjectKkn::where('pengaju', $dosen->nip)->get();

        // Ambil semua logbooks dari semua project
        $projectIds = $projects->pluck('id_project');
        $allLogbooks = LogbookKegiatan::whereIn('anggota_id', $projectIds)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Ambil semua laporan akhir yang menunggu
        $laporanMenunggu = LaporanAkhir::whereIn('anggota_id', $projectIds)
            ->where('status', 'submitted')
            ->get();

        return view('dashboard.dosen.dashboard', compact('projects', 'kelompokKkn', 'allLogbooks', 'laporanMenunggu'));
    }

    public function formPengajuanProject(Request $request)
    {
        $session = $request->session()->get('id');
        $data_diri = Dosen::where('id', $session)->first();
        $data_pengelompokan = KelompokKkn::where('pembimbing', $data_diri->nip)->first();

        return view('dashboard.dosen.form_pengajuan_project', compact('data_diri', 'data_pengelompokan'));
    }

    public function penilaianLogbook()
    {
        return view('dashboard.dosen.penilaian_logbook');
    }
}
