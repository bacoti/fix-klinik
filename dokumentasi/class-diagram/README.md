# Class Diagram - Fix Klinik

Dokumentasi Class Diagram untuk Sistem Informasi Klinik.

## 📊 Diagram

### 1. Class Diagram Lengkap
**File:** [`class-diagram.mmd`](./class-diagram.mmd)

Diagram lengkap yang menampilkan:
- ✅ Semua attributes (properties)
- ✅ Semua methods (functions)
- ✅ Semua relationships
- ✅ Data types
- ✅ Multiplicity
- ✅ Notes & enumerations

### 2. Class Diagram Simplified
**File:** [`class-diagram-simplified.mmd`](./class-diagram-simplified.mmd)

Diagram sederhana untuk presentasi yang menampilkan:
- ✅ Main attributes saja
- ✅ Key methods saja
- ✅ Core relationships
- ✅ Lebih mudah dibaca

---

## 🏗️ Struktur Class

### 1. **User** (Authentication & Authorization)
**Extends:** `Authenticatable` (Laravel)  
**Traits:** `HasApiTokens`, `HasFactory`, `Notifiable`

**Properties:**
- `id`: Primary key
- `name`: Nama lengkap user
- `email`: Email (unique)
- `password`: Hashed password
- `role`: Enum (admin, nurse, doctor, pharmacist)
- `email_verified_at`: Timestamp verifikasi email
- `remember_token`: Token untuk "remember me"

**Methods:**
- `screeningsAsNurse()`: Screening yang dilakukan user sebagai nurse
- `examinationsAsDoctor()`: Examination yang dilakukan user sebagai doctor
- `prescriptionsAsPharmacist()`: Prescription yang dispensed oleh pharmacist

**Role Types:**
- `admin` - Administrator sistem
- `nurse` - Perawat (pemeriksaan awal)
- `doctor` - Dokter (diagnosis & treatment)
- `pharmacist` - Apoteker (proses resep)

---

### 2. **Patient** (Data Pasien)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `name`: Nama lengkap pasien
- `email`: Email (unique)
- `phone`: Nomor telepon
- `address`: Alamat lengkap
- `date_of_birth`: Tanggal lahir
- `gender`: Enum (male, female)
- `verified`: Boolean - status verifikasi data

**Methods:**
- `screenings()`: Relasi one-to-many ke Screening
- `latestScreening()`: Screening terakhir
- `examinations()`: Relasi one-to-many ke Examination
- `medicalRecords()`: Relasi one-to-many ke MedicalRecord
- `getAgeAttribute()`: Hitung umur dari date_of_birth
- `getMedicalRecordNumberAttribute()`: Generate nomor rekam medis (MR000001)
- `getRegistrationNumberAttribute()`: Alias untuk medical record number
- `getHasScreeningTodayAttribute()`: Check apakah sudah screening hari ini
- `getHasExaminationTodayAttribute()`: Check apakah sudah examination hari ini
- `getLatestScreeningAttribute()`: Get screening terakhir

**Business Logic:**
- Medical Record Number format: `MR` + 6 digit padded ID (contoh: MR000123)
- Age dihitung otomatis dari date_of_birth
- Validasi mencegah screening/examination duplikat di hari yang sama

---

### 3. **Screening** (Pemeriksaan Awal)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `patient_id`: Foreign key → Patient
- `nurse_id`: Foreign key → User (nurse)
- `temperature`: Suhu tubuh (°C, decimal 1 digit)
- `blood_pressure_systolic`: Tekanan darah sistolik
- `blood_pressure_diastolic`: Tekanan darah diastolik
- `heart_rate`: Denyut nadi (bpm)
- `respiratory_rate`: Laju pernapasan (/menit)
- `oxygen_saturation`: Saturasi oksigen (%)
- `weight`: Berat badan (kg, decimal 2 digit)
- `height`: Tinggi badan (cm, decimal 2 digit)
- `complaints`: Keluhan utama pasien
- `notes`: Catatan tambahan

**Methods:**
- `patient()`: Relasi belongs-to ke Patient
- `nurse()`: Relasi belongs-to ke User
- `getBmiAttribute()`: Hitung BMI dari weight & height
- `getBmiCategoryAttribute()`: Kategori BMI (Underweight, Normal, Overweight, Obese)
- `getBloodPressureAttribute()`: Format tekanan darah (120/80)

**Business Logic:**
- BMI = weight / (height_in_meters²)
- BMI Categories:
  - < 18.5: Underweight
  - 18.5-24.9: Normal
  - 25-29.9: Overweight
  - ≥ 30: Obese
- Blood pressure format: systolic/diastolic (contoh: 120/80)

