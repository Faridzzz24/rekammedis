# 🔑 Panduan Testing & Akun Demo — MedRecord

Dokumen ini berisi informasi akun demo dan petunjuk pengujian untuk fitur **Transfer Data & Rujukan Rekam Medis Antar Rumah Sakit**.

---

## 🌐 URL Aplikasi
```
http://127.0.0.1:8000
```
> Pastikan `php artisan serve` sedang berjalan.

---

## 🔑 Daftar Akun Demo

Semua akun menggunakan password standar: **`password`**

### 1. Admin (Administrator Sistem)
- **Email:** `admin@medrecord.test`
- **Password:** `password`
- **Akses:** Manajemen Rumah Sakit, Dokter, Pasien, Rekam Medis, dan Rujukan.

---

### 2. Dokter (Praktisi Medis)

| Nama Dokter | Email | Password | Rumah Sakit | Spesialisasi | Keterangan |
|-------------|-------|----------|--------------|--------------|------------|
| **dr. Sari Puspita** | `sari@medrecord.test` | `password` | RS Medika Utama | Penyakit Dalam | **Dokter Penerima Rujukan** (Ada 1 rujukan pending) |
| **dr. Andi Wijaya** | `andi@medrecord.test` | `password` | RS Harapan Bunda | Umum | **Dokter Pengirim Rujukan** |
| **dr. Budi Hartono** | `budi@medrecord.test` | `password` | RS Harapan Bunda | Neurologi | Dokter Spesialis |
| **dr. Dewi Lestari** | `dewi@medrecord.test` | `password` | Klinik Sehat Sejahtera | Umum | Dokter Klinik |

---

### 3. Pasien (Client)

| Nama Pasien | NIK | Email | Password | Keterangan |
|-------------|-----|-------|----------|------------|
| **Rudi Santoso** | `3201010101900001` | `rudi@medrecord.test` | `password` | Memiliki riwayat medis di **RS Harapan Bunda** & **RS Medika Utama** |
| **Siti Nurhaliza** | `3201020202850002` | *(Tanpa Akun)* | - | Pasien terdaftar via admin/dokter |
| **Hasan Basri** | `3201030303780003` | *(Tanpa Akun)* | - | Pasien dengan rujukan aktif dari Klinik ke RS Medika Utama |

---

## 🧪 Skenario Pengujian

### Skenario A: Tes Sisi Dokter Penerima Rujukan (dr. Sari Puspita)
> *Mengetes penerimaan rujukan dan akses otomatis ke riwayat medis pasien.*

1. Buka `http://127.0.0.1:8000/login`
2. Login dengan:
   - **Email:** `sari@medrecord.test`
   - **Password:** `password`
3. Masuk ke menu **Rujukan** di sidebar (akan ada indikator badge `1`).
4. Klik **Detail** pada rujukan pasien **Hasan Basri** dari dr. Dewi.
5. **Verifikasi Fitur Transfer Data:**
   - [x] Alur Rujukan (Klinik Sehat Sejahtera $\rightarrow$ RS Medika Utama)
   - [x] Keluhan, Diagnosis Awal, dan Catatan Rujukan
   - [x] **Seluruh Riwayat Medis Pasien** tampil otomatis tanpa perlu input manual ulang.
6. Klik **Terima Rujukan**.
7. Klik **Buat Rekam Medis Lanjutan** untuk menginput diagnosa & tindakan lanjutan dari RS Medika Utama.

---

### Skenario B: Tes Sisi Pasien / Client (Rudi Santoso)
> *Mengetes akses pasien terhadap riwayat medis lintas rumah sakit.*

1. Login dengan:
   - **Email:** `rudi@medrecord.test`
   - **Password:** `password`
2. Buka menu **Rekam Medis**:
   - Pasien dapat melihat riwayat pemeriksaan dari **RS Harapan Bunda** (Dokter A) dan **RS Medika Utama** (Dokter B).
3. Buka menu **Rujukan**:
   - Pasien dapat memantau status rujukan antar rumah sakit (Pending, Diterima, Selesai).

---

### Skenario C: Membuat Rujukan Baru (Dokter A $\rightarrow$ Dokter B)
1. Login sebagai **dr. Andi** (`andi@medrecord.test`).
2. Masuk ke menu **Rekam Medis** $\rightarrow$ Klik **Tambah** (atau buka detail rekam medis pasien).
3. Klik tombol **Buat Rujukan**.
4. Pilih **Rumah Sakit Tujuan** (misal: RS Medika Utama) dan **Dokter Tujuan** (misal: dr. Sari Puspita).
5. Pilih prioritas (Normal / Mendesak / Darurat) dan tuliskan alasan rujukan.
6. Klik **Kirim Rujukan**.
7. Switch account ke **dr. Sari** (`sari@medrecord.test`) untuk memproses rujukan baru tersebut.

---

## 💡 Cara Kerja Sistem Transfer Data
1. **Pendaftaran/Input Awal:** Pasien diperiksa di Rumah Sakit A, dokter menginput rekam medis & keluhan.
2. **Pembuatan Rujukan:** Dokter di RS A merujuk pasien ke Dokter spesialis B di RS B.
3. **Data Transfer Otomatis:** Rekam medis, diagnosis, tanda vital, dan riwayat alergi terhubung secara digital via tabel `referrals` dan `medical_records`.
4. **Penerimaan Rujukan:** Dokter B di RS B langsung dapat membaca seluruh riwayat pasien tanpa perlu bertanya atau mencatat manual dari awal.
