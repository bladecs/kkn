<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KelompokKkn;
use App\Models\LaporanAkhir;
use App\Models\LogbookKegiatan;
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
        $allLogbooks = LogbookKegiatan::where('kelompok_id', $kelompokKkn->id_kelompok)->limit(5)->get();

        // Ambil semua laporan akhir yang menunggu
        $laporanMenunggu = LaporanAkhir::where('status', 'dinilai')->get();

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
        $session = session('id');
        $dosen = Dosen::where('id', $session)->first();
        $kelompokKkn = KelompokKkn::with(['detailKelompok', 'anggotaKelompok'])->where('pembimbing', $dosen->nip)->first();
        $allLogbooks = LogbookKegiatan::where('kelompok_id', $kelompokKkn->id_kelompok)
            ->paginate(10);
        $statusCounts = [
            'draft' => $allLogbooks->where('status', 'draft')->count(),
            'dinilai' => $allLogbooks->where('status', 'dinilai')->count(),
            'direvisi' => $allLogbooks->where('status', 'direvisi')->count(),
        ];

        return view('dashboard.dosen.dashboard_penilaian_logbook', compact('kelompokKkn', 'allLogbooks', 'statusCounts'));
    }
    
    public function penilaianLaporanAkhir()
    {
        $session = session('id');
        $dosen = Dosen::where('id', $session)->first();
        $kelompokKkn = KelompokKkn::with(['detailKelompok', 'anggotaKelompok'])->where('pembimbing', $dosen->nip)->first();
        $allLaporanAkhir = LaporanAkhir::where('kelompok_id', $kelompokKkn->id_kelompok)
            ->paginate(10);
        $statusCounts = [
            'submitted' => $allLaporanAkhir->where('status', 'submitted')->count(),
            'dinilai' => $allLaporanAkhir->where('status', 'dinilai')->count(),
            'revisi' => $allLaporanAkhir->where('status', 'revisi')->count(),
        ];

        return view('dashboard.dosen.dashboard_penilaian_laporan_akhir', compact('kelompokKkn', 'allLaporanAkhir', 'statusCounts'));
    }
}
