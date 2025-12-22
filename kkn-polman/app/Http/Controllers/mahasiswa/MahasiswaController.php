<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailPendaftaranKkn;
use App\Models\pendaftaraModel;
use App\Models\PendaftaranKkn;
use App\Models\projectModel;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function pendaftaran(Request $request)
    {
        $request->validate([
            'kloter' => 'required',
            'ipk' => 'required',
            'semester' => 'required',
        ]);

        $id = session('id');

        $data_diri = Mahasiswa::where('id', $id)->first();
        $id_pendaftaran = uniqid('pendaftaran_');

        try {
            PendaftaranKkn::create([
                'id_pendaftaran' => $id_pendaftaran,
                'nim' => $data_diri->nim,
                'status' => 'pending',
            ]);

            DetailPendaftaranKkn::create([
                'id_detail_pendaftaran' => uniqid('detail_'),
                'no_pendaftaran' => $id_pendaftaran,
                'kloter' => $request->input('kloter'),
                'semester' => $request->input('semester'),
            ]);
            return redirect()->route('dashboard_mhs')->with('success', 'Pendaftaran KKN berhasil diajukan.');
        } catch (\Exception $e) {
            \Log::error('Pendaftaran KKN gagal for id '.$id.': '.$e->getMessage(), ['exception' => $e]);

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengajukan pendaftaran. Silakan coba lagi atau hubungi admin.');
        }
    }

    public function updateDataDiri(Request $request)
    {
        $nim = session('nim');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$nim.',nim',
            'phone' => 'required|string|max:15',
            'nim' => 'required|string|max:20|unique:users,nim,'.$nim.',nim',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'alamat' => 'required|string|max:500',
        ]);

        try {
            User::where('nim', $nim)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'nim' => $request->input('nim'),
                'tmp_lahir' => $request->input('tempat_lahir'),
                'tgl_lahir' => $request->input('tanggal_lahir'),
                'gender' => $request->input('gender'),
                'alamat' => $request->input('alamat'),
            ]);

            return redirect()->back()->with('success', 'Data diri berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui data diri untuk nim '.$nim.': '.$e->getMessage(), ['exception' => $e]);

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data diri. Silakan coba lagi atau hubungi admin.');
        }
    }

    public function pengajuanProject(Request $request)
    {
        $nim = session('nim');
        $data_diri = User::where('nim', $nim)->first();
        $data_pendaftaran = pendaftaraModel::where('nim', $nim)->first();

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
            $proposalFileName = 'proposal_'.time().'_'.$nim.'.'.$proposalFile->getClientOriginalExtension();
            $proposalPath = $proposalFile->storeAs('proposal_kkn_files', $proposalFileName, 'public');

            // Upload RAB
            $rabFile = $request->file('rab_kkn');
            $rabFileName = 'rab_'.time().'_'.$nim.'.'.$rabFile->getClientOriginalExtension();
            $rabPath = $rabFile->storeAs('rab_kkn_files', $rabFileName, 'public');

            projectModel::create([
                'id' => uniqid('proj_'),
                'nim' => $nim,
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
