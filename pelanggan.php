<?php
// 1. Mengikutkan header untuk proteksi session dan koneksi database
include 'components/header.php';

// PROSES HAPUS PELANGGAN (DELETE)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_pelanggan') {
    $id_pelanggan = $_GET['id'];
    
    $query_hapus = mysqli_query($conn, "DELETE FROM table_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    
    if ($query_hapus) {
        header("Location: pelanggan.php");
        exit;
    }
}

$notif_sukses = "";
$notif_gagal  = "";

if (isset($_POST['tambah_pelanggan'])) {
    $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
    $no_hp          = htmlspecialchars($_POST['no_hp']);
    $no_plat        = strtoupper(str_replace(' ', '', $_POST['no_plat']));
    $tipe_motor     = htmlspecialchars($_POST['tipe_motor']);

    $cek_plat = mysqli_query($conn, "SELECT * FROM table_kendaraan WHERE no_plat = '$no_plat'");
    
    if (mysqli_num_rows($cek_plat) > 0) {
        $notif_gagal = "Gagal! Nomor plat kendaraan $no_plat sudah terdaftar di sistem.";
    } else {
        $query_pelanggan = "INSERT INTO table_pelanggan (nama_pelanggan, no_hp) VALUES ('$nama_pelanggan', '$no_hp')";
        
        if (mysqli_query($conn, $query_pelanggan)) {
            $id_pelanggan_baru = mysqli_insert_id($conn);

            $tahun_sekarang = date('Y');
            $query_kendaraan = "INSERT INTO table_kendaraan (id_pelanggan, no_plat, merk_tipe, tahun_keluaran) 
                                VALUES ('$id_pelanggan_baru', '$no_plat', '$tipe_motor', '$tahun_sekarang')";
            
            if (mysqli_query($conn, $query_kendaraan)) {
                $notif_sukses = "Berhasil mendaftarkan pelanggan dan kendaraan baru!";
            } else {
                $notif_gagal = "Gagal menyimpan data kendaraan.";
            }
        } else {
            $notif_gagal = "Gagal menyimpan data pelanggan.";
        }
    }
}

$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggan - Bengkel System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <?php include 'components/sidebar.php'; ?>

    <div class="pl-64">
        <div class="max-w-7xl mx-auto px-8 py-8">
            
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Data Pelanggan & Kendaraan</h1>
                <p class="text-gray-600 mt-1">Cari atau daftarkan pelanggan baru yang datang ke bengkel.</p>
            </header>

            <?php if (!empty($notif_sukses)) : ?>
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm font-medium text-sm">
                     <?= $notif_sukses; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($notif_gagal)) : ?>
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm font-medium text-sm">
                     <?= $notif_gagal; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm h-fit">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Registrasi Pelanggan Baru</h2>
                    
                    <form action="" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" placeholder="Contoh: Budi" required autocomplete="off"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required autocomplete="off"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">No. Plat Kendaraan</label>
                            <input type="text" name="no_plat" placeholder="Contoh: BG1234AB" required autocomplete="off"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition uppercase">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tipe / Model Motor</label>
                            <input type="text" name="tipe_motor" placeholder="Contoh: Honda Beat" required autocomplete="off"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition">
                        </div>

                        <button type="submit" name="tambah_pelanggan"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-sm transition active:scale-[0.99]">
                            Simpan Data Pelanggan
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    
                    <div class="mb-6">
                        <form action="" method="GET" class="flex gap-2">
                            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword); ?>" placeholder="Cari berdasarkan Nama atau No Plat (Contoh: BG1234AB)..."
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition">
                            <button type="submit" name="cari" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold px-6 rounded-xl text-sm transition">
                                Cari
                            </button>
                            <?php if (!empty($keyword)) : ?>
                                <a href="pelanggan.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 rounded-xl text-sm flex items-center transition">
                                    Reset
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                                    <th class="py-3 px-4">Nama Pelanggan</th>
                                    <th class="py-3 px-4">No. HP</th>
                                    <th class="py-3 px-4">No. Plat</th>
                                    <th class="py-3 px-4">Tipe Motor</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                                <?php
                                $sql = "SELECT * FROM table_kendaraan 
                                        JOIN table_pelanggan ON table_kendaraan.id_pelanggan = table_pelanggan.id_pelanggan";
                                
                                if (!empty($keyword)) {
                                    $sql .= " WHERE table_pelanggan.nama_pelanggan LIKE '%$keyword%' 
                                              OR table_kendaraan.no_plat LIKE '%$keyword%'";
                                }

                                $sql .= " ORDER BY table_kendaraan.id_kendaraan DESC";
                                $query_tampil = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query_tampil) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_tampil)) {
                                        ?>
                                        <tr class="hover:bg-gray-50/70 transition">
                                            <td class="py-3.5 px-4 font-semibold text-gray-800"><?= $row['nama_pelanggan']; ?></td>
                                            <td class="py-3.5 px-4 font-mono text-gray-500"><?= $row['no_hp']; ?></td>
                                            <td class="py-3.5 px-4">
                                                <span class="bg-gray-800 text-gray-100 font-mono font-bold px-2.5 py-1 rounded text-xs tracking-wider">
                                                    <?= $row['no_plat']; ?>
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-center space-x-1">
                                                <a href="transaksi.php?id_kendaraan=<?= $row['id_kendaraan']; ?>" 
                                                class="inline-block bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold px-3 py-1.5 rounded-lg text-xs transition shadow-sm">
                                                    + Masuk Antrean
                                                </a>
                                                <a href="pelanggan.php?aksi=hapus_pelanggan&id=<?= $row['id_pelanggan']; ?>" 
                                                onclick="return confirm('Hapus pelanggan ini? Data kendaraan mereka juga akan ikut terhapus!')"
                                                class="inline-block bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-semibold px-3 py-1.5 rounded-lg text-xs transition shadow-sm">
                                                    - Hapus
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="py-8 text-center text-gray-400">Data pelanggan tidak ditemukan atau masih kosong.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

</body>
</html>