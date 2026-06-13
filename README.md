# 🔧 Project Web Bengkel

Repositori ini berisi kodingan sistem informasi bengkel berbasis PHP Native. File database `.sql` juga sudah disertakan di dalam folder ini agar memudahkan proses instalasi di lingkungan lokal (XAMPP).

---

## 📌 Prasyarat Sistem
Sebelum menjalankan project ini, pastikan laptop kamu sudah terinstal:
* **XAMPP** (dengan versi PHP yang mendukung)
* Web Browser (Chrome, Edge, atau Firefox)
* Git / GitHub Desktop (untuk mengambil pembaruan kodingan)

---

## 🚀 Cara Menjalankan Project di Laptop Kamu

Ikuti langkah-langkah di bawah ini secara berurutan agar web bisa berjalan tanpa error:

### 1. Persiapan Folder Project
1. Clone atau download repositori ini dari GitHub.
2. Letakkan folder project ini (`[Nama_Folder_Bengkel_Kamu]`) ke dalam direktori XAMPP kamu, biasanya di:
```text
   C:\xampp\htdocs\

2. Menyalakan Server Lokal
Buka aplikasi XAMPP Control Panel.

Klik tombol Start pada modul Apache dan MySQL sampai indikatornya berwarna hijau.

3. Impor Database ke phpMyAdmin
Buka browser kamu, lalu akses ke alamat: http://localhost/phpmyadmin/

Buat database baru dengan mengklik menu New di panel sebelah kiri.

Beri nama database tersebut: [isi_nama_database_kamu] (Penting: nama harus sama persis agar koneksi tidak error!).

Klik pada nama database baru yang baru saja dibuat tersebut.

Pilih menu Import di bar bagian atas.

Klik Choose File, lalu cari dan pilih file database [nama_file_database_kamu].sql yang ada di dalam folder project ini.

Gulung ke bawah, lalu klik tombol Import (atau Go). Tunggu sampai muncul notifikasi sukses.

4. Menjalankan Aplikasi Web
Buka tab baru di browser kamu.

Akses aplikasi web dengan mengetikkan alamat URL berikut:

Plaintext
   http://localhost/[Nama_Folder_Bengkel_Kamu]/
Web Bengkel sudah siap digunakan dan diuji!

🔑 Informasi Akun Login (Testing)
Untuk keperluan testing dan mencoba fitur di dalam web, kamu bisa menggunakan akun berikut:

Akses Admin / Petugas:

Username: [isi_username_admin]

Password: [isi_password_admin]

Akses Pelanggan (jika ada):

Username: [isi_username_pelanggan]

Password: [isi_password_pelanggan]

⚠️ Catatan Troubleshooting (Kendala Koneksi)
Jika saat membuka web kamu mendapati pesan error koneksi database, silakan cek file konfigurasi database kamu yang berada di folder:
📂 config/koneksi.php

Pastikan pengaturannya disesuaikan dengan settingan default XAMPP kamu:

PHP
$host = "localhost";
$user = "root";
$password = ""; // Kosongkan jika XAMPP standar
$database = "[isi_nama_database_kamu]"; 
Jika ada kendala atau error kodingan di luar masalah database, silakan kabari ya!


---

### Langkah Akhir (Push ke GitHub):
1. Setelah kamu edit file `README.md` tersebut di VS Code dan kamu save, buka aplikasi **GitHub Desktop**.
2. Kamu akan melihat file `README.md` masuk ke daftar perubahan (*Changes*).
3. Isi kolom **Summary** di pojok kiri bawah (misal tulis: `update panduan readme`).
4. Klik tombol **Commit to main**.
5. Klik **Push origin** di bagian atas.

Sekarang, coba kamu buka link repositori GitHub kamu lewat HP atau browser. Tampilan catatannya pasti langsung rapi, estetik, dan temanmu dijamin langsung paham cara pakainya!