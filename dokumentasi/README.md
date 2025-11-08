# Dokumentasi Sistem Informasi Klinik

Dokumentasi lengkap untuk Sistem Informasi Klinik berbasis web menggunakan Laravel.

## 📁 Struktur Dokumentasi

```
dokumentasi/
├── kebutuhan-fungsional/          # Functional Requirements (FR)
├── kebutuhan-non-fungsional/      # Non-Functional Requirements (NFR)
├── use-case/                      # Use Case Diagram
├── deskripsi-use-case/            # Use Case Description
├── activity-diagram/              # Activity Diagram
├── class-diagram/                 # Class Diagram
├── sequence-diagram/              # Sequence Diagram
└── database-design/               # Database Design & ERD
```

## 📋 Daftar Dokumen

### 1. Kebutuhan Fungsional (FR)
📂 Folder: `kebutuhan-fungsional/`

Berisi daftar lengkap kebutuhan fungsional sistem untuk 4 role:
- **Admin** - Manajemen sistem, master data, laporan, user
- **Nurse/Perawat** - Registrasi, pendaftaran, pemeriksaan awal
- **Doctor/Dokter** - Konsultasi, diagnosis, resep, surat keterangan
- **Pharmacist/Apoteker** - Proses resep, stok obat, pembelian

📄 **File:** (Akan dibuat sesuai kebutuhan)

---

### 2. Kebutuhan Non-Fungsional (NFR)
📂 Folder: `kebutuhan-non-fungsional/`

Berisi 34 NFR dalam 10 kategori:
- 🔒 Keamanan (Security) - 6 NFR
- ⚡ Performa (Performance) - 4 NFR
- 🛡️ Keandalan (Reliability) - 4 NFR
- 👥 Kegunaan (Usability) - 4 NFR
- 📈 Skalabilitas (Scalability) - 2 NFR
- 🔧 Maintainability - 3 NFR
- 💻 Portabilitas (Portability) - 3 NFR
- 🔗 Kompatibilitas (Compatibility) - 2 NFR
- 💾 Backup & Recovery - 3 NFR
- ⚖️ Compliance & Regulasi - 3 NFR

📄 **File:** `kebutuhan-non-fungsional.md`

---

### 3. Use Case Diagram
📂 Folder: `use-case/`

Berisi diagram use case untuk semua role:
- Use case gabungan (semua role dalam 1 diagram)
- Use case per role (Admin, Nurse, Doctor, Pharmacist)

📄 **File:**
- `use-case-diagram.md` - Dokumentasi lengkap dengan diagram Mermaid
- `use-case-diagram.mmd` - Source diagram gabungan (horizontal)
- `use-case-diagram.png` - Gambar PNG diagram gabungan
- `use-case-vertical.mmd` - Source diagram gabungan (vertical)
- `use-case-vertical.png` - Gambar PNG vertical
- `usecase-admin.mmd` & `usecase-admin.png` - Diagram Admin
- `usecase-nurse.mmd` & `usecase-nurse.png` - Diagram Nurse
- `usecase-doctor.mmd` & `usecase-doctor.png` - Diagram Doctor
- `usecase-pharmacist.mmd` & `usecase-pharmacist.png` - Diagram Pharmacist

**Total:** 76 Use Cases

---

### 4. Deskripsi Use Case
📂 Folder: `deskripsi-use-case/`

Berisi deskripsi detail untuk setiap use case:
- ID & Nama Use Case
- Actor yang terlibat
- Deskripsi singkat
- Precondition & Postcondition
- Main Flow (alur normal)
- Alternative Flow (alur alternatif)

📄 **File:** `deskripsi-usecase.md`

**Total:** 96+ Use Case lengkap dengan deskripsi

---

### 5. Activity Diagram
📂 Folder: `activity-diagram/`

Berisi diagram alur proses bisnis utama:

📄 **File:**
- `activity-diagram-registrasi.mmd` & `.png` - Proses Registrasi Pasien & Pendaftaran
- `activity-diagram-pemeriksaan-awal.mmd` & `.png` - Proses Pemeriksaan Awal oleh Perawat
- `activity-diagram-pemeriksaan-dokter.mmd` & `.png` - Proses Konsultasi & Pemeriksaan Dokter
- `activity-diagram-proses-resep.mmd` & `.png` - Proses Resep oleh Apoteker
- `activity-diagram-manajemen-stok.mmd` & `.png` - Manajemen Stok Obat

---

### 6. Class Diagram
📂 Folder: `class-diagram/`

Berisi diagram struktur class dan relationship antar class:

📄 **File:**
- `class-diagram.mmd` - Class diagram lengkap (full attributes & methods)
- `class-diagram-simplified.mmd` - Class diagram simplified untuk presentasi
- `README.md` - Dokumentasi lengkap class structure

**Total:** 8 Classes (User, Patient, Screening, Examination, Medicine, Prescription, StockLog, MedicalRecord)

