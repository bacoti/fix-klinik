# Database Design - Fix Klinik

Dokumentasi ini menjelaskan struktur database untuk sistem manajemen klinik (Fix Klinik).

## � Dokumentasi

1. **[ERD Diagram](./erd-diagram.mmd)** - Entity Relationship Diagram lengkap
2. **[Database Relationship Overview](./database-relationship-overview.mmd)** - Overview relasi database
3. **[Data Dictionary](./data-dictionary.md)** - Dokumentasi lengkap semua tabel dan field

## �📊 Entity Relationship Diagram (ERD)

File ERD dalam format Mermaid: [`erd-diagram.mmd`](./erd-diagram.mmd)

**Cara melihat diagram:**
1. Buka file `erd-diagram.mmd` di VS Code
2. Install extension "Markdown Preview Mermaid Support" jika belum
3. Klik kanan → "Open Preview" atau tekan `Ctrl+Shift+V`

Atau bisa dilihat online di:
- https://mermaid.live/

## 🗂️ Struktur Database

### 1. User Management
**Table: `users`**
- Menyimpan data pengguna sistem (admin, nurse, doctor, pharmacist)
- Field penting: `role` untuk membedakan hak akses

**Related Tables:**
- `password_reset_tokens` - Reset password
- `personal_access_tokens` - API authentication (Sanctum)
- `failed_jobs` - Queue monitoring

### 2. Patient Management
**Table: `patients`**
- Data pasien (nama, kontak, tanggal lahir, jenis kelamin)
- Email unique untuk mencegah duplikasi
- Status `verified` untuk validasi data

### 3. Screening (Pemeriksaan Awal)
**Table: `screenings`**
- Vital signs: suhu, tekanan darah, nadi, respirasi, saturasi oksigen
- Antropometri: berat badan, tinggi badan
- Keluhan utama pasien
- Dilakukan oleh: **Nurse** (`nurse_id`)
- Relasi: `patient_id` → `patients`

### 4. Examination (Pemeriksaan Dokter)
**Table: `examinations`**
- Anamnesis & pemeriksaan fisik
- Diagnosis dokter
- Resep dalam bentuk teks
- Surat sakit (jika ada)
- Follow-up date
- Dilakukan oleh: **Doctor** (`doctor_id`)
- Relasi: `patient_id` → `patients`

### 5. Medicine (Obat)
**Table: `medicines`**
- Master data obat
- Type: tablet, capsule, syrup, injection, cream, ointment
- Stock management
- Harga & tanggal expired
- Unit: strip, bottle, tube, dll

### 6. Prescription (Resep)
**Table: `prescriptions`**
- Detail resep per obat
- Quantity & instruksi penggunaan
- Tracking dispensing (kapan & oleh siapa)
- Relasi:
  - `examination_id` → `examinations`
  - `medicine_id` → `medicines`
  - `dispensed_by` → `users` (pharmacist)

### 7. Stock Management
**Table: `stock_logs`**
- Log perubahan stok obat
- Type: in (masuk), out (keluar), adjustment (koreksi)
- History tracking untuk audit
- Relasi: `medicine_id` → `medicines`

### 8. Medical Records (Rekam Medis)
**Table: `medical_records`**
- Aggregate dari semua aktivitas pasien
- Activity type: registration, screening, examination, prescription
- Details dalam format JSON (flexible)
- Timeline pasien
- Relasi: `patient_id` → `patients`

---

## 🔗 Relationship Summary

```
users (nurse) 1 -----> N screenings
users (doctor) 1 -----> N examinations
users (pharmacist) 1 -----> N prescriptions

patients 1 -----> N screenings
patients 1 -----> N examinations
patients 1 -----> N medical_records

screenings 1 -----> 1 examinations (optional)

examinations 1 -----> N prescriptions

medicines 1 -----> N prescriptions
medicines 1 -----> N stock_logs
```

---

## 📝 Catatan Penting

### Foreign Key Constraints
- `onDelete('cascade')` - Data akan terhapus otomatis jika parent dihapus
- `nullOnDelete()` - Foreign key akan NULL jika parent dihapus

### Indexing
- Unique keys: email (users, patients)
- Foreign keys otomatis ter-index
- Perlu index tambahan untuk query yang sering:
  - `patients.phone`
  - `medicines.type`
  - `medical_records.activity_type`
  - `medical_records.activity_date`

### Data Types
- `enum` - Pilihan terbatas (role, gender, type)
- `json` - Flexible data structure
- `decimal(x,y)` - Untuk data presisi (harga, vital signs)
- `text` - Data panjang tanpa limit

### Timestamps
Semua table memiliki:
- `created_at` - Waktu record dibuat
- `updated_at` - Waktu record terakhir diupdate

---

## 🔄 Migration Order

Urutan migration (dari yang paling dasar):
1. `users` - Master user data
2. `patients` - Master patient data
3. `medicines` - Master medicine data
4. `screenings` - Patient screening (FK: patients, users)
5. `examinations` - Doctor examination (FK: patients, users)
6. `prescriptions` - Medicine prescriptions (FK: examinations, medicines, users)
7. `stock_logs` - Stock movement (FK: medicines)
8. `medical_records` - Activity log (FK: patients)

---

## 📊 Database Statistics (Estimasi)

| Table | Estimated Growth | Retention |
|-------|------------------|-----------|
| users | Low | Permanent |
| patients | Medium | Permanent |
| medicines | Low-Medium | Permanent |
| screenings | High | 2-5 years |
| examinations | High | Permanent (legal) |
| prescriptions | High | Permanent (legal) |
| stock_logs | High | 1 year |
| medical_records | High | Permanent (legal) |

---

## 🛠️ Tools untuk Generate Diagram

Diagram ini dibuat dengan menganalisis migration files:
- `database/migrations/*.php`

Update diagram jika ada perubahan struktur database dengan:
1. Analisa migration terbaru
2. Update file `erd-diagram.mmd`
3. Commit changes

---

Terakhir diupdate: November 8, 2025
