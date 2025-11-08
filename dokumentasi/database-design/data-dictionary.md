# Data Dictionary - Fix Klinik Database

Dokumentasi lengkap semua tabel dan field dalam database Fix Klinik.

---

## 1. USERS (Pengguna Sistem)

### Deskripsi
Tabel untuk menyimpan data pengguna sistem dengan berbagai role (admin, nurse, doctor, pharmacist).

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| name | VARCHAR | 255 | NOT NULL | - | Nama lengkap pengguna |
| email | VARCHAR | 255 | UNIQUE, NOT NULL | - | Email untuk login |
| email_verified_at | TIMESTAMP | - | NULL | NULL | Waktu verifikasi email |
| password | VARCHAR | 255 | NOT NULL | - | Password (hashed) |
| remember_token | VARCHAR | 100 | NULL | NULL | Token "Remember Me" |
| role | ENUM | - | NOT NULL | 'admin' | admin, nurse, doctor, pharmacist |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- UNIQUE KEY: `email`

### Relationships
- Has many: `screenings` (as nurse_id)
- Has many: `examinations` (as doctor_id)
- Has many: `prescriptions` (as dispensed_by)

---

## 2. PATIENTS (Pasien)

### Deskripsi
Tabel master data pasien klinik.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| name | VARCHAR | 255 | NOT NULL | - | Nama lengkap pasien |
| email | VARCHAR | 255 | UNIQUE, NOT NULL | - | Email pasien |
| phone | VARCHAR | 255 | NOT NULL | - | Nomor telepon |
| address | TEXT | - | NOT NULL | - | Alamat lengkap |
| date_of_birth | DATE | - | NOT NULL | - | Tanggal lahir |
| gender | ENUM | - | NOT NULL | - | male, female |
| verified | BOOLEAN | - | NOT NULL | false | Status verifikasi data |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- UNIQUE KEY: `email`
- INDEX: `phone` (recommended)

### Relationships
- Has many: `screenings`
- Has many: `examinations`
- Has many: `medical_records`

---

## 3. SCREENINGS (Pemeriksaan Awal)

### Deskripsi
Tabel untuk data pemeriksaan awal oleh perawat, termasuk vital signs dan keluhan.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| patient_id | BIGINT | - | FK, NOT NULL | - | Relasi ke patients |
| nurse_id | BIGINT | - | FK, NOT NULL | - | Relasi ke users (perawat) |
| temperature | DECIMAL | 4,1 | NOT NULL | - | Suhu tubuh (°C) |
| blood_pressure_systolic | INTEGER | - | NULL | NULL | Tekanan darah sistolik (mmHg) |
| blood_pressure_diastolic | INTEGER | - | NULL | NULL | Tekanan darah diastolik (mmHg) |
| heart_rate | INTEGER | - | NULL | NULL | Denyut jantung (bpm) |
| respiratory_rate | INTEGER | - | NULL | NULL | Laju pernapasan (per menit) |
| oxygen_saturation | INTEGER | - | NULL | NULL | Saturasi oksigen (%) |
| weight | DECIMAL | 5,2 | NOT NULL | - | Berat badan (kg) |
| height | DECIMAL | 5,2 | NOT NULL | - | Tinggi badan (cm) |
| complaints | TEXT | - | NOT NULL | - | Keluhan utama pasien |
| notes | TEXT | - | NULL | NULL | Catatan tambahan |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- FOREIGN KEY: `patient_id` → `patients(id)` ON DELETE CASCADE
- FOREIGN KEY: `nurse_id` → `users(id)` ON DELETE CASCADE
- INDEX: `created_at` (for date range queries)

### Relationships
- Belongs to: `patients`
- Belongs to: `users` (nurse)
- Has one: `examinations` (optional)
- Has one: `medical_records` (logged)

### Business Rules
- BMI dapat dihitung otomatis: BMI = weight / (height/100)²
- Vital signs normal ranges:
  - Temperature: 36.5 - 37.5°C
  - Blood Pressure: 90/60 - 120/80 mmHg
  - Heart Rate: 60-100 bpm
  - Respiratory Rate: 12-20 per minute
  - Oxygen Saturation: ≥95%

---

## 4. EXAMINATIONS (Pemeriksaan Dokter)

