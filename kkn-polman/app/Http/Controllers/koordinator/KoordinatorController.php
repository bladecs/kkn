<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\lokasiModel;
use App\Models\pendaftaraModel;
use App\Models\projectModel;
use App\Models\pengelompokanModel;
use Illuminate\Http\Request;

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
            'id_lokasi' => 'required|exists:lokasi,id',
            'id_project' => 'required|exists:project,id',
            'nama_kelompok' => 'required|string|max:255',
            'jumlah_anggota' => 'required|integer|min:1',
            'koordinator' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:active,completed',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'exists:pendaftaran_kkn,nim',
        ]);

        $uniqIdPengelompokan = uniqid('KLG-');

        pendaftaraModel::whereIn('nim', $request->input('anggota'))->update([
            'id_pengelompokan' => $uniqIdPengelompokan,
            'status' => 'grouped',
        ]);

        pengelompokanModel::create([
            'id' => $uniqIdPengelompokan,
            'nip' => $request->input('nip'),
            'id_lokasi' => $request->input('id_lokasi'),
            'id_project' => $request->input('id_project'),
            'nama_kelompok' => $request->input('nama_kelompok'),
            'jumlah_anggota' => $request->input('jumlah_anggota'),
            'koordinator' => $request->input('koordinator'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Pengelompokan mahasiswa berhasil disimpan.');
    }

    public function deletePendaftaran(Request $request, $nim)
    {
        pendaftaraModel::where('nim', $nim)->delete();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
