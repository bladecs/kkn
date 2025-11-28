<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\DetailSchedule;
use App\Models\Dosen;
use App\Models\dosenModel;
use App\Models\KategoriSchema;
use App\Models\lokasiModel;
use App\Models\pendaftaranKKN;
use App\Models\projectModel;
use App\Models\pengelompokanModel;
use App\Models\Schedule;
use App\Models\Schema;
use Illuminate\Http\Request;

class KoordinatorDashboarController extends Controller
{
    public function index(Request $request)
    {
        $count_pendaftaran = pendaftaranKKN::count();
        $daily_pendaftaran = pendaftaranKKN::whereDate('created_at', now()->toDateString())->count();
        $count_not_verif = pendaftaranKKN::where('status', 'verifikasi')->count();
        $data = [
            'chart_labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'chart_data' => [12, 19, 8, 15, 22, 10, 5],
            'aktivitas_koordinator' => [
                [
                    'tanggal' => '2023-10-15',
                    'judul' => 'Verifikasi Pendaftaran',
                    'deskripsi' => 'Memverifikasi 15 pendaftaran baru',
                ],
                [
                    'tanggal' => '2023-10-14',
                    'judul' => 'Review Project Proposal',
                    'deskripsi' => 'Mereview 8 proposal project KKN',
                ],
            ],
        ];

        return view('dashboard.koordinator.dashboard',compact('data', 'count_pendaftaran', 'count_not_verif', 'daily_pendaftaran'));
    }

    public function formSchedule(Request $request)
    {
        $session = $request->session()->get('id');
        $data_diri = Dosen::where('id',$session)->first();
        return view('dashboard.koordinator.form_schedule');
    }

    public function formSchema(){
        $kategoriSchemas = KategoriSchema::all();
        $schedule = Schedule::all();
        $schedules = DetailSchedule::all();
        $schema = Schema::all();
        return view('dashboard.koordinator.form_schema',compact('kategoriSchemas','schedules'));
    }

    public function pendaftaranKKN(Request $request)
    {
        $data_pendaftaran = pendaftaranKKN::with('user')->get();
        return view('dashboard.koordinator.pendaftaran_kkn', compact('data_pendaftaran'));
    }

    public function pendaftaranProject(Request $request)
    {
        $data_project = projectModel::all();
        return view('dashboard.koordinator.pendaftaran_project', compact('data_project'));
    }

    public function pengelompokanMhs(Request $request)
    {
        $mahasiswa = pendaftaraModel::whereIn('status', ['complete','grouped'])->get();
        $dosen = dosenModel::where('role', 'dosen')->get();
        $lokasi = lokasiModel::all();
        $project = projectModel::where('status', 'complete')->get();
        $pengelompokan = pengelompokanModel::with(['lokasi','project','dosen'])->get();

        return view('dashboard.koordinator.pengelompokan_mahasiswa',compact(
            'mahasiswa',
            'dosen',
            'lokasi',
            'project',
            'pengelompokan'
        ));
    }
}
