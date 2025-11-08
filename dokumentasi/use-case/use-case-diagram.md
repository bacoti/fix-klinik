# Use Case Diagram - Sistem Informasi Klinik

## Use Case Diagram Lengkap - Semua Role dalam Satu Diagram

```mermaid
%%{init: {'theme':'default'}}%%
flowchart TB
    %% Actors
    Admin((Admin))
    Nurse((Nurse<br/>Perawat))
    Doctor((Dokter))
    Pharmacist((Apoteker))
    
    subgraph System["SISTEM INFORMASI KLINIK"]
        
        subgraph Auth["AUTENTIKASI & PROFIL"]
            UC1[Login]
            UC2[Logout]
            UC3[Ganti Password]
            UC4[Edit Profil]
            UC5[Lihat Notifikasi]
        end
        
        subgraph Patient["MANAJEMEN PASIEN"]
            UC6[Registrasi Pasien Baru]
            UC7[Lihat Data Pasien]
            UC8[Edit Data Pasien]
            UC9[Hapus Data Pasien]
            UC10[Lihat Riwayat Medis]
            UC11[Export Data Pasien]
        end
        
        subgraph Queue["PENDAFTARAN & ANTRIAN"]
            UC12[Daftar Kunjungan]
            UC13[Kelola Antrian]
            UC14[Panggil Antrian]
            UC15[Update Status Antrian]
            UC16[Cetak Kartu Antrian]
            UC17[Monitor Antrian]
        end
        
        subgraph Screening["PEMERIKSAAN AWAL"]
            UC18[Input Vital Sign]
            UC19[Input Anamnesa Awal]
            UC20[Input Alergi]
            UC21[Upload Hasil Lab]
            UC22[Transfer ke Dokter]
        end
        
        subgraph Examination["KONSULTASI DOKTER"]
            UC23[Input Anamnesa Lengkap]
            UC24[Input Pemeriksaan Fisik]
            UC25[Input Diagnosis]
            UC26[Input Tindakan Medis]
            UC27[Buat Resep Obat]
            UC28[Lihat Riwayat Pemeriksaan]
        end
        
        subgraph Certificate["SURAT KETERANGAN"]
            UC29[Buat Surat Sakit]
            UC30[Buat Surat Sehat]
            UC31[Buat Surat Rujukan]
        end
        
        subgraph Pharmacy["APOTEK & RESEP"]
            UC32[Lihat Resep Pending]
            UC33[Verifikasi Resep]
            UC34[Racik Obat]
            UC35[Cetak Label Obat]
            UC36[Penjualan OTC]
            UC37[Hitung Total Obat]
        end
        
        subgraph Stock["MANAJEMEN STOK"]
            UC38[Tambah Obat Baru]
            UC39[Input Stok Masuk]
            UC40[Input Stok Keluar]
            UC41[Stok Opname]
            UC42[Lihat Kartu Stok]
            UC43[Alert Stok Minimum]
            UC44[Alert Obat Kadaluarsa]
        end
        
        subgraph Purchase["PEMBELIAN"]
            UC45[Kelola Supplier]
            UC46[Buat Purchase Order]
            UC47[Terima Barang]
            UC48[Retur Pembelian]
        end
        
        subgraph Payment["PEMBAYARAN"]
            UC49[Lihat Tagihan]
            UC50[Proses Pembayaran]
            UC51[Apply Diskon]
            UC52[Cetak Kuitansi]
            UC53[Kelola Cicilan]
        end
        
        subgraph Master["MASTER DATA"]
            UC54[Kelola Master Dokter]
            UC55[Kelola Master Perawat]
            UC56[Kelola Master Tindakan]
            UC57[Kelola Master Ruangan]
            UC58[Kelola Master Poli]
            UC59[Kelola Master Diagnosis]
        end
        
        subgraph User["MANAJEMEN USER"]
            UC60[Tambah User]
            UC61[Edit User]
            UC62[Hapus User]
            UC63[Reset Password]
            UC64[Kelola Role Permission]
        end
        
        subgraph Report["LAPORAN"]
            UC65[Laporan Keuangan]
            UC66[Laporan Kunjungan]
            UC67[Laporan Pasien]
            UC68[Laporan Apotek]
            UC69[Laporan Kinerja]
            UC70[Export Laporan]
        end
        
        subgraph Setting["PENGATURAN SISTEM"]
            UC71[Pengaturan Umum]
            UC72[Pengaturan Tarif]
            UC73[Pengaturan Notifikasi]
            UC74[Backup Database]
            UC75[Restore Database]
            UC76[Activity Log]
        end
    end
    
    %% ADMIN CONNECTIONS
    Admin --- UC1 & UC2 & UC3 & UC4 & UC5
    Admin --- UC6 & UC7 & UC8 & UC9 & UC10 & UC11
    Admin --- UC12 & UC13 & UC14 & UC15 & UC16 & UC17
    Admin --- UC49 & UC50 & UC51 & UC52 & UC53
    Admin --- UC54 & UC55 & UC56 & UC57 & UC58 & UC59
    Admin --- UC60 & UC61 & UC62 & UC63 & UC64
    Admin --- UC65 & UC66 & UC67 & UC68 & UC69 & UC70
    Admin --- UC71 & UC72 & UC73 & UC74 & UC75 & UC76
    
    %% NURSE CONNECTIONS
    Nurse --- UC1 & UC2 & UC3 & UC4 & UC5
    Nurse --- UC6 & UC7 & UC8 & UC10
    Nurse --- UC12 & UC13 & UC14 & UC15 & UC16 & UC17
    Nurse --- UC18 & UC19 & UC20 & UC21 & UC22
    Nurse --- UC26
    
    %% DOCTOR CONNECTIONS
    Doctor --- UC1 & UC2 & UC3 & UC4 & UC5
    Doctor --- UC7 & UC10
    Doctor --- UC14 & UC15 & UC17
    Doctor --- UC23 & UC24 & UC25 & UC26 & UC27 & UC28
    Doctor --- UC29 & UC30 & UC31
    Doctor --- UC66 & UC70
    
    %% PHARMACIST CONNECTIONS
    Pharmacist --- UC1 & UC2 & UC3 & UC4 & UC5
    Pharmacist --- UC32 & UC33 & UC34 & UC35 & UC36 & UC37
    Pharmacist --- UC38 & UC39 & UC40 & UC41 & UC42 & UC43 & UC44
    Pharmacist --- UC45 & UC46 & UC47 & UC48
    Pharmacist --- UC49 & UC50 & UC52
    Pharmacist --- UC68 & UC70
    
    %% Styling
    classDef actorStyle fill:#FFE5B4,stroke:#FF8C00,stroke-width:3px
    classDef ucStyle fill:#E6F3FF,stroke:#4A90E2,stroke-width:2px
    classDef moduleStyle fill:#F0F0F0,stroke:#666,stroke-width:2px
    
    class Admin,Nurse,Doctor,Pharmacist actorStyle
    class UC1,UC2,UC3,UC4,UC5,UC6,UC7,UC8,UC9,UC10,UC11,UC12,UC13,UC14,UC15,UC16,UC17,UC18,UC19,UC20,UC21,UC22,UC23,UC24,UC25,UC26,UC27,UC28,UC29,UC30,UC31,UC32,UC33,UC34,UC35,UC36,UC37,UC38,UC39,UC40,UC41,UC42,UC43,UC44,UC45,UC46,UC47,UC48,UC49,UC50,UC51,UC52,UC53,UC54,UC55,UC56,UC57,UC58,UC59,UC60,UC61,UC62,UC63,UC64,UC65,UC66,UC67,UC68,UC69,UC70,UC71,UC72,UC73,UC74,UC75,UC76 ucStyle
```