---

### 4. **Examination** (Pemeriksaan Dokter)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `patient_id`: Foreign key → Patient
- `doctor_id`: Foreign key → User (doctor)
- `anamnesis`: Anamnesis (riwayat penyakit)
- `physical_examination`: Hasil pemeriksaan fisik
- `diagnosis`: Diagnosis dokter
- `prescription_text`: Resep dalam bentuk teks
- `additional_notes`: Catatan tambahan
- `sick_letter`: Boolean - apakah perlu surat sakit
- `sick_days`: Jumlah hari istirahat
- `follow_up_date`: Tanggal kontrol kembali

**Methods:**
- `patient()`: Relasi belongs-to ke Patient
- `doctor()`: Relasi belongs-to ke User
- `prescriptions()`: Relasi one-to-many ke Prescription

**Business Logic:**
- Sick letter (surat sakit) opsional
- Sick days wajib diisi jika sick_letter = true
- Follow-up date untuk jadwal kontrol berikutnya

---

### 5. **Medicine** (Obat)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `name`: Nama obat
- `type`: Enum - jenis obat
- `unit`: Satuan kemasan (strip, bottle, tube, dll)
- `description`: Deskripsi obat
- `stock`: Jumlah stok tersedia
- `price`: Harga per unit (decimal)
- `expired_at`: Tanggal kadaluarsa

**Methods:**
- `prescriptions()`: Relasi one-to-many ke Prescription
- `stockLogs()`: Relasi one-to-many ke StockLog

**Medicine Types:**
- `tablet` - Tablet
- `capsule` - Kapsul
- `syrup` - Sirup
- `injection` - Injeksi
- `cream` - Krim
- `ointment` - Salep

**Business Logic:**
- Stock management dengan tracking log
- Alert untuk obat mendekati expired
- Validasi stock sebelum dispensing

---

### 6. **Prescription** (Resep)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `examination_id`: Foreign key → Examination
- `medicine_id`: Foreign key → Medicine
- `quantity`: Jumlah obat yang diresepkan
- `instructions`: Instruksi penggunaan obat
- `dispensed_at`: Timestamp kapan obat diserahkan
- `dispensed_by`: Foreign key → User (pharmacist)

**Methods:**
- `examination()`: Relasi belongs-to ke Examination
- `medicine()`: Relasi belongs-to ke Medicine
- `dispensedBy()`: Relasi belongs-to ke User

**Business Logic:**
- 1 Examination bisa punya banyak Prescription (multi-medicine)
- Tracking siapa & kapan prescription di-dispense
- Validasi stock medicine sebelum dispense

---

### 7. **StockLog** (Log Stok Obat)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `medicine_id`: Foreign key → Medicine
- `type`: Enum - jenis transaksi stok
- `quantity`: Jumlah perubahan stok
- `description`: Deskripsi transaksi

**Methods:**
- `medicine()`: Relasi belongs-to ke Medicine

**Stock Log Types:**
- `in` - Stok masuk (pembelian, supplier)
- `out` - Stok keluar (terdispense, rusak, expired)
- `adjustment` - Koreksi stok (stock opname)

**Business Logic:**
- Setiap perubahan stok tercatat di log
- Audit trail untuk tracking stok
- Memudahkan analisis penggunaan obat

---

### 8. **MedicalRecord** (Rekam Medis)
**Extends:** `Model`  
**Traits:** `HasFactory`

**Properties:**
- `id`: Primary key
- `patient_id`: Foreign key → Patient
- `activity_type`: Enum - jenis aktivitas
- `details`: JSON - detail aktivitas (flexible)
- `activity_date`: Timestamp aktivitas

**Methods:**
- `patient()`: Relasi belongs-to ke Patient

**Activity Types:**
- `registration` - Registrasi pasien baru
- `screening` - Pemeriksaan awal
- `examination` - Pemeriksaan dokter
- `prescription` - Pemberian resep

**Business Logic:**
- Timeline semua aktivitas pasien
- Format JSON untuk flexibility
- Memudahkan tracking riwayat medis

---

## 🔗 Relationships Summary

### One-to-Many Relationships:

1. **User (Nurse) → Screening**
   - 1 Nurse melakukan banyak Screening
   - Foreign key: `screenings.nurse_id`

2. **User (Doctor) → Examination**
   - 1 Doctor melakukan banyak Examination
   - Foreign key: `examinations.doctor_id`

3. **User (Pharmacist) → Prescription**
   - 1 Pharmacist dispense banyak Prescription
   - Foreign key: `prescriptions.dispensed_by`

4. **Patient → Screening**
   - 1 Patient punya banyak Screening
   - Foreign key: `screenings.patient_id`

