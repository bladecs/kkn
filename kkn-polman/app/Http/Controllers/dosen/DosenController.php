<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\projectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
     public function pengajuanProject(Request $request)
    {
        $nip = session('nip');
        // $data_diri = User::where('nip', $nim)->first();
        // $data_pendaftaran = pendaftaraModel::where('nim', $nim)->first();

        $request->validate([
            'judul_project' => 'required|string|max:255',
            'deskripsi_project' => 'required|string',
            'jalan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'alamat' => 'required|string|max:500',
            'proposal_kkn' => 'required|file|mimes:pdf|max:5120',
            'rab_kkn' => 'required|file|mimes:pdf|max:5120',
        ]);

        try {

            // Upload proposal
            $proposalFile = $request->file('proposal_kkn');
            $proposalFileName = 'proposal_'.time().'_'.$nip.'.'.$proposalFile->getClientOriginalExtension();
            $proposalPath = $proposalFile->storeAs('proposal_kkn_files', $proposalFileName, 'public');

            // Upload RAB
            $rabFile = $request->file('rab_kkn');
            $rabFileName = 'rab_'.time().'_'.$nip.'.'.$rabFile->getClientOriginalExtension();
            $rabPath = $rabFile->storeAs('rab_kkn_files', $rabFileName, 'public');

            projectModel::create([
                'id' => uniqid('proj_'),
                'nip' => $nip,
                'judul_project' => $request->input('judul_project'),
                'deskripsi_project' => $request->input('deskripsi_project'),
                'jalan' => $request->input('jalan'),
                'lokasi' => $request->input('lokasi'),
                'kota' => $request->input('kota'),
                'provinsi' => $request->input('provinsi'),
                'alamat' => $request->input('alamat'),
                'proposal_kkn_path' => $proposalPath,
                'rab_kkn_path' => $rabPath,
            ]);

            return redirect()->route('dashboard_mhs')->with('success', 'Pengajuan project KKN berhasil diajukan.');
        } catch (\Exception $e) {
            if (isset($proposalPath) && Storage::disk('public')->exists($proposalPath)) {
                Storage::disk('public')->delete($proposalPath);
            }
            if (isset($rabPath) && Storage::disk('public')->exists($rabPath)) {
                Storage::disk('public')->delete($rabPath);
            }

            return redirect()->route('dashboard_mhs')
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: '.$e->getMessage());
        }
    }
}