## Use Case Diagram per Role

### 1. Admin Use Cases

```mermaid
graph LR
    Admin((Admin))
    
    subgraph "Manajemen Pasien"
        UC1[Registrasi Pasien]
        UC2[Lihat Data Pasien]
        UC3[Edit Data Pasien]
        UC4[Lihat Riwayat Medis]
    end
    
    subgraph "Manajemen Antrian"
        UC5[Daftar Kunjungan]
        UC6[Kelola Antrian]
        UC7[Cetak Kartu]
    end
    
    subgraph "Master Data"
        UC8[Master Dokter]
        UC9[Master Perawat]
        UC10[Master Tindakan]
        UC11[Master Ruangan]
        UC12[Master Obat]
        UC13[Master Supplier]
    end
    
    subgraph "User & System"
        UC14[Kelola User]
        UC15[Role & Permission]
        UC16[Pengaturan Sistem]
        UC17[Backup Database]
        UC18[Activity Log]
    end
    
    subgraph "Laporan"
        UC19[Laporan Keuangan]
        UC20[Laporan Kunjungan]
        UC21[Laporan Pasien]
        UC22[Laporan Apotek]
        UC23[Laporan Kinerja]
    end
    
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14
    Admin --> UC15
    Admin --> UC16
    Admin --> UC17
    Admin --> UC18
    Admin --> UC19
    Admin --> UC20
    Admin --> UC21
    Admin --> UC22
    Admin --> UC23
```