### Deskripsi
Tabel untuk data pemeriksaan dan diagnosis oleh dokter.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| patient_id | BIGINT | - | FK, NOT NULL | - | Relasi ke patients |
| doctor_id | BIGINT | - | FK, NOT NULL | - | Relasi ke users (dokter) |
| anamnesis | TEXT | - | NULL | NULL | Riwayat penyakit/keluhan |
| physical_examination | TEXT | - | NULL | NULL | Hasil pemeriksaan fisik |
| diagnosis | TEXT | - | NOT NULL | - | Diagnosis dokter |
| prescription_text | TEXT | - | NOT NULL | - | Resep dalam bentuk teks |
| additional_notes | TEXT | - | NULL | NULL | Catatan tambahan |
| sick_letter | BOOLEAN | - | NOT NULL | false | Perlu surat sakit? |
| sick_days | INTEGER | - | NULL | NULL | Jumlah hari sakit |
| follow_up_date | DATE | - | NULL | NULL | Tanggal kontrol ulang |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- FOREIGN KEY: `patient_id` → `patients(id)` ON DELETE CASCADE
- FOREIGN KEY: `doctor_id` → `users(id)` ON DELETE CASCADE
- INDEX: `created_at`, `follow_up_date`

### Relationships
- Belongs to: `patients`
- Belongs to: `users` (doctor)
- Has many: `prescriptions`
- Has one: `medical_records` (logged)

### Business Rules
- Jika `sick_letter = true`, maka `sick_days` harus diisi
- `follow_up_date` harus > tanggal pemeriksaan
- Resep detail akan dipecah ke tabel `prescriptions`

---

## 5. MEDICINES (Obat)

### Deskripsi
Tabel master data obat dan inventory.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| name | VARCHAR | 255 | NOT NULL | - | Nama obat |
| type | VARCHAR | 255 | NOT NULL | 'tablet' | tablet, capsule, syrup, injection, cream, ointment |
| unit | VARCHAR | 50 | NOT NULL | 'strip' | strip, bottle, tube, box, vial |
| description | VARCHAR | 255 | NULL | NULL | Deskripsi/keterangan obat |
| stock | INTEGER | - | NOT NULL | - | Jumlah stok |
| price | DECIMAL | 10,2 | NOT NULL | 0.00 | Harga per unit |
| expired_at | TIMESTAMP | - | NULL | NULL | Tanggal kadaluarsa |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- INDEX: `type`, `expired_at` (for expiry monitoring)
- INDEX: `stock` (for low stock alert)

### Relationships
- Has many: `prescriptions`
- Has many: `stock_logs`

### Business Rules
- `stock` tidak boleh negatif
- Alert jika `expired_at` < 3 bulan dari sekarang
- Alert jika `stock` < minimum stock level
- Price dalam Rupiah (IDR)

---

## 6. PRESCRIPTIONS (Resep)

### Deskripsi
Tabel detail resep obat dari pemeriksaan dokter.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| examination_id | BIGINT | - | FK, NOT NULL | - | Relasi ke examinations |
| medicine_id | BIGINT | - | FK, NOT NULL | - | Relasi ke medicines |
| quantity | INTEGER | - | NOT NULL | - | Jumlah obat |
| instructions | TEXT | - | NOT NULL | - | Aturan pakai |
| dispensed_at | TIMESTAMP | - | NULL | NULL | Waktu obat diserahkan |
| dispensed_by | BIGINT | - | FK, NULL | NULL | Relasi ke users (apoteker) |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- FOREIGN KEY: `examination_id` → `examinations(id)` ON DELETE CASCADE
- FOREIGN KEY: `medicine_id` → `medicines(id)` ON DELETE CASCADE
- FOREIGN KEY: `dispensed_by` → `users(id)` ON DELETE SET NULL
- INDEX: `dispensed_at` (for pharmacy reports)

### Relationships
- Belongs to: `examinations`
- Belongs to: `medicines`
- Belongs to: `users` (pharmacist)
- Has one: `medical_records` (logged)

### Business Rules
- `quantity` harus ≤ stok obat yang tersedia
- Setelah dispensed, stok obat akan berkurang
- `dispensed_at` dan `dispensed_by` diisi bersamaan
- Instructions contoh: "3x sehari setelah makan"

---

## 7. STOCK_LOGS (Log Stok)

