# 📋 SISTEM PRESENSI MAGANG

Aplikasi presensi berbasis lokasi dengan GPS tracking, validasi radius kantor, 
dan laporan otomatis untuk peserta magang. Dibangun dengan Laravel 12.

---

## ✨ FITUR LENGKAP

### 👥 **MANAJEMEN USER**
- ✅ Multi-level user: **Admin**, **Pembimbing**, **Peserta**
- ✅ Register & Login dengan Laravel Breeze
- ✅ Profile dengan upload foto avatar
- ✅ Data magang (institusi, NIM, periode magang)
- ✅ Periode magang tidak bisa diubah setelah diisi

### 📍 **PRESENSI**
- ✅ Check-in dengan validasi GPS (Haversine formula)
- ✅ Validasi radius kantor (bisa diatur)
- ✅ Validasi jam masuk (tidak boleh sebelum jam masuk)
- ✅ Validasi jam pulang (tidak boleh sebelum jam pulang)
- ✅ Izin terlambat terintegrasi
- ✅ Status: tepat waktu, terlambat, pulang cepat
- ✅ Riwayat presensi dengan pagination
- ✅ Info jam kerja real-time

### 📝 **IZIN**
- ✅ 4 Jenis Izin: **Izin**, **Sakit**, **Izin Terlambat**, **Tugas Luar**
- ✅ Upload file bukti (surat dokter, surat tugas)
- ✅ Validasi overlapping tanggal
- ✅ Approval system (admin approve/reject dengan catatan)
- ✅ Download file bukti
- ✅ Notifikasi status izin

### 📊 **ADMIN PANEL**
- ✅ Dashboard dengan statistik realtime
- ✅ Grafik presensi 7 hari
- ✅ Statistik izin per jenis
- ✅ Daftar peserta terbaik
- ✅ Manajemen user (CRUD) - Admin, Pembimbing, Peserta
- ✅ Reset password user
- ✅ Approval izin
- ✅ Settings lokasi & waktu (latitude, longitude, radius, jam kerja)

### 👨‍🏫 **PEMBIMBING PANEL**
- ✅ Dashboard khusus pembimbing
- ✅ Daftar peserta bimbingan
- ✅ Detail peserta dengan riwayat presensi
- ✅ Monitoring izin peserta
- ✅ **Catatan akhir magang** (bisa diisi pembimbing)

### 🔐 **KEAMANAN**
- ✅ Multi-login prevention (1 akun hanya bisa login di 1 device)
- ✅ Middleware role-based (admin, pembimbing, peserta)
- ✅ Validasi back-end untuk semua fitur
- ✅ CSRF protection
- ✅ Password hashing

### 🎨 **UI/UX**
- ✅ Landing page modern dengan glass morphism
- ✅ Login/Register page cantik
- ✅ Navigation dengan hover dropdown
- ✅ Notifikasi dengan animasi
- ✅ Form izin dengan card style
- ✅ Tampilan responsif (mobile friendly)
- ✅ Dark mode? (opsional)

---

## 🛠️ TEKNOLOGI YANG DIGUNAKAN

| Teknologi | Keterangan |
|-----------|------------|
| **Laravel 12** | Framework PHP |
| **MySQL** | Database |
| **Tailwind CSS** | Styling |
| **Alpine.js** | Interaktivitas frontend |
| **Laravel Breeze** | Authentication scaffolding |
| **Carbon** | Manipulasi tanggal |
| **Haversine Formula** | Perhitungan jarak GPS |

---

## 📸 SCREENSHOT

*[Tambah screenshot di sini nanti]*

---

## ⚙️ CARA INSTALASI

### 1. **Clone Repository**
```bash
git clone https://github.com/username/sistem-presensi.git
cd sistem-presensi