### 2. Nurse (Perawat) Use Cases

```mermaid
graph LR
    Nurse((Nurse))
    
    subgraph "Pendaftaran"
        UC1[Registrasi Pasien Baru]
        UC2[Daftar Kunjungan]
        UC3[Kelola Antrian]
        UC4[Cetak Kartu]
    end
    
    subgraph "Pemeriksaan Awal"
        UC5[Input Vital Sign]
        UC6[Input Anamnesa]
        UC7[Input Alergi]
        UC8[Upload Hasil Lab]
        UC9[Transfer ke Dokter]
    end
    
    subgraph "Tindakan"
        UC10[Assist Tindakan Medis]
        UC11[Kelola Ruangan]
    end
    
    subgraph "Data Pasien"
        UC12[Lihat Data Pasien]
        UC13[Edit Alergi]
        UC14[Lihat Riwayat]
    end
    
    Nurse --> UC1
    Nurse --> UC2
    Nurse --> UC3
    Nurse --> UC4
    Nurse --> UC5
    Nurse --> UC6
    Nurse --> UC7
    Nurse --> UC8
    Nurse --> UC9
    Nurse --> UC10
    Nurse --> UC11
    Nurse --> UC12
    Nurse --> UC13
    Nurse --> UC14
```

### 3. Doctor (Dokter) Use Cases

```mermaid
graph LR
    Doctor((Dokter))
    
    subgraph "Antrian"
        UC1[Lihat Antrian]
        UC2[Panggil Pasien]
        UC3[Update Status]
    end
    
    subgraph "Konsultasi"
        UC4[Input Anamnesa]
        UC5[Input Pemeriksaan Fisik]
        UC6[Input Diagnosis]
        UC7[Input Tindakan]
        UC8[Buat Resep]
    end
    
    subgraph "Surat Keterangan"
        UC9[Surat Sakit]
        UC10[Surat Sehat]
        UC11[Surat Rujukan]
    end
    
    subgraph "Data & Riwayat"
        UC12[Lihat Data Pasien]
        UC13[Lihat Riwayat Medis]
        UC14[Riwayat Pemeriksaan]
    end
    
    subgraph "Jadwal"
        UC15[Lihat Jadwal]
        UC16[Request Perubahan]
    end
    
    subgraph "Laporan"
        UC17[Laporan Pasien Sendiri]
        UC18[Statistik Kinerja]
    end
    
    Doctor --> UC1
    Doctor --> UC2
    Doctor --> UC3
    Doctor --> UC4
    Doctor --> UC5
    Doctor --> UC6
    Doctor --> UC7
    Doctor --> UC8
    Doctor --> UC9
    Doctor --> UC10
    Doctor --> UC11
    Doctor --> UC12
    Doctor --> UC13
    Doctor --> UC14
    Doctor --> UC15
    Doctor --> UC16
    Doctor --> UC17
    Doctor --> UC18
```

