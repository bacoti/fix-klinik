# UI Design: Registrasi Pasien

## 📄 Halaman: Form Registrasi Pasien Baru

**Role:** Nurse  
**Route:** `/nurse/patients/create`

### Layout Wireframe

```
┌─────────────────────────────────────────────────────────────────────┐
│ [Logo] FIX KLINIK    [Nurse Dashboard] [Profile ▼] [Logout]        │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  Dashboard > Pasien > Registrasi Pasien Baru                        │
│                                                                     │
│  ┌───────────────────────────────────────────────────────────────┐ │
│  │                   REGISTRASI PASIEN BARU                       │ │
│  ├───────────────────────────────────────────────────────────────┤ │
│  │                                                               │ │
│  │  Data Pribadi                                                 │ │
│  │  ─────────────────────────────────────────────────────────    │ │
│  │                                                               │ │
│  │  Nama Lengkap *                                               │ │
│  │  [_____________________________________________]               │ │
│  │                                                               │ │
│  │  Email *                           Nomor Telepon *            │ │
│  │  [______________________]          [___________________]      │ │
│  │                                                               │ │
│  │  Tanggal Lahir *                   Jenis Kelamin *            │ │
│  │  [DD/MM/YYYY ▼]                    ⚪ Laki-laki  ⚪ Perempuan │ │
│  │                                                               │ │
│  │  Alamat Lengkap *                                             │ │
│  │  [_____________________________________________]               │ │
│  │  [_____________________________________________]               │ │
│  │  [_____________________________________________]               │ │
│  │                                                               │ │
│  │  ☐ Saya sudah memverifikasi data pasien                      │ │
│  │                                                               │ │
│  │  [  Batal  ]                          [  Simpan Pasien  ]    │ │
│  │                                                               │ │
│  └───────────────────────────────────────────────────────────────┘ │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 📥 Input Design

### Form Fields

| Field Name | Type | Required | Max Length | Validation | Placeholder |
|------------|------|----------|------------|------------|-------------|
| Nama Lengkap | text | ✅ Yes | 255 | Min 3 chars, letters only | Contoh: Ahmad Zainudin |
| Email | email | ✅ Yes | 255 | Valid email, unique | contoh@email.com |
| Nomor Telepon | tel | ✅ Yes | 20 | Numeric, 10-15 digits | 08123456789 |
| Tanggal Lahir | date | ✅ Yes | - | Valid date, max today | DD/MM/YYYY |
| Jenis Kelamin | radio | ✅ Yes | - | male or female | - |
| Alamat Lengkap | textarea | ✅ Yes | 500 | Min 10 chars | Jl. Contoh No. 123, Kota |
| Verifikasi Data | checkbox | ✅ Yes | - | Must be checked | - |

### Input Validation Rules

**Nama Lengkap:**
- Minimum 3 karakter
- Hanya huruf dan spasi
- Tidak boleh angka atau karakter khusus

**Email:**
- Format email valid (xxx@xxx.xxx)
- Unique (tidak boleh duplikat)
- Case-insensitive

**Nomor Telepon:**
- Hanya angka
- 10-15 digit
- Bisa diawali 0 atau +62

**Tanggal Lahir:**
- Tidak boleh tanggal masa depan
- Format DD/MM/YYYY
- Minimum umur 0 tahun (bisa bayi)
- Maximum umur 150 tahun

**Alamat:**
- Minimum 10 karakter
- Maximum 500 karakter

**Verifikasi Data:**
- Harus dicentang sebelum submit

### Error Messages

| Field | Error Type | Message |
|-------|------------|---------|
| Nama Lengkap | Empty | "Nama lengkap wajib diisi" |
| Nama Lengkap | Invalid | "Nama hanya boleh berisi huruf dan spasi" |
| Nama Lengkap | Too Short | "Nama minimal 3 karakter" |
| Email | Empty | "Email wajib diisi" |
| Email | Invalid Format | "Format email tidak valid" |
| Email | Duplicate | "Email sudah terdaftar" |
| Nomor Telepon | Empty | "Nomor telepon wajib diisi" |
| Nomor Telepon | Invalid | "Nomor telepon hanya boleh berisi angka" |
| Nomor Telepon | Too Short/Long | "Nomor telepon harus 10-15 digit" |
| Tanggal Lahir | Empty | "Tanggal lahir wajib diisi" |
| Tanggal Lahir | Future Date | "Tanggal lahir tidak boleh di masa depan" |
| Jenis Kelamin | Empty | "Jenis kelamin wajib dipilih" |
| Alamat | Empty | "Alamat wajib diisi" |
| Alamat | Too Short | "Alamat minimal 10 karakter" |
| Verifikasi | Not Checked | "Anda harus memverifikasi data pasien" |

---

## 📤 Output Design

### Success Output

**Modal/Alert:**
```
┌─────────────────────────────────────────┐
│           ✅ BERHASIL!                  │
├─────────────────────────────────────────┤
│                                         │
│  Pasien berhasil didaftarkan!          │
│                                         │
│  Nomor Rekam Medis:                    │
│  MR000123                              │
│                                         │
│  Nama: Ahmad Zainudin                  │
│  Email: ahmad@email.com                │
│                                         │
│  [  Daftar Pasien Lain  ]  [  Lihat  ] │
│                                         │
└─────────────────────────────────────────┘
```

**Behavior:**
- Show success modal
- Display Medical Record Number (auto-generated)
- Display patient summary
- Options: Register another atau View patient list

**Auto-Generated Data:**
- Medical Record Number: `MR` + 6-digit padded ID (MR000001, MR000123)
- Registration Date: Current datetime
- Status: `verified = false` (default)

### Error Output

**Display:**
- Error messages below each field (inline)
- Red border on invalid fields
- Summary error box at top (if multiple errors)

**Example Error Display:**
```
┌─────────────────────────────────────────┐
│ ❌ Terdapat 3 kesalahan:                │
│ • Email sudah terdaftar                 │
│ • Nomor telepon tidak valid             │
│ • Verifikasi data belum dicentang       │
└─────────────────────────────────────────┘
```

---

## 🎨 UI Components

### Form Layout

- **Width:** Max 800px, centered
- **Padding:** 30px
- **Background:** White card with shadow
- **Border-radius:** 8px

### Input Fields

**Text Input:**
```css
- Height: 40px
- Border: 1px solid #d1d5db
- Border-radius: 4px
- Padding: 8px 12px
- Font-size: 14px
- Focus: Border blue (#3490dc)
```

**Textarea:**
```css
- Min-height: 100px
- Resizable: vertical
- Same styling as text input
```

**Date Picker:**
- Native date input dengan calendar icon
- Format display: DD/MM/YYYY
- Format value: YYYY-MM-DD

**Radio Buttons:**
```css
- Size: 18px
- Spacing: 20px between options
- Label: 14px, clickable
- Selected: Blue fill
```

### Buttons

**Primary Button (Simpan):**
```css
- Background: #3490dc (Blue)
- Color: White
- Padding: 10px 24px
- Border-radius: 4px
- Font-size: 14px, Bold
- Hover: #2779bd
```

**Secondary Button (Batal):**
```css
- Background: #f7fafc (Light gray)
- Color: #4a5568
- Border: 1px solid #cbd5e0
- Same size as primary
```

---

## 💡 User Experience

### Auto-Save Draft (Future)
- Save form data to localStorage
- Restore if user accidentally closes tab
- Clear after successful submission

### Smart Input
- Auto-format phone number (add dash/space)
- Auto-capitalize nama
- Email auto-lowercase
- Alamat auto-capitalize first letter

### Real-time Validation
- Show checkmark (✓) for valid fields
- Show error immediately on blur
- Email uniqueness check on blur (debounced)

### Keyboard Shortcuts
- Tab: Navigate between fields
- Enter: Submit form (if all valid)
- Esc: Cancel/clear form

---

## 📱 Responsive Design

### Desktop (≥1024px)
- Two-column layout untuk Email & Phone
- Full width form (max 800px)

### Tablet (768px - 1023px)
- Single column layout
- Full width inputs

### Mobile (≤767px)
- Full width layout
- Larger touch targets (48px min)
- Date picker native mobile
- Sticky submit button at bottom

---

## 🔄 Form States

### Initial State
- All fields empty
- Submit button disabled
- Verifikasi unchecked

### Filling State
- Fields turn green when valid
- Submit button enabled when all valid
- Character counter for textarea

### Loading State
- Submit button: "Menyimpan..." with spinner
- Disable all inputs
- Prevent double submission

### Success State
- Show modal
- Clear form (optional)
- Focus on "Daftar Pasien Lain" button

### Error State
- Show error messages
- Keep form data
- Focus on first error field
- Submit button re-enabled

---

## ♿ Accessibility

- ✅ All inputs have labels
- ✅ Required fields marked with *
- ✅ Error messages associated with inputs (aria-describedby)
- ✅ Keyboard navigation
- ✅ Focus indicators
- ✅ Screen reader friendly

---

## 📋 Additional Features

### Data Verification Checkbox
**Purpose:** Ensure nurse has verified patient data before submission

**Text:** "Saya sudah memverifikasi data pasien dengan KTP/identitas resmi"

**Required:** Yes, must be checked to enable submit

### Email Duplicate Check
**Behavior:**
- Check on blur event
- Debounce 500ms
- Show loading indicator
- Show "✓ Email tersedia" atau "❌ Email sudah terdaftar"

### Cancel Confirmation
**Behavior:**
- If form has data, show confirmation dialog
- "Data yang sudah diisi akan hilang. Yakin ingin membatalkan?"
- Options: "Ya, Batal" atau "Tidak, Lanjut Isi"

---

## 🔗 Navigation

**After Success:**
1. **Daftar Pasien Lain** → Clear form, stay on page
2. **Lihat Detail** → Redirect to `/nurse/patients/{id}`

**Cancel:**
- Redirect to `/nurse/patients` (patient list)

---

**Created:** November 8, 2025  
**Status:** ✅ Complete
