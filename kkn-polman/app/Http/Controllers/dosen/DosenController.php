<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\LaporanAkhir;
use App\Models\LogbookKegiatan;
use App\Models\LokasiKkn;
use App\Models\ProjectKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DosenController extends Controller
{
    public function pengajuanProject(Request $request)
    {
        $session = $request->session()->get('id');
        $data_diri = Dosen::where('id', $session)->first();
        $request->validate([
            'judul_project' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jalan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'deskripsi_project' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $id_lokasi = uniqid('LOK-');
            LokasiKkn::create([
                'id_lokasi' => $id_lokasi,
                'nama_lokasi' => $request->lokasi,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'alamat' => $request->alamat,
            ]);
            ProjectKkn::create([
                'id_project' => uniqid('PRJ-'),
                'judul' => $request->judul_project,
                'deskripsi' => $request->deskripsi_project,
                'lokasi_id' => $id_lokasi,
                'pengaju' => $data_diri->nip,
                'status' => 'pending',
            ]);
            DB::commit();

            return back()->route('dashboard_dosen')->with('success', 'Project KKN berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat mengajukan project: '.$e->getMessage());
        }
    }

    public function submitNilaiLogbook(Request $request)
    {
        $request->validate([
            'id_logbook' => 'required|exists:logbook_kegiatan,id_logbook',
            'action' => 'required|in:dinilai,direvisi',
            'nilai' => 'required_if:action,dinilai|nullable|integer|min:0|max:100',
        ]);

        $logbook = LogbookKegiatan::where('id_logbook', $request->id_logbook)->first();
        if (! $logbook) {
            return back()->with('error', 'Logbook tidak ditemukan.');
        }
        try {
            DB::beginTransaction();
            $logbook->status = $request->action;
            if ($request->action == 'dinilai') {
                $logbook->nilai = $request->nilai;
                LogbookKegiatan::where('id_logbook', $request->id_logbook)->update([
                    'status' => $logbook->status,
                    'nilai' => $logbook->nilai,
                ]);
            } else {
                LogbookKegiatan::where('id_logbook', $request->id_logbook)->update([
                    'status' => $logbook->status,
                ]);
            }
            DB::commit();
            return back()->with('success', 'Logbook berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui logbook ID '.$request->id_logbook.': '.$e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui logbook: '.$e->getMessage());
        }
    }

    public function submitNilaiLaporanAkhir(Request $request)
    {
        $request->validate([
            'id_laporan_akhir' => 'required|exists:laporan_akhir,id_laporan_akhir',
            'action' => 'required|in:dinilai,direvisi',
            'nilai' => 'required_if:action,dinilai|nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $laporan = LaporanAkhir::where('id_laporan_akhir', $request->id_laporan_akhir)->first();
        if (! $laporan) {
            return back()->with('error', 'Laporan akhir tidak ditemukan.');
        }
        try {
            DB::beginTransaction();
            $laporan->status = $request->action;
            if ($request->action == 'dinilai') {
                $laporan->nilai = $request->nilai;
                $laporan->catatan = $request->catatan;
                LaporanAkhir::where('id_laporan_akhir', $request->id_laporan_akhir)->update([
                    'status' => $laporan->status,
                    'nilai' => $laporan->nilai,
                    'comment' => $laporan->catatan,
                ]);
            } else {
                $laporan->catatan = $request->catatan;
                LaporanAkhir::where('id_laporan_akhir', $request->id_laporan_akhir)->update([
                    'status' => $laporan->status,
                    'comment' => $laporan->catatan,
                ]);
            }
            DB::commit();
            return back()->with('success', 'Laporan akhir berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui laporan akhir ID '.$request->id_laporan_akhir.': '.$e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui laporan akhir: '.$e->getMessage());
        }
    }
}