### 4. Pharmacist (Apoteker) Use Cases

```mermaid
graph LR
    Pharmacist((Apoteker))
    
    subgraph "Proses Resep"
        UC1[Lihat Resep Pending]
        UC2[Verifikasi Resep]
        UC3[Cek Stok]
        UC4[Racik Obat]
        UC5[Cetak Label]
        UC6[Selesaikan Resep]
    end
    
    subgraph "Penjualan"
        UC7[Penjualan OTC]
        UC8[Hitung Total]
        UC9[Cetak Struk]
    end
    
    subgraph "Stok Obat"
        UC10[Tambah Obat Baru]
        UC11[Input Stok Masuk]
        UC12[Input Stok Keluar]
        UC13[Stok Opname]
        UC14[Kartu Stok]
        UC15[Alert Stok Minimum]
    end
    
    subgraph "Pembelian"
        UC16[Kelola Supplier]
        UC17[Buat PO]
        UC18[Terima Barang]
        UC19[Retur Pembelian]
    end
    
    subgraph "Laporan"
        UC20[Laporan Penjualan]
        UC21[Laporan Stok]
        UC22[Laporan Pembelian]
        UC23[Laporan Laba Apotek]
    end
    
    Pharmacist --> UC1
    Pharmacist --> UC2
    Pharmacist --> UC3
    Pharmacist --> UC4
    Pharmacist --> UC5
    Pharmacist --> UC6
    Pharmacist --> UC7
    Pharmacist --> UC8
    Pharmacist --> UC9
    Pharmacist --> UC10
    Pharmacist --> UC11
    Pharmacist --> UC12
    Pharmacist --> UC13
    Pharmacist --> UC14
    Pharmacist --> UC15
    Pharmacist --> UC16
    Pharmacist --> UC17
    Pharmacist --> UC18
    Pharmacist --> UC19
    Pharmacist --> UC20
    Pharmacist --> UC21
    Pharmacist --> UC22
    Pharmacist --> UC23
```

## Use Case Shared Antar Role

```mermaid
graph TB
    Admin((Admin))
    Nurse((Nurse))
    Doctor((Dokter))
    Pharmacist((Apoteker))
    
    subgraph "Shared Use Cases"
        UC1[Login]
        UC2[Logout]
        UC3[Ganti Password]
        UC4[Edit Profil]
        UC5[Lihat Notifikasi]
        UC6[Activity Log Pribadi]
    end
    
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    
    Nurse --> UC1
    Nurse --> UC2
    Nurse --> UC3
    Nurse --> UC4
    Nurse --> UC5
    Nurse --> UC6
    
    Doctor --> UC1
    Doctor --> UC2
    Doctor --> UC3
    Doctor --> UC4
    Doctor --> UC5
    Doctor --> UC6
    
    Pharmacist --> UC1
    Pharmacist --> UC2
    Pharmacist --> UC3
    Pharmacist --> UC4
    Pharmacist --> UC5
    Pharmacist --> UC6
```

## Cara Menggunakan

1. **Lihat di VS Code**: Install extension "Markdown Preview Mermaid Support"
2. **Export ke Image**: 
   - Buka file ini di VS Code
   - Klik kanan pada diagram
   - Pilih "Export to PNG/SVG"
3. **Online Viewer**: Copy paste kode mermaid ke https://mermaid.live

## Keterangan

- **Garis solid (—>)**: Interaksi utama
- **Garis putus-putus (-.->)**: Interaksi opsional/shared
- **Subgraph**: Pengelompokan use case berdasarkan modul
