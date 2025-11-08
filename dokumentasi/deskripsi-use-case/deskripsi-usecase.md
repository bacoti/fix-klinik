# Deskripsi Use Case - Sistem Informasi Klinik

## Daftar Isi
- [Use Case Admin](#use-case-admin)
- [Use Case Nurse/Perawat](#use-case-nurseperawat)
- [Use Case Doctor/Dokter](#use-case-doctordokter)
- [Use Case Pharmacist/Apoteker](#use-case-pharmacistapoteker)
- [Use Case Shared (Semua Role)](#use-case-shared-semua-role)

---

## Use Case Shared (Semua Role)

### UC-001: Login
**Actor:** Admin, Nurse, Doctor, Pharmacist  
**Deskripsi:** User melakukan login ke sistem untuk mengakses fitur sesuai role  
**Precondition:** User memiliki akun aktif di sistem  
**Postcondition:** User berhasil login dan masuk ke dashboard sesuai role  

**Main Flow:**
1. User membuka halaman login
2. System menampilkan form login (username & password)
3. User memasukkan username dan password
4. User menekan tombol "Login"
5. System memvalidasi kredensial
6. System membuat session untuk user
7. System redirect ke dashboard sesuai role
8. Use case selesai

**Alternative Flow:**
- 5a. Username atau password salah
  - 5a1. System menampilkan pesan error "Username atau password salah"
  - 5a2. Kembali ke step 3
- 5b. Akun user tidak aktif
  - 5b1. System menampilkan pesan "Akun Anda tidak aktif, hubungi administrator"
  - 5b2. Use case selesai

---

### UC-002: Logout
**Actor:** Admin, Nurse, Doctor, Pharmacist  
**Deskripsi:** User keluar dari sistem  
**Precondition:** User sudah login ke sistem  
**Postcondition:** Session user dihapus dan user kembali ke halaman login  

**Main Flow:**
1. User menekan tombol "Logout"
2. System menampilkan konfirmasi logout
3. User mengkonfirmasi logout
4. System menghapus session user
5. System mencatat log aktivitas logout
6. System redirect ke halaman login
7. Use case selesai

---

### UC-003: Ganti Password
**Actor:** Admin, Nurse, Doctor, Pharmacist  
**Deskripsi:** User mengganti password akun  
**Precondition:** User sudah login ke sistem  
**Postcondition:** Password user berhasil diubah  

**Main Flow:**
1. User membuka menu "Profil"
2. User memilih "Ganti Password"
3. System menampilkan form ganti password
4. User memasukkan password lama
5. User memasukkan password baru
6. User memasukkan konfirmasi password baru
7. User menekan tombol "Simpan"
8. System memvalidasi password lama
9. System memvalidasi kekuatan password baru
10. System memvalidasi konfirmasi password
11. System mengenkripsi password baru
12. System menyimpan password baru ke database
13. System menampilkan notifikasi sukses
14. Use case selesai

**Alternative Flow:**
- 8a. Password lama salah
  - 8a1. System menampilkan pesan "Password lama salah"
  - 8a2. Kembali ke step 4
- 9a. Password baru tidak memenuhi syarat (min 8 karakter)
  - 9a1. System menampilkan pesan error validasi
  - 9a2. Kembali ke step 5
- 10a. Konfirmasi password tidak sama
  - 10a1. System menampilkan pesan "Konfirmasi password tidak sama"
  - 10a2. Kembali ke step 6

---

## Use Case Admin

### UC-004: Registrasi Pasien Baru
**Actor:** Admin, Nurse  
**Deskripsi:** Mendaftarkan pasien baru ke sistem  
**Precondition:** User sudah login sebagai Admin atau Nurse  
**Postcondition:** Data pasien tersimpan dan nomor rekam medis di-generate  

**Main Flow:**
1. User membuka menu "Pasien"
2. User memilih "Registrasi Pasien Baru"
3. System menampilkan form registrasi pasien
4. User memasukkan NIK pasien
5. System validasi NIK (16 digit dan belum terdaftar)
6. User memasukkan data identitas (nama, TTL, gender, alamat, telepon, email)
7. User memasukkan data tambahan (golongan darah, status nikah, pekerjaan)
8. User memasukkan data alergi (opsional)
9. User upload foto pasien (opsional)
10. User menekan tombol "Simpan"
11. System validasi semua input
12. System generate nomor rekam medis otomatis
13. System menyimpan data pasien ke database
14. System menampilkan notifikasi sukses dan nomor RM
15. System menampilkan opsi cetak kartu pasien
16. Use case selesai

**Alternative Flow:**
- 5a. NIK sudah terdaftar
  - 5a1. System menampilkan pesan "NIK sudah terdaftar" dan data pasien existing
  - 5a2. Use case selesai
- 5b. Format NIK tidak valid
  - 5b1. System menampilkan pesan "NIK harus 16 digit angka"
  - 5b2. Kembali ke step 4
- 11a. Ada field required yang kosong
  - 11a1. System menampilkan highlight field yang harus diisi
  - 11a2. Kembali ke step 6

---

### UC-005: Edit Data Pasien
**Actor:** Admin, Nurse  
**Deskripsi:** Mengubah data pasien yang sudah terdaftar  
**Precondition:** User sudah login dan data pasien ada di sistem  
**Postcondition:** Data pasien berhasil diupdate  

**Main Flow:**
1. User membuka menu "Pasien"
2. User mencari pasien (by nama/no RM/NIK)
3. System menampilkan hasil pencarian
4. User memilih pasien yang akan diedit
5. System menampilkan detail data pasien
6. User menekan tombol "Edit"
7. System menampilkan form edit (terisi data lama)
8. User mengubah data yang perlu diubah
9. User menekan tombol "Simpan"
10. System validasi input
11. System menyimpan perubahan ke database
12. System mencatat log perubahan (audit trail)
13. System menampilkan notifikasi sukses
14. Use case selesai

**Alternative Flow:**
- 3a. Pasien tidak ditemukan
  - 3a1. System menampilkan pesan "Data pasien tidak ditemukan"
  - 3a2. Use case selesai
- 10a. Validasi gagal
  - 10a1. System menampilkan pesan error
  - 10a2. Kembali ke step 8

---

### UC-006: Daftar Kunjungan
**Actor:** Admin, Nurse  
**Deskripsi:** Mendaftarkan kunjungan pasien dan generate nomor antrian  
**Precondition:** User sudah login dan data pasien sudah terdaftar  
**Postcondition:** Kunjungan terdaftar dan nomor antrian ter-generate  

**Main Flow:**
1. User membuka menu "Pendaftaran"
2. User memilih "Daftar Kunjungan"
3. System menampilkan form pendaftaran
4. User mencari pasien (by nama/no RM/NIK)
5. System menampilkan data pasien
6. User memilih dokter tujuan
7. System menampilkan jadwal dan ketersediaan dokter
8. User memilih jenis layanan (umum/spesialis)
9. User memasukkan keluhan utama
10. User memilih prioritas (normal/urgent)
11. User menekan tombol "Daftar"
12. System generate nomor antrian otomatis
13. System menyimpan data kunjungan
14. System menampilkan nomor antrian
15. System menampilkan opsi cetak kartu antrian
16. Use case selesai

**Alternative Flow:**
- 5a. Pasien tidak ditemukan
  - 5a1. System menampilkan opsi "Registrasi Pasien Baru"
  - 5a2. Jika user pilih Ya, lanjut ke UC-004
  - 5a3. Jika tidak, use case selesai
- 7a. Dokter tidak tersedia hari ini
  - 7a1. System menampilkan pesan "Dokter tidak praktek hari ini"
  - 7a2. System menampilkan jadwal praktek dokter
  - 7a3. Kembali ke step 6

---

### UC-007: Kelola Master Dokter
**Actor:** Admin  
**Deskripsi:** Menambah, edit, atau hapus data dokter  
**Precondition:** User login sebagai Admin  
**Postcondition:** Data dokter tersimpan/terupdate  

**Main Flow (Tambah Dokter):**
1. User membuka menu "Master Data"
2. User memilih "Master Dokter"
3. System menampilkan list dokter
4. User menekan tombol "Tambah Dokter"
5. System menampilkan form tambah dokter
6. User memasukkan data (nama, SIP, spesialisasi, telepon, email)
7. User memasukkan tarif konsultasi
8. User mengatur jadwal praktek per hari
9. User menekan tombol "Simpan"
10. System validasi input
11. System menyimpan data dokter
12. System menampilkan notifikasi sukses
13. Use case selesai

**Alternative Flow:**
- 10a. SIP sudah terdaftar
  - 10a1. System menampilkan pesan "SIP sudah terdaftar"
  - 10a2. Kembali ke step 6

---

### UC-008: Kelola User
**Actor:** Admin  
**Deskripsi:** Menambah, edit, hapus user dan atur role  
**Precondition:** User login sebagai Admin  
**Postcondition:** Data user tersimpan/terupdate  

**Main Flow (Tambah User):**
1. User membuka menu "Manajemen User"
2. User menekan tombol "Tambah User"
3. System menampilkan form tambah user
4. User memasukkan data (nama, email, username)
5. User memilih role (Admin/Nurse/Doctor/Pharmacist)
6. User memasukkan password default
7. User menekan tombol "Simpan"
8. System validasi input (username unique)
9. System enkripsi password
10. System menyimpan data user
11. System menampilkan notifikasi sukses
12. Use case selesai

**Alternative Flow:**
- 8a. Username sudah digunakan
  - 8a1. System menampilkan pesan "Username sudah digunakan"
  - 8a2. Kembali ke step 4

---

### UC-009: Backup Database
**Actor:** Admin  
**Deskripsi:** Melakukan backup database secara manual  
**Precondition:** User login sebagai Admin  
**Postcondition:** File backup database tersimpan  

**Main Flow:**
1. User membuka menu "Pengaturan Sistem"
2. User memilih "Backup Database"
3. System menampilkan halaman backup
4. User menekan tombol "Backup Sekarang"
5. System menampilkan konfirmasi
6. User mengkonfirmasi
7. System generate file backup (.sql)
8. System menyimpan file di server
9. System menampilkan link download
10. System menampilkan notifikasi sukses
11. Use case selesai

---

## Use Case Nurse/Perawat

### UC-010: Input Vital Sign
**Actor:** Nurse  
**Deskripsi:** Memasukkan data vital sign pasien saat pemeriksaan awal  
**Precondition:** Nurse sudah login dan pasien sudah terdaftar kunjungan  
**Postcondition:** Data vital sign tersimpan di rekam medis  

**Main Flow:**
1. Nurse membuka menu "Pemeriksaan Awal"
2. Nurse memilih pasien dari antrian
3. System menampilkan data pasien
4. Nurse menekan "Mulai Pemeriksaan"
5. System menampilkan form vital sign
6. Nurse memasukkan tekanan darah (sistol/diastol)
7. Nurse memasukkan suhu badan
8. Nurse memasukkan nadi
9. Nurse memasukkan laju pernapasan
10. Nurse memasukkan berat badan
11. Nurse memasukkan tinggi badan
12. System otomatis hitung BMI
13. Nurse menekan tombol "Simpan"
14. System validasi input
15. System menyimpan data ke rekam medis
16. System menampilkan notifikasi sukses
17. Use case selesai

---

### UC-011: Input Anamnesa Awal
**Actor:** Nurse  
**Deskripsi:** Memasukkan keluhan dan riwayat pasien  
**Precondition:** Nurse sudah input vital sign  
**Postcondition:** Data anamnesa tersimpan  

**Main Flow:**
1. Nurse melanjutkan dari input vital sign
2. System menampilkan form anamnesa
3. Nurse memasukkan keluhan utama detail
4. Nurse memasukkan riwayat penyakit sekarang
5. Nurse memasukkan riwayat penyakit dahulu
6. Nurse memasukkan riwayat penyakit keluarga
7. Nurse memasukkan riwayat pengobatan
8. Nurse menekan tombol "Simpan"
9. System menyimpan data anamnesa
10. System menampilkan notifikasi sukses
11. Use case selesai

---

### UC-012: Transfer ke Dokter
**Actor:** Nurse  
**Deskripsi:** Menyelesaikan pemeriksaan awal dan transfer ke dokter  
**Precondition:** Nurse sudah input vital sign dan anamnesa  
**Postcondition:** Status antrian berubah ke "Siap Diperiksa Dokter"  

**Main Flow:**
1. Nurse menekan tombol "Transfer ke Dokter"
2. System menampilkan konfirmasi
3. Nurse memilih ruangan pemeriksaan
4. Nurse mengkonfirmasi transfer
5. System update status antrian
6. System kirim notifikasi ke dokter
7. System menampilkan notifikasi sukses
8. Use case selesai

---

## Use Case Doctor/Dokter

### UC-013: Input Diagnosis
**Actor:** Doctor  
**Deskripsi:** Dokter memasukkan diagnosis pasien  
**Precondition:** Doctor sudah melakukan pemeriksaan  
**Postcondition:** Diagnosis tersimpan di rekam medis  

**Main Flow:**
1. Doctor membuka data pemeriksaan pasien
2. Doctor menekan tab "Diagnosis"
3. System menampilkan form diagnosis
4. Doctor mencari diagnosis (ICD-10)
5. System menampilkan hasil pencarian
6. Doctor memilih diagnosis utama
7. Doctor menambah diagnosis banding (opsional)
8. Doctor memasukkan keterangan diagnosis
9. Doctor menekan tombol "Simpan"
10. System menyimpan diagnosis
11. System update rekam medis
12. System menampilkan notifikasi sukses
13. Use case selesai

---

### UC-014: Buat Resep Obat
**Actor:** Doctor  
**Deskripsi:** Dokter membuat resep obat untuk pasien  
**Precondition:** Doctor sudah input diagnosis  
**Postcondition:** Resep tersimpan dan dikirim ke apoteker  

**Main Flow:**
1. Doctor menekan tab "Resep"
2. System menampilkan form resep
3. Doctor mencari obat
4. System menampilkan hasil dan stok obat
5. Doctor memilih obat
6. Doctor memasukkan dosis (misal: 500mg)
7. Doctor memasukkan frekuensi (misal: 3x sehari)
8. Doctor memasukkan durasi (misal: 5 hari)
9. Doctor memasukkan aturan pakai detail
10. System cek interaksi obat (jika ada obat lain)
11. Doctor menambah obat lain (jika perlu, repeat step 3-10)
12. Doctor menekan tombol "Simpan Resep"
13. System validasi ketersediaan stok
14. System menyimpan resep
15. System kirim notifikasi ke apoteker
16. System menampilkan notifikasi sukses
17. Use case selesai

**Alternative Flow:**
- 10a. Ada interaksi obat berbahaya
  - 10a1. System menampilkan warning interaksi
  - 10a2. Doctor review dan konfirmasi atau ganti obat
  - 10a3. Lanjut ke step 11
- 13a. Stok obat tidak tersedia
  - 13a1. System menampilkan peringatan stok habis
  - 13a2. System suggest obat pengganti
  - 13a3. Doctor ganti obat atau tetap simpan
  - 13a4. Lanjut ke step 14

---

### UC-015: Buat Surat Keterangan Sakit
**Actor:** Doctor  
**Deskripsi:** Dokter membuat surat keterangan sakit untuk pasien  
**Precondition:** Doctor sudah melakukan pemeriksaan  
**Postcondition:** Surat keterangan sakit ter-generate dan bisa dicetak  

**Main Flow:**
1. Doctor membuka data pemeriksaan pasien
2. Doctor menekan menu "Surat Keterangan"
3. Doctor memilih "Surat Sakit"
4. System menampilkan form surat sakit
5. Doctor memasukkan lama istirahat (hari)
6. Doctor memasukkan keterangan tambahan
7. Doctor menekan "Preview"
8. System generate preview surat (PDF)
9. Doctor review surat
10. Doctor menekan "Cetak"
11. System menyimpan log surat
12. System generate PDF final
13. Use case selesai

---

### UC-016: Buat Surat Rujukan
**Actor:** Doctor  
**Deskripsi:** Dokter membuat surat rujukan ke RS/klinik lain  
**Precondition:** Doctor sudah melakukan pemeriksaan  
**Postcondition:** Surat rujukan ter-generate  

**Main Flow:**
1. Doctor membuka data pemeriksaan pasien
2. Doctor menekan menu "Surat Keterangan"
3. Doctor memilih "Surat Rujukan"
4. System menampilkan form rujukan
5. Doctor memasukkan tujuan rujukan
6. Doctor memasukkan diagnosis
7. Doctor memasukkan alasan rujukan
8. Doctor memasukkan pemeriksaan yang sudah dilakukan
9. Doctor memasukkan terapi yang sudah diberikan
10. Doctor memasukkan saran pemeriksaan lanjutan
11. Doctor menekan "Preview"
12. System generate preview surat
13. Doctor menekan "Cetak"
14. System menyimpan log surat
15. System generate PDF final
16. Use case selesai

---

## Use Case Pharmacist/Apoteker

### UC-017: Proses Resep
**Actor:** Pharmacist  
**Deskripsi:** Apoteker memproses resep dari dokter  
**Precondition:** Ada resep pending dari dokter  
**Postcondition:** Resep selesai diproses dan obat siap diserahkan  

**Main Flow:**
1. Pharmacist membuka menu "Resep Pending"
2. System menampilkan list resep yang belum diproses
3. Pharmacist memilih resep yang akan diproses
4. System menampilkan detail resep dan data pasien
5. Pharmacist verifikasi resep (dosis, aturan pakai)
6. Pharmacist cek ketersediaan stok semua obat
7. Pharmacist pilih batch obat (FEFO)
8. Pharmacist racik/siapkan obat sesuai resep
9. Pharmacist hitung total biaya obat
10. System update stok obat otomatis
11. Pharmacist cetak label obat
12. Pharmacist cetak etiket (aturan pakai)
13. Pharmacist tandai resep selesai
14. System kirim ke kasir untuk pembayaran
15. System menampilkan notifikasi sukses
16. Use case selesai

**Alternative Flow:**
- 6a. Stok obat tidak tersedia
  - 6a1. Pharmacist hubungi dokter untuk obat pengganti
  - 6a2. Doctor approve penggantian
  - 6a3. Pharmacist update resep
  - 6a4. Lanjut ke step 7
- 7a. Batch obat akan expired < 3 bulan
  - 7a1. System menampilkan warning
  - 7a2. Pharmacist review dan konfirmasi
  - 7a3. Lanjut ke step 8

---

### UC-018: Penjualan OTC
**Actor:** Pharmacist  
**Deskripsi:** Apoteker melakukan penjualan obat bebas tanpa resep  
**Precondition:** Pharmacist sudah login  
**Postcondition:** Transaksi tersimpan dan stok terupdate  

**Main Flow:**
1. Pharmacist membuka menu "Penjualan OTC"
2. System menampilkan halaman transaksi
3. Pharmacist mencari obat
4. System menampilkan hasil dan harga
5. Pharmacist input jumlah obat
6. Pharmacist tambah obat ke keranjang
7. Pharmacist repeat step 3-6 untuk obat lain (jika ada)
8. Pharmacist review keranjang
9. Pharmacist menekan "Proses"
10. System hitung total pembayaran
11. System menampilkan total
12. Pharmacist konfirmasi
13. System update stok otomatis
14. System generate struk penjualan
15. System kirim ke kasir (jika perlu) atau langsung cetak struk
16. Use case selesai

---

### UC-019: Input Stok Masuk
**Actor:** Pharmacist  
**Deskripsi:** Apoteker mencatat pembelian obat baru  
**Precondition:** Pharmacist sudah login  
**Postcondition:** Stok obat bertambah  

**Main Flow:**
1. Pharmacist membuka menu "Stok Obat"
2. Pharmacist memilih "Stok Masuk"
3. System menampilkan form stok masuk
4. Pharmacist pilih supplier
5. Pharmacist input nomor faktur/invoice
6. Pharmacist input tanggal pembelian
7. Pharmacist pilih obat (atau tambah obat baru jika belum ada)
8. Pharmacist input batch number
9. Pharmacist input tanggal expired
10. Pharmacist input jumlah obat masuk
11. Pharmacist input harga beli per unit
12. Pharmacist repeat step 7-11 untuk obat lain
13. Pharmacist menekan "Simpan"
14. System validasi input
15. System update stok obat
16. System simpan histori stok
17. System menampilkan notifikasi sukses
18. Use case selesai

**Alternative Flow:**
- 9a. Expired date < 6 bulan dari sekarang
  - 9a1. System menampilkan warning
  - 9a2. Pharmacist review dan konfirmasi
  - 9a3. Lanjut ke step 10

---

### UC-020: Stok Opname
**Actor:** Pharmacist  
**Deskripsi:** Apoteker melakukan perhitungan fisik stok obat  
**Precondition:** Pharmacist sudah login  
**Postcondition:** Stok sistem disesuaikan dengan fisik  

**Main Flow:**
1. Pharmacist membuka menu "Stok Opname"
2. Pharmacist menekan "Mulai Stok Opname"
3. System generate list semua obat dengan stok sistem
4. Pharmacist hitung fisik obat satu per satu
5. Pharmacist input stok fisik per obat
6. System otomatis hitung selisih (stok sistem - stok fisik)
7. Pharmacist input keterangan jika ada selisih
8. Pharmacist repeat step 4-7 untuk semua obat
9. Pharmacist menekan "Selesai"
10. System menampilkan summary selisih
11. Pharmacist review hasil
12. Pharmacist menekan "Approve"
13. System update stok sesuai fisik
14. System simpan laporan stok opname
15. System menampilkan notifikasi sukses
16. Use case selesai

**Alternative Flow:**
- 12a. Perlu approval supervisor untuk selisih besar
  - 12a1. System kirim notifikasi ke supervisor
  - 12a2. Supervisor review dan approve
  - 12a3. Lanjut ke step 13

---

### UC-021: Kelola Supplier
**Actor:** Pharmacist  
**Deskripsi:** Apoteker menambah/edit data supplier obat  
**Precondition:** Pharmacist sudah login  
**Postcondition:** Data supplier tersimpan  

**Main Flow:**
1. Pharmacist membuka menu "Supplier"
2. Pharmacist menekan "Tambah Supplier"
3. System menampilkan form supplier
4. Pharmacist input nama supplier
5. Pharmacist input alamat
6. Pharmacist input nomor telepon
7. Pharmacist input email
8. Pharmacist input kontak person
9. Pharmacist menekan "Simpan"
10. System validasi input
11. System menyimpan data supplier
12. System menampilkan notifikasi sukses
13. Use case selesai

---

### UC-022: Buat Purchase Order
**Actor:** Pharmacist  
**Deskripsi:** Apoteker membuat PO pembelian obat  
**Precondition:** Pharmacist sudah login dan data supplier ada  
**Postcondition:** PO tersimpan dan bisa dikirim ke supplier  

**Main Flow:**
1. Pharmacist membuka menu "Pembelian"
2. Pharmacist memilih "Buat PO"
3. System menampilkan form PO
4. Pharmacist pilih supplier
5. Pharmacist pilih obat yang akan dipesan
6. Pharmacist input qty yang dipesan
7. Pharmacist input harga estimasi
8. Pharmacist repeat step 5-7 untuk obat lain
9. System hitung total estimasi
10. Pharmacist review PO
11. Pharmacist menekan "Simpan"
12. System generate nomor PO otomatis
13. System menyimpan PO
14. System generate PDF PO
15. System menampilkan opsi kirim email ke supplier
16. Use case selesai

---

## Rangkuman Total Use Case

| Role | Jumlah Use Case |
|------|-----------------|
| Shared (Semua Role) | 3 |
| Admin | 38+ |
| Nurse | 14+ |
| Doctor | 18+ |
| Pharmacist | 23+ |
| **TOTAL** | **96+ Use Case** |

---

## Catatan Penggunaan

1. **ID Use Case** menggunakan format UC-XXX
2. **Precondition** harus dipenuhi sebelum use case dimulai
3. **Postcondition** adalah state setelah use case berhasil
4. **Main Flow** adalah alur normal/happy path
5. **Alternative Flow** adalah alur jika ada kondisi khusus/error

Dokumen ini dapat digunakan untuk:
- Dokumentasi sistem
- Testing (test case generation)
- Training user baru
- Development reference
