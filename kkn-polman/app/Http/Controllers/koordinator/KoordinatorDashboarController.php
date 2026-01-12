<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\DetailKelompokKkn;
use App\Models\DetailSchedule;
use App\Models\DetailSchema;
use App\Models\Dosen;
use App\Models\KategoriSchema;
use App\Models\LokasiKkn;
use App\Models\Mahasiswa;
use App\Models\PendaftaranKKN;
use App\Models\Prodi;
use App\Models\ProjectKkn;
use App\Models\Schedule;
use App\Models\Schema;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;

class KoordinatorDashboarController extends Controller
{
    public function index(Request $request)
    {
        $count_pendaftaran = PendaftaranKKN::count();
        $daily_pendaftaran = PendaftaranKKN::whereDate('created_at', now()->toDateString())->count();
        $project_belum_diperiksa = ProjectKkn::where('status', 'pending')->count();
        $count_not_verif = PendaftaranKKN::where('status', 'verifikasi')->count();
        $jumlah_schedule = DetailSchedule::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->count();
        $jumlah_schema = DetailSchema::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->count();
        $project_selesai = ProjectKkn::where('status', 'approved')->count();
        $schedules = DetailSchedule::with('schema')->get();

        return view('dashboard.koordinator.dashboard', compact('project_belum_diperiksa', 'count_pendaftaran', 'count_not_verif', 'daily_pendaftaran',
            'jumlah_schedule', 'jumlah_schema', 'project_selesai', 'schedules'));
    }

    public function formSchedule(Request $request)
    {
        $session = $request->session()->get('id');
        $data_diri = Dosen::where('id', $session)->first();

        return view('dashboard.koordinator.form_schedule');
    }

    public function formSchema()
    {
        $kategoriSchemas = KategoriSchema::all();
        $schedule = Schedule::all();
        $schedules = DetailSchedule::all();
        $schema = Schema::all();

        return view('dashboard.koordinator.form_schema', compact('kategoriSchemas', 'schedules'));
    }

    public function getAvailableKategori(Request $request)
    {
        try {
            $scheduleId = $request->input('schedule_id');

            // Validasi input
            if (! $scheduleId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule ID tidak boleh kosong',
                ], 422);
            }

