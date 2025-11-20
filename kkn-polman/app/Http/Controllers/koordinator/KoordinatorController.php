<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\lokasiModel;
use App\Models\pendaftaraModel;
use App\Models\projectModel;
use App\Models\pengelompokanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KoordinatorController extends Controller
{
    public function verifikasiPendaftaran(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:pendaftaran_kkn,nim',
            'status' => 'required|in:complete,rejected',
        ]);

        pendaftaraModel::where('nim', $request->input('nim'))->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diverifikasi.');
    }

    public function verifikasiProject(Request $request)
    {
        $request->validate([
            'status' => 'required|in:complete,rejected',
        ]);

        if (! empty($request->nim)) {
            $data_project = projectModel::where('nim', $request->nim)->first();
            if (! $data_project) {
                return back()->with('error', 'Data project dengan NIM tersebut tidak ditemukan.');
            } else {
                lokasiModel::create([
                    'id' => uniqid('LOK-'),
                    'nama_lokasi' => $data_project->lokasi,
                    'kota' => $data_project->kota,
                    'provinsi' => $data_project->provinsi,
                    'jalan' => $data_project->jalan,
                    'alamat' => $data_project->alamat,
                ]);
            }

            $updated = projectModel::where('nim', $request->nim)->update([
                'penyetuju' => 'Koordinator',
                'status' => $request->status,
            ]);

            if ($updated) {
                return back()->with('success', 'Verifikasi berdasarkan NIM berhasil.');
            } else {
                return back()->with('error', 'NIM tidak ditemukan.');
            }
        }

        if (! empty($request->nip)) {
            $data_project = projectModel::where('nip', $request->nip)->first();
            if (! $data_project) {
                return back()->with('error', 'Data project dengan NIP tersebut tidak ditemukan.');
            } else {
                lokasiModel::create([
                    'id' => uniqid('LOK-'),
                    'nama_lokasi' => $data_project->lokasi,
                    'kota' => $data_project->kota,
                    'provinsi' => $data_project->provinsi,
                    'jalan' => $data_project->jalan,
                    'alamat' => $data_project->alamat,
                ]);
            }

            $updated = projectModel::where('nip', $request->nip)->update([
                'penyetuju' => 'Koordinator',
                'status' => $request->status,
            ]);

            if ($updated) {
                return back()->with('success', 'Verifikasi berdasarkan NIP berhasil.');
            } else {
                return back()->with('error', 'NIP tidak ditemukan.');
            }
        }

        return back()->with('error', 'Harus mengisi NIM atau NIP untuk verifikasi.');
    }

    public function buatPengelompokan(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:dosen,nip',
            'id_project' => 'required|exists:project,id',
            'nama_kelompok' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'exists:pendaftaran_kkn,nim',
        ]);

        // Unique ID untuk pengelompokan
        $uniqIdPengelompokan = uniqid('KLG-');

        // Ambil project + relasi lokasi
        $data_project = projectModel::where('id', $request->id_project)
            ->first();

        $data_lokasi = lokasiModel::where('nama_lokasi', $data_project->lokasi)->first();

        if (! $data_project) {
            return back()->with('error', 'Project tidak ditemukan.');
        }

        // Update semua anggota yang dipilih
        pendaftaraModel::whereIn('nim', $request->anggota)->update([
            'id_pengelompokan' => $uniqIdPengelompokan,
            'status' => 'grouped',
        ]);

        // Simpan data pengelompokan
        pengelompokanModel::create([
            'id' => $uniqIdPengelompokan,
            'nip' => $request->nip,
            'id_lokasi' => $data_lokasi->id,
            'id_project' => $request->id_project,
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_anggota' => count($request->anggota), // otomatis
            'koordinator' => 'Koordinator',
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengelompokan mahasiswa berhasil disimpan.');
    }

    public function deletePendaftaran(Request $request, $nim)
    {
        pendaftaraModel::where('nim', $nim)->delete();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
