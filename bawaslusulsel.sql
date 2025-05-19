CREATE TABLE login (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user','guest') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Users untuk autentikasi
CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'guest') DEFAULT 'user',
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel User untuk profil pengguna (jika terpisah)
CREATE TABLE profil (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50),
    no_hp VARCHAR(20),
    alamat TEXT,
    email VARCHAR(100) UNIQUE NOT NULL,
    foto VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

-- Tabel Surat
CREATE TABLE surat (
    id_surat INT PRIMARY KEY AUTO_INCREMENT,
    jenis_surat VARCHAR(50) NOT NULL,
    tanggal DATE NOT NULL,
    pengirim VARCHAR(100) NOT NULL,
    penerima VARCHAR(100) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Administrasi
CREATE TABLE administrasi (
    id_dokumen INT PRIMARY KEY AUTO_INCREMENT,
    jenis_dokumen VARCHAR(50) NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    tanggal DATE NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Basis Data
CREATE TABLE basis_data (
    id_anggota INT PRIMARY KEY AUTO_INCREMENT,
    nama_anggota VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    stts_anggota ENUM('Aktif','Non-Aktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Laporan Bulanan
CREATE TABLE laporan_bulanan (
    id_laporan INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    bulan ENUM('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') NOT NULL,
    tahun YEAR NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    status ENUM('Draft','Disetujui','Ditolak') DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Kegiatan Rapat
CREATE TABLE kegiatan_rapat (
    id_kegiatan INT PRIMARY KEY AUTO_INCREMENT,
    jenis_kegiatan VARCHAR(50) NOT NULL,
    tanggal DATE NOT NULL,
    judul_kegiatan VARCHAR(255) NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    peserta TEXT NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Statistik Laporan
CREATE TABLE statistik_laporan (
    id_statistik INT PRIMARY KEY AUTO_INCREMENT,
    jenis_kegiatan VARCHAR(50) NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Agenda Rapat
CREATE TABLE agenda_rapat (
    id_rapat INT PRIMARY KEY AUTO_INCREMENT,
    judul_rapat VARCHAR(255) NOT NULL,
    tanggal DATE NOT NULL,
    waktu_mulai TIME NOT NULL,
    waktu_selesai TIME NOT NULL,
    tempat VARCHAR(100) NOT NULL,
    pemimpinan_rapat VARCHAR(100) NOT NULL,
    notulen VARCHAR(100) NOT NULL,
    peserta TEXT NOT NULL,
    agenda TEXT NOT NULL,
    dokumen_path VARCHAR(255),
    status ENUM('Terlaksana','Ditunda','Dibatalkan') DEFAULT 'Terlaksana',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

