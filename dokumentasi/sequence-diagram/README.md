# Sequence Diagram - Fix Klinik

Dokumentasi Sequence Diagram untuk Sistem Informasi Klinik yang menggambarkan interaksi antar komponen dalam berbagai use case.

## 📊 Daftar Sequence Diagram

### 1. **Login & Autentikasi**
**File:** [`sequence-login-autentikasi.mmd`](./sequence-login-autentikasi.mmd)

**Actors:** User (Admin/Nurse/Doctor/Pharmacist)

**Flow:**
1. User membuka halaman login
2. Input email & password
3. Sistem validasi credentials
4. Verifikasi password hash
5. Create session & authentication cookie
6. Redirect ke dashboard sesuai role

**Key Points:**
- ✅ Password verification dengan bcrypt
- ✅ Session management
- ✅ Role-based dashboard routing
- ✅ Error handling untuk invalid credentials

---

### 2. **Registrasi Pasien Baru**
**File:** [`sequence-registrasi-pasien.mmd`](./sequence-registrasi-pasien.mmd)

**Actors:** Nurse

**Flow:**
1. Nurse membuka form registrasi
2. Input data pasien (nama, email, phone, address, DOB, gender)
3. Validasi client-side & server-side
4. Check email uniqueness
5. Insert patient data ke database
6. Generate medical record number (MR000001)
7. Create medical record entry (activity: registration)
8. Tampilkan success dengan medical record number

**Key Points:**
- ✅ Email uniqueness validation
- ✅ Medical record number auto-generation
- ✅ Dual validation (client & server)
- ✅ Medical record tracking dari awal

---

### 3. **Pemeriksaan Awal (Screening) oleh Perawat**
**File:** [`sequence-pemeriksaan-awal.mmd`](./sequence-pemeriksaan-awal.mmd)

**Actors:** Nurse

**Flow:**
1. Nurse memilih pasien dari daftar
2. Input vital signs:
   - Temperature
   - Blood Pressure (systolic/diastolic)
   - Heart Rate
   - Respiratory Rate
   - Oxygen Saturation
3. Input anthropometry:
   - Weight
   - Height
4. Sistem calculate BMI otomatis
5. Input keluhan utama & notes
6. Submit screening data
7. Check duplikasi screening hari ini
8. Insert screening data
9. Create medical record entry (activity: screening)
10. Pasien masuk ke antrian dokter

**Key Points:**
- ✅ Auto-calculation BMI & category
- ✅ Prevent duplicate screening di hari yang sama
- ✅ Comprehensive vital signs tracking
- ✅ Auto-queue untuk dokter

---

### 4. **Pemeriksaan Dokter & Resep**
**File:** [`sequence-pemeriksaan-dokter.mmd`](./sequence-pemeriksaan-dokter.mmd)

**Actors:** Doctor

**Flow:**
1. Doctor melihat antrian pasien (yang sudah screening)
2. Pilih pasien untuk diperiksa
3. View patient data & screening results
4. Input anamnesis (riwayat penyakit)
5. Input physical examination
6. Input diagnosis
7. (Optional) Pilih obat & buat resep:
   - Pilih obat dari database
   - Input quantity & instructions
   - Multiple medicines support
8. (Optional) Centang surat sakit & input jumlah hari
9. (Optional) Input follow-up date
10. Input additional notes
11. Submit examination
12. Check duplikasi examination hari ini
13. Insert examination data
14. Insert prescriptions (jika ada)
15. Create medical record entry (activity: examination)
16. Pasien masuk antrian apotek (jika ada resep)

**Key Points:**
- ✅ Integration dengan screening data
- ✅ Multi-medicine prescription support
- ✅ Sick letter generation
- ✅ Follow-up scheduling
- ✅ Prevent duplicate examination
- ✅ Auto-queue ke apotek jika ada resep

---

### 5. **Proses Resep oleh Apoteker**
**File:** [`sequence-proses-resep.mmd`](./sequence-proses-resep.mmd)

**Actors:** Pharmacist

**Flow:**
1. Pharmacist lihat antrian resep (not dispensed)
2. Pilih pasien untuk proses resep
3. View examination details, patient info, prescriptions
4. Loop untuk setiap obat:
   - Check stock availability
   - Jika stock cukup: siapkan obat
   - Jika stock tidak cukup: beli/adjust atau skip