            // Validasi schedule exists
            $schedule = DetailSchedule::where('schedule_id', $scheduleId)->first();
            if (! $schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Schedule tidak ditemukan',
                ], 404);
            }

            // Get all kategori schema
            $allKategori = KategoriSchema::all();

            // Get kategori yang sudah digunakan di schedule ini
            $usedKategori = DetailSchema::where('schedule_id', $scheduleId)
                ->pluck('kategori_id')
                ->toArray();

            // Filter available kategori
            $availableKategori = $allKategori->filter(function ($kategori) use ($usedKategori) {
                return ! in_array($kategori->id_kategori, $usedKategori);
            })->values();

            // Get existing schemas for this schedule
            $existingSchemas = DetailSchema::where('schedule_id', $scheduleId)
                ->with('kategori')
                ->get()
                ->map(function ($schema) {
                    return [
                        'id_detail_schema' => $schema->id_detail_schema,
                        'id_schema' => $schema->schedule_id,
                        'kategori_id' => $schema->kategori_id,
                        'nama_kategori' => $schema->kategori->deskripsi ?? '-',
                        'kuota' => $schema->kuota,
                        'tgl_mulai' => $schema->tgl_mulai,
                        'tgl_selesai' => $schema->tgl_selesai,
                        'created_at' => $schema->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $availableKategori,
                'used_count' => count($usedKategori),
                'total_count' => $allKategori->count(),
                'existing_schemas' => $existingSchemas,
                'schemas_count' => $existingSchemas->count(),
                'schedule_info' => [
                    'kloter' => $schedule->kloter,
                    'tgl_mulai' => $schedule->tgl_mulai,
                    'tgl_selesai' => $schedule->tgl_selesai,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getAvailableKategori: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: '.$e->getMessage(),
            ], 500);
        }
    }

    public function checkDateConflicts(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:detail_schedule,schedule_id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        try {
            $scheduleId = $request->schedule_id;
            $tglMulai = $request->tgl_mulai;
            $tglSelesai = $request->tgl_selesai;

            // Cek konflik dengan schema lain dalam schedule yang sama
            $conflictingSchemas = DetailSchema::where('schedule_id', $scheduleId)
                ->where(function ($query) use ($tglMulai, $tglSelesai) {
                    $query->whereBetween('tgl_mulai', [$tglMulai, $tglSelesai])
                        ->orWhereBetween('tgl_selesai', [$tglMulai, $tglSelesai])
                        ->orWhere(function ($q) use ($tglMulai, $tglSelesai) {
                            $q->where('tgl_mulai', '<=', $tglMulai)
                                ->where('tgl_selesai', '>=', $tglSelesai);
                        });
                })
                ->with('kategori')
                ->get();

            return response()->json([
                'conflicts' => $conflictingSchemas->count() > 0,
                'conflicting_schemas' => $conflictingSchemas->map(function ($schema) {
                    return [
                        'id_schema' => $schema->id_schema,
                        'kategori_id' => $schema->kategori_id,
                        'nama_kategori' => $schema->kategori->deskripsi ?? '-',
                        'tgl_mulai' => $schema->tgl_mulai,
                        'tgl_selesai' => $schema->tgl_selesai,
                        'kuota' => $schema->kuota,
                    ];
                }),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage(),
            ], 500);
        }
    }

    public function getUnavailableDates(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:detail_schemas,schedule_id',
        ]);

        try {
            $scheduleId = $request->schedule_id;

            $schemas = DetailSchema::where('schedule_id', $scheduleId)->get();

            $unavailableDates = [];

            foreach ($schemas as $schema) {
                $start = new DateTime($schema->tgl_mulai);
                $end = new DateTime($schema->tgl_selesai);

                $interval = new DateInterval('P1D');
                $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

                foreach ($period as $date) {
                    $unavailableDates[] = $date->format('Y-m-d');
                }
            }

            return response()->json([
                'success' => true,
                'unavailable_dates' => array_unique($unavailableDates),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage(),
            ], 500);
        }
    }

    public function validateDates(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:detail_schedule,schedule_id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        try {
            $scheduleId = $request->schedule_id;
            $tglMulai = $request->tgl_mulai;
            $tglSelesai = $request->tgl_selesai;

            // Validasi range schedule
            $schedule = DetailSchedule::where('schedule_id', $scheduleId);
            if ($tglMulai < $schedule->tgl_mulai || $tglSelesai > $schedule->tgl_selesai) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Tanggal harus dalam range schedule: '.
                                $schedule->tgl_mulai.' hingga '.$schedule->tgl_selesai,
                ]);
            }

            // Cek tabrakan dengan schema lain
            $conflictingSchemas = Schema::where('id_kegiatan', $scheduleId)
                ->where(function ($query) use ($tglMulai, $tglSelesai) {
                    $query->whereBetween('tgl_mulai', [$tglMulai, $tglSelesai])
                        ->orWhereBetween('tgl_selesai', [$tglMulai, $tglSelesai])
                        ->orWhere(function ($q) use ($tglMulai, $tglSelesai) {
                            $q->where('tgl_mulai', '<=', $tglMulai)
                                ->where('tgl_selesai', '>=', $tglSelesai);
                        });
                })
                ->with('kategori')
                ->get();

            if ($conflictingSchemas->count() > 0) {
                $conflictingList = $conflictingSchemas->map(function ($schema) {
                    return [
                        'kategori' => $schema->kategori_id,
                        'periode' => $schema->tgl_mulai.' hingga '.$schema->tgl_selesai,
                    ];
                });

                return response()->json([
                    'valid' => false,
                    'message' => 'Periode bertabrakan dengan schema lain',
                    'conflicting_schemas' => $conflictingList,
                ]);
            }

            return response()->json([
                'valid' => true,
                'message' => 'Tanggal tersedia',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Terjadi kesalahan validasi: '.$e->getMessage(),
            ], 500);
        }
    }

    public function getSchemasBySchedule($id)
    {
        try {
            $schemas = Schema::with('detailSchemas.kategori')->where('schedule_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'schemas' => $schemas,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data schema',
            ], 500);
        }
    }

    public function pendaftaranKKN(Request $request)
    {
        $status_counts = PendaftaranKKN::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        $data_pendaftaran = PendaftaranKKN::with('detailPendaftaran', 'mahasiswa', 'mahasiswa.user')->get();

        return view('dashboard.koordinator.pendaftaran_kkn', compact('data_pendaftaran', 'status_counts'));
    }

    public function pendaftaranProject(Request $request)
    {
        $status_counts = ProjectKkn::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        $data_project = ProjectKkn::all();

        return view('dashboard.koordinator.pendaftaran_project', compact('data_project', 'status_counts'));
    }

    public function pengelompokanMhs(Request $request)
    {
        $data_mahasiswa = PendaftaranKKN::whereIn('status', ['complete', 'grouped'])->get();
        $mahasiswa = Mahasiswa::whereIn('nim', $data_mahasiswa->pluck('nim'))->with('anggotaKelompok')->get();
        $prodi = Prodi::all();
        $data_dosen = User::where('role', 'dosen')->get();
        $dosen = Dosen::whereIn('id', $data_dosen->pluck('id'))->get();
        $lokasi = LokasiKkn::all();
        $project = ProjectKkn::where('status', 'complete')->get();
        $pengelompokan = DetailKelompokKkn::with(['project', 'kelompok'])->get();
        $schema = DetailSchema::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->where('kategori_id', 'SCH_003')
            ->orderBy('tgl_mulai', 'asc')
            ->first();

        return view('dashboard.koordinator.pengelompokan_mahasiswa', compact(
            'mahasiswa',
            'dosen',
            'prodi',
            'lokasi',
            'project',
            'pengelompokan',
            'schema',
        ));
    }
}
