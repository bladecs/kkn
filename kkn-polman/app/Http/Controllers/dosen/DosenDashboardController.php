<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\dosenModel;
use App\Models\pendaftaraModel;
use Illuminate\Http\Request;
use App\Models\User;

class DosenDashboardController extends Controller
{
 public function index(Request $request){
   $count_pendaftaran = pendaftaraModel::count();
        $daily_pendaftaran = pendaftaraModel::whereDate('created_at', now()->toDateString())->count();
        $count_not_verif = pendaftaraModel::where('status', 'verifikasi')->count();
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

        return view('dashboard.dosen.dashboard',compact('data', 'count_pendaftaran', 'count_not_verif', 'daily_pendaftaran'));
 }
  public function formPengajuanProject(Request $request)
    {
        $nim = $request->session()->get('nip');
        $data_diri = dosenModel::where('nip', $nim)->first();
        

        return view('dashboard.dosen.form_pengajuan_project', compact( 'data_diri'));
    }
}
