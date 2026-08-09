# 🚀 Panduan Deploy Laravel ke Vercel

Project ini sudah dikonfigurasi dan siap di-deploy ke **Vercel** menggunakan serverless PHP builder (`vercel-php`).

---

## 🛠️ File Konfigurasi Vercel yang Telah Dibuat
1. **`vercel.json`**: Konfigurasi routing serverless function & aset statis.
2. **`api/index.php`**: Entrypoint serverless function untuk menangani environment temporary `/tmp` (storage, view cache, & SQLite DB).
3. **`.vercelignore`**: Memfilter folder lokal (`vendor`, `node_modules`, `.env`) agar build di Vercel bersih.
4. **`package.json`**: Menambahkan script `"vercel-build": "vite build"`.

---

## 📋 Langkah Deploy ke Vercel

### Cara 1: Deploy via Vercel CLI (Paling Cepat)

1. **Install Vercel CLI** (jika belum ada):
   ```bash
   npm install -g vercel
   ```

2. **Login ke Akun Vercel**:
   ```bash
   vercel login
   ```

3. **Jalankan Command Deploy**:
   Di folder project ini (`c:\Internship 2026\Rekam Medis`), jalankan:
   ```bash
   vercel
   ```
   - Tekan `Y` untuk konfirmasi setup project.
   - Tekan `Enter` untuk nama project & scope default.

4. **Deploy ke Production**:
   ```bash
   vercel --prod
   ```

---

### Cara 2: Deploy via GitHub (Otomatis CI/CD)

1. Push folder project ini ke repositori **GitHub** Anda.
2. Buka dashboard [Vercel](https://vercel.com/dashboard) $\rightarrow$ Klik **Add New...** $\rightarrow$ **Project**.
3. Hubungkan ke repositori GitHub project `Rekam Medis` ini.
4. Pada bagian **Environment Variables** di Vercel, tambahkan variable berikut:

| Key | Value | Keterangan |
|-----|-------|------------|
| `APP_NAME` | `MedRecord` | Nama Aplikasi |
| `APP_ENV` | `production` | Environment |
| `APP_KEY` | `base64:3F+9p72jZ1QxYn3x3L7H0xQ2V5m8N9b1C4d6E8f0G2h=` | *Atau hasil generate `php artisan key:generate --show`* |
| `APP_DEBUG` | `true` | True untuk mode demo |
| `APP_URL` | `https://nama-project-anda.vercel.app` | URL Vercel Anda |
| `DB_CONNECTION` | `sqlite` | Database SQLite |
| `DB_DATABASE` | `/tmp/database.sqlite` | Path database temporary |

5. Klik **Deploy**. Vercel akan otomatis meng-compile aset Vite dan menjalankan aplikasi!

---

## 🗄️ Catatan Database di Vercel

- Aplikasi ini dikonfigurasi menggunakan **SQLite** yang di-copy ke `/tmp/database.sqlite` secara otomatis saat serverless function berjalan pertama kali.
- Jika Anda ingin menggunakan database MySQL/PostgreSQL permanen di cloud saat produksi, cukup ubah Environment Variable di Dashboard Vercel:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=host_mysql_cloud_anda (misal: PlanetScale / Aiven / Supabase)
  DB_PORT=3306
  DB_DATABASE=nama_db
  DB_USERNAME=user_db
  DB_PASSWORD=pass_db
  ```