### Deskripsi
Tabel untuk tracking perubahan stok obat (masuk/keluar/koreksi).

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| medicine_id | BIGINT | - | FK, NOT NULL | - | Relasi ke medicines |
| type | ENUM | - | NOT NULL | - | in (masuk), out (keluar), adjustment (koreksi) |
| quantity | INTEGER | - | NOT NULL | - | Jumlah perubahan (+ atau -) |
| description | TEXT | - | NOT NULL | - | Keterangan perubahan |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu transaksi |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- FOREIGN KEY: `medicine_id` → `medicines(id)` ON DELETE CASCADE
- INDEX: `type`, `created_at`

### Relationships
- Belongs to: `medicines`

### Business Rules
- Type `in`: quantity positif (stok bertambah)
- Type `out`: quantity negatif (stok berkurang)
- Type `adjustment`: bisa positif/negatif (koreksi stok)
- Auto-log saat:
  - Pembelian obat baru
  - Dispensing prescription
  - Stok opname
  - Return/rusak/expired

---

## 8. MEDICAL_RECORDS (Rekam Medis)

### Deskripsi
Tabel agregasi timeline aktivitas pasien untuk rekam medis lengkap.

### Fields

| Field Name | Type | Length | Constraint | Default | Description |
|------------|------|--------|------------|---------|-------------|
| id | BIGINT | - | PK, AUTO_INCREMENT | - | Primary key |
| patient_id | BIGINT | - | FK, NOT NULL | - | Relasi ke patients |
| activity_type | VARCHAR | 255 | NOT NULL | - | registration, screening, examination, prescription |
| details | JSON | - | NOT NULL | - | Data aktivitas dalam JSON |
| activity_date | TIMESTAMP | - | NOT NULL | - | Waktu aktivitas |
| created_at | TIMESTAMP | - | NULL | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | - | NULL | NULL | Waktu diupdate |

### Indexes
- PRIMARY KEY: `id`
- FOREIGN KEY: `patient_id` → `patients(id)` ON DELETE CASCADE
- INDEX: `activity_type`, `activity_date`

### Relationships
- Belongs to: `patients`

### Business Rules
- Auto-generated dari events (screening, examination, prescription)
- JSON structure tergantung `activity_type`
- Digunakan untuk:
  - Timeline pasien
  - Laporan rekam medis
  - Audit trail
  - Export data

### JSON Structure Examples

**Registration:**
```json
{
  "patient_name": "John Doe",
  "registered_by": "Admin Name",
  "notes": "New patient registration"
}
```

**Screening:**
```json
{
  "nurse_name": "Nurse Name",
  "vital_signs": {
    "temperature": 36.5,
    "blood_pressure": "120/80",
    "heart_rate": 75
  },
  "complaints": "Demam dan batuk"
}
```

**Examination:**
```json
{
  "doctor_name": "Dr. Name",
  "diagnosis": "Common Cold",
  "sick_days": 3
}
```

**Prescription:**
```json
{
  "medicines": [
    {
      "name": "Paracetamol 500mg",
      "quantity": 10,
      "instructions": "3x sehari"
    }
  ],
  "dispensed_by": "Pharmacist Name"
}
```

---

## 📊 Summary Statistics

| Table | Primary Use | Growth Rate | Retention Policy |
|-------|-------------|-------------|------------------|
| users | System users | Low | Permanent |
| patients | Patient data | Medium | Permanent |
| screenings | Daily operations | High | 2-5 years |
| examinations | Daily operations | High | Permanent (legal) |
| medicines | Inventory | Low-Medium | Permanent |
| prescriptions | Daily operations | High | Permanent (legal) |
| stock_logs | Audit trail | High | 1-2 years |
| medical_records | Reports/Timeline | High | Permanent (legal) |

---

## 🔒 Data Security Notes

### PII (Personally Identifiable Information)
- `patients`: name, email, phone, address, date_of_birth
- `users`: name, email

### Sensitive Medical Data
- `screenings`: all vital signs data
- `examinations`: diagnosis, anamnesis, physical_examination
- `prescriptions`: medicine details, instructions

### Compliance
- HIPAA compliance recommended
- Data encryption at rest
- Audit logging for all access
- Regular backup strategy
- Access control by role

---

## 📝 Maintenance Recommendations

### Daily
- Monitor low stock alerts
- Check expired medicine
- Backup database

### Weekly
- Review stock logs for anomalies
- Check failed jobs queue
- Performance monitoring

### Monthly
- Archive old medical records
- Database optimization
- User access audit

### Yearly
- Data retention policy review
- Schema optimization
- Migration planning

---

**Last Updated:** November 8, 2025  
**Database Version:** 1.0  
**Laravel Version:** 10.x
