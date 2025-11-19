<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\pendaftaraModel;
use App\Models\projectModel;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function pendaftaran(Request $request)
    {
        $request->validate([
            'ipk' => 'required|numeric|min:0|max:4',
            'sks' => 'required|integer|min:0',
            'semester' => 'required|integer|min:1|max:14',
            'status_mhs' => 'required|string',
            'ktm' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'proposal' => 'required|file|mimes:pdf|max:5120',
            'rab' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $nim = session('nim');

        $data_diri = User::where('nim', $nim)->first();

        try {
            $ktm_path = $request->file('ktm')->store('ktm_files', 'public');
            $photo_path = $request->file('photo')->store('photo_files', 'public');
            $proposal_path = $request->file('proposal')->store('proposal_files', 'public');
            $rab_path = $request->hasFile('rab') ? $request->file('rab')->store('rab_files', 'public') : null;

            pendaftaraModel::create([
                'nim' => $nim,
                'name' => $data_diri->name,
                'ipk' => $request->input('ipk'),
                'sks' => $request->input('sks'),
                'semester' => $request->input('semester'),
                'status_mhs' => $request->input('status_mhs'),
                'jurusan' => $data_diri->jurusan,
                'study_program' => $data_diri->study_program,
                'ktm_path' => $ktm_path,
                'photo_path' => $photo_path,
                'proposal_path' => $proposal_path,
                'rab_path' => $rab_path,
            ]);

            return redirect()->route('dashboard_mhs')->with('success', 'Pendaftaran KKN berhasil diajukan.');
        } catch (\Exception $e) {
            \Log::error('Pendaftaran KKN gagal for nim '.$nim.': '.$e->getMessage(), ['exception' => $e]);

            try {
                if (! empty($ktm_path)) {
                    Storage::disk('public')->delete($ktm_path);
                }
                if (! empty($photo_path)) {
                    Storage::disk('public')->delete($photo_path);
                }
                if (! empty($proposal_path)) {
                    Storage::disk('public')->delete($proposal_path);
                }
                if (! empty($rab_path)) {
                    Storage::disk('public')->delete($rab_path);
                }
            } catch (\Exception $cleanupEx) {
                \Log::warning('Gagal membersihkan file setelah error pendaftaran: '.$cleanupEx->getMessage());
            }

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
