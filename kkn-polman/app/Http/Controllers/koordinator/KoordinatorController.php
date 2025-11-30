<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\DetailSchedule;
use App\Models\DetailSchema;
use App\Models\lokasiModel;
use App\Models\PendaftaranKkn;
use App\Models\pengelompokanModel;
use App\Models\ProjectKkn;
use App\Models\projectModel;
use App\Models\Schedule;
use App\Models\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoordinatorController extends Controller
{
    public function verifikasiPendaftaran(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:pendaftaran_kkn,nim',
            'status' => 'required|in:complete,rejected',
        ]);

        PendaftaranKkn::where('nim', $request->input('nim'))->update([
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
            $data_project = ProjectKkn::where('nim', $request->nim)->first();
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

            $updated = ProjectKkn::where('nim', $request->nim)->update([
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
            $data_project = ProjectKkn::where('nip', $request->nip)->first();
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

    public function createSchedule(Request $request)
    {
        $session = $request->session()->get('id');
        $request->validate([
            'kloter' => 'required|numeric|unique:detail_schedule,kloter',
            'deskripsi' => 'required|string|max:250',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
        ]);

        $id_kegiatan = uniqid('SCH', $request->input('kloter'));

        try {
            DB::beginTransaction();
            Schedule::create([
                'id_kegiatan' => $id_kegiatan,
                'created_by' => $session,
            ]);

            DetailSchedule::create([
                'id_detail_schedule' => uniqid('DSCH'),
                'kloter' => $request->input('kloter'),
                'schedule_id' => $id_kegiatan,
                'deskripsi' => $request->input('deskripsi'),
                'tgl_mulai' => $request->input('tgl_mulai'),
                'tgl_selesai' => $request->input('tgl_mulai'),
            ]);
            DB::commit();

            return redirect()->route('dashboard_koordinator')->with('success', 'Create schedule success');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Registration failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Registration failed: '.$e->getMessage());
        }
    }

    // public function createSchema(Request $request)
    // {
    //     $request->validate([
    //         'created_by' => 'required',
    //         'schedule_id' => 'required',
    //         'kategori_id' => 'required',
    //         'kuota' => 'nullable',
    //         'tgl_mulai' => 'required',
    //         'tgl_selesai' => 'required',
    //     ]);

    //     $id_schema = uniqid('SCM', $request->input('schedule_id'));
    //     try {
    //         DB::beginTransaction();

    //         Schema::create([
    //             'id_schema' => $id_schema,
    //             'schedule_id' => $request->input('schedule_id'),
    //             'created_by' => $request->input('created_by'),
    //         ]);

    //         DetailSchema::create([
    //             'id_detail_schema' => uniqid('DTSM'),
    //             'schema_id' => $id_schema,
    //             'kategori_id' => $request->input('kategori_id'),
    //             'kuota' => $request->input('kuota'),
    //             'tgl_mulai' => $request->input('tgl_mulai'),
    //             'tgl_selesai' => $request->input('tgl_selesai'),
    //         ]);

    //         DB::commit();

    //         return redirect()->route('dashboard_koordinator')->with('success', 'Berhasil membuat schema');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         \Log::error('Registration failed: '.$e->getMessage());

    //         return redirect()->back()->with('error', 'Registration failed: '.$e->getMessage());
    //     }
    // }

    public function createSchema(Request $request)
    {
        try {
            $validated = $request->validate([
                'schedule_id' => 'required|exists:detail_schedule,schedule_id',
                'kategori_id' => 'required|exists:kategori_schema,id_kategori',
                'kuota' => 'nullable|integer',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
                'created_by' => 'required|exists:users,id',
            ]);

            // Validasi tanggal terhadap schedule
            $schedule = DetailSchedule::where('schedule_id', $validated['schedule_id'])->first();
            if ($validated['tgl_mulai'] < $schedule->tgl_mulai || $validated['tgl_selesai'] > $schedule->tgl_selesai) {
                return redirect()->back()->withErrors([
                    'tgl_mulai' => 'Tanggal schema harus berada dalam periode schedule yang dipilih.',
                ])->withInput();
            }

            // Validasi kategori belum digunakan di schedule ini
            $existingSchema = DetailSchema::where('schedule_id', $validated['schedule_id'])
                ->where('kategori_id', $validated['kategori_id'])
                ->first();

            if ($existingSchema) {
                return redirect()->back()->withErrors([
                    'kategori_id' => 'Kategori schema ini sudah digunakan pada schedule yang dipilih.',
                ])->withInput();
            }

            $id_schema = uniqid('SCM', $request->input('schedule_id'));
            DB::beginTransaction();

            Schema::create([
                'id_schema' => $id_schema,
                'schedule_id' => $request->input('schedule_id'),
                'created_by' => $request->input('created_by'),
            ]);

            DetailSchema::create([
                'id_detail_schema' => uniqid('DTSM'),
                'schedule_id' => $request->input('schedule_id'),
                'schema_id' => $id_schema,
                'kategori_id' => $request->input('kategori_id'),
                'kuota' => $request->input('kuota'),
                'tgl_mulai' => $request->input('tgl_mulai'),
                'tgl_selesai' => $request->input('tgl_selesai'),
            ]);

            DB::commit();

            return redirect()->route('dashboard_koordinator')->with('success', 'Schema berhasil dibuat!');

        } catch (\Exception $e) {

            \Log::error('Error creating schema: '.$e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat schema: '.$e->getMessage())->withInput();
        }
    }

    public function updateSchema(Request $request)
    {
        $request->validate([
            'detail_id' => 'required|exists:detail_schemas,id_detail_schema',
            'kategori_id' => 'required',
            'kuota' => 'nullable|numeric',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
        ]);

        try {
            // Ambil data detail schema berdasarkan primary key
            $detail = DetailSchema::where('id_detail_schema', $request->detail_id)->first();

            if (! $detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail schema tidak ditemukan',
                ], 404);
            }

            // Update semua field
            $detail->update([
                'kategori_id' => $request->kategori_id,
                'kuota' => $request->kuota ?? null,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
            ]);

            return redirect()->back()->with('success', 'Schema berhasil diperbarui!');

        } catch (\Exception $e) {

            \Log::error('Update failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Update gagal: '.$e->getMessage());
        }
    }

    public function deleteSchema(Request $request)
    {
        $request->validate([
            'detail_id' => 'required|exists:detail_schemas,id_detail_schema',
        ]);

        try {
            $detail = DetailSchema::where('id_detail_schema', $request->detail_id)->first();

            if (! $detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail schema tidak ditemukan',
                ], 404);
            }

            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Schema berhasil dihapus!',
            ]);

        } catch (\Exception $e) {

            \Log::error('Delete failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus schema: '.$e->getMessage(),
            ], 500);
        }
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
