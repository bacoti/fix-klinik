# UI Design: Login Page

## 📄 Halaman: Login & Autentikasi

### Layout Wireframe

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│                    FIX KLINIK SYSTEM                        │
│                  Sistem Informasi Klinik                    │
│                                                             │
│              ┌─────────────────────────────┐                │
│              │                             │                │
│              │      [LOGO KLINIK]          │                │
│              │                             │                │
│              └─────────────────────────────┘                │
│                                                             │
│              ┌─────────────────────────────┐                │
│              │  Email Address              │                │
│              │  [____________________]     │                │
│              │                             │                │
│              │  Password                   │                │
│              │  [____________________]     │                │
│              │                             │                │
│              │  □ Remember Me              │                │
│              │                             │                │
│              │  [    LOGIN BUTTON    ]     │                │
│              │                             │                │
│              │  Forgot Password?           │                │
│              │                             │                │
│              └─────────────────────────────┘                │
│                                                             │
│                  © 2025 Fix Klinik                          │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 📥 Input Design

### Form Fields

| Field Name | Type | Required | Validation | Placeholder |
|------------|------|----------|------------|-------------|
| Email | text/email | ✅ Yes | Valid email format | admin@klinik.com |
| Password | password | ✅ Yes | Min 8 characters | ••••••••••••• |
| Remember Me | checkbox | ❌ No | - | - |

### Input Validation

**Client-Side:**
- Email format validation (must contain @)
- Password minimum 8 characters
- Empty field validation

**Server-Side:**
- Email exists in database
- Password hash verification
- Account status check (active/inactive)

### Error Messages

| Error Type | Message |
|------------|---------|
| Empty Email | "Email wajib diisi" |
| Invalid Email Format | "Format email tidak valid" |
| Empty Password | "Password wajib diisi" |
| Invalid Credentials | "Email atau password salah" |
| Account Inactive | "Akun Anda tidak aktif. Hubungi administrator" |

---

## 📤 Output Design

### Success Output

**Behavior:**
- Redirect ke dashboard sesuai role
- Set session & authentication cookie
- Display welcome message di dashboard

**Dashboard Routing:**
- `role = admin` → `/admin/dashboard`
- `role = nurse` → `/nurse/dashboard`
- `role = doctor` → `/doctor/dashboard`
- `role = pharmacist` → `/pharmacist/dashboard`

### Error Output

**Display:**
- Alert box di atas form (warna merah)
- Icon error (❌)
- Error message sesuai tabel di atas
- Form fields tetap terisi (kecuali password)

---

## 🎨 UI Components

### Colors

- **Primary Color:** #3490dc (Blue) - untuk button
- **Error Color:** #e3342f (Red) - untuk error messages
- **Background:** #f7fafc (Light gray)
- **Text:** #2d3748 (Dark gray)

### Typography

- **Heading:** 24px, Bold, "FIX KLINIK SYSTEM"
- **Subheading:** 16px, Regular, "Sistem Informasi Klinik"
- **Labels:** 14px, Medium
- **Input Text:** 14px, Regular
- **Error Messages:** 13px, Regular, Red

### Button Style

```css
Login Button:
- Width: 100% (full width)
- Height: 40px
- Background: #3490dc (Blue)
- Text: White, 14px, Bold
- Border-radius: 4px
- Hover: #2779bd (Darker blue)
- Active/Pressed: #1c5a85
```

---

## 💡 User Experience

### Flow

1. User membuka halaman login
2. Input email & password
3. (Optional) Check "Remember Me"
4. Click "Login" button
5. Show loading state (button disabled, spinner)
6. Redirect to dashboard atau show error

### Loading State

**Button saat loading:**
- Text: "Logging in..."
- Disabled state
- Spinner icon

### Remember Me

**Behavior:**
- Jika checked: Session expires in 30 days
- Jika unchecked: Session expires when browser closes

### Forgot Password

**Link:**
- Text: "Forgot Password?" 
- Style: Blue, underline on hover
- Action: Redirect to `/forgot-password` (future feature)

---

## 📱 Responsive Design

### Desktop (≥1024px)
- Login box: 400px width, centered
- Logo size: 150x150px
- Full layout seperti wireframe

### Tablet (768px - 1023px)
- Login box: 80% width, centered
- Logo size: 120x120px
- Reduced padding

### Mobile (≤767px)
- Login box: 95% width
- Logo size: 100x100px
- Smaller font sizes
- Stack elements vertically

---

## ♿ Accessibility

- ✅ Label for each input field
- ✅ Keyboard navigation support (Tab key)
- ✅ Focus states for inputs
- ✅ ARIA labels for screen readers
- ✅ High contrast colors
- ✅ Error messages clearly associated with fields

---

## 🔒 Security Features

- ✅ Password field type="password" (hidden characters)
- ✅ CSRF token in form
- ✅ Rate limiting (max 5 attempts per 1 minute)
- ✅ Session timeout after 2 hours idle
- ✅ Secure cookie (httpOnly, secure flag)

---

## 📋 Notes

- Login page tidak memerlukan autentikasi
- Tidak ada link "Register" (user dibuat oleh admin)
- "Forgot Password" untuk future implementation
- Support keyboard shortcuts (Enter to submit)

---

**Created:** November 8, 2025  
**Status:** ✅ Complete