5. **Patient → Examination**
   - 1 Patient punya banyak Examination
   - Foreign key: `examinations.patient_id`

6. **Patient → MedicalRecord**
   - 1 Patient punya banyak MedicalRecord
   - Foreign key: `medical_records.patient_id`

7. **Examination → Prescription**
   - 1 Examination bisa punya banyak Prescription
   - Foreign key: `prescriptions.examination_id`

8. **Medicine → Prescription**
   - 1 Medicine bisa diresepkan di banyak Prescription
   - Foreign key: `prescriptions.medicine_id`

9. **Medicine → StockLog**
   - 1 Medicine punya banyak StockLog
   - Foreign key: `stock_logs.medicine_id`

---

## 🎯 Design Patterns

### 1. **Repository Pattern**
Models menggunakan Eloquent ORM sebagai data access layer:
- Separation of concerns
- Testability
- Query builder abstraction

### 2. **Factory Pattern**
Semua models menggunakan `HasFactory` trait:
- Data seeding
- Testing dengan fake data
- Consistent data generation

### 3. **Observer Pattern** (Potential)
Laravel Events & Listeners untuk:
- Send notification after examination
- Update stock after prescription dispensed
- Log activities to medical_records

### 4. **Accessor/Mutator Pattern**
Laravel Accessors untuk computed properties:
- `Patient::getAgeAttribute()`
- `Screening::getBmiAttribute()`
- `Patient::getMedicalRecordNumberAttribute()`

---

## 📐 Inheritance & Traits

### Base Classes:
- `User extends Authenticatable`
  - Laravel's authentication base class
  - Provides auth functionality

- Semua model lain `extends Model`
  - Laravel Eloquent base class
  - ORM functionality

### Traits:
- `HasApiTokens` (User)
  - Laravel Sanctum API authentication
  
- `Notifiable` (User)
  - Laravel notification system
  
- `HasFactory` (All models)
  - Factory pattern implementation

---

## 🔒 Data Validation & Security

### Mass Assignment Protection:
- Gunakan `$fillable` untuk whitelist attributes
- Mencegah mass assignment vulnerability

### Password Security:
- `User::$hidden` menyembunyikan password & token
- Password di-hash dengan bcrypt

### Data Casting:
- Boolean casting untuk `verified`, `sick_letter`
- Datetime casting untuk timestamps
- Decimal casting untuk precision data (BMI, price)
- JSON casting untuk flexible data structure

---

## 📊 Database Considerations

### Indexing Strategy:
- Primary keys (auto-indexed)
- Foreign keys (auto-indexed)
- Unique constraints: `users.email`, `patients.email`
- Additional indexes untuk query optimization:
  - `screenings.created_at`
  - `examinations.follow_up_date`
  - `medicines.expired_at`
  - `medical_records.activity_date`

### Soft Deletes (Optional):
Bisa ditambahkan untuk:
- Users (untuk audit trail)
- Patients (GDPR compliance)
- Medicines (historical data)

---

## 🚀 Cara Melihat Diagram

### Di VS Code:
1. Install extension: **Markdown Preview Mermaid Support**
2. Buka file `.mmd`
3. Klik kanan → **Open Preview** atau tekan `Ctrl+Shift+V`

### Generate ke PNG:
```bash
# Full diagram
mmdc -i dokumentasi/class-diagram/class-diagram.mmd -o dokumentasi/class-diagram/class-diagram.png -w 3000 -H 3500 -b white

# Simplified diagram
mmdc -i dokumentasi/class-diagram/class-diagram-simplified.mmd -o dokumentasi/class-diagram/class-diagram-simplified.png -w 2500 -H 2000 -b white
```

### Online Viewer:
Copy paste kode dari file `.mmd` ke:
- https://mermaid.live/
- https://mermaid-js.github.io/mermaid-live-editor/

---

## 📝 Notes

### Laravel Eloquent Features Used:
- ✅ Eloquent Relationships (belongsTo, hasMany, hasOne)
- ✅ Accessors (virtual attributes)
- ✅ Casting (type conversion)
- ✅ Mass assignment protection
- ✅ Query scopes (whereDate, latest, etc)
- ✅ Timestamps (created_at, updated_at)

### Code Quality:
- ✅ PSR-12 coding standard
- ✅ Type hinting
- ✅ DocBlocks untuk documentation
- ✅ Meaningful method names
- ✅ Single Responsibility Principle

---

## 📅 Version History

- **Version:** 1.0
- **Created:** November 8, 2025
- **Last Updated:** November 8, 2025
- **Status:** ✅ Complete

---

**© 2025 - Fix Klinik System**