5. Confirm semua obat siap
6. Submit dispensing
7. Database transaction BEGIN
8. Loop untuk setiap obat:
   - Lock medicine stock
   - Check stock >= quantity
   - Update prescription (dispensed_at, dispensed_by)
   - Update medicine stock (decrease)
   - Insert stock_log (type: out)
9. Create medical record entry (activity: prescription)
10. COMMIT transaction
11. Print labels obat

**Key Points:**
- ✅ **Database Transaction** untuk atomic operation
- ✅ **Stock locking** untuk prevent race condition
- ✅ **Auto rollback** jika ada error
- ✅ **Stock validation** sebelum dispense
- ✅ **Complete audit trail** via stock_log
- ✅ Print labels untuk packaging

**Critical:**
- Menggunakan transaction untuk menjamin konsistensi data
- All or nothing operation (jika 1 obat gagal, semua rollback)

---

### 6. **Manajemen Stok Obat**
**File:** [`sequence-manajemen-stok.mmd`](./sequence-manajemen-stok.mmd)

**Actors:** Pharmacist

**Flow:**

#### A. Stock In (Tambah Stok)
1. Pilih obat
2. Input quantity masuk
3. Input description (supplier, PO number)
4. BEGIN transaction
5. UPDATE stock = stock + quantity
6. INSERT stock_log (type: in)
7. COMMIT transaction

#### B. Stock Out (Kurangi Stok)
1. Pilih obat
2. Input quantity keluar
3. Input reason (expired, rusak, dll)
4. BEGIN transaction
5. Check stock >= quantity
6. UPDATE stock = stock - quantity
7. INSERT stock_log (type: out)
8. COMMIT transaction

#### C. Stock Adjustment (Koreksi Stok)
1. Pilih obat
2. View current stock
3. Input stok fisik aktual
4. Calculate difference
5. Input reason (stock opname)
6. BEGIN transaction
7. UPDATE stock = actual_stock
8. INSERT stock_log (type: adjustment, quantity: difference)
9. COMMIT transaction

#### D. View Stock History
1. Pilih obat
2. GET stock_logs by medicine_id
3. Tampilkan history (date, type, quantity, description)

**Key Points:**
- ✅ **3 jenis transaksi** stok: in, out, adjustment
- ✅ **Transaction-based** untuk data integrity
- ✅ **Complete audit trail** untuk semua perubahan
- ✅ **Stock validation** untuk prevent negative stock
- ✅ **History tracking** untuk analisis

---

## 🔄 Interaction Patterns

### 1. **MVC Pattern**
Semua sequence diagram mengikuti pola MVC:
- **Actor** → **View (Page)** → **Controller** → **Model/Database**
- Response: **Database** → **Controller** → **View** → **Actor**

### 2. **Request-Response Cycle**
- User action → HTTP Request → Server Processing → HTTP Response → UI Update

### 3. **Database Transaction Pattern**
Untuk operasi critical (stock, prescription):
```
BEGIN TRANSACTION
  → Multiple operations
  → If all success: COMMIT
  → If any fail: ROLLBACK
```

### 4. **Validation Pattern**
Dual validation untuk data integrity:
- **Client-side:** Immediate feedback, better UX
- **Server-side:** Security, data integrity

### 5. **Audit Trail Pattern**
Setiap major activity tercatat di `medical_records`:
- Registration
- Screening
- Examination
- Prescription dispensing

---

## 🎯 Design Principles

### 1. **Atomicity**
- Database transactions untuk operasi multi-step
- All-or-nothing approach
- Auto rollback on error

### 2. **Consistency**
- Foreign key constraints
- Stock validation sebelum operation
- Duplicate prevention (screening/examination per day)

### 3. **Isolation**
- Row-level locking untuk stock
- Prevent concurrent update conflicts
- Transaction isolation levels

### 4. **Durability**
- Persistent storage di database
- Stock logs untuk audit trail
- Medical records untuk compliance

### 5. **Error Handling**
- Graceful error messages
- Transaction rollback
- User-friendly error display

---

## 📊 Object Lifecycle

### Patient Lifecycle:
```
Registration → Screening → Examination → Prescription (optional) → Complete
```

### Prescription Lifecycle:
```
Created (by Doctor) → Queued → Dispensed (by Pharmacist) → Complete
```

### Medicine Stock Lifecycle:
```
Stock In → Available → Dispensed/Out → Log Created
```