**Key Features:**
- ✅ Semua attributes dengan data types
- ✅ Semua methods (relationships & computed properties)
- ✅ Relationship cardinality (1-to-many)
- ✅ Laravel Eloquent patterns
- ✅ Design patterns (Factory, Accessor/Mutator)

---

### 7. Sequence Diagram
📂 Folder: `sequence-diagram/`

Berisi diagram interaksi antar komponen dalam berbagai use case:

📄 **File:**
- `sequence-login-autentikasi.mmd` - Login & authentication flow
- `sequence-registrasi-pasien.mmd` - Patient registration process
- `sequence-pemeriksaan-awal.mmd` - Screening by nurse
- `sequence-pemeriksaan-dokter.mmd` - Examination & prescription by doctor
- `sequence-proses-resep.mmd` - Prescription dispensing by pharmacist
- `sequence-manajemen-stok.mmd` - Medicine stock management
- `README.md` - Dokumentasi lengkap interaction flows

**Total:** 6 Sequence Diagrams

**Key Features:**
- ✅ Actor-Component interactions
- ✅ Request-Response cycles
- ✅ Database transactions
- ✅ Error handling flows
- ✅ Alternative scenarios
- ✅ Business logic details

---

### 8. Database Design
📂 Folder: `database-design/`

Berisi desain struktur database dan ERD:

📄 **File:**
- `erd-diagram.mmd` - Entity Relationship Diagram
- `database-relationship-overview.mmd` - Database relationship overview
- `data-dictionary.md` - Data dictionary lengkap
- `README.md` - Dokumentasi database design

**Total:** 8 Tables + supporting tables

**Key Features:**
- ✅ ERD dengan relationships
- ✅ Data dictionary semua tabel & field
- ✅ Foreign key constraints
- ✅ Indexing strategy
- ✅ Migration order

---

## 🚀 Cara Menggunakan

### Lihat Diagram di VS Code
1. Install extension: **Markdown Preview Mermaid Support**
2. Buka file `.md` atau `.mmd`
3. Tekan `Ctrl+Shift+V` untuk preview

### Generate Diagram ke PNG
Gunakan script yang sudah disediakan di root project:
```bash
bash generate-diagram.sh
```

Atau manual per file:
```bash
# Use Case Diagram
mmdc -i dokumentasi/use-case/use-case-diagram.mmd -o dokumentasi/use-case/use-case-diagram.png -w 3000 -H 2000 -b white

# Activity Diagram
mmdc -i dokumentasi/activity-diagram/activity-diagram-registrasi.mmd -o dokumentasi/activity-diagram/activity-diagram-registrasi.png -w 2000 -H 2500 -b white
```

### Edit Diagram
1. Edit file `.mmd` dengan Mermaid syntax
2. Preview perubahan di VS Code
3. Generate ulang PNG dengan script

### View Online
Copy paste kode Mermaid dari file `.mmd` ke:
- https://mermaid.live
- https://mermaid-js.github.io/mermaid-live-editor

---

## 📊 Ringkasan Dokumentasi

| Kategori | Jumlah | Format |
|----------|--------|--------|
| Kebutuhan Non-Fungsional | 34 NFR | Markdown |
| Use Case | 76+ UC | Diagram + Deskripsi |
| Activity Diagram | 5 Proses | Diagram Mermaid |
| Class Diagram | 8 Classes | Diagram Mermaid |
| Sequence Diagram | 6 Flows | Diagram Mermaid |
| Database Design | 8 Tables | ERD + Data Dictionary |
| Role User | 4 Role | - |

---

## 🔧 Tools yang Digunakan

- **Mermaid** - Diagram as code (use case & activity diagram)
- **Mermaid CLI** - Convert diagram ke PNG/SVG
- **Markdown** - Dokumentasi text
- **VS Code** - Editor dengan Mermaid support

---

## 📝 Catatan Penting

1. **Format Diagram**: Semua diagram menggunakan Mermaid syntax
2. **Source Control**: File `.mmd` adalah source, `.png` adalah output
3. **Update**: Jika edit diagram, jangan lupa regenerate PNG
4. **Backup**: File dokumentasi di-commit ke Git

---

## 👥 Role & Akses

| Role | Akses Utama |
|------|-------------|
| **Admin** | Full access - Manajemen sistem, master data, laporan, user |
| **Nurse** | Registrasi pasien, pendaftaran, pemeriksaan awal, tindakan |
| **Doctor** | Konsultasi, diagnosis, resep, surat keterangan, laporan pribadi |
| **Pharmacist** | Proses resep, stok obat, pembelian, laporan apotek |

---

## 📅 Versi Dokumentasi

- **Versi:** 1.0
- **Tanggal:** November 2025
- **Status:** ✅ Lengkap

---

## 📧 Kontak

Untuk pertanyaan atau update dokumentasi, hubungi tim development.

---

**© 2025 - Sistem Informasi Klinik**
