<?php
// Mengikutkan header.php untuk proteksi session & koneksi database
include 'components/header.php';

// Ambil tanggal hari ini secara dinamis
$hari_ini = date('Y-m-d');

// 1. Hitung motor yang sedang mengantre hari ini (Menggunakan tanggal_servis & status_servis)
$q_antre = mysqli_query($conn, "SELECT COUNT(*) as total FROM table_servis WHERE tanggal_servis = '$hari_ini' AND status_servis = 'Antre'");
$data_antre = mysqli_fetch_assoc($q_antre);

// 2. Hitung motor yang sedang diproses hari ini (Menggunakan tanggal_servis & status_servis)
$q_proses = mysqli_query($conn, "SELECT COUNT(*) as total FROM table_servis WHERE tanggal_servis = '$hari_ini' AND status_servis = 'Diproses'");
$data_proses = mysqli_fetch_assoc($q_proses);

// 3. Hitung motor yang sudah selesai hari ini (Menggunakan tanggal_servis & status_servis)
$q_selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM table_servis WHERE tanggal_servis = '$hari_ini' AND status_servis = 'Selesai'");
$data_selesai = mysqli_fetch_assoc($q_selesai);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bengkel System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <?php include 'components/sidebar.php'; ?>

    <div class="pl-64">
        <div class="max-w-7xl mx-auto px-8 py-8">
            
            <header class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Utama</h1>
                    <p class="text-gray-600 mt-1">Selamat datang kembali, <span class="font-semibold text-blue-600"><?= $_SESSION['nama_user']; ?></span>!</p>
                </div>
                <div class="text-sm bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm font-medium text-gray-700">
                    📅 <?= date('d M Y'); ?>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-amber-50 border border-amber-200 p-6 rounded-2xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm text-amber-700 font-semibold uppercase tracking-wider">Mengantre Hari Ini</p>
                        <h3 class="text-3xl font-bold text-amber-900 mt-2"><?= $data_antre['total']; ?> <span class="text-lg font-medium text-amber-700">Motor</span></h3>
                    </div>
                    <div class="p-3 bg-amber-500/10 text-amber-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-700 font-semibold uppercase tracking-wider">Sedang Diproses</p>
                        <h3 class="text-3xl font-bold text-blue-900 mt-2"><?= $data_proses['total']; ?> <span class="text-lg font-medium text-blue-700">Motor</span></h3>
                    </div>
                    <div class="p-3 bg-blue-500/10 text-blue-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 p-6 rounded-2xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-700 font-semibold uppercase tracking-wider">Selesai Hari Ini</p>
                        <h3 class="text-3xl font-bold text-green-900 mt-2"><?= $data_selesai['total']; ?> <span class="text-lg font-medium text-green-700">Motor</span></h3>
                    </div>
                    <div class="p-3 bg-green-500/10 text-green-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/xl" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Aksi Cepat Resepsionis</h2>
                <p class="text-sm text-gray-500 mb-4">Gunakan menu di samping atau pintasan di bawah untuk memproses aktivitas pelanggan.</p>
                <div class="flex gap-4">
                    <a href="pelanggan.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl text-sm transition">
                        + Tambah Pelanggan Baru
                    </a>
                    <a href="transaksi.php" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-xl text-sm transition">
                        Lihat Antrean Servis
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>