---

## 🔐 Security Considerations

### Authentication:
- Password hashing (bcrypt)
- Session management
- Remember token

### Authorization:
- Role-based access control
- Each action checks user role
- Dashboard routing by role

### Data Validation:
- Input sanitization
- SQL injection prevention (Eloquent ORM)
- XSS protection (Laravel Blade)

### Transaction Security:
- CSRF token (Laravel)
- Database locking
- Atomic operations

---

## 🚀 Performance Optimizations

### Database:
- Eager loading untuk prevent N+1 queries
- Indexing pada foreign keys
- Transaction untuk batch operations

### Caching (Future):
- Medicine list caching
- Patient search results
- Dashboard statistics

### Query Optimization:
- SELECT only needed columns
- WHERE clauses untuk filter
- LIMIT untuk pagination

---

## 📱 User Experience Flow

### Nurse Flow:
```
Login → Dashboard → Register Patient → Screening → Queue Pasien ke Dokter
```

### Doctor Flow:
```
Login → Dashboard → View Queue → Examination → Prescription → Queue ke Apotek
```

### Pharmacist Flow:
```
Login → Dashboard → View Prescription Queue → Dispense → Stock Management
```

### Admin Flow:
```
Login → Dashboard → View Reports → Manage Users → Manage Master Data
```

---

## 🛠️ Cara Melihat Diagram

### Di VS Code:
1. Install extension: **Markdown Preview Mermaid Support**
2. Buka file `.mmd`
3. Klik kanan → **Open Preview** atau `Ctrl+Shift+V`

### Generate ke PNG:
```bash
# Login & Autentikasi
mmdc -i dokumentasi/sequence-diagram/sequence-login-autentikasi.mmd -o dokumentasi/sequence-diagram/sequence-login-autentikasi.png -w 2000 -H 1500 -b white

# Registrasi Pasien
mmdc -i dokumentasi/sequence-diagram/sequence-registrasi-pasien.mmd -o dokumentasi/sequence-diagram/sequence-registrasi-pasien.png -w 2000 -H 2000 -b white

# Pemeriksaan Awal
mmdc -i dokumentasi/sequence-diagram/sequence-pemeriksaan-awal.mmd -o dokumentasi/sequence-diagram/sequence-pemeriksaan-awal.png -w 2000 -H 2500 -b white

# Pemeriksaan Dokter
mmdc -i dokumentasi/sequence-diagram/sequence-pemeriksaan-dokter.mmd -o dokumentasi/sequence-diagram/sequence-pemeriksaan-dokter.png -w 2000 -H 3000 -b white

# Proses Resep
mmdc -i dokumentasi/sequence-diagram/sequence-proses-resep.mmd -o dokumentasi/sequence-diagram/sequence-proses-resep.png -w 2000 -H 3000 -b white

# Manajemen Stok
mmdc -i dokumentasi/sequence-diagram/sequence-manajemen-stok.mmd -o dokumentasi/sequence-diagram/sequence-manajemen-stok.png -w 2000 -H 3000 -b white
```

### Online Viewer:
Copy paste kode dari file `.mmd` ke:
- https://mermaid.live/
- https://mermaid-js.github.io/mermaid-live-editor/

---

## 📋 Checklist Diagram

- ✅ Login & Autentikasi
- ✅ Registrasi Pasien Baru
- ✅ Pemeriksaan Awal (Screening)
- ✅ Pemeriksaan Dokter & Resep
- ✅ Proses Resep oleh Apoteker
- ✅ Manajemen Stok Obat

**Total:** 6 Sequence Diagrams lengkap

---

## 📝 Notes

### Mermaid Sequence Diagram Syntax:
- `actor` - External user
- `participant` - System component
- `->` - Synchronous message
- `-->` - Response/return
- `alt/else/end` - Alternative flow
- `loop/end` - Iteration
- `Note over` - Additional information

### Best Practices:
- ✅ Clear actor & participant names
- ✅ Descriptive message labels
- ✅ Alternative flows untuk error handling
- ✅ Notes untuk explain business logic
- ✅ Transaction boundaries clearly marked

---

## 📅 Version History

- **Version:** 1.0
- **Created:** November 8, 2025
- **Last Updated:** November 8, 2025
- **Status:** ✅ Complete

---

**© 2025 - Fix Klinik System**
