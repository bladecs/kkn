<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelompok;
use App\Models\DetailKelompokKkn;
use App\Models\DetailSchedule;
use App\Models\DetailSchema;
use App\Models\KelompokKkn;
use App\Models\PendaftaranKkn;
use App\Models\ProjectKkn;
use App\Models\Schedule;
use App\Models\Schema;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        if (! empty($request->nip)) {
            $data_project = ProjectKkn::where('pengaju', $request->nip)->first();
            if (! $data_project) {
                return back()->with('error', 'Data project dengan NIP tersebut tidak ditemukan.');
            }

            $updated = ProjectKkn::where('pengaju', $request->nip)->update([
                'approved_by' => session('id'),
                'status' => $request->status,
            ]);

            if ($updated) {
                return back()->with('success', 'Verifikasi berdasarkan NIM berhasil.');
            } else {
                return back()->with('error', 'NIM tidak ditemukan.');
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

    public function UpdateSchedule(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'kloter' => 'required|string|max:50',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);
        
        DB::beginTransaction();
        
        try {
            if ($id) {
                $schedule = DetailSchedule::where('schedule_id', $id)->firstOrFail();
                $schedule->update($request->all());
                $message = 'Schedule berhasil diperbarui';
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'schedule' => $schedule,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan schedule: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroySchedule($id)
    {
        DB::beginTransaction();
        
        try {
            $schedule = Schedule::findOrFail($id);
            
            // Delete related schemas and their details
            DetailSchedule::where('schedule_id', $id)->delete();
            Schema::where('schedule_id', $id)->delete();
            
            $schedule->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Schedule berhasil dihapus',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus schedule: ' . $e->getMessage(),
            ], 500);
        }
    }

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

    public function updateSchema(Request $request, $id)
    {
        $request->validate([
            'details' => 'required|array',
            'details.*.kuota' => 'required|integer|min:0',
            'details.*.tgl_mulai' => 'nullable|date',
            'details.*.tgl_selesai' => 'nullable|date|after_or_equal:details.*.tgl_mulai',
        ]);

        DB::beginTransaction();

        try {
            $schema = Schema::findOrFail($id);

            // Update details
            foreach ($request->details as $index => $detailData) {
                // Update existing detail
                $detail = DetailSchema::find($detailData['id']);
                if ($detail && $detail->schema_id == $id) {
                    $detail->update([
                        'kuota' => $detailData['kuota'],
                        'tgl_mulai' => $detailData['tgl_mulai'],
                        'tgl_selesai' => $detailData['tgl_selesai'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Schema berhasil diperbarui',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui schema: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroySchema($id)
    {
        DB::beginTransaction();
        
        try {
            $schema = Schema::findOrFail($id);
            
            DetailSchema::where('schema_id', $id)->delete();
            
            $schema->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Schema berhasil dihapus',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus schema: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function buatPengelompokan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelompok' => 'required|string|max:255|unique:detail_kelompok_kkn,nama_kelompok',
            'nip' => 'required|exists:dosen,nip',
            'id_project' => 'nullable|exists:project_kkn,id_project',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'exists:mahasiswa,nim',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil schema aktif
        $schema = DetailSchema::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->where('kategori_id', 'SCH_003')
            ->orderBy('tgl_mulai', 'asc')
            ->first();

        if ($schema) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
            $schemaMulai = Carbon::parse($schema->tgl_mulai);
            $schemaSelesai = Carbon::parse($schema->tgl_selesai);

            // Validasi tanggal terhadap schema
            if ($tanggalMulai->lt($schemaMulai) || $tanggalSelesai->gt($schemaSelesai)) {
                return redirect()->back()
                    ->withErrors([
                        'tanggal_mulai' => 'Tanggal harus berada dalam periode schema aktif',
                        'tanggal_selesai' => 'Tanggal harus berada dalam periode schema aktif',
                    ])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->withErrors(['error' => 'Tidak ada schema aktif. Silakan buat schema terlebih dahulu.'])
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Buat pengelompokan baru
            $pengelompokan = KelompokKkn::create([
                'id_kelompok' => uniqid('KLG'),
                'pembimbing' => $request->nip,
                'created_by' => session('id'),
                'status' => 'active',
            ]);

            DetailKelompokKkn::create([
                'id_detail_kelompok' => uniqid('DKK'),
                'nama_kelompok' => $request->nama_kelompok,
                'kelompok_id' => $pengelompokan->id_kelompok,
                'project_id' => $request->id_project,
                'jumlah_anggota' => count($request->anggota),
                'tgl_mulai' => $request->tanggal_mulai,
                'tgl_selesai' => $request->tanggal_selesai,
            ]);

            AnggotaKelompok::insert(
                array_map(function ($nim) use ($pengelompokan, $request) {
                    return [
                        'id_anggota' => uniqid('AK'),
                        'kelompok_id' => $pengelompokan->id_kelompok,
                        'nim' => $nim,
                        'role_anggota' => $nim === $request->anggota[0] ? 'ketua' : 'anggota',
                    ];
                }, $request->anggota)
            );

            // COMMIT transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('dashboard_koordinator')->with('success', 'Kelompok berhasil dibuat!');

        } catch (\Exception $e) {
            // ROLLBACK transaksi jika terjadi error
            DB::rollBack();

            \Log::error('Buatpengelompokan failed: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function editPengelompokan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kelompok' => 'required|exists:detail_kelompok_kkn,id_kelompok',
            'nama_kelompok' => 'required|string|max:255',
            'nip' => 'required|exists:dosen,nip',
            'id_project' => 'nullable|exists:project_kkn,id_project',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:pending,active,completed',
            'anggota' => 'array',
            'anggota.*' => 'exists:mahasiswa,nim',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update Kelompok
            $kelompok = KelompokKkn::find($request->id_kelompok);
            $kelompok->update([
                'pembimbing' => $request->nip,
                'status' => $request->status,
            ]);

            // Update Detail Kelompok
            $detailKelompok = DetailKelompokKkn::where('kelompok_id', $request->id_kelompok)->first();
            $detailKelompok->update([
                'nama_kelompok' => $request->nama_kelompok,
                'project_id' => $request->id_project,
                'tgl_mulai' => $request->tanggal_mulai,
                'tgl_selesai' => $request->tanggal_selesai,
            ]);

            // Update Anggota jika ada perubahan
            if ($request->has('anggota')) {
                // Hapus anggota lama
                AnggotaKelompok::where('kelompok_id', $request->id_kelompok)->delete();

                // Tambah anggota baru
                $anggotaData = [];
                foreach ($request->anggota as $index => $nim) {
                    $anggotaData[] = [
                        'id_anggota' => uniqid('AK'),
                        'kelompok_id' => $request->id_kelompok,
                        'nim' => $nim,
                        'role_anggota' => $index === 0 ? 'ketua' : 'anggota',
                    ];
                }

                AnggotaKelompok::insert($anggotaData);

                // Update jumlah anggota
                DetailKelompokKkn::where('kelompok_id', $request->id_kelompok)
                    ->update([
                        'jumlah_anggota' => count($request->anggota),
                    ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Kelompok berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Update pengelompokan failed: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function getKelompokData($id)
    {
        try {
            $kelompok = KelompokKkn::with(['detailKelompok', 'anggotaKelompok.mahasiswa'])->find($id);

            if (! $kelompok) {
                return response()->json(['error' => 'Kelompok tidak ditemukan'], 404);
            }

            $anggota = $kelompok->anggotaKelompok->map(function ($anggota) {
                return [
                    'nim' => $anggota->nim,
                    'name' => $anggota->mahasiswa->name,
                    'role' => $anggota->role_anggota,
                    'prodi' => $anggota->mahasiswa->prodi->nama_prodi,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'id_kelompok' => $kelompok->id_kelompok,
                    'id_detail_kelompok' => $kelompok->detailKelompok->first()->id_detail_kelompok,
                    'nama_kelompok' => $kelompok->detailKelompok->first()->nama_kelompok,
                    'nip' => $kelompok->pembimbing,
                    'project_id' => $kelompok->detailKelompok->first()->project_id,
                    'tanggal_mulai' => $kelompok->detailKelompok->first()->tgl_mulai,
                    'tanggal_selesai' => $kelompok->detailKelompok->first()->tgl_selesai,
                    'status' => $kelompok->status,
                    'anggota' => $anggota,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }

    public function deletePengelompokan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kelompok' => 'required|exists:kelompok_kkn,id_kelompok',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Data tidak valid'], 400);
        }

        try {
            DB::beginTransaction();

            $kelompok = KelompokKkn::find($request->id_kelompok);

            // Hapus detail kelompok
            DetailKelompokKkn::where('kelompok_id', $kelompok->id_kelompok)->delete();

            // Hapus anggota kelompok
            AnggotaKelompok::where('kelompok_id', $kelompok->id_kelompok)->delete();

            // Hapus kelompok
            $kelompok->delete();

            DB::commit();

            return response()->json(['success' => 'Kelompok berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Delete pengelompokan failed: '.$e->getMessage());

            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }

    public function deletePendaftaran(Request $request, $nim)
    {
        PendaftaranKkn::where('nim', $nim)->delete();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
