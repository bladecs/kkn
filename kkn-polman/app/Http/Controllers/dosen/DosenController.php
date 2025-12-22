<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\LokasiKkn;
use App\Models\ProjectKkn;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function pengajuanProject(Request $request){
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

        try{
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
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengajukan project: ' . $e->getMessage());
        }
    }
}
