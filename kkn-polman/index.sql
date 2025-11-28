-- Tabel user
CREATE TABLE user (
    id_user VARCHAR(50) PRIMARY KEY,
    email VARCHAR(150),
    password VARCHAR(255),
    role VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME
);

-- Tabel jurusan
CREATE TABLE jurusan (
    id_jurusan VARCHAR(50) PRIMARY KEY,
    nama_jurusan VARCHAR(150),
    created_at DATETIME,
    updated_at DATETIME
);

-- Tabel prodi
CREATE TABLE prodi (
    id_prodi VARCHAR(50) PRIMARY KEY,
    jurusan_id VARCHAR(50),
    nama_prodi VARCHAR(150),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id_jurusan)
);

-- Tabel mahasiswa
CREATE TABLE mahasiswa (
    nim VARCHAR(50) PRIMARY KEY,
    name VARCHAR(150),
    semester INT,
    prodi_id VARCHAR(50),
    jurusan_id VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (prodi_id) REFERENCES prodi(id_prodi),
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id_jurusan)
);

-- Tabel dosen
CREATE TABLE dosen (
    nip VARCHAR(50) PRIMARY KEY,
    name VARCHAR(150),
    prodi_id VARCHAR(50),
    jurusan_id VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (prodi_id) REFERENCES prodi(id_prodi),
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id_jurusan)
);

-- Tabel schedule
CREATE TABLE schedule (
    id_kegiatan VARCHAR(50) PRIMARY KEY,
    created_by VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (created_by) REFERENCES user(id_user)
);

-- Tabel detail_schedule
CREATE TABLE detail_schedule (
    id_detail_schedule VARCHAR(50) PRIMARY KEY,
    schedule_id VARCHAR(50),
    kloter VARCHAR(50),
    kode_kegiatan VARCHAR(50),
    deskripsi TEXT,
    tgl_mulai DATETIME,
    tgl_selesai DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (schedule_id) REFERENCES schedule(id_kegiatan)
);

-- Tabel pendaftaran_kkn
CREATE TABLE pendaftaran_kkn (
    id_pendaftaran VARCHAR(50) PRIMARY KEY,
    nim VARCHAR(50),
    status VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

-- Tabel detail_pendaftaran_kkn
CREATE TABLE detail_pendaftaran_kkn (
    id_detail_pendaftaran VARCHAR(50) PRIMARY KEY,
    no_pendaftaran VARCHAR(50),
    kloter VARCHAR(50),
    tgl DATETIME,
    semester INT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (no_pendaftaran) REFERENCES pendaftaran_kkn(id_pendaftaran)
);

-- Tabel kategori_kegiatan
CREATE TABLE kategori_kegiatan (
    id_kategori VARCHAR(50) PRIMARY KEY,
    nama VARCHAR(150),
    created_at DATETIME,
    updated_at DATETIME
);

-- Tabel kategori_schema
CREATE TABLE kategori_schema (
    id_kategori VARCHAR(50) PRIMARY KEY,
    deskripsi TEXT,
    created_at DATETIME,
    updated_at DATETIME
);

-- Tabel schema
CREATE TABLE schema (
    id_schema VARCHAR(50) PRIMARY KEY,
    approved_by VARCHAR(50),
    created_by VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (approved_by) REFERENCES user(id_user),
    FOREIGN KEY (created_by) REFERENCES user(id_user)
);

-- Tabel detail_schema
CREATE TABLE detail_schema (
    id_detail_schema VARCHAR(50) PRIMARY KEY,
    schema_id VARCHAR(50),
    kategori_id VARCHAR(50),
    tgl_mulai DATETIME,
    tgl_selesai DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (schema_id) REFERENCES schema(id_schema),
    FOREIGN KEY (kategori_id) REFERENCES kategori_schema(id_kategori)
);

-- Tabel lokasi_kkn
CREATE TABLE lokasi_kkn (
    id_lokasi VARCHAR(50) PRIMARY KEY,
    nama_lokasi VARCHAR(150),
    alamat TEXT,
    kota VARCHAR(100),
    provinsi VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
);

-- Tabel project_kkn
CREATE TABLE project_kkn (
    id_project VARCHAR(50) PRIMARY KEY,
    judul VARCHAR(255),
    deskripsi TEXT,
    lokasi_id VARCHAR(50),
    pengaju VARCHAR(150),
    status VARCHAR(50),
    approved_by VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (approved_by) REFERENCES user(id_user),
    FOREIGN KEY (lokasi_id) REFERENCES lokasi_kkn(id_lokasi)
);

-- Tabel kelompok_kkn
CREATE TABLE kelompok_kkn (
    id_kelompok VARCHAR(50) PRIMARY KEY,
    pembimbing VARCHAR(150),
    created_by VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (created_by) REFERENCES user(id_user)
);

-- Tabel detail_kelompok_kkn
CREATE TABLE detail_kelompok_kkn (
    id_detail_kelompok VARCHAR(50) PRIMARY KEY,
    kelompok_id VARCHAR(50),
    project_id VARCHAR(50),
    jumlah_anggota INT,
    tgl_mulai DATETIME,
    tgl_selesai DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (kelompok_id) REFERENCES kelompok_kkn(id_kelompok),
    FOREIGN KEY (project_id) REFERENCES project_kkn(id_project)
);

-- Tabel anggota_kelompok
CREATE TABLE anggota_kelompok (
    id_anggota VARCHAR(50) PRIMARY KEY,
    nim VARCHAR(50),
    kelompok_id VARCHAR(50),
    role_anggota VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    FOREIGN KEY (kelompok_id) REFERENCES kelompok_kkn(id_kelompok)
);

-- Tabel logbook_kegiatan
CREATE TABLE logbook_kegiatan (
    id_logbook VARCHAR(50) PRIMARY KEY,
    anggota_id VARCHAR(50),
    nilai INT,
    status VARCHAR(50),
    week INT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (anggota_id) REFERENCES anggota_kelompok(id_anggota)
);

-- Tabel detail_logbook
CREATE TABLE detail_logbook (
    id_detail_logbook VARCHAR(50) PRIMARY KEY,
    logbook_id VARCHAR(50),
    nama_kegiatan VARCHAR(255),
    kategori_id VARCHAR(50),
    deskripsi_kegiatan TEXT,
    jumlah_waktu INT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (logbook_id) REFERENCES logbook_kegiatan(id_logbook),
    FOREIGN KEY (kategori_id) REFERENCES kategori_kegiatan(id_kategori)
);

-- Tabel laporan_akhir
CREATE TABLE laporan_akhir (
    id_laporan_akhir VARCHAR(50) PRIMARY KEY,
    anggota_id VARCHAR(50),
    path VARCHAR(255),
    nilai INT,
    status VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (anggota_id) REFERENCES anggota_kelompok(id_anggota)
);