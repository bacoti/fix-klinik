# Kebutuhan Non-Fungsional (NFR) - Sistem Informasi Klinik

## Daftar Isi
1. [Keamanan (Security)](#1-keamanan-security)
2. [Performa (Performance)](#2-performa-performance)
3. [Keandalan (Reliability)](#3-keandalan-reliability)
4. [Kegunaan (Usability)](#4-kegunaan-usability)
5. [Skalabilitas (Scalability)](#5-skalabilitas-scalability)
6. [Maintainability](#6-maintainability)
7. [Portabilitas (Portability)](#7-portabilitas-portability)
8. [Kompatibilitas (Compatibility)](#8-kompatibilitas-compatibility)
9. [Backup & Recovery](#9-backup--recovery)
10. [Compliance & Regulasi](#10-compliance--regulasi)

---

## 1. Keamanan (Security)

### NFR-SEC-001: Autentikasi
**Deskripsi:** Sistem harus menggunakan mekanisme autentikasi yang aman  
**Requirement:**
- Semua user harus login dengan username dan password
- Password minimal 8 karakter (kombinasi huruf, angka, simbol)
- Password harus dienkripsi menggunakan algoritma bcrypt atau argon2
- Maksimal 3x percobaan login gagal, setelah itu akun di-lock 15 menit
- Session timeout setelah 30 menit idle
- Logout otomatis jika tidak ada aktivitas

**Acceptance Criteria:**
- ✅ Password tidak tersimpan dalam bentuk plain text
- ✅ Sistem mencatat semua percobaan login (sukses/gagal)
- ✅ Session di-invalidate setelah logout

---

### NFR-SEC-002: Otorisasi & Akses Kontrol
**Deskripsi:** Sistem harus membatasi akses berdasarkan role user  
**Requirement:**
- Implementasi Role-Based Access Control (RBAC)
- Setiap role (Admin, Nurse, Doctor, Pharmacist) memiliki hak akses berbeda
- User hanya bisa mengakses fitur sesuai role-nya
- Admin bisa mengatur permission per role
- Akses ke data sensitif (password, data medis) harus dibatasi

**Acceptance Criteria:**
- ✅ Nurse tidak bisa akses laporan keuangan
- ✅ Doctor tidak bisa edit master data
- ✅ Pharmacist tidak bisa hapus data pasien
- ✅ Hanya Admin yang bisa kelola user

---

### NFR-SEC-003: Enkripsi Data
**Deskripsi:** Data sensitif harus dienkripsi  
**Requirement:**
- Password user dienkripsi dengan bcrypt/argon2
- Data rekam medis sensitif dienkripsi (AES-256)
- Komunikasi menggunakan HTTPS/SSL
- File upload (foto, dokumen) disimpan di storage terenkripsi

**Acceptance Criteria:**
- ✅ Password tidak bisa di-decrypt
- ✅ Transmisi data menggunakan SSL certificate valid
- ✅ File sensitif tidak bisa diakses langsung via URL

---

### NFR-SEC-004: Validasi Input
**Deskripsi:** Sistem harus memvalidasi semua input untuk mencegah serangan  
**Requirement:**
- Validasi input di sisi client dan server
- Sanitasi input untuk mencegah SQL Injection
- Sanitasi input untuk mencegah XSS (Cross-Site Scripting)
- Validasi format (email, NIK, nomor telepon, dll)
- Validasi file upload (type, size, extension)

**Acceptance Criteria:**
- ✅ SQL Injection tidak bisa dilakukan
- ✅ XSS attack tidak berhasil
- ✅ Upload file selain image/PDF ditolak

---

### NFR-SEC-005: Audit Trail
**Deskripsi:** Sistem harus mencatat semua aktivitas user  
**Requirement:**
- Log setiap login/logout user
- Log semua perubahan data (create, update, delete)
- Log mencatat: timestamp, user, IP address, action, data lama, data baru
- Log tidak bisa dihapus/diubah oleh user biasa
- Hanya Admin yang bisa lihat log lengkap

**Acceptance Criteria:**
- ✅ Setiap perubahan data tercatat di log
- ✅ Log bisa di-filter berdasarkan user, tanggal, aksi
- ✅ Log tersimpan minimal 1 tahun

---

### NFR-SEC-006: CSRF Protection
**Deskripsi:** Sistem harus terlindungi dari CSRF attack  
**Requirement:**
- Implementasi CSRF token untuk setiap form
- Token di-generate per session
- Token di-validate setiap submit form
- Request tanpa token valid akan ditolak

**Acceptance Criteria:**
- ✅ CSRF attack tidak berhasil
- ✅ Token expired setelah session berakhir

---

## 2. Performa (Performance)

### NFR-PERF-001: Response Time
**Deskripsi:** Sistem harus responsif dan cepat  
**Requirement:**
- Halaman utama load dalam ≤ 2 detik
- Form input response ≤ 1 detik
- Pencarian data pasien ≤ 1 detik
- Generate laporan PDF ≤ 5 detik
- API response time ≤ 500ms

**Acceptance Criteria:**
- ✅ 95% request selesai dalam waktu yang ditentukan
- ✅ Loading indicator muncul jika proses > 1 detik

---

### NFR-PERF-002: Concurrent Users
**Deskripsi:** Sistem harus support multiple user bersamaan  
**Requirement:**
- Support minimal 50 concurrent users tanpa degradasi performa
- Support 100+ concurrent users saat peak hours
- Queue management untuk request yang banyak
- Load balancing jika diperlukan

**Acceptance Criteria:**
- ✅ Response time tetap stabil dengan 50 users
- ✅ Tidak ada timeout saat peak hours

---

### NFR-PERF-003: Database Optimization
**Deskripsi:** Database harus optimal  
**Requirement:**
- Index pada kolom yang sering di-query (NIK, no RM, nama)
- Query optimization (avoid N+1 problem)
- Database connection pooling
- Pagination untuk list data yang banyak
- Lazy loading untuk data besar

**Acceptance Criteria:**
- ✅ Query execution time ≤ 100ms
- ✅ List data pakai pagination (max 50 rows per page)

---

### NFR-PERF-004: Caching
**Deskripsi:** Implementasi caching untuk data yang sering diakses  
**Requirement:**
- Cache data master (dokter, tindakan, obat)
- Cache static assets (CSS, JS, images)
- Cache expire setelah 1 jam atau saat data update
- Browser caching untuk static files

**Acceptance Criteria:**
- ✅ Data master load dari cache jika tidak ada perubahan
- ✅ Page load 50% lebih cepat dengan cache

---

## 3. Keandalan (Reliability)

### NFR-REL-001: Availability
**Deskripsi:** Sistem harus tersedia 24/7  
**Requirement:**
- Uptime minimal 99.5% per bulan
- Downtime terencana hanya saat maintenance (max 2 jam/bulan)
- Notifikasi ke admin jika ada downtime
- Monitoring sistem real-time

**Acceptance Criteria:**
- ✅ System available 99.5% (≈ 3.6 jam downtime/bulan)
- ✅ Maintenance dijadwalkan di jam tidak sibuk (malam)

---

### NFR-REL-002: Error Handling
**Deskripsi:** Sistem harus handle error dengan baik  
**Requirement:**
- Tampilkan error message yang user-friendly
- Log error detail di server (stack trace, context)
- Tidak menampilkan error teknis ke user
- Fallback mechanism jika fitur gagal
- Rollback otomatis jika transaksi gagal

**Acceptance Criteria:**
- ✅ User tidak lihat stack trace atau error PHP
- ✅ Error dicatat di log file untuk debugging
- ✅ Transaksi keuangan rollback jika ada error

---

### NFR-REL-003: Data Integrity
**Deskripsi:** Data harus konsisten dan valid  
**Requirement:**
- Database constraint (foreign key, unique, not null)
- Transaction management (ACID compliance)
- Data validation sebelum save
- Prevent duplicate data (NIK pasien, username)
- Referential integrity terjaga

**Acceptance Criteria:**
- ✅ Tidak ada orphan data
- ✅ Duplikat data dicegah
- ✅ Relasi antar tabel valid

---

### NFR-REL-004: Fault Tolerance
**Deskripsi:** Sistem harus tetap berjalan meski ada komponen yang error  
**Requirement:**
- Isolasi error (error di satu modul tidak crash seluruh sistem)
- Graceful degradation (fitur optional bisa skip jika error)
- Retry mechanism untuk proses yang gagal
- Circuit breaker untuk external service

**Acceptance Criteria:**
- ✅ Error di laporan tidak block transaksi
- ✅ Error upload foto tidak block registrasi pasien

---

## 4. Kegunaan (Usability)

### NFR-USA-001: User Interface
**Deskripsi:** Interface harus mudah digunakan  
**Requirement:**
- Design clean dan modern
- Navigasi intuitif (max 3 klik untuk akses fitur)
- Konsisten layout antar halaman
- Responsive design (mobile, tablet, desktop)
- Warna sesuai standar medis (tidak mencolok)

**Acceptance Criteria:**
- ✅ User baru bisa gunakan sistem dalam ≤ 30 menit training
- ✅ Tampilan konsisten di Chrome, Firefox, Edge

---

### NFR-USA-002: Accessibility
**Deskripsi:** Sistem harus accessible untuk semua user  
**Requirement:**
- Font size minimal 14px, bisa diperbesar
- Kontras warna memenuhi standar WCAG 2.1
- Keyboard navigation support (tab, enter, esc)
- Label jelas untuk setiap input field
- Error message jelas dan actionable

**Acceptance Criteria:**
- ✅ User bisa navigate hanya pakai keyboard
- ✅ Error message kasih tau cara memperbaiki

---

### NFR-USA-003: Help & Documentation
**Deskripsi:** Tersedia bantuan untuk user  
**Requirement:**
- User manual/panduan per role
- Tooltip untuk field yang kompleks
- FAQ untuk pertanyaan umum
- Video tutorial (opsional)
- Contact support yang jelas

**Acceptance Criteria:**
- ✅ User manual tersedia dalam Bahasa Indonesia
- ✅ Tooltip muncul saat hover field

---

### NFR-USA-004: Feedback & Notifikasi
**Deskripsi:** User harus dapat feedback untuk setiap aksi  
**Requirement:**
- Success message setelah save data
- Loading indicator untuk proses > 1 detik
- Konfirmasi untuk aksi destructive (hapus, void)
- Notifikasi real-time (antrian, resep baru, stok habis)
- Toast/alert yang auto-hide setelah 5 detik

**Acceptance Criteria:**
- ✅ User tahu aksinya berhasil/gagal
- ✅ Konfirmasi muncul sebelum hapus data

---

## 5. Skalabilitas (Scalability)

### NFR-SCAL-001: Data Growth
**Deskripsi:** Sistem harus handle pertumbuhan data  
**Requirement:**
- Support minimal 10,000 pasien
- Support minimal 100,000 transaksi per tahun
- Database tidak slow meski data besar
- Archive data lama (> 5 tahun) jika perlu
- Partisi table untuk data besar

**Acceptance Criteria:**
- ✅ Performa tetap stabil dengan 10K+ pasien
- ✅ Query tetap cepat dengan ratusan ribu record

---

### NFR-SCAL-002: User Growth
**Deskripsi:** Sistem harus support pertambahan user  
**Requirement:**
- Support minimal 100 user account
- Add user baru tanpa impact performa
- Role management fleksibel
- Multi-branch support (jika expand ke cabang lain)

**Acceptance Criteria:**
- ✅ Bisa tambah user tanpa limit
- ✅ System tetap stabil dengan 100+ users

---

## 6. Maintainability

### NFR-MAIN-001: Code Quality
**Deskripsi:** Kode harus mudah di-maintain  
**Requirement:**
- Follow coding standard (PSR-12 untuk PHP)
- Code documentation (comment untuk logic kompleks)
- Modular architecture (separation of concerns)
- DRY principle (Don't Repeat Yourself)
- Clean code (readable, testable)

**Acceptance Criteria:**
- ✅ Developer baru bisa understand code dalam 1 minggu
- ✅ Bug bisa di-fix dalam waktu reasonable

---

### NFR-MAIN-002: Logging & Monitoring
**Deskripsi:** Sistem harus bisa di-monitor  
**Requirement:**
- Application log (error, warning, info)
- Access log (request, response time)
- Database query log
- System health monitoring
- Alert jika ada anomali

**Acceptance Criteria:**
- ✅ Log tersimpan di file/database
- ✅ Admin dapat notifikasi jika ada critical error

---

### NFR-MAIN-003: Update & Deployment
**Deskripsi:** Update sistem harus mudah  
**Requirement:**
- Versioning system (semantic versioning)
- Database migration support
- Rollback mechanism jika update gagal
- Zero-downtime deployment (jika possible)
- Changelog untuk setiap update

**Acceptance Criteria:**
- ✅ Update bisa dilakukan tanpa data loss
- ✅ Rollback bisa dilakukan dalam 15 menit

---

## 7. Portabilitas (Portability)

### NFR-PORT-001: Platform Independence
**Deskripsi:** Sistem harus bisa jalan di berbagai platform  
**Requirement:**
- Support OS: Windows Server, Linux (Ubuntu/CentOS)
- Support Web Server: Apache, Nginx
- Support Database: MySQL 8.0+, MariaDB 10.5+
- Support PHP 8.0+

**Acceptance Criteria:**
- ✅ Aplikasi jalan di Windows dan Linux
- ✅ Compatible dengan Apache dan Nginx

---

### NFR-PORT-002: Browser Compatibility
**Deskripsi:** Sistem harus compatible dengan browser modern  
**Requirement:**
- Support Chrome (latest - 2 versions)
- Support Firefox (latest - 2 versions)
- Support Edge (latest - 2 versions)
- Support Safari (latest version) - opsional
- Tidak support IE11

**Acceptance Criteria:**
- ✅ Semua fitur jalan di Chrome, Firefox, Edge
- ✅ Layout tidak broken di browser yang didukung

---

### NFR-PORT-003: Responsive Design
**Deskripsi:** Sistem harus accessible dari berbagai device  
**Requirement:**
- Responsive untuk Desktop (1920x1080, 1366x768)
- Responsive untuk Tablet (768x1024)
- Responsive untuk Mobile (375x667) - minimal read-only
- Touch-friendly untuk tablet/mobile

**Acceptance Criteria:**
- ✅ Layout adapt sesuai screen size
- ✅ Button/link mudah di-tap di mobile

---

## 8. Kompatibilitas (Compatibility)

### NFR-COMP-001: Third-Party Integration
**Deskripsi:** Sistem harus bisa integrasi dengan sistem lain (future)  
**Requirement:**
- API endpoint untuk data export
- Support REST API
- API authentication (token-based)
- API documentation (Swagger/Postman)
- Webhooks untuk notifikasi (opsional)

**Acceptance Criteria:**
- ✅ API bisa diakses dengan token valid
- ✅ API documentation lengkap

---

### NFR-COMP-002: File Format Support
**Deskripsi:** Sistem harus support berbagai format file  
**Requirement:**
- Export laporan: PDF, Excel (XLSX), CSV
- Import data: Excel (XLSX), CSV
- Upload foto: JPEG, PNG (max 5MB)
- Upload dokumen: PDF (max 10MB)

**Acceptance Criteria:**
- ✅ Laporan bisa di-export ke PDF dan Excel
- ✅ Upload foto validate type dan size

---

## 9. Backup & Recovery

### NFR-BKP-001: Backup Strategy
**Deskripsi:** Data harus di-backup secara rutin  
**Requirement:**
- Full backup database setiap hari (jam 00:00)
- Incremental backup setiap 6 jam
- Backup disimpan minimal 30 hari
- Backup file tersimpan di lokasi terpisah
- Manual backup kapan saja oleh Admin

**Acceptance Criteria:**
- ✅ Backup otomatis jalan setiap hari
- ✅ Backup file bisa di-download

---

### NFR-BKP-002: Disaster Recovery
**Deskripsi:** Sistem harus bisa recovery dari disaster  
**Requirement:**
- Restore database dari backup file
- RTO (Recovery Time Objective): < 4 jam
- RPO (Recovery Point Objective): < 24 jam
- Documented recovery procedure
- Test recovery minimal 1x per 6 bulan

**Acceptance Criteria:**
- ✅ Database bisa di-restore dalam 4 jam
- ✅ Data loss maksimal 24 jam

---

### NFR-BKP-003: Data Retention
**Deskripsi:** Data harus disimpan sesuai regulasi  
**Requirement:**
- Rekam medis disimpan minimal 5 tahun
- Data transaksi disimpan minimal 7 tahun
- Log aktivitas disimpan minimal 1 tahun
- Soft delete untuk data sensitif (tidak hard delete)
- Archive data lama ke storage terpisah

**Acceptance Criteria:**
- ✅ Data pasien/transaksi tidak bisa dihapus permanent
- ✅ Soft delete bisa di-restore oleh Admin

---

## 10. Compliance & Regulasi

### NFR-COMP-001: Regulasi Kesehatan
**Deskripsi:** Sistem harus comply dengan regulasi kesehatan  
**Requirement:**
- Sesuai standar rekam medis elektronik (RME)
- Proteksi data pasien sesuai UU Perlindungan Data Pribadi
- Kerahasiaan data medis terjaga
- Informed consent untuk penggunaan data
- Hak pasien untuk akses data pribadi

**Acceptance Criteria:**
- ✅ Data medis hanya bisa diakses authorized personnel
- ✅ Patient consent tercatat

---

### NFR-COMP-002: Standar Coding
**Deskripsi:** Sistem harus gunakan standar medis internasional  
**Requirement:**
- Diagnosis menggunakan ICD-10 (atau ICD-11)
- Tindakan medis menggunakan kode standar
- Obat menggunakan nama generic dan trade name
- Format tanggal: DD/MM/YYYY atau YYYY-MM-DD
- Format currency: IDR (Rupiah)

**Acceptance Criteria:**
- ✅ Diagnosis bisa di-search dengan kode ICD-10
- ✅ Tanggal konsisten formatnya

---

### NFR-COMP-003: Legal & Compliance
**Deskripsi:** Sistem harus comply dengan hukum yang berlaku  
**Requirement:**
- Tanda tangan digital untuk dokumen (jika ada)
- Timestamp akurat untuk semua transaksi
- Audit trail tidak bisa dimanipulasi
- Data retention sesuai hukum
- Privacy policy untuk user

**Acceptance Criteria:**
- ✅ Timestamp menggunakan server time (synchronized)
- ✅ Audit trail immutable

---

## Rangkuman NFR

| Kategori | Jumlah NFR | Prioritas |
|----------|-----------|-----------|
| Keamanan (Security) | 6 | **High** |
| Performa (Performance) | 4 | **High** |
| Keandalan (Reliability) | 4 | **High** |
| Kegunaan (Usability) | 4 | Medium |
| Skalabilitas (Scalability) | 2 | Medium |
| Maintainability | 3 | Medium |
| Portabilitas (Portability) | 3 | Low |
| Kompatibilitas (Compatibility) | 2 | Low |
| Backup & Recovery | 3 | **High** |
| Compliance & Regulasi | 3 | **High** |
| **TOTAL** | **34 NFR** | - |

---

## Prioritas Implementasi

### Phase 1 (Must Have - High Priority)
1. ✅ NFR-SEC-001: Autentikasi
2. ✅ NFR-SEC-002: Otorisasi
3. ✅ NFR-SEC-004: Validasi Input
5. ✅ NFR-PERF-001: Response Time
6. ✅ NFR-REL-001: Availability
7. ✅ NFR-REL-003: Data Integrity
8. ✅ NFR-BKP-001: Backup Strategy
9. ✅ NFR-COMP-001: Regulasi Kesehatan

### Phase 2 (Should Have - Medium Priority)
1. NFR-SEC-003: Enkripsi Data
2. NFR-SEC-005: Audit Trail
3. NFR-PERF-002: Concurrent Users
4. NFR-PERF-003: Database Optimization
5. NFR-REL-002: Error Handling
6. NFR-USA-001: User Interface
7. NFR-USA-004: Feedback & Notifikasi
8. NFR-BKP-002: Disaster Recovery

### Phase 3 (Nice to Have - Low Priority)
1. NFR-SEC-006: CSRF Protection
2. NFR-PERF-004: Caching
3. NFR-SCAL-001: Data Growth
4. NFR-PORT-002: Browser Compatibility
5. NFR-COMP-001: Third-Party Integration

---

## Catatan
- NFR ini dapat dijadikan acuan untuk **testing non-functional**
- Setiap NFR harus memiliki **acceptance criteria** yang measurable
- NFR harus di-review secara berkala (setiap 6 bulan)
- Prioritas NFR bisa disesuaikan dengan kebutuhan bisnis
