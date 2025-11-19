<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\pendaftaraModel;
use Illuminate\Http\Request;

class KoordinatorDashboarController extends Controller
{
    public function index(Request $request)
    {
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

        return view('dashboard.koordinator.dashboard',compact('data', 'count_pendaftaran', 'count_not_verif', 'daily_pendaftaran'));
    }

    public function pendaftaranKKN(Request $request)
    {
        $data_pendaftaran = pendaftaraModel::with('user')->get();
        return view('dashboard.koordinator.pendaftaran_kkn', compact('data_pendaftaran'));
    }
}
