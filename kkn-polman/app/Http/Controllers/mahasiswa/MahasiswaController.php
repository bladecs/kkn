<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailLogbook;
use App\Models\DetailPendaftaranKkn;
use App\Models\LaporanAkhir;
use App\Models\LogbookKegiatan;
use App\Models\Mahasiswa;
use App\Models\PendaftaranKkn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function storeLaporanHarian(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'week' => 'required|integer|min:1',
            'kelompok' => 'required|string',
            'keterangan' => 'nullable|string',
            'kegiatan.*.nama_kegiatan' => 'required|string',
            'kegiatan.*.kategori_id' => 'required|exists:kategori_kegiatan,id_kategori',
            'kegiatan.*.deskripsi_kegiatan' => 'required|string',
            'kegiatan.*.jumlah_waktu' => 'required|integer|min:15|max:480',
        ]);

        $session = session('id');
        $data_diri = Mahasiswa::with('anggotaKelompok')->where('id', $session)->first();

        try {
            DB::beginTransaction();

            // Create main laporan
            $laporan = LogbookKegiatan::create([
                'id_logbook' => uniqid('LB_'),
                'anggota_id' => $data_diri->anggotaKelompok->first()->id_anggota,
                'nilai' => null,
                'status' => 'draft',
                'week' => $request->input('week'),
            ]);
            $kegiatanData = $request->input('kegiatan', []);

            if (count($kegiatanData) > 1) {
                foreach ($kegiatanData as $kegiatan) {
                    DetailLogbook::create([
                        'id_detail_logbook' => uniqid('DLB_'),
                        'logbook_id' => $laporan->id_logbook,
                        'nama_kegiatan' => $kegiatan['nama_kegiatan'],
                        'kategori_id' => $kegiatan['kategori_id'],
                        'deskripsi_kegiatan' => $kegiatan['deskripsi_kegiatan'],
                        'jumlah_waktu' => $kegiatan['jumlah_waktu'],
                    ]);
                }
            } elseif (count($kegiatanData) === 1) {
                DetailLogbook::create([
                    'id_detail_logbook' => uniqid('DLB_'),
                    'logbook_id' => $laporan->id_logbook,
                    'nama_kegiatan' => $kegiatanData[0]['nama_kegiatan'],
                    'kategori_id' => $kegiatanData[0]['kategori_id'],
                    'deskripsi_kegiatan' => $kegiatanData[0]['deskripsi_kegiatan'],
                    'jumlah_waktu' => $kegiatanData[0]['jumlah_waktu'],
                ]);
            } else {
                throw new \Exception('Data kegiatan tidak ditemukan');
            }

            DB::commit();

            return redirect()->route('dashboard_mhs')
                ->with('success', 'Laporan harian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan laporan harian untuk mahasiswa id '.$session.': '.$e->getMessage(), ['exception' => $e]);

            return back()->with('error', 'Gagal menyimpan laporan: '.$e->getMessage());
        }
    }

    public function storeLaporanAkhir(Request $request)
    {
        $request->validate([
            'laporan_pdf' => 'required|mimes:pdf|max:20480',
            'presentasi' => 'required|max:30720',
            'catatan' => 'nullable|string',
            'link_tambahan' => 'nullable|url',
        ]);

        $session = session('id');
        $data_diri = Mahasiswa::with('anggotaKelompok')->where('id', $session)->first();

        if (! $data_diri || ! $data_diri->anggotaKelompok) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data mahasiswa atau kelompok tidak ditemukan',
                ], 404);
            }

            return back()->with('error', 'Data mahasiswa atau kelompok tidak ditemukan');
        }

        // Mulai DB Transaction
        DB::beginTransaction();

        try {
            // Handle file uploads
            $pdfPath = $request->file('laporan_pdf')->store('laporan_akhir_pdfs', 'public');
            $pptPath = $request->file('presentasi')->store('laporan_akhir_ppts', 'public');

            LaporanAkhir::create([
                'id_laporan_akhir' => 'LA_'.time().'_'.uniqid(),
                'anggota_id' => $data_diri->anggotaKelompok->first()->id_anggota,
                'path_pdf' => $pdfPath,
                'path_ppt' => $pptPath,
                'catatan' => $request->input('catatan'),
                'link_tambahan' => $request->input('link_tambahan'),
                'nilai' => null,
                'status' => 'submitted',
            ]);

            // Commit transaction jika semua berhasil
            DB::commit();

            // Return JSON response for AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan akhir berhasil diajukan!',
                    'redirect_url' => route('dashboard_mhs'),
                ]);
            }

            return redirect()->route('dashboard_mhs')
                ->with('success', 'Laporan akhir berhasil diajukan!');

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollBack();

            // Log error
            \Log::error('Gagal menyimpan laporan akhir untuk mahasiswa id '.$session.': '.$e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan laporan akhir: '.$e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menyimpan laporan akhir: '.$e->getMessage());
        }
    }
}
