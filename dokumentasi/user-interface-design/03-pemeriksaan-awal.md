# UI Design: Pemeriksaan Awal (Screening)

## 📄 Halaman: Form Pemeriksaan Awal oleh Perawat

**Role:** Nurse  
**Route:** `/nurse/screening/{patient_id}`

### Layout Wireframe

```
┌──────────────────────────────────────────────────────────────────────────┐
│ [Logo] FIX KLINIK    [Nurse Dashboard] [Profile ▼] [Logout]             │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Dashboard > Daftar Pasien > Pemeriksaan Awal                            │
│                                                                          │
│  ┌────────────────────────────────────────────────────────────────────┐ │
│  │  📋 PEMERIKSAAN AWAL (SCREENING)                                   │ │
│  ├────────────────────────────────────────────────────────────────────┤ │
│  │                                                                    │ │
│  │  Data Pasien                                                       │ │
│  │  ─────────────────────────────────────────────────────────────     │ │
│  │  Nama          : Ahmad Zainudin                                    │ │
│  │  No. RM        : MR000123                                          │ │
│  │  Umur          : 35 tahun                                          │ │
│  │  Jenis Kelamin : Laki-laki                                         │ │
│  │                                                                    │ │
│  │  ──────────────────────────────────────────────────────────────    │ │
│  │                                                                    │ │
│  │  🌡️ Tanda-tanda Vital                                              │ │
│  │  ─────────────────────────────────────────────────────────────     │ │
│  │                                                                    │ │
│  │  Suhu Tubuh (°C) *               Tekanan Darah *                   │ │
│  │  [______] °C                     [____] / [____] mmHg              │ │
│  │                                  (Sistolik / Diastolik)            │ │
│  │                                                                    │ │
│  │  Denyut Nadi *                   Laju Pernapasan *                 │ │
│  │  [______] bpm                    [______] /menit                   │ │
│  │                                                                    │ │
│  │  Saturasi Oksigen *                                                │ │
│  │  [______] %                                                        │ │
│  │                                                                    │ │
│  │  ──────────────────────────────────────────────────────────────    │ │
│  │                                                                    │ │
│  │  📏 Antropometri                                                    │ │
│  │  ─────────────────────────────────────────────────────────────     │ │
│  │                                                                    │ │
│  │  Berat Badan (kg) *              Tinggi Badan (cm) *               │ │
│  │  [______] kg                     [______] cm                       │ │
│  │                                                                    │ │
│  │  BMI (otomatis)                  Kategori                          │ │
│  │  [  23.45  ]                     [  Normal  ]                      │ │
│  │                                                                    │ │
│  │  ──────────────────────────────────────────────────────────────    │ │
│  │                                                                    │ │
│  │  💬 Keluhan & Catatan                                               │ │
│  │  ─────────────────────────────────────────────────────────────     │ │
│  │                                                                    │ │
│  │  Keluhan Utama *                                                   │ │
│  │  [___________________________________________________________]      │ │
│  │  [___________________________________________________________]      │ │
│  │  [___________________________________________________________]      │ │
│  │                                                                    │ │
│  │  Catatan Tambahan                                                  │ │
│  │  [___________________________________________________________]      │ │
│  │  [___________________________________________________________]      │ │
│  │                                                                    │ │
│  │  [  Batal  ]                          [  Simpan & Lanjut  ]       │ │
│  │                                                                    │ │
│  └────────────────────────────────────────────────────────────────────┘ │
│                                                                          │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 📥 Input Design

### Form Sections

#### 1. Data Pasien (Read-Only)
Informasi pasien yang sudah terdaftar, tidak bisa diedit.

#### 2. Tanda-tanda Vital

| Field Name | Type | Unit | Required | Range | Validation |
|------------|------|------|----------|-------|------------|
| Suhu Tubuh | decimal | °C | ✅ Yes | 35-42 | 1 decimal place |
| Tekanan Darah Sistolik | integer | mmHg | ✅ Yes | 60-250 | Integer only |
| Tekanan Darah Diastolik | integer | mmHg | ✅ Yes | 40-150 | Integer only |
| Denyut Nadi | integer | bpm | ✅ Yes | 40-200 | Integer only |
| Laju Pernapasan | integer | /menit | ✅ Yes | 10-60 | Integer only |
| Saturasi Oksigen | integer | % | ✅ Yes | 70-100 | Integer only |

#### 3. Antropometri

| Field Name | Type | Unit | Required | Range | Validation |
|------------|------|------|----------|-------|------------|
| Berat Badan | decimal | kg | ✅ Yes | 1-300 | 2 decimal places |
| Tinggi Badan | decimal | cm | ✅ Yes | 30-250 | 2 decimal places |
| BMI | decimal | - | ❌ Auto | - | Auto-calculated |
| Kategori BMI | text | - | ❌ Auto | - | Auto-generated |

#### 4. Keluhan & Catatan

| Field Name | Type | Required | Max Length | Validation |
|------------|------|----------|------------|------------|
| Keluhan Utama | textarea | ✅ Yes | 1000 | Min 10 chars |
| Catatan Tambahan | textarea | ❌ No | 500 | - |

---

## 📐 Auto-Calculation: BMI

### Formula
```
BMI = Berat Badan (kg) / (Tinggi Badan (m))²
```

### Kategori BMI (Indonesia)

| BMI Range | Kategori | Color |
|-----------|----------|-------|
| < 18.5 | Underweight (Kurus) | 🟡 Orange |
| 18.5 - 24.9 | Normal | 🟢 Green |
| 25.0 - 29.9 | Overweight (Gemuk) | 🟡 Orange |
| ≥ 30.0 | Obese (Obesitas) | 🔴 Red |

### Display

**BMI Result:**
```
┌─────────────────────────────────┐
│ BMI: 23.45                      │
│ Kategori: Normal ✓              │
│ [Warna hijau sebagai indikator] │
└─────────────────────────────────┘
```

---

## 📊 Validation Rules

### Tanda Vital - Normal Ranges (for Warning)

| Vital Sign | Normal Range | Warning |
|------------|--------------|---------|
| Suhu | 36.5 - 37.5°C | Show ⚠️ if outside |
| Tekanan Darah Sistolik | 90 - 120 mmHg | Show ⚠️ if < 90 or > 140 |
| Tekanan Darah Diastolik | 60 - 80 mmHg | Show ⚠️ if < 60 or > 90 |
| Denyut Nadi | 60 - 100 bpm | Show ⚠️ if outside |
| Laju Pernapasan | 12 - 20 /menit | Show ⚠️ if outside |
| Saturasi Oksigen | 95 - 100% | Show ⚠️ if < 95% |

**Note:** Warning bukan error, data tetap bisa disimpan.

### Error Messages

| Field | Error Type | Message |
|-------|------------|---------|
| Suhu Tubuh | Empty | "Suhu tubuh wajib diisi" |
| Suhu Tubuh | Out of Range | "Suhu tubuh harus antara 35-42°C" |
| Tekanan Darah | Empty | "Tekanan darah wajib diisi" |
| Tekanan Darah | Invalid | "Sistolik harus lebih besar dari diastolik" |
| Denyut Nadi | Empty | "Denyut nadi wajib diisi" |
| Denyut Nadi | Out of Range | "Denyut nadi harus antara 40-200 bpm" |
| Laju Pernapasan | Empty | "Laju pernapasan wajib diisi" |
| Saturasi Oksigen | Empty | "Saturasi oksigen wajib diisi" |
| Saturasi Oksigen | Out of Range | "Saturasi oksigen harus antara 70-100%" |
| Berat Badan | Empty | "Berat badan wajib diisi" |
| Tinggi Badan | Empty | "Tinggi badan wajib diisi" |
| Keluhan Utama | Empty | "Keluhan utama wajib diisi" |
| Keluhan Utama | Too Short | "Keluhan minimal 10 karakter" |

---

## 📤 Output Design

### Success Output

**Modal:**
```
┌─────────────────────────────────────────┐
│           ✅ BERHASIL!                  │
├─────────────────────────────────────────┤
│                                         │
│  Pemeriksaan awal berhasil disimpan!   │
│                                         │
│  Pasien: Ahmad Zainudin (MR000123)     │
│                                         │
│  Hasil:                                 │
│  • Suhu: 36.5°C                        │
│  • Tekanan Darah: 120/80 mmHg          │
│  • BMI: 23.45 (Normal)                 │
│                                         │
│  Pasien telah masuk ke antrian dokter  │
│                                         │
│  [  Kembali ke Daftar  ]  [  Lihat  ]  │
│                                         │
└─────────────────────────────────────────┘
```

**Behavior:**
- Show success message
- Display screening summary
- Info: Pasien otomatis masuk antrian dokter
- Options: Kembali ke daftar atau lihat detail

### Warning Display

**Example - Abnormal Vital Signs:**
```
┌─────────────────────────────────────────┐
│ ⚠️ PERINGATAN                           │
├─────────────────────────────────────────┤
│                                         │
│ Tanda vital tidak normal:               │
│ • Suhu: 38.5°C (Tinggi)                │
│ • Tekanan Darah: 150/95 (Tinggi)       │
│ • Saturasi Oksigen: 92% (Rendah)       │
│                                         │
│ Segera prioritaskan untuk dokter!      │
│                                         │
│ [  Tetap Simpan  ]  [  Koreksi Data  ] │
│                                         │
└─────────────────────────────────────────┘
```

---

## 🎨 UI Components

### Input Groups

**Vital Signs:**
- Icon indicator (🌡️ suhu, 💉 tekanan darah, ❤️ nadi)
- Unit label di sebelah input
- Color-coded warning (yellow/red for abnormal)

**BMI Display:**
```css
- Background: Based on category color
- Font-size: 18px, Bold
- Border-radius: 8px
- Padding: 12px
- Auto-update saat input berat/tinggi
```

### Real-time Calculation

**BMI Calculator:**
- Update otomatis saat input berat/tinggi
- Debounce 300ms
- Smooth transition animation
- Color change berdasarkan kategori

---

## 💡 User Experience

### Smart Input Features

**Auto-unit Conversion:**
- Berat: Support input "50 kg" → otomatis parse jadi 50
- Tinggi: Support "170 cm" atau "1.7 m" → convert ke cm

**Quick Fill Buttons (Optional):**
- Normal values: Auto-fill dengan nilai normal
- Previous values: Load dari screening terakhir

**Input Masks:**
- Tekanan darah: "___/___" format
- Decimal: Auto-format dengan 1-2 desimal

### Keyboard Shortcuts

- **Tab:** Navigate antar field
- **Enter:** Auto-tab ke field berikutnya
- **Ctrl+S:** Save form
- **Esc:** Cancel

### Visual Feedback

**Valid Input:**
- Green checkmark (✓) di kanan field
- Green border

**Warning Input:**
- Orange warning icon (⚠️)
- Orange border
- Tooltip dengan info normal range

**Invalid Input:**
- Red cross (✗)
- Red border
- Error message below field

---

## 📱 Responsive Design

### Desktop (≥1024px)
- Two-column layout untuk paired inputs
- Side-by-side: Suhu & Tekanan Darah
- Side-by-side: Berat & Tinggi

### Tablet (768px - 1023px)
- Two-column untuk vital signs
- Single column untuk text areas

### Mobile (≤767px)
- Full single column
- Sticky header dengan patient info
- Floating action button untuk submit

---

## 🔄 Form States

### Duplicate Check
**Before loading form:**
- Check if patient already has screening today
- If yes: Show warning modal
  - "Pasien sudah melakukan screening hari ini"
  - Options: "Lihat Data" atau "Input Ulang"

### Loading State
- Skeleton loader untuk patient data
- Disable inputs saat loading
- Button: "Memuat data..."

### Saving State
- Button: "Menyimpan..." dengan spinner
- Disable all inputs
- Show progress indicator

---

## ♿ Accessibility

- ✅ Grouped inputs dengan fieldset
- ✅ Clear labels dengan units
- ✅ ARIA labels untuk screen readers
- ✅ High contrast for warnings
- ✅ Keyboard accessible
- ✅ Focus trap dalam modal

---

## 📋 Additional Features

### Previous Screening Comparison

**Display (if available):**
```
┌─────────────────────────────────────┐
│ 📊 Perbandingan dengan screening    │
│    terakhir (7 hari yang lalu):     │
│                                     │
│ • Berat: 68 kg → 70 kg (+2 kg)     │
│ • BMI: 22.5 → 23.45 (+0.95)        │
│ • Tekanan Darah: 120/80 → 120/80   │
│                                     │
└─────────────────────────────────────┘
```

### Quick Actions

**Toolbar buttons:**
- 🔄 Reset Form
- 📋 Load Previous Data
- 💾 Save as Draft
- 🖨️ Print Screening Form

---

## 🔗 Navigation

**After Success:**
1. **Kembali ke Daftar** → `/nurse/patients`
2. **Lihat Detail** → `/nurse/screening/{id}`
3. **Screening Pasien Lain** → Stay, load new patient

**Cancel:**
- Confirmation if form has data
- Redirect to `/nurse/patients`

---

**Created:** November 8, 2025  
**Status:** ✅ Complete
