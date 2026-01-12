# Dokumentasi Sistem Manajemen KKN (Kuliah Kerja Nyata) Polman

Sistem ini adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola seluruh proses Kuliah Kerja Nyata (KKN) di Politeknik Negeri Manado. Sistem ini memfasilitasi koordinasi antara mahasiswa, dosen, dan koordinator KKN dalam mengelola pendaftaran, pengelompokan, penugasan proyek, dan penilaian.

## 📋 Daftar Isi
1. [Arsitektur Sistem](#arsitektur-sistem)
2. [Alur Umum Sistem](#alur-umum-sistem)
3. [Model Data & Relasi](#model-data--relasi)
4. [Controller & Fungsionalitas](#controller--fungsionalitas)
5. [Alur Proses Lengkap](#alur-proses-lengkap)
6. [Panduan Penggunaan Per Role](#panduan-penggunaan-per-role)

---

## 🏗️ Arsitektur Sistem

Sistem menggunakan pola **Model-View-Controller (MVC)** dengan Laravel Framework. Struktur keseluruhan:

```
kkn-polman/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/              # Admin controllers
│   │   │   ├── mahasiswa/          # Student controllers
│   │   │   ├── dosen/              # Lecturer controllers
│   │   │   ├── koordinator/        # Coordinator controllers
│   │   │   └── AuthController.php  # Authentication
│   │   └── Middleware/
│   ├── Models/                     # Database models (20+ models)
│   └── Providers/
├── database/
│   ├── migrations/                 # Database structure
│   ├── factories/                  # Data factories
│   └── seeders/                    # Data seeders
├── resources/
│   ├── views/                      # Blade templates
│   ├── css/                        # Styling
│   └── js/                         # Frontend scripts
└── routes/
    ├── web.php                     # Web routes
    └── api.php                     # API routes
```

---

## 🔄 Alur Umum Sistem

```
┌─────────────────────────────────────────────────────────────────┐
│                     SISTEM MANAJEMEN KKN                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  1. AUTENTIKASI & REGISTRASI                                     │
│     └─> Login dengan role (Mahasiswa/Dosen/Koordinator)         │
│                                                                   │
│  2. PENDAFTARAN KKN (Mahasiswa)                                  │
│     └─> Pilih kloter, IPK, semester → Persetujuan Koordinator   │
│                                                                   │
│  3. PENGAJUAN PROYEK (Dosen)                                     │
│     └─> Buat proposal proyek → Verifikasi Koordinator            │
│                                                                   │
│  4. PENGELOMPOKAN (Koordinator)                                  │
│     └─> Kelompokkan mahasiswa & assign ke proyek                 │
│                                                                   │
│  5. JADWAL & SKEMA (Koordinator)                                 │
│     └─> Buat timeline KKN dengan kategori kegiatan              │
│                                                                   │
│  6. PELAKSANAAN KKN (Mahasiswa)                                  │
│     └─> Buat logbook harian & laporan akhir                     │
│                                                                   │
│  7. PENILAIAN (Dosen)                                            │
│     └─> Nilai logbook & laporan akhir mahasiswa                 │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📊 Model Data & Relasi

### 1. **User & Authentication Models**

#### `User` (users table)
```php
// Atribut utama:
- id (PK, String)
- email (unique)
- password (hashed)
- role (enum: mahasiswa, dosen, koordinator, admin)
- name, phone, alamat, tmp_lahir, tgl_lahir, gender
- nim/nip (optional, sesuai role)

// Relasi:
- belongsTo: Mahasiswa (optional)
- belongsTo: Dosen (optional)
```

**Deskripsi**: Tabel utama untuk autentikasi. Setiap user memiliki role yang menentukan akses dan menu yang tersedia.

---

### 2. **Data Master Models**

#### `Mahasiswa` (mahasiswa table)
```php
// PK: nim (String)
// Atribut:
- id (FK to users)
- nim (String, unique)
- name
- semester
- prodi_id (FK)
- jurusan_id (FK)

// Relasi:
- belongsTo: User
- belongsTo: Prodi
- belongsTo: Jurusan
- hasMany: PendaftaranKkn
- hasMany: AnggotaKelompok
```

**Deskripsi**: Menyimpan data akademik mahasiswa. Satu mahasiswa dapat terdaftar di satu kloter KKN.

---

#### `Dosen` (dosen table)
```php
// PK: nip (String)
// Atribut:
- nip (String, unique)
- name
- prodi_id (FK)
- jurusan_id (FK)

// Relasi:
- belongsTo: Prodi
- belongsTo: Jurusan
- hasMany: ProjectKkn (sebagai pengaju)
- hasMany: KelompokKkn (sebagai pembimbing)
```

**Deskripsi**: Data dosen pembimbing KKN. Dosen dapat mengajukan proyek dan membimbing kelompok.

---

#### `Jurusan` & `Prodi` (jurusan, prodi tables)
```php
// Relasi one-to-many:
- Jurusan hasMany Prodi
- Prodi belongsTo Jurusan
```

**Deskripsi**: Master data struktur organisasi akademik.

---

### 3. **KKN Process Models**

#### `PendaftaranKkn` (pendaftaran_kkn table)
```php
// PK: id_pendaftaran (String)
// Atribut:
- id_pendaftaran
- nim (FK to mahasiswa)
- status (enum: pending, complete, rejected)
- created_at, updated_at

// Relasi:
- belongsTo: Mahasiswa
- hasMany: DetailPendaftaranKkn
```

**Deskripsi**: Melacak pendaftaran KKN setiap mahasiswa. Status diperbarui oleh koordinator.

---

#### `DetailPendaftaranKkn` (detail_pendaftaran_kkn table)
```php
// PK: id_detail_pendaftaran
// Atribut:
- no_pendaftaran (FK to pendaftaran_kkn)
- kloter (Integer, 1-4)
- semester (Integer)
- ipk (Float, optional)

// Relasi:
- belongsTo: PendaftaranKkn
```

**Deskripsi**: Detail spesifik pendaftaran (kloter, semester, IPK).

---

#### `ProjectKkn` (project_kkn table)
```php
// PK: id_project
// Atribut:
- id_project
- judul (String)
- deskripsi (Text)
- lokasi_id (FK)
- pengaju (FK to dosen.nip)
- status (enum: pending, complete, rejected)
- approved_by (FK to users, nullable)
- created_at, updated_at

// Relasi:
- belongsTo: Dosen (pengaju)
- belongsTo: LokasiKkn
- belongsTo: User (approver)
- hasMany: DetailKelompokKkn
```

**Deskripsi**: Proyek KKN yang diajukan dosen. Perlu diverifikasi koordinator sebelum digunakan.

---

#### `LokasiKkn` (lokasi_kkn table)
```php
// PK: id_lokasi
// Atribut:
- nama_lokasi
- deskripsi
- alamat
- kontak

// Relasi:
- hasMany: ProjectKkn
```

**Deskripsi**: Lokasi pelaksanaan KKN.

---

### 4. **Grouping & Assignment Models**

#### `KelompokKkn` (kelompok_kkn table)
```php
// PK: id_kelompok
// Atribut:
- id_kelompok (String)
- pembimbing (FK to dosen.nip)
- created_by (FK to users)
- status (enum: active, inactive)
- created_at, updated_at

// Relasi:
- belongsTo: Dosen (pembimbing)
- belongsTo: User (creator)
- hasMany: DetailKelompokKkn
- hasMany: AnggotaKelompok
```

**Deskripsi**: Pengelompokan mahasiswa untuk KKN. Satu kelompok dipimpin oleh satu dosen pembimbing.

---

#### `AnggotaKelompok` (anggota_kelompok table)
```php
// PK: id_anggota
// Atribut:
- id_anggota (String)
- kelompok_id (FK to kelompok_kkn)
- nim (FK to mahasiswa)
- status (enum: active, inactive)

// Relasi:
- belongsTo: KelompokKkn
- belongsTo: Mahasiswa
- hasMany: LogbookKegiatan
- hasMany: LaporanAkhir
```

**Deskripsi**: Daftar anggota dalam satu kelompok KKN.

---

#### `DetailKelompokKkn` (detail_kelompok_kkn table)
```php
// PK: id_detail_kelompok
// Atribut:
- kelompok_id (FK)
- project_id (FK)
- status

// Relasi:
- belongsTo: KelompokKkn
- belongsTo: ProjectKkn
```

**Deskripsi**: Relasi many-to-many antara kelompok dan proyek yang ditugaskan.

---

### 5. **Schedule & Schema Models**

#### `Schedule` (schedule table)
```php
// PK: id_kegiatan
// Atribut:
- id_kegiatan
- created_by (FK to users)

// Relasi:
- belongsTo: User
- hasMany: DetailSchedule
```

**Deskripsi**: Master jadwal KKN per kloter.

---

#### `DetailSchedule` (detail_schedule table)
```php
// PK: id_detail_schedule
// Atribut:
- schedule_id (FK)
- kloter (Integer, unique)
- deskripsi (Text)
- tgl_mulai (Date)
- tgl_selesai (Date)

// Relasi:
- belongsTo: Schedule
- hasMany: DetailSchema
```

**Deskripsi**: Detail jadwal per kloter (tanggal mulai/selesai, deskripsi).

---

#### `Schema` (schema table)
```php
// PK: id_schema
// Atribut:
- id_schema
- created_by (FK to users)

// Relasi:
- belongsTo: User
- hasMany: DetailSchema
```

**Deskripsi**: Master skema kegiatan KKN.

---

#### `DetailSchema` (detail_schema table)
```php
// PK: id_detail_schema
// Atribut:
- schedule_id (FK)
- schema_id (FK)
- kategori_id (FK)
- fase (String)
- tgl_mulai (Date)
- tgl_selesai (Date)
- jumlah_jam (Integer)
- deskripsi (Text)

// Relasi:
- belongsTo: DetailSchedule
- belongsTo: Schema
- belongsTo: KategoriKegiatan
```

**Deskripsi**: Rincian skema kegiatan per kategori dalam jadwal KKN.

---

### 6. **Activity & Logbook Models**

#### `KategoriKegiatan` (kategori_kegiatan table)
```php
// PK: id_kategori
// Atribut:
- nama_kategori
- deskripsi
- warna (untuk UI)

// Relasi:
- hasMany: DetailLogbook
- hasMany: DetailSchema
```

**Deskripsi**: Kategori jenis kegiatan KKN (misalnya: survey, pelatihan, pembangunan, dll).

---

#### `LogbookKegiatan` (logbook_kegiatan table)
```php
// PK: id_logbook
// Atribut:
- id_logbook
- anggota_id (FK to anggota_kelompok)
- kelompok_id (FK to kelompok_kkn)
- nilai (Float, nullable, diisi dosen)
- status (enum: pending, submitted, approved, rejected)
- week (Integer, minggu ke-)

// Relasi:
- belongsTo: AnggotaKelompok
- hasMany: DetailLogbook
```

**Deskripsi**: Logbook mingguan per anggota kelompok. Dosen akan memberikan nilai.

---

#### `DetailLogbook` (detail_logbook table)
```php
// PK: id_detail_logbook
// Atribut:
- logbook_id (FK)
- kategori_id (FK)
- nama_kegiatan
- deskripsi_kegiatan
- jumlah_waktu (dalam menit, 15-480)
- tanggal
- keterangan (optional)

// Relasi:
- belongsTo: LogbookKegiatan
- belongsTo: KategoriKegiatan
```

**Deskripsi**: Detail kegiatan harian yang tercatat dalam logbook.

---

#### `LaporanAkhir` (laporan_akhir table)
```php
// PK: id_laporan_akhir
// Atribut:
- id_laporan_akhir
- kelompok_id (FK)
- anggota_id (FK)
- path_pdf (File path)
- path_ppt (File path)
- catatan (Text)
- comment (Text, dari dosen)
- link_tambahan (URL, optional)
- nilai (Float, nullable)
- status (enum: pending, submitted, approved, rejected)

// Relasi:
- belongsTo: AnggotaKelompok
- belongsTo: KelompokKkn
```

**Deskripsi**: Laporan akhir KKN per anggota. Berisi file PDF, presentasi, dan catatan.

---

## 🎮 Controller & Fungsionalitas

### **1. AuthController**
**File**: `app/Http/Controllers/AuthController.php`

**Fungsi Utama**:
- `showAuthForm()`: Tampilkan form login/register
- `login()`: Autentikasi user, set session dengan role
- `register()`: Registrasi user baru (mahasiswa)
- `getProdi()`: AJAX untuk fetch prodi berdasarkan jurusan
- `logout()`: Logout user

**Alur Login**:
```
POST /login
  ↓
[AuthController::login]
  ↓
Validasi email & password
  ↓
Ambil data mahasiswa/dosen sesuai role
  ↓
Set session (id, nim, nip, role, etc)
  ↓
Redirect ke dashboard sesuai role
```

---

### **2. MahasiswaController**
**File**: `app/Http/Controllers/mahasiswa/MahasiswaController.php`

#### `pendaftaran(Request $request)`
**Endpoint**: `POST /form-submit`
**Tujuan**: Mahasiswa mendaftar KKN

**Alur**:
```
Form pendaftaran (kloter, IPK, semester)
  ↓
Validasi input
  ↓
Generate ID pendaftaran (uniqid)
  ↓
Create PendaftaranKkn (status: pending)
  ↓
Create DetailPendaftaranKkn (dengan detail kloter, semester)
  ↓
Redirect dashboard dengan pesan sukses
```

**Database Impact**:
- Insert ke `pendaftaran_kkn` (1 record)
- Insert ke `detail_pendaftaran_kkn` (1 record)

---

#### `updateDataDiri(Request $request)`
**Endpoint**: `POST /update-data-diri`
**Tujuan**: Update profil mahasiswa

**Validasi**:
- name, email, phone, nim, tempat_lahir, tanggal_lahir, gender, alamat

**Database Impact**:
- Update `users` table dengan field-field di atas

---

#### `storeLaporanHarian(Request $request)`
**Endpoint**: `POST /logbook-submit`
**Tujuan**: Submit logbook harian

**Input Data**:
```php
[
    'tanggal' => date,
    'week' => integer (1-13),
    'kelompok' => string (ID kelompok),
    'keterangan' => text (optional),
    'kegiatan' => [
        [
            'nama_kegiatan' => string,
            'kategori_id' => exists in kategori_kegiatan,
            'deskripsi_kegiatan' => text,
            'jumlah_waktu' => integer (15-480 menit)
        ],
        // ... multiple kegiatan
    ]
]
```

**Alur**:
```
Validasi semua input
  ↓
Generate ID logbook (uniqid)
  ↓
Create LogbookKegiatan (status: pending)
  ↓
Loop setiap kegiatan → Create DetailLogbook
  ↓
Commit transaction
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Insert 1 record ke `logbook_kegiatan`
- Insert N records ke `detail_logbook` (N = jumlah kegiatan)

---

#### `storeLaporanAkhir(Request $request)`
**Endpoint**: `POST /submit-laporan-akhir`
**Tujuan**: Submit laporan akhir KKN

**Input Data**:
```php
[
    'kelompok_id' => string,
    'path_pdf' => file,
    'path_ppt' => file,
    'catatan' => text,
    'link_tambahan' => url (optional)
]
```

**Alur**:
```
Validasi input & upload file
  ↓
Generate ID laporan (uniqid)
  ↓
Store file ke storage (pdf & ppt)
  ↓
Create LaporanAkhir dengan path file
  ↓
Set status: pending (menunggu approval dosen)
```

**Database Impact**:
- Insert ke `laporan_akhir`

---

### **3. KoordinatorController**
**File**: `app/Http/Controllers/koordinator/KoordinatorController.php`

#### `verifikasiPendaftaran(Request $request)`
**Endpoint**: `PUT /verifikasi-pendaftaran`
**Tujuan**: Koordinator verifikasi pendaftaran mahasiswa

**Input**:
```php
[
    'nim' => string (must exist in pendaftaran_kkn),
    'status' => enum (complete, rejected)
]
```

**Alur**:
```
Validasi NIM & status
  ↓
Update PendaftaranKkn.status
  ↓
Redirect dengan pesan sukses
```

**Status Meanings**:
- `pending`: Menunggu verifikasi koordinator
- `complete`: Pendaftaran diterima, mahasiswa eligible untuk pengelompokan
- `rejected`: Pendaftaran ditolak (tidak memenuhi syarat)

---

#### `verifikasiProject(Request $request)`
**Endpoint**: `PUT /verifikasi-project`
**Tujuan**: Koordinator verifikasi proyek dari dosen

**Input**:
```php
[
    'nip' => string (NIP dosen pengaju),
    'status' => enum (complete, rejected)
]
```

**Alur**:
```
Validasi NIP dosen
  ↓
Cari ProjectKkn dengan pengaju = NIP
  ↓
Update status & approved_by (set ke koordinator ID)
```

---

#### `createSchedule(Request $request)`
**Endpoint**: `POST /submit-schedule`
**Tujuan**: Buat jadwal KKN untuk satu kloter

**Input Data**:
```php
[
    'kloter' => integer (1-4, unique),
    'deskripsi' => string (max 250),
    'tgl_mulai' => date,
    'tgl_selesai' => date
]
```

**Alur**:
```
Validasi input (kloter harus unique)
  ↓
Generate schedule ID (uniqid)
  ↓
BEGIN TRANSACTION
  ↓
Create Schedule record
  ↓
Create DetailSchedule dengan tanggal & deskripsi
  ↓
COMMIT
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Insert 1 record ke `schedule`
- Insert 1 record ke `detail_schedule`

---

#### `updateSchedule(Request $request)`
**Endpoint**: `PUT /update-schedule/{id}`
**Tujuan**: Update jadwal yang sudah ada

**Input**: Same as createSchedule

**Database Impact**:
- Update `detail_schedule` record

---

#### `createSchema(Request $request)`
**Endpoint**: `POST /submit-schema`
**Tujuan**: Buat skema kegiatan per kategori dalam jadwal

**Input Data**:
```php
[
    'schedule_id' => string (FK to detail_schedule),
    'kategori_id' => string (FK to kategori_kegiatan),
    'fase' => string (description),
    'tgl_mulai' => date,
    'tgl_selesai' => date,
    'jumlah_jam' => integer,
    'deskripsi' => text
]
```

**Alur**:
```
Validasi semua input
  ↓
Check date conflict dengan schema lain
  ↓
Generate schema ID
  ↓
Create DetailSchema
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Insert 1 record ke `detail_schema`

---

#### `buatPengelompokan(Request $request)`
**Endpoint**: `POST /buat-pengelompokan`
**Tujuan**: Buat kelompok KKN dan assign mahasiswa

**Input Data**:
```php
[
    'pembimbing' => string (NIP dosen),
    'mahasiswa' => [
        'nim1', 'nim2', 'nim3', ...
    ]
]
```

**Alur**:
```
Validasi pembimbing & mahasiswa
  ↓
Generate kelompok ID
  ↓
BEGIN TRANSACTION
  ↓
Create KelompokKkn dengan pembimbing
  ↓
Loop setiap mahasiswa:
    └─> Create AnggotaKelompok
  ↓
COMMIT
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Insert 1 record ke `kelompok_kkn`
- Insert N records ke `anggota_kelompok`

---

#### `editPengelompokan(Request $request)`
**Endpoint**: `PUT /update-pengelompokan`
**Tujuan**: Edit kelompok yang sudah ada

**Operasi Umum**:
- Ubah pembimbing
- Tambah/hapus anggota

**Database Impact**:
- Update `kelompok_kkn`
- Insert/Delete di `anggota_kelompok`

---

#### `deletePengelompokan(Request $request)`
**Endpoint**: `DELETE /delete-pengelompokan`
**Tujuan**: Hapus kelompok

**Alur**:
```
Validasi kelompok ID
  ↓
Delete anggota_kelompok (cascade)
  ↓
Delete kelompok_kkn
  ↓
Redirect dengan pesan sukses
```

---

### **4. DosenController**
**File**: `app/Http/Controllers/dosen/DosenController.php`

#### `pengajuanProject(Request $request)`
**Endpoint**: `POST /submit-pengajuan-project`
**Tujuan**: Dosen mengajukan proyek KKN

**Input Data**:
```php
[
    'judul' => string,
    'deskripsi' => text,
    'lokasi_id' => string (FK to lokasi_kkn),
    'nip' => string (dosen NIP)
]
```

**Alur**:
```
Validasi semua input
  ↓
Generate project ID
  ↓
Create ProjectKkn (status: pending)
  ↓
Set pengaju = dosen NIP
  ↓
Redirect dengan pesan sukses (menunggu verifikasi koordinator)
```

**Database Impact**:
- Insert 1 record ke `project_kkn`

---

#### `submitNilaiLogbook(Request $request)`
**Endpoint**: `PUT /nilai-logbook`
**Tujuan**: Dosen memberikan nilai untuk logbook mingguan

**Input Data**:
```php
[
    'logbook_id' => string,
    'nilai' => float (0-100)
]
```

**Alur**:
```
Validasi logbook ID & nilai
  ↓
Update LogbookKegiatan.nilai
  ↓
Update status ke 'approved' (optional)
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Update `logbook_kegiatan`

---

#### `submitNilaiLaporanAkhir(Request $request)`
**Endpoint**: `PUT /nilai-laporan-akhir`
**Tujuan**: Dosen memberikan nilai untuk laporan akhir

**Input Data**:
```php
[
    'laporan_id' => string,
    'nilai' => float (0-100),
    'comment' => text (optional)
]
```

**Alur**:
```
Validasi laporan ID & nilai
  ↓
Update LaporanAkhir.nilai & comment
  ↓
Update status ke 'approved'
  ↓
Redirect dengan pesan sukses
```

**Database Impact**:
- Update `laporan_akhir`

---

## 🎯 Alur Proses Lengkap

### **FASE 1: PERSIAPAN & SETUP**

#### Step 1: Admin/Koordinator Setup Master Data
```
[Admin Dashboard]
├─> Create Jurusan & Prodi
├─> Create Lokasi KKN
├─> Create Kategori Kegiatan
├─> Import data Mahasiswa
└─> Import data Dosen
```

**Models Affected**:
- Jurusan, Prodi, LokasiKkn, KategoriKegiatan, Mahasiswa, Dosen

**Database Tables**:
- jurusan, prodi, lokasi_kkn, kategori_kegiatan, mahasiswa, dosen

---

#### Step 2: Koordinator Buat Jadwal KKN
```
[Koordinator Dashboard]
│
└─> Form Jadwal (/form_schedule)
    │
    ├─ Input Kloter (1-4)
    ├─ Input Tanggal Mulai
    ├─ Input Tanggal Selesai
    ├─ Input Deskripsi
    │
    └─> Submit (/submit-schedule)
        │
        └─> KoordinatorController::createSchedule()
            │
            ├─> Generate Schedule ID
            ├─> Create Schedule
            ├─> Create DetailSchedule
            └─> Commit
```

**Database Changes**:
- `schedule` : Insert 1 record
- `detail_schedule` : Insert 1 record

**Result**: Jadwal KKN terbuat per kloter

---

#### Step 3: Koordinator Buat Skema Kegiatan
```
[Koordinator Dashboard]
│
└─> Form Skema (/form_schema)
    │
    ├─ Select Schedule (kloter)
    ├─ Select Kategori Kegiatan
    ├─ Input Fase (nama fase)
    ├─ Input Tanggal Mulai & Selesai
    ├─ Input Jumlah Jam
    ├─ Input Deskripsi
    │
    └─> Submit (/submit-schema)
        │
        └─> KoordinatorController::createSchema()
            │
            ├─> Validasi date conflict
            ├─> Generate Schema ID
            ├─> Create DetailSchema
            └─> Redirect
```

**Database Changes**:
- `detail_schema` : Insert 1+ record (per kategori)

**Result**: Timeline kegiatan KKN terbentuk

---

### **FASE 2: PENDAFTARAN**

#### Step 1: Mahasiswa Daftar KKN
```
[Mahasiswa Dashboard]
│
└─> Form Pendaftaran (/form)
    │
    ├─ Select Kloter (1-4)
    ├─ Input IPK
    ├─ Input Semester
    │
    └─> Submit (/form-submit)
        │
        └─> MahasiswaController::pendaftaran()
            │
            ├─> Validasi input
            ├─> Generate ID Pendaftaran
            ├─> Create PendaftaranKkn (status: pending)
            ├─> Create DetailPendaftaranKkn
            └─> Redirect dashboard dengan pesan sukses
```

**Database Changes**:
- `pendaftaran_kkn` : Insert 1 record (status: pending)
- `detail_pendaftaran_kkn` : Insert 1 record

**Result**: Mahasiswa terdaftar, menunggu verifikasi koordinator

---

#### Step 2: Koordinator Verifikasi Pendaftaran
```
[Koordinator Dashboard]
│
└─> Halaman Pendaftaran KKN (/pendaftaran-kkn)
    │
    ├─ View daftar pendaftaran (status: pending)
    │
    ├─ Per mahasiswa:
    │  ├─ Review data (NIM, semester, IPK)
    │  ├─ Tombol "Terima" atau "Tolak"
    │
    └─> Submit verifikasi (/verifikasi-pendaftaran)
        │
        └─> KoordinatorController::verifikasiPendaftaran()
            │
            ├─> Update PendaftaranKkn.status → 'complete' atau 'rejected'
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `pendaftaran_kkn` : Update status field

**Result**: Mahasiswa diterima atau ditolak. Jika diterima → eligible untuk pengelompokan

---

### **FASE 3: PENGAJUAN PROYEK**

#### Step 1: Dosen Ajukan Proyek
```
[Dosen Dashboard]
│
└─> Form Pengajuan Proyek (/form-pengajuan-kkn-dosen)
    │
    ├─ Input Judul Proyek
    ├─ Input Deskripsi Detail
    ├─ Select Lokasi KKN
    │
    └─> Submit (/submit-pengajuan-project)
        │
        └─> DosenController::pengajuanProject()
            │
            ├─> Validasi input
            ├─> Generate Project ID
            ├─> Create ProjectKkn (status: pending)
            ├─> Set pengaju = dosen NIP
            └─> Redirect dashboard
```

**Database Changes**:
- `project_kkn` : Insert 1 record (status: pending)

**Result**: Proyek terdaftar, menunggu verifikasi koordinator

---

#### Step 2: Koordinator Verifikasi Proyek
```
[Koordinator Dashboard]
│
└─> Halaman Pendaftaran Project (/pendaftaran-project)
    │
    ├─ View daftar project (status: pending)
    │
    ├─ Per project:
    │  ├─ Review judul & deskripsi
    │  ├─ Review lokasi
    │  ├─ Tombol "Verifikasi" atau "Tolak"
    │
    └─> Submit verifikasi (/verifikasi-project)
        │
        └─> KoordinatorController::verifikasiProject()
            │
            ├─> Update ProjectKkn.status → 'complete' atau 'rejected'
            ├─> Set ProjectKkn.approved_by = koordinator ID
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `project_kkn` : Update status & approved_by fields

**Result**: Proyek verified, siap diassign ke kelompok

---

### **FASE 4: PENGELOMPOKAN**

#### Step 1: Koordinator Buat Kelompok
```
[Koordinator Dashboard]
│
└─> Halaman Pengelompokan Mahasiswa (/pengelompokan)
    │
    ├─ Form Buat Kelompok:
    │  ├─ Select Dosen Pembimbing
    │  ├─ Checkbox Mahasiswa (yang sudah verified)
    │  │   (hanya tampil mahasiswa dengan status: complete)
    │  └─ Tombol "Buat Kelompok"
    │
    └─> Submit (/buat-pengelompokan)
        │
        └─> KoordinatorController::buatPengelompokan()
            │
            ├─> Validasi pembimbing & list mahasiswa
            ├─> Generate Kelompok ID
            ├─> BEGIN TRANSACTION
            ├─> Create KelompokKkn
            ├─> Loop mahasiswa → Create AnggotaKelompok
            ├─> COMMIT
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `kelompok_kkn` : Insert 1 record
- `anggota_kelompok` : Insert N records (N = jumlah anggota)

**Result**: Kelompok terbentuk dengan anggota & pembimbing

---

#### Step 2: Koordinator Assign Proyek ke Kelompok
```
[Koordinator Dashboard]
│
└─> Halaman Pengelompokan Mahasiswa (/pengelompokan)
    │
    ├─ Per kelompok (yang sudah terbuat):
    │  ├─ Tampilkan list project (yang sudah verified)
    │  ├─ Select project untuk kelompok ini
    │  └─ Tombol "Assign"
    │
    └─> Submit update (/update-pengelompokan)
        │
        └─> KoordinatorController::editPengelompokan()
            │
            ├─> Validasi kelompok & project
            ├─> Update/Create DetailKelompokKkn
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `detail_kelompok_kkn` : Insert 1 record (kelompok ↔ project)

**Result**: Kelompok tertugasi ke satu atau lebih proyek

---

### **FASE 5: PELAKSANAAN KKN**

#### Step 1: Mahasiswa Buat Logbook Harian
```
[Mahasiswa Dashboard]
│
└─> Menu "Pelaporan Harian" (/pelaporan-harian)
    │
    ├─ Form Logbook:
    │  ├─ Input Tanggal
    │  ├─ Select Minggu ke- (1-13)
    │  ├─ Select Kelompok
    │  ├─ Input Keterangan Umum
    │  │
    │  ├─ Dynamic Kegiatan (add/remove):
    │  │  ├─ Input Nama Kegiatan
    │  │  ├─ Select Kategori
    │  │  ├─ Input Deskripsi
    │  │  ├─ Input Durasi (15-480 menit)
    │  │  └─ [Remove button]
    │  │
    │  └─ Tombol "Submit Logbook"
    │
    └─> Submit (/logbook-submit)
        │
        └─> MahasiswaController::storeLaporanHarian()
            │
            ├─> Validasi tanggal, week, kategori, durasi
            ├─> Generate Logbook ID
            ├─> BEGIN TRANSACTION
            ├─> Create LogbookKegiatan (status: pending)
            ├─> Loop kegiatan → Create DetailLogbook
            ├─> COMMIT
            └─> Redirect dashboard dengan pesan sukses
```

**Database Changes**:
- `logbook_kegiatan` : Insert 1 record per minggu per mahasiswa
- `detail_logbook` : Insert N records (N = jumlah kegiatan)

**Result**: Logbook mingguan tercatat, menunggu penilaian dosen

---

#### Step 2: Dosen Nilai Logbook
```
[Dosen Dashboard]
│
└─> Menu "Penilaian Logbook" (/penilaian-logbook)
    │
    ├─ View logbook list:
    │  ├─ Filter by mahasiswa/kelompok
    │  ├─ List logbook dengan status: pending
    │  │
    │  ├─ Per logbook:
    │  │  ├─ Tampilkan detail kegiatan
    │  │  ├─ Input Nilai (0-100)
    │  │  └─ Tombol "Beri Nilai"
    │
    └─> Submit nilai (/nilai-logbook)
        │
        └─> DosenController::submitNilaiLogbook()
            │
            ├─> Validasi logbook ID & nilai
            ├─> Update LogbookKegiatan.nilai
            ├─> Update status → 'approved' (optional)
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `logbook_kegiatan` : Update nilai field

**Result**: Logbook mendapat nilai dari dosen

---

#### Step 3: Mahasiswa Buat Laporan Akhir
```
[Mahasiswa Dashboard]
│
└─> Menu "Pelaporan Akhir" (/pelaporan-akhir)
    │
    ├─ Form Laporan Akhir:
    │  ├─ Upload File PDF (laporan)
    │  ├─ Upload File PPT (presentasi)
    │  ├─ Input Catatan
    │  ├─ Input Link Tambahan (optional)
    │  └─ Tombol "Submit Laporan"
    │
    └─> Submit (/submit-laporan-akhir)
        │
        └─> MahasiswaController::storeLaporanAkhir()
            │
            ├─> Validasi file (PDF & PPT)
            ├─> Upload files ke storage
            ├─> Generate Laporan ID
            ├─> Create LaporanAkhir (status: pending)
            ├─> Save file paths
            └─> Redirect dashboard dengan pesan sukses
```

**Database Changes**:
- `laporan_akhir` : Insert 1 record per mahasiswa

**Result**: Laporan akhir tersimpan, menunggu penilaian dosen

---

### **FASE 6: PENILAIAN AKHIR**

#### Step 1: Dosen Nilai Laporan Akhir
```
[Dosen Dashboard]
│
└─> Menu "Penilaian Laporan Akhir" (/panilaian-laporan-akhir)
    │
    ├─ View laporan list:
    │  ├─ Filter by mahasiswa/kelompok
    │  ├─ List laporan dengan status: pending/submitted
    │  │
    │  ├─ Per laporan:
    │  │  ├─ Download/preview PDF & PPT
    │  │  ├─ Tampilkan catatan mahasiswa
    │  │  ├─ Input Nilai (0-100)
    │  │  ├─ Input Comment
    │  │  └─ Tombol "Beri Nilai"
    │
    └─> Submit nilai (/nilai-laporan-akhir)
        │
        └─> DosenController::submitNilaiLaporanAkhir()
            │
            ├─> Validasi laporan ID & nilai
            ├─> Update LaporanAkhir.nilai
            ├─> Update LaporanAkhir.comment
            ├─> Update status → 'approved'
            └─> Redirect dengan pesan sukses
```

**Database Changes**:
- `laporan_akhir` : Update nilai, comment, status fields

**Result**: Laporan akhir dinilai, proses KKN selesai

---

### **REKAPITULASI ALUR DATA**

```
DATABASE FLOW DIAGRAM:

┌──────────────────────────────────────────────────────────────┐
│ FASE 1: SETUP                                                │
└──────────────────────────────────────────────────────────────┘
  schedule table
    ↓
  detail_schedule table (timeline per kloter)
    ↓
  detail_schema table (aktivitas per periode)

┌──────────────────────────────────────────────────────────────┐
│ FASE 2: PENDAFTARAN MAHASISWA                                │
└──────────────────────────────────────────────────────────────┘
  mahasiswa table (existing)
    ↓
  pendaftaran_kkn table (created)
    ↓
  detail_pendaftaran_kkn table (details)
    ↓
  [Koordinator verifikasi] → status = complete/rejected

┌──────────────────────────────────────────────────────────────┐
│ FASE 3: PENGAJUAN PROYEK                                     │
└──────────────────────────────────────────────────────────────┘
  dosen table (existing)
    ↓
  project_kkn table (created)
    ↓
  [Koordinator verifikasi] → status = complete/rejected

┌──────────────────────────────────────────────────────────────┐
│ FASE 4: PENGELOMPOKAN                                        │
└──────────────────────────────────────────────────────────────┘
  pendaftaran_kkn (status = complete)
    ↓
  kelompok_kkn table (created)
    ↓
  anggota_kelompok table (members)
    ↓
  detail_kelompok_kkn table (kelompok ↔ project)

┌──────────────────────────────────────────────────────────────┐
│ FASE 5: PELAKSANAAN                                          │
└──────────────────────────────────────────────────────────────┘
  anggota_kelompok (existing)
    ↓
  logbook_kegiatan table (weekly logs)
    ↓
  detail_logbook table (activities per day)
    ↓
  [Dosen memberi nilai]
    ↓
  logbook_kegiatan.nilai (updated)

┌──────────────────────────────────────────────────────────────┐
│ FASE 6: LAPORAN AKHIR                                        │
└──────────────────────────────────────────────────────────────┘
  anggota_kelompok (existing)
    ↓
  laporan_akhir table (created)
    ↓
  [Dosen memberi nilai]
    ↓
  laporan_akhir.nilai & .comment (updated)
    ↓
  [KKN SELESAI]
```

---

## 👥 Panduan Penggunaan Per Role

### **ROLE 1: MAHASISWA**

**Akses Menu**:
- Dashboard (`/dashboard-mhs`)
- Data Diri (`/data-diri`)
- Form Pendaftaran KKN (`/form`)
- Pelaporan Harian (`/pelaporan-harian`)
- Pelaporan Akhir (`/pelaporan-akhir`)

**Workflow**:
```
1. Login dengan akun mahasiswa
   ↓
2. Update Data Diri (nama, email, alamat, dsb)
   ↓
3. Daftar KKN → pilih kloter, input IPK & semester
   [Status: pending, menunggu verifikasi]
   ↓
4. Tunggu verifikasi koordinator
   [Koordinator akan accept/reject]
   ↓
5. Jika diterima → lanjut ke pengelompokan
   [Koordinator mengelompokkan & assign proyek]
   ↓
6. Selama KKN berlangsung → input logbook harian setiap hari
   - Tanggal, minggu ke-, daftar kegiatan & durasi
   [Dosen akan memberikan nilai]
   ↓
7. Setelah KKN selesai → upload laporan akhir
   - File PDF (laporan)
   - File PPT (presentasi)
   [Dosen akan memberikan nilai akhir]
   ↓
8. KKN selesai, tunggu pengumuman nilai final
```

**Key Models**:
- Mahasiswa, User, PendaftaranKkn, DetailPendaftaranKkn
- AnggotaKelompok, LogbookKegiatan, DetailLogbook
- LaporanAkhir

**Key Controllers**:
- MahasiswaController

---

### **ROLE 2: DOSEN**

**Akses Menu**:
- Dashboard (`/dashboard-dosen`)
- Form Pengajuan Proyek (`/form-pengajuan-kkn-dosen`)
- Penilaian Logbook (`/penilaian-logbook`)
- Penilaian Laporan Akhir (`/panilaian-laporan-akhir`)

**Workflow**:
```
1. Login dengan akun dosen
   ↓
2. Ajukan Proyek KKN
   - Judul, deskripsi, lokasi
   [Status: pending, menunggu verifikasi koordinator]
   ↓
3. Tunggu verifikasi koordinator
   [Koordinator akan accept/reject]
   ↓
4. Jika project disetujui → bisa menjadi pembimbing kelompok
   [Koordinator akan assign kelompok ke dosen]
   ↓
5. Selama KKN → bimbing kelompok & nilai logbook mingguan
   - Lihat list logbook mahasiswa
   - Beri nilai (0-100) per logbook
   ↓
6. Akhir KKN → nilai laporan akhir mahasiswa
   - Download & review PDF/PPT
   - Beri nilai (0-100) & comment
   ↓
7. Semua penilaian selesai
```

**Key Models**:
- Dosen, User, ProjectKkn, KelompokKkn
- AnggotaKelompok, LogbookKegiatan, LaporanAkhir

**Key Controllers**:
- DosenController, DosenDashboardController

---

### **ROLE 3: KOORDINATOR**

**Akses Menu**:
- Dashboard (`/dashboard-koordinator`)
- Form Jadwal (`/form_schedule`)
- Form Skema (`/form_schema`)
- Pendaftaran KKN (`/pendaftaran-kkn`)
- Pendaftaran Project (`/pendaftaran-project`)
- Pengelompokan Mahasiswa (`/pengelompokan`)

**Workflow**:
```
1. Login dengan akun koordinator
   ↓
2. Setup jadwal KKN untuk setiap kloter
   - Input kloter (1-4)
   - Input tanggal mulai & selesai
   [Buat Schedule & DetailSchedule]
   ↓
3. Buat skema kegiatan per kategori
   - Select schedule (kloter)
   - Input detail fase kegiatan untuk setiap kategori
   [Buat DetailSchema]
   ↓
4. Verifikasi pendaftaran mahasiswa
   - Review list pendaftaran (status: pending)
   - Accept/reject per mahasiswa
   [Update pendaftaran_kkn status]
   ↓
5. Verifikasi pengajuan proyek dari dosen
   - Review list project (status: pending)
   - Accept/reject per project
   [Update project_kkn status]
   ↓
6. Lakukan pengelompokan mahasiswa
   - Buat kelompok baru
   - Assign dosen pembimbing
   - Assign anggota mahasiswa (hanya yang sudah verified)
   [Buat KelompokKkn & AnggotaKelompok]
   ↓
7. Assign proyek ke kelompok
   - Select proyek untuk setiap kelompok
   [Buat DetailKelompokKkn]
   ↓
8. Monitor proses KKN secara keseluruhan
   - Lihat status logbook submission
   - Lihat status laporan akhir submission
   ↓
9. Selesaikan semester KKN, siapkan rapor
```

**Key Models**:
- Schedule, DetailSchedule
- Schema, DetailSchema
- PendaftaranKkn, DetailPendaftaranKkn
- ProjectKkn
- KelompokKkn, AnggotaKelompok, DetailKelompokKkn
- KategoriKegiatan, LokasiKkn

**Key Controllers**:
- KoordinatorController, KoordinatorDashboarController

---

### **ROLE 4: ADMIN**

**Catatan**: Role admin ada di routes tapi belum detail di dokumentasi ini.

**Kemungkinan Fungsi**:
- Manage users (CRUD mahasiswa, dosen, koordinator)
- Manage master data (jurusan, prodi, kategori, lokasi)
- Manage permissions & roles
- Generate reports

---

## 📊 Database Relationships Summary

```
users (1) ←──→ (1) mahasiswa
users (1) ←──→ (1) dosen
users (1) ←──→ (*) pendaftaran_kkn (created_by)
users (1) ←──→ (*) project_kkn (approved_by)
users (1) ←──→ (*) kelompok_kkn (created_by)
users (1) ←──→ (*) schedule (created_by)
users (1) ←──→ (*) schema (created_by)

jurusan (1) ←──→ (*) prodi
jurusan (1) ←──→ (*) mahasiswa
jurusan (1) ←──→ (*) dosen

prodi (1) ←──→ (*) mahasiswa
prodi (1) ←──→ (*) dosen

mahasiswa (1) ←──→ (*) pendaftaran_kkn
mahasiswa (1) ←──→ (*) anggota_kelompok

dosen (1) ←──→ (*) project_kkn (pengaju)
dosen (1) ←──→ (*) kelompok_kkn (pembimbing)

pendaftaran_kkn (1) ←──→ (*) detail_pendaftaran_kkn

lokasi_kkn (1) ←──→ (*) project_kkn

project_kkn (1) ←──→ (*) detail_kelompok_kkn

kelompok_kkn (1) ←──→ (*) anggota_kelompok
kelompok_kkn (1) ←──→ (*) detail_kelompok_kkn
kelompok_kkn (1) ←──→ (*) logbook_kegiatan

anggota_kelompok (1) ←──→ (*) logbook_kegiatan
anggota_kelompok (1) ←──→ (*) laporan_akhir

logbook_kegiatan (1) ←──→ (*) detail_logbook

kategori_kegiatan (1) ←──→ (*) detail_logbook
kategori_kegiatan (1) ←──→ (*) detail_schema

schedule (1) ←──→ (*) detail_schedule

detail_schedule (1) ←──→ (*) detail_schema

schema (1) ←──→ (*) detail_schema
```

---

## 🔒 Middleware & Security

**Middleware yang digunakan**:
- `auth`: Memastikan user sudah login
- `role:mahasiswa|dosen|koordinator|admin`: Memastikan user memiliki role yang sesuai

**Contoh route dengan middleware**:
```php
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Routes untuk mahasiswa
});

Route::middleware(['auth', 'role:koordinator'])->group(function () {
    // Routes untuk koordinator
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    // Routes untuk dosen
});
```

---

## 🚀 Setup & Installation

```bash
# Clone repository
git clone <repository-url>
cd kkn-polman

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan seed (optional, jika ada seeders)

# Build assets
npm run build

# Start server
php artisan serve
```

---

## 📝 Kesimpulan

Sistem manajemen KKN ini dirancang dengan arsitektur yang modular dan terstruktur:

1. **Setup Phase**: Admin & Koordinator menyiapkan jadwal, skema, dan data master
2. **Registration Phase**: Mahasiswa mendaftar, koordinator verifikasi
3. **Project Submission**: Dosen ajukan proyek, koordinator verifikasi
4. **Grouping Phase**: Koordinator buat kelompok dan assign mahasiswa
5. **Execution Phase**: Mahasiswa melakukan KKN dengan daily logging
6. **Assessment Phase**: Dosen memberikan nilai untuk logbook & laporan akhir

Setiap fase memiliki database transactions yang aman dan validasi input yang ketat untuk memastikan integritas data.

---

**Dokumentasi terakhir diupdate**: Desember 2025
