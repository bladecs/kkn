<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
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

    public function kelolaUser(){
        return view('dashboard.admin.kelola_user');
    }
    
    public function createUser(){
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
                    'errors' => $validator->errors()
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
                        'dosen_role_type' => $request->dosen_role_type ?? null
                    ]
                ], 201);
            }
            
            return redirect()->route('dashboard_admin')
                ->with('success', 'Akun berhasil dibuat!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat akun: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal membuat akun: ' . $e->getMessage())
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
                'data' => $user
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
        $prodis = Prodi::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('nama')->get();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'prodis' => $prodis,
                    'jurusans' => $jurusans
                ]
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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            if ($user->role === 'mahasiswa') {
                $this->updateMahasiswa($request, $user);
            } else {
                $this->updateDosen($request, $user);
            }
            
            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            
            DB::commit();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil diperbarui!',
                    'data' => $user
                ]);
            }
            
            return redirect()->route('admin.users.index')
                ->with('success', 'Akun berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui akun: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui akun: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // Hapus data relasi berdasarkan role
            if ($user->role === 'mahasiswa') {
                Mahasiswa::where('id', $user->id)->delete();
            } elseif ($user->role === 'dosen') {
                Dosen::where('id', $user->id)->delete();
            }
            
            // Hapus user
            $user->delete();
            
            DB::commit();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil dihapus!'
                ]);
            }
            
            return redirect()->route('admin.users.index')
                ->with('success', 'Akun berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus akun: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
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
            'prodi_id' => ['required', 'exists:prodi,id'],
            'jurusan_id' => ['required', 'exists:jurusan,id'],
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'prodi_id' => ['required', 'exists:prodi,id'],
            'jurusan_id' => ['required', 'exists:jurusan,id'],
        ];

        if ($user->role === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:20', 
                Rule::unique('mahasiswa', 'nim')->ignore($user->id, 'id'),
                Rule::unique('users', 'id')->ignore($user->id)
            ];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
        } else {
            $rules['nip'] = ['required', 'string', 'max:30', 
                Rule::unique('dosen', 'nip')->ignore($user->id, 'id'),
                Rule::unique('users', 'id')->ignore($user->id)
            ];
            
            // Untuk update, hanya admin yang bisa ubah role type
            if (auth()->user()->role === 'admin') {
                $rules['dosen_role_type'] = ['required', 'in:dosen_biasa,koordinator'];
                
                if ($request->dosen_role_type === 'koordinator') {
                    $rules['koordinator_wilayah'] = ['nullable', 'string', 'max:100'];
                    $rules['koordinator_telepon'] = ['nullable', 'string', 'max:20'];
                }
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
            'id' => uniqid('USR' . $request->nim),
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

        // Add koordinator specific fields
        if ($role === 'koordinator') {
            $dosenData['is_koordinator'] = true;
            $dosenData['koordinator_wilayah'] = $request->koordinator_wilayah;
            $dosenData['koordinator_telepon'] = $request->koordinator_telepon;
        }

        Dosen::create($dosenData);

        return $user;
    }

    /**
     * Update Mahasiswa
     */
    private function updateMahasiswa(Request $request, User $user)
    {
        // Update User
        $user->email = $request->email;
        $user->id = $request->nim; // Update ID jika NIM berubah
        
        // Update Mahasiswa
        $mahasiswa = Mahasiswa::where('id', $user->id)->firstOrFail();
        $mahasiswa->update([
            'nim' => $request->nim,
            'name' => $request->name,
            'semester' => $request->semester,
            'prodi_id' => $request->prodi_id,
            'jurusan_id' => $request->jurusan_id,
        ]);
    }

    /**
     * Update Dosen
     */
    private function updateDosen(Request $request, User $user)
    {
        // Update User
        $user->email = $request->email;
        $user->id = $request->nip; // Update ID jika NIP berubah
        
        // Update role jika admin mengubah
        if (auth()->user()->role === 'admin') {
            $role = $request->dosen_role_type === 'koordinator' ? 'koordinator' : 'dosen';
            $user->role = $role;
        }
        
        // Update Dosen
        $dosen = Dosen::where('id', $user->id)->firstOrFail();
        $dosenData = [
            'nip' => $request->nip,
            'name' => $request->name,
            'prodi_id' => $request->prodi_id,
            'jurusan_id' => $request->jurusan_id,
        ];

        // Update koordinator fields
        if (auth()->user()->role === 'admin') {
            $dosenData['is_koordinator'] = $request->dosen_role_type === 'koordinator';
            
            if ($request->dosen_role_type === 'koordinator') {
                $dosenData['koordinator_wilayah'] = $request->koordinator_wilayah;
                $dosenData['koordinator_telepon'] = $request->koordinator_telepon;
            } else {
                $dosenData['koordinator_wilayah'] = null;
                $dosenData['koordinator_telepon'] = null;
            }
        }

        $dosen->update($dosenData);
    }

    /**
     * Toggle user status (aktif/nonaktif)
     */
    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Toggle status
            $user->is_active = !$user->is_active;
            $user->save();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status akun berhasil diubah.',
                    'data' => [
                        'is_active' => $user->is_active
                    ]
                ]);
            }
            
            return redirect()->back()
                ->with('success', 'Status akun berhasil diubah.');
                
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal mengubah status: ' . $e->getMessage());
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
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
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
                    ->orWhereHas('mahasiswa', function($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dosen', function($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('nip', 'like', "%{$search}%");
                    })
                    ->paginate(10);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $users
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
                'Content-Disposition' => 'attachment; filename="users_' . date('Y-m-d') . '.csv"',
            ];
            
            $callback = function() use ($users) {
                $file = fopen('php://output', 'w');
                
                // Header
                fputcsv($file, ['ID', 'Role', 'Email', 'Nama', 'Prodi', 'Jurusan', 'Status', 'Tanggal Daftar']);
                
                // Data
                foreach ($users as $user) {
                    $nama = '';
                    $prodi = '';
                    $jurusan = '';
                    
                    if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                        $nama = $user->mahasiswa->name;
                        $prodi = $user->mahasiswa->prodi->nama ?? '';
                        $jurusan = $user->mahasiswa->jurusan->nama ?? '';
                    } elseif (($user->role === 'dosen' || $user->role === 'koordinator') && $user->dosen) {
                        $nama = $user->dosen->name;
                        $prodi = $user->dosen->prodi->nama ?? '';
                        $jurusan = $user->dosen->jurusan->nama ?? '';
                    }
                    
                    fputcsv($file, [
                        $user->id,
                        $user->role,
                        $user->email,
                        $nama,
                        $prodi,
                        $jurusan,
                        $user->is_active ? 'Aktif' : 'Nonaktif',
                        $user->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data: ' . $e->getMessage()
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
            
            // Filter berdasarkan status jika ada
            if ($request->has('is_active') && $request->is_active !== '') {
                $query->where('is_active', $request->is_active);
            }
            
            // Search
            if ($request->has('search') && $request->search['value']) {
                $search = $request->search['value'];
                $query->where(function($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                      ->orWhere('id', 'like', "%{$search}%")
                      ->orWhereHas('mahasiswa', function($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%")
                             ->orWhere('nim', 'like', "%{$search}%");
                      })
                      ->orWhereHas('dosen', function($q2) use ($search) {
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
                'data' => $users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->mahasiswa->name ?? $user->dosen->name ?? '-',
                        'email' => $user->email,
                        'role' => $user->role,
                        'status' => $user->is_active ? 'Aktif' : 'Nonaktif',
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'actions' => view('admin.users.partials.actions', compact('user'))->render()
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}
