-- =============================================
-- Laravel required tables
-- =============================================

CREATE TABLE sessions (
    id          VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id     BIGINT UNSIGNED NULL,
    ip_address  VARCHAR(45) NULL,
    user_agent  TEXT NULL,
    payload     LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE cache (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    value       MEDIUMTEXT NOT NULL,
    expiration  INT NOT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE cache_locks (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    owner       VARCHAR(255) NOT NULL,
    expiration  INT NOT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE jobs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue       VARCHAR(255) NOT NULL,
    payload     LONGTEXT NOT NULL,
    attempts    TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at  INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE job_batches (
    id          VARCHAR(255) NOT NULL PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    total_jobs  INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options     MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at  INT NOT NULL,
    finished_at INT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE failed_jobs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid        VARCHAR(255) NOT NULL UNIQUE,
    connection  TEXT NOT NULL,
    queue       TEXT NOT NULL,
    payload     LONGTEXT NOT NULL,
    exception   LONGTEXT NOT NULL,
    failed_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

-- =============================================
-- Application tables
-- =============================================

CREATE TABLE role (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_role   VARCHAR(100) NOT NULL,
    created_at  TIMESTAMP NULL DEFAULT NULL,
    updated_at  TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE tahun_akademik (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_akademik  VARCHAR(20)              NOT NULL,
    semester        ENUM('Ganjil','Genap')   NOT NULL,
    status          ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
    created_at      TIMESTAMP NULL DEFAULT NULL,
    updated_at      TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE jurusan (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(150) NOT NULL,
    kode_jurusan VARCHAR(20)  NOT NULL UNIQUE,
    created_at   TIMESTAMP NULL DEFAULT NULL,
    updated_at   TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE status_pembayaran (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_status VARCHAR(100) NOT NULL,
    keterangan  TEXT         NULL,
    created_at  TIMESTAMP NULL DEFAULT NULL,
    updated_at  TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE sumber_pembiayaan (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_sumber VARCHAR(150) NOT NULL,
    created_at  TIMESTAMP NULL DEFAULT NULL,
    updated_at  TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE tahun_masuk (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun             YEAR         NOT NULL,
    tahun_akademik_id INT UNSIGNED NOT NULL,
    created_at        TIMESTAMP NULL DEFAULT NULL,
    updated_at        TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_tahun_masuk_tahun_akademik
        FOREIGN KEY (tahun_akademik_id) REFERENCES tahun_akademik(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE prodi (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_prodi    VARCHAR(150)                   NOT NULL,
    kode_prodi    VARCHAR(20)                    NOT NULL UNIQUE,
    jenjang_prodi ENUM('D3','S1','S2','S3') NOT NULL,
    jurusan_id    INT UNSIGNED                   NOT NULL,
    created_at    TIMESTAMP NULL DEFAULT NULL,
    updated_at    TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_prodi_jurusan
        FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE users (
    id                              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username                        VARCHAR(100) NOT NULL UNIQUE,
    password                        VARCHAR(255) NOT NULL,
    email                           VARCHAR(150) NOT NULL UNIQUE,
    role_id                         INT UNSIGNED NOT NULL,
    email_verified_at               TIMESTAMP    NULL DEFAULT NULL,
    remember_token                  VARCHAR(100) NULL,
    password_reset_token            VARCHAR(255) NULL,
    password_reset_token_created_at TIMESTAMP    NULL DEFAULT NULL,
    created_at                      TIMESTAMP NULL DEFAULT NULL,
    updated_at                      TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id) REFERENCES role(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE mahasiswa (
    id                   INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    nama_mahasiswa       VARCHAR(150)  NOT NULL,
    npm                  VARCHAR(20)   NOT NULL UNIQUE,
    jenis_kelamin        ENUM('L','P') NOT NULL,
    tgl_lahir            DATE          NULL,
    jalur_masuk          VARCHAR(100)  NULL,
    pendaftaran          VARCHAR(100)  NULL,
    prodi_id             INT UNSIGNED  NOT NULL,
    status_akademik      VARCHAR(50)   NOT NULL,
    sumber_pembiayaan_id INT UNSIGNED  NULL,
    status_pembayaran_id INT UNSIGNED  NULL,
    nilai_ukt            DECIMAL(15,2) NOT NULL DEFAULT 0,
    user_id              INT UNSIGNED  NOT NULL,
    tahun_masuk_id       INT UNSIGNED  NOT NULL,
    created_at           TIMESTAMP NULL DEFAULT NULL,
    updated_at           TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_mahasiswa_prodi
        FOREIGN KEY (prodi_id) REFERENCES prodi(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_mahasiswa_sumber_pembiayaan
        FOREIGN KEY (sumber_pembiayaan_id) REFERENCES sumber_pembiayaan(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT fk_mahasiswa_status_pembayaran
        FOREIGN KEY (status_pembayaran_id) REFERENCES status_pembayaran(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT fk_mahasiswa_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_mahasiswa_tahun_masuk
        FOREIGN KEY (tahun_masuk_id) REFERENCES tahun_masuk(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE invoice (
    id                   INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id         INT UNSIGNED  NOT NULL,
    tahun_akademik_id    INT UNSIGNED  NOT NULL,
    besaran_ukt          DECIMAL(15,2) NOT NULL DEFAULT 0,
    kode_invoice         VARCHAR(100)  NOT NULL UNIQUE,
    status_pembayaran_id INT UNSIGNED  NOT NULL,
    metode_pembayaran    VARCHAR(50)   NULL,
    sumber_pembiayaan_id INT UNSIGNED  NULL,
    qris_expired_at      TIMESTAMP     NULL DEFAULT NULL,
    tanggal_pembayaran   TIMESTAMP     NULL DEFAULT NULL,
    created_at           TIMESTAMP NULL DEFAULT NULL,
    updated_at           TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_invoice_mahasiswa
        FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_invoice_tahun_akademik
        FOREIGN KEY (tahun_akademik_id) REFERENCES tahun_akademik(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_invoice_status_pembayaran
        FOREIGN KEY (status_pembayaran_id) REFERENCES status_pembayaran(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_invoice_sumber_pembiayaan
        FOREIGN KEY (sumber_pembiayaan_id) REFERENCES sumber_pembiayaan(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE banding (
    id                INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    kode_banding      VARCHAR(100)  NOT NULL UNIQUE,
    mahasiswa_id      INT UNSIGNED  NOT NULL,
    invoice_id        INT UNSIGNED  NOT NULL,
    alasan            TEXT          NOT NULL,
    besaran_usulan    DECIMAL(15,2) NOT NULL DEFAULT 0,
    bukti_pendukung   VARCHAR(255)  NULL,
    status            ENUM('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
    tanggal_pengajuan TIMESTAMP     NULL DEFAULT NULL,
    tanggal_diproses  TIMESTAMP     NULL DEFAULT NULL,
    keterangan_admin  TEXT          NULL,
    diproses_oleh     INT UNSIGNED  NULL,
    created_at        TIMESTAMP NULL DEFAULT NULL,
    updated_at        TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_banding_mahasiswa
        FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_banding_invoice
        FOREIGN KEY (invoice_id) REFERENCES invoice(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_banding_diproses_oleh
        FOREIGN KEY (diproses_oleh) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE banding_settings (
    id                   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_akademik_id    INT UNSIGNED NOT NULL,
    tanggal_mulai_tampil DATE         NOT NULL,
    tanggal_akhir_tampil DATE         NOT NULL,
    is_active            TINYINT(1)   NOT NULL DEFAULT 1,
    keterangan           TEXT         NULL,
    created_by           INT UNSIGNED NOT NULL,
    created_at           TIMESTAMP NULL DEFAULT NULL,
    updated_at           TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_banding_settings_tahun_akademik
        FOREIGN KEY (tahun_akademik_id) REFERENCES tahun_akademik(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_banding_settings_created_by
        FOREIGN KEY (created_by) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE invoice_settings (
    id                   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_akademik_id    INT UNSIGNED NOT NULL,
    tanggal_mulai_tampil DATE         NOT NULL,
    tanggal_akhir_tampil DATE         NOT NULL,
    is_active            TINYINT(1)   NOT NULL DEFAULT 1,
    keterangan           TEXT         NULL,
    created_by           INT UNSIGNED NOT NULL,
    created_at           TIMESTAMP NULL DEFAULT NULL,
    updated_at           TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_invoice_settings_tahun_akademik
        FOREIGN KEY (tahun_akademik_id) REFERENCES tahun_akademik(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_invoice_settings_created_by
        FOREIGN KEY (created_by) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- =============================================
-- Seed data: Roles
-- =============================================
INSERT INTO role (nama_role, created_at, updated_at) VALUES
('Admin',     NOW(), NOW()),
('Keuangan',  NOW(), NOW()),
('Akademik',  NOW(), NOW()),
('Direktur',  NOW(), NOW()),
('Mahasiswa', NOW(), NOW());

-- =============================================
-- Seed data: Demo users (password = 'password')
-- =============================================
INSERT INTO users (username, password, email, role_id, created_at, updated_at) VALUES
('admin',    '$2y$12$YourHashWillBeReplacedBySeeder', 'admin@sidu.ac.id',    1, NOW(), NOW()),
('keuangan', '$2y$12$YourHashWillBeReplacedBySeeder', 'keuangan@sidu.ac.id', 2, NOW(), NOW()),
('akademik', '$2y$12$YourHashWillBeReplacedBySeeder', 'akademik@sidu.ac.id', 3, NOW(), NOW()),
('direktur', '$2y$12$YourHashWillBeReplacedBySeeder', 'direktur@sidu.ac.id', 4, NOW(), NOW());
