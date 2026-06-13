<?php
// Mengikutkan koneksi database langsung (tanpa header.php agar tidak memicu proteksi redirect/tampilan lain)
session_start();
include 'config/koneksi.php';

// Jika belum login, tidak boleh melihat nota
if (!isset($_SESSION['user_logged'])) {
    header("Location: index.php");
    exit;
}

// Ambil ID Servis dari parameter URL (GET)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID Transaksi tidak valid!'); window.location='transaksi.php';</script>";
    exit;
}

$id_servis = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data detail servis dengan JOIN 3 tabel agar data pelanggan & kendaraan muncul lengkap
$query = mysqli_query($conn, "SELECT * FROM table_servis 
    JOIN table_kendaraan ON table_servis.id_kendaraan = table_kendaraan.id_kendaraan
    JOIN table_pelanggan ON table_kendaraan.id_pelanggan = table_pelanggan.id_pelanggan
    WHERE table_servis.id_servis = '$id_servis'");

// Cek apakah data servis ditemukan
if (mysqli_num_rows($query) === 0) {
    echo "<script>alert('Data transaksi tidak ditemukan!'); window.location='transaksi.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran #SRV-<?= $data['id_servis']; ?></title>
    <style>
        /* Gaya khusus struk kasir termal (Thermal Printer) */
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 280px;
            margin: 0 auto;
            padding: 10px;
            color: #000;
            font-size: 12px;
            line-height: 1.4;
        }
        .tengah {
            text-align: center;
        }
        .tebal {
            font-weight: bold;
        }
        .garis-pembatas {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .tabel-info {
            width: 100%;
            border-collapse: collapse;
        }
        .tabel-info td {
            padding: 2px 0;
            vertical-align: top;
        }
        .total-bayar {
            font-size: 14px;
            text-align: right;
            margin-top: 5px;
        }
        
        /* Menghilangkan header/footer URL bawaan browser saat dicetak */
        @media print {
            @page {
                margin: 0;
            }
            body {
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body>

    <div class="tengah">
        <span class="tebal" style="font-size: 14px;">BENGKEL MOTOR JAYA</span><br>
        <span>Jl. Jend. Sudirman No. 45, Palembang</span><br>
        <span>HP: 0812-XXXX-XXXX</span>
    </div>

    <div class="garis-pembatas"></div>

    <table class="tabel-info">
        <tr>
            <td>No. Nota</td>
            <td>:</td>
            <td>#SRV-<?= $data['id_servis']; ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= date('d M Y', strtotime($data['tanggal_servis'])); ?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td><?= $data['nama_pelanggan']; ?></td>
        </tr>
        <tr>
            <td>No. Plat</td>
            <td>:</td>
            <td><span class="tebal"><?= $data['no_plat']; ?></span></td>
        </tr>
        <tr>
            <td>Motor</td>
            <td>:</td>
            <td><?= $data['merk_tipe']; ?></td>
        </tr>
    </table>

    <div class="garis-pembatas"></div>

    <div style="margin-bottom: 5px;">
        <span class="tebal">[ KELUHAN ]</span><br>
        <span><?= $data['keluhan']; ?></span>
    </div>
    
    <div style="margin-top: 8px; margin-bottom: 5px;">
        <span class="tebal">[ TINDAKAN MEKANIK ]</span><br>
        <span><?= $data['tindakan_mekanik'] ?: '-'; ?></span>
    </div>

    <div class="garis-pembatas"></div>

    <div class="total-bayar">
        <span>TOTAL: </span>
        <span class="tebal" style="font-size: 15px;">Rp <?= number_format($data['total_biaya'], 0, ',', '.'); ?></span>
    </div>

    <div class="garis-pembatas"></div>

    <div class="tengah" style="margin-top: 15px; font-size: 10px;">
        <span>Terima kasih atas kunjungan Anda.</span><br>
        <span>Kasir: <?= $_SESSION['nama_user']; ?></span>
    </div>

    <script>
        window.print();
        
        // Opsional: Setelah box print selesai/dibatalkan, tab otomatis menutup sendiri
        window.onafterprint = function() {
            window.close();
        }
    </script>

</body>
</html>