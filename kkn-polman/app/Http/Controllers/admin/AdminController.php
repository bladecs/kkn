<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelompok;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::count();
        $dosen = User::where('role', 'dosen')->count();
        $koordinator = User::where('role', 'koordinator')->count();
        $new_users = User::whereDate('created_at', now()->subDays(7))->paginate(15);

        return view('dashboard.admin.dashboard', compact('mahasiswa', 'dosen', 'koordinator', 'new_users'));
    }

    public function kelolaUser()
    {
        $mahasiswa = Mahasiswa::count();
        $mahasiswa_list = Mahasiswa::with('user')->paginate(10);
        $dosen = User::where('role', 'dosen')->count();
        $dosen_list = User::where('role', 'dosen')->with('dosen')->paginate(10);
        $koordinator = User::where('role', 'koordinator')->count();
        $koordinator_list = User::where('role', 'koordinator')->with('dosen')->paginate(10);
        $totalUsers = User::count();
        $new_users = User::whereDate('created_at', now()->subDays(7))->paginate(15);
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();

        return view('dashboard.admin.kelola_user', compact('mahasiswa', 'mahasiswa_list', 'dosen', 'dosen_list', 'koordinator', 'koordinator_list', 'totalUsers', 'new_users', 'jurusan', 'prodi'));
    }

    public function createUser()
    {
        $jurusan = Jurusan::with('prodi')->get();

        return view('dashboard.admin.form_create_user', compact('jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input berdasarkan role
        $validator = $this->validateUser($request);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            if ($request->role === 'mahasiswa') {
                $user = $this->createMahasiswa($request);
            } else {
                $user = $this->createDosen($request);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil dibuat!',
                    'data' => [
                        'id' => $user->id,
                        'name' => $request->name,
                        'role' => $request->role,
                        'dosen_role_type' => $request->dosen_role_type ?? null,
                    ],
                ], 201);
            }

            return redirect()->route('dashboard_admin')
                ->with('success', 'Akun berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat akun: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal membuat akun: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['mahasiswa', 'mahasiswa.prodi', 'mahasiswa.jurusan'])->findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with(['mahasiswa', 'mahasiswa.prodi', 'mahasiswa.jurusan'])->findOrFail($id);
        $prodis = Prodi::orderBy('nama_prodi')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'prodis' => $prodis,
                    'jurusans' => $jurusans,
                ],
            ]);
        }

        return view('admin.users.edit', compact('user', 'prodis', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validasi berdasarkan role user
        $validator = $this->validateUserUpdate($request, $user);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $oldUserId = $user->id; // Simpan ID lama untuk update relasi
            
            // Update user data
            $user->email = $request->email;

            // Update ID jika NIM/NIP berubah
            if ($user->role === 'mahasiswa' && $request->filled('nim') && $request->nim !== $user->mahasiswa->nim) {
                $user->id = $request->nim; // Update ID user dengan NIM baru
            } elseif (in_array($user->role, ['dosen', 'koordinator']) && $request->filled('nip') && $request->nip !== $user->dosen->nip) {
                $user->id = $request->nip; // Update ID user dengan NIP baru
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Update berdasarkan role
            if ($user->role === 'mahasiswa') {
                $this->updateMahasiswaData($user, $request, $oldUserId);
            } elseif (in_array($user->role, ['dosen', 'koordinator'])) {
                $this->updateDosenData($user, $request, $oldUserId);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil diperbarui!',
                    'data' => $user->load($user->role === 'mahasiswa' ? 'mahasiswa' : 'dosen'),
                ]);
            }

            return redirect()->route('admin.kelola.user')
                ->with('success', 'Akun berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update error: '.$e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui akun: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui akun: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update data mahasiswa dan relasi terkait
     */
    private function updateMahasiswaData(User $user, Request $request, $oldUserId)
    {
        $mahasiswa = $user->mahasiswa;
        $oldNim = $mahasiswa->nim;
        $newNim = $request->nim;

        if ($mahasiswa) {
            // Update data mahasiswa
            $mahasiswa->update([
                'id' => $user->id, // Update ID reference ke users
                'nim' => $newNim,
                'name' => $request->name,
                'semester' => $request->semester,
                'prodi_id' => $request->prodi_id,
                'jurusan_id' => $request->jurusan_id,
            ]);

            // Jika NIM berubah, update semua relasi yang menggunakan NIM
            if ($oldNim !== $newNim) {
                // Update anggota_kelompok
                DB::table('anggota_kelompok')
                    ->where('nim', $oldNim)
                    ->update(['nim' => $newNim]);

                // Update pendaftaran_kkn
                DB::table('pendaftaran_kkn')
                    ->where('nim', $oldNim)
                    ->update(['nim' => $newNim]);

                // Update user ID di tabel sessions jika ada
                DB::table('sessions')
                    ->where('user_id', $oldUserId)
                    ->update(['user_id' => $user->id]);
            }
        }
    }

    /**
     * Update data dosen dan relasi terkait
     */
    private function updateDosenData(User $user, Request $request, $oldUserId)
    {
        $dosen = $user->dosen;
        $oldNip = $dosen->nip;
        $newNip = $request->nip;

        if ($dosen) {
            // Update data dosen
            $dosen->update([
                'id' => $user->id, // Update ID reference ke users
                'nip' => $newNip,
                'name' => $request->name,
                'prodi_id' => $request->prodi_id,
                'jurusan_id' => $request->jurusan_id,
            ]);

            // Jika NIP berubah, update semua relasi yang menggunakan NIP
            if ($oldNip !== $newNip) {
                // Update kelompok_kkn (pembimbing)
                DB::table('kelompok_kkn')
                    ->where('pembimbing', $oldNip)
                    ->update(['pembimbing' => $newNip]);

                // Update project_kkn (pengaju)
                DB::table('project_kkn')
                    ->where('pengaju', $oldNip)
                    ->update(['pengaju' => $newNip]);
                    
                // Update user ID di tabel sessions jika ada
                DB::table('sessions')
                    ->where('user_id', $oldUserId)
                    ->update(['user_id' => $user->id]);
            }

            // Update role jika diubah dari admin
            if (auth()->user()->role === 'admin' && $request->filled('dosen_role_type')) {
                $newRole = $request->dosen_role_type === 'koordinator' ? 'koordinator' : 'dosen';
                
                if ($user->role !== $newRole) {
                    $user->role = $newRole;
                    $user->save();
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::with(['dosen', 'mahasiswa'])->findOrFail($id);
            $userRole = $user->role;
            $userId = $user->id;

            // Hapus data relasi berdasarkan role
            if ($userRole === 'mahasiswa' && $user->mahasiswa) {
                $nim = $user->mahasiswa->nim;
                
                // Hapus relasi yang terhubung dengan mahasiswa
                $this->deleteMahasiswaRelations($nim, $userId);
                
                // Hapus mahasiswa
                Mahasiswa::where('nim', $nim)->delete();
                
            } elseif (($userRole === 'dosen' || $userRole === 'koordinator') && $user->dosen) {
                $nip = $user->dosen->nip;
                
                // Hapus relasi yang terhubung dengan dosen
                $this->deleteDosenRelations($nip, $userId);
                
                // Hapus dosen
                Dosen::where('nip', $nip)->delete();
            }

            // Hapus user terakhir untuk menjaga foreign key constraint
            $user->delete();

            DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil dihapus!',
                ]);
            }

            return redirect()->route('admin.kelola.user')
                ->with('success', 'Akun berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete error: '.$e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus akun: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus akun: '.$e->getMessage());
        }
    }

    /**
     * Hapus semua relasi mahasiswa
     */
    private function deleteMahasiswaRelations($nim, $userId)
    {
        // Cari semua pendaftaran milik mahasiswa ini
        $pendaftaranIds = DB::table('pendaftaran_kkn')
            ->where('nim', $nim)
            ->pluck('id_pendaftaran');

        // Hapus detail_pendaftaran_kkn
        if ($pendaftaranIds->count() > 0) {
            DB::table('detail_pendaftaran_kkn')
                ->whereIn('no_pendaftaran', $pendaftaranIds)
                ->delete();
        }

        // Hapus pendaftaran_kkn
        DB::table('pendaftaran_kkn')
            ->where('nim', $nim)
            ->delete();

        // Hapus anggota_kelompok
        $anggotaIds = DB::table('anggota_kelompok')
            ->where('nim', $nim)
            ->pluck('id_anggota');

        if ($anggotaIds->count() > 0) {
            // Hapus detail logbook terkait anggota
            DB::table('detail_logbook')
                ->whereIn('logbook_id', function($query) use ($anggotaIds) {
                    $query->select('id_logbook')
                        ->from('logbook_kegiatan')
                        ->whereIn('anggota_id', $anggotaIds);
                })
                ->delete();

            // Hapus logbook kegiatan
            DB::table('logbook_kegiatan')
                ->whereIn('anggota_id', $anggotaIds)
                ->delete();

            // Hapus laporan akhir
            DB::table('laporan_akhir')
                ->whereIn('anggota_id', $anggotaIds)
                ->delete();

            // Hapus anggota kelompok
            DB::table('anggota_kelompok')
                ->where('nim', $nim)
                ->delete();
        }

        // Hapus sessions
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Hapus semua relasi dosen
     */
    private function deleteDosenRelations($nip, $userId)
    {
        // Periksa apakah dosen ini masih menjadi pembimbing di kelompok
        $kelompokIds = DB::table('kelompok_kkn')
            ->where('pembimbing', $nip)
            ->pluck('id_kelompok');

        if ($kelompokIds->count() > 0) {
            // Jika dosen masih menjadi pembimbing, set pembimbing ke NULL
            DB::table('kelompok_kkn')
                ->where('pembimbing', $nip)
                ->update(['pembimbing' => null]);
        }

        // Periksa apakah dosen ini masih menjadi pengaju project
        DB::table('project_kkn')
            ->where('pengaju', $nip)
            ->update(['pengaju' => '1225444665']); // Set ke koordinator default

        // Periksa apakah dosen ini masih menjadi approved_by di project
        DB::table('project_kkn')
            ->where('approved_by', $userId)
            ->update(['approved_by' => 'USRKOOR01']); // Set ke koordinator default

        // Periksa apakah dosen ini masih menjadi created_by di schedules
        DB::table('schedules')
            ->where('created_by', $userId)
            ->update(['created_by' => 'USRKOOR01']); // Set ke koordinator default

        // Periksa apakah dosen ini masih menjadi created_by di schemas
        DB::table('schemas')
            ->where('created_by', $userId)
            ->update(['created_by' => 'USRKOOR01']); // Set ke koordinator default

        // Periksa apakah dosen ini masih menjadi approved_by di schemas
        DB::table('schemas')
            ->where('approved_by', $userId)
            ->update(['approved_by' => 'USRKOOR01']); // Set ke koordinator default

        // Periksa apakah dosen ini masih menjadi created_by di kelompok_kkn
        DB::table('kelompok_kkn')
            ->where('created_by', $userId)
            ->update(['created_by' => 'USRKOOR01']); // Set ke koordinator default

        // Hapus sessions
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * API Store - khusus untuk request AJAX
     */
    public function apiStore(Request $request)
    {
        return $this->store($request);
    }

    /**
     * Validate user creation request
     */
    private function validateUser(Request $request)
    {
        $rules = [
            'role' => ['required', 'in:mahasiswa,dosen'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'prodi_id' => ['required', 'exists:prodi,id_prodi'],
            'jurusan_id' => ['required', 'exists:jurusan,id_jurusan'],
        ];

        if ($request->role === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:20', 'unique:mahasiswa,nim', 'unique:users,id'];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
        } else {
            $rules['nip'] = ['required', 'string', 'max:30', 'unique:dosen,nip', 'unique:users,id'];
            $rules['dosen_role_type'] = ['required', 'in:dosen_biasa,koordinator'];

            // Validasi untuk koordinator
            if ($request->dosen_role_type === 'koordinator') {
                $rules['koordinator_wilayah'] = ['nullable', 'string', 'max:100'];
                $rules['koordinator_telepon'] = ['nullable', 'string', 'max:20'];
            }
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * Validate user update request
     */
    private function validateUserUpdate(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ];

        // Tambahkan validasi untuk prodi_id dan jurusan_id
        if ($request->has('prodi_id')) {
            $rules['prodi_id'] = ['required', 'exists:prodi,id_prodi'];
        }
        
        if ($request->has('jurusan_id')) {
            $rules['jurusan_id'] = ['required', 'exists:jurusan,id_jurusan'];
        }

        if ($user->role === 'mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            $rules['nim'] = ['required', 'string', 'max:20',
                Rule::unique('mahasiswa')->ignore($mahasiswa ? $mahasiswa->nim : null, 'nim'),
            ];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];

        } elseif (in_array($user->role, ['dosen', 'koordinator'])) {
            $dosen = $user->dosen;
            $rules['nip'] = ['required', 'string', 'max:30',
                Rule::unique('dosen')->ignore($dosen ? $dosen->nip : null, 'nip'),
            ];
            
            // Validasi untuk role type jika admin mengubah
            if (auth()->user()->role === 'admin') {
                $rules['dosen_role_type'] = ['required', 'in:dosen_biasa,koordinator'];
            }
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * Create Mahasiswa user
     */
    private function createMahasiswa(Request $request)
    {
        // Create User
        $user = User::create([
            'id' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Create Mahasiswa
        Mahasiswa::create([
            'id' => $user->id,
            'nim' => $request->nim,
            'name' => $request->name,
            'semester' => $request->semester,
            'prodi_id' => $request->prodi_id,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return $user;
    }

    /**
     * Create Dosen user
     */
    private function createDosen(Request $request)
    {
        // Determine role based on dosen_role_type
        $role = $request->dosen_role_type === 'koordinator' ? 'koordinator' : 'dosen';

        // Create User
        $user = User::create([
            'id' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // Create Dosen
        $dosenData = [
            'id' => $user->id,
            'nip' => $request->nip,
            'name' => $request->name,
            'prodi_id' => $request->prodi_id,
            'jurusan_id' => $request->jurusan_id,
        ];

        Dosen::create($dosenData);

        return $user;
    }

    /**
     * Toggle user status (aktif/nonaktif)
     */
    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);

            // Toggle status - perlu menambahkan field is_active di tabel users jika belum ada
            $user->is_active = ! $user->is_active;
            $user->save();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status akun berhasil diubah.',
                    'data' => [
                        'is_active' => $user->is_active,
                    ],
                ]);
            }

            return redirect()->back()
                ->with('success', 'Status akun berhasil diubah.');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal mengubah status: '.$e->getMessage());
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'mahasiswa_count' => User::where('role', 'mahasiswa')->count(),
                'dosen_count' => User::where('role', 'dosen')->count(),
                'koordinator_count' => User::where('role', 'koordinator')->count(),
                'active_users' => User::where('is_active', true)->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search users
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('email', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%")
            ->orWhereHas('mahasiswa', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            })
            ->orWhereHas('dosen', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            })
            ->paginate(10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        try {
            $users = User::with(['mahasiswa', 'dosen'])->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="users_'.date('Y-m-d').'.csv"',
            ];

            $callback = function () use ($users) {
                $file = fopen('php://output', 'w');

                // Header
                fputcsv($file, ['ID', 'Role', 'Email', 'Nama', 'NIM/NIP', 'Prodi', 'Jurusan', 'Status', 'Tanggal Daftar']);

                // Data
                foreach ($users as $user) {
                    $nama = '';
                    $nimNip = '';
                    $prodi = '';
                    $jurusan = '';
                    $status = 'Aktif';

                    if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                        $nama = $user->mahasiswa->name;
                        $nimNip = $user->mahasiswa->nim;
                        $prodi = $user->mahasiswa->prodi->nama_prodi ?? '';
                        $jurusan = $user->mahasiswa->jurusan->nama_jurusan ?? '';
                    } elseif (($user->role === 'dosen' || $user->role === 'koordinator') && $user->dosen) {
                        $nama = $user->dosen->name;
                        $nimNip = $user->dosen->nip;
                        $prodi = $user->dosen->prodi->nama_prodi ?? '';
                        $jurusan = $user->dosen->jurusan->nama_jurusan ?? '';
                    }

                    fputcsv($file, [
                        $user->id,
                        $user->role,
                        $user->email,
                        $nama,
                        $nimNip,
                        $prodi,
                        $jurusan,
                        $status,
                        $user->created_at->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get users data for DataTable
     */
    public function datatable(Request $request)
    {
        try {
            $query = User::with(['mahasiswa', 'dosen']);

            // Filter berdasarkan role jika ada
            if ($request->has('role') && $request->role) {
                $query->where('role', $request->role);
            }

            // Search
            if ($request->has('search') && $request->search['value']) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                                ->orWhere('nip', 'like', "%{$search}%");
                        });
                });
            }

            // Order
            $orderColumn = $request->order[0]['column'] ?? 0;
            $orderDirection = $request->order[0]['dir'] ?? 'desc';
            $columns = ['id', 'role', 'email', 'created_at'];

            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDirection);
            }

            // Pagination
            $length = $request->length ?? 10;
            $users = $query->paginate($length);

            return response()->json([
                'draw' => $request->draw ?? 1,
                'recordsTotal' => User::count(),
                'recordsFiltered' => $users->total(),
                'data' => $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->mahasiswa->name ?? $user->dosen->name ?? '-',
                        'email' => $user->email,
                        'role' => $user->role,
                        'status' => 'Aktif',
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'actions' => view('admin.users.partials.actions', compact('user'))->render(),
                    ];
                }),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: '.$e->getMessage(),
            ], 500);
        }
    }
}