<?php
include 'components/header.php';

$hari_ini = date('Y-m-d');
$notif = "";

// Cek apakah ada kiriman id_kendaraan dari halaman pelanggan.php lewat URL (GET)
$id_kendaraan_pilihan = isset($_GET['id_kendaraan']) ? $_GET['id_kendaraan'] : '';

// 1. PROSES TAMBAH ANTREAN BARU (CREATE)
if (isset($_POST['tambah_antrean'])) {
    $id_kendaraan   = $_POST['id_kendaraan'];
    $keluhan        = htmlspecialchars($_POST['keluhan']);
    
    $query_input = "INSERT INTO table_servis (id_kendaraan, tanggal_servis, keluhan, status_servis, total_biaya) 
                    VALUES ('$id_kendaraan', '$hari_ini', '$keluhan', 'Antre', 0)";
    
    if (mysqli_query($conn, $query_input)) {
        $notif = "<div class='mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm font-medium'>✅ Antrean baru berhasil ditambahkan!</div>";
        // Reset pilihan setelah sukses input
        $id_kendaraan_pilihan = "";
    }
}

// 2. PROSES UPDATE STATUS (ANTRE -> DIPROSES)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'proses') {
    $id_servis = $_GET['id'];
    mysqli_query($conn, "UPDATE table_servis SET status_servis = 'Diproses' WHERE id_servis = '$id_servis'");
    header("Location: transaksi.php");
    exit;
}

// PROSES HAPUS/BATALKAN SERVIS (DELETE)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_servis') {
    $id_servis = $_GET['id'];
    mysqli_query($conn, "DELETE FROM table_servis WHERE id_servis = '$id_servis'");
    header("Location: transaksi.php");
    exit;
}

// 3. PROSES UPDATE SELESAI SERVIS (DIPROSES -> SELESAI)
if (isset($_POST['servis_selesai'])) {
    $id_servis        = $_POST['id_servis'];
    $tindakan_mekanik = htmlspecialchars($_POST['tindakan_mekanik']);
    $total_biaya      = $_POST['total_biaya'];

    $query_update = "UPDATE table_servis SET 
                        tindakan_mekanik = '$tindakan_mekanik', 
                        total_biaya = '$total_biaya', 
                        status_servis = 'Selesai' 
                     WHERE id_servis = '$id_servis'";
    
    if (mysqli_query($conn, $query_update)) {
        header("Location: transaksi.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Servis - Bengkel System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <?php include 'components/sidebar.php'; ?>

    <div class="pl-64">
        <div class="max-w-7xl mx-auto px-8 py-8">
            
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Transaksi & Antrean Servis</h1>
                <p class="text-gray-600 mt-1">Kelola antrean running, update proses mekanik, hingga cetak nota pembayaran.</p>
            </header>

            <?= $notif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm h-fit">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Antrean</h2>
                    <form action="" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Pilih Kendaraan / Pelanggan</label>
                            <select name="id_kendaraan" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white text-gray-700 text-sm">
                                <option value="">-- Pilih Motor --</option>
                                <?php
                                $motor = mysqli_query($conn, "SELECT table_kendaraan.id_kendaraan, table_kendaraan.no_plat, table_kendaraan.merk_tipe, table_pelanggan.nama_pelanggan 
                                                              FROM table_kendaraan 
                                                              JOIN table_pelanggan ON table_kendaraan.id_pelanggan = table_pelanggan.id_pelanggan");
                                while ($m = mysqli_fetch_assoc($motor)) {
                                    // Logika Pintar: jika ID motor sama dengan yang dikirim dari URL, otomatis beri atribut 'selected'
                                    $terpilih = ($m['id_kendaraan'] == $id_kendaraan_pilihan) ? 'selected' : '';
                                    echo "<option value='".$m['id_kendaraan']."' $terpilih>".$m['no_plat']." - ".$m['merk_tipe']." oxide (".$m['nama_pelanggan'].")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Keluhan Pelanggan</label>
                            <textarea name="keluhan" rows="3" placeholder="Contoh: Tarikan gas berat, mau ganti oli mesin..." required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 text-sm transition"></textarea>
                        </div>
                        <button type="submit" name="tambah_antrean" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm">
                            Masukkan Ke Antrean
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Daftar Antrean Hari Ini</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                                    <th class="py-3 px-4">Motor/Pelanggan</th>
                                    <th class="py-3 px-4">Keluhan & Tindakan</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi / Kontrol</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                                <?php
                                $query_servis = mysqli_query($conn, "SELECT * FROM table_servis 
                                    JOIN table_kendaraan ON table_servis.id_kendaraan = table_kendaraan.id_kendaraan
                                    JOIN table_pelanggan ON table_kendaraan.id_pelanggan = table_pelanggan.id_pelanggan
                                    WHERE table_servis.tanggal_servis = '$hari_ini'
                                    ORDER BY table_servis.id_servis DESC");

                                if (mysqli_num_rows($query_servis) > 0) {
                                    while ($s = mysqli_fetch_assoc($query_servis)) {
                                        ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4">
                                                <div class="font-bold text-gray-800"><?= $s['no_plat']; ?></div>
                                                <div class="text-xs text-gray-500"><?= $s['merk_tipe']; ?> - <?= $s['nama_pelanggan']; ?></div>
                                            </td>
                                            <td class="py-4 px-4 max-w-xs">
                                                <div class="text-gray-700"><span class="font-semibold text-xs text-red-500">Keluhan:</span> <?= $s['keluhan']; ?></div>
                                                <?php if(!empty($s['tindakan_mekanik'])): ?>
                                                    <div class="text-xs text-green-600 mt-1"><span class="font-semibold">Solusi:</span> <?= $s['tindakan_mekanik']; ?></div>
                                                    <div class="text-xs font-mono font-bold text-gray-800 mt-0.5">Rp <?= number_format($s['total_biaya'],0,',','.'); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4">
                                                <?php if($s['status_servis'] == 'Antre'): ?>
                                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-xs font-semibold">Antre</span>
                                                <?php elseif($s['status_servis'] == 'Diproses'): ?>
                                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-semibold">Diproses</span>
                                                <?php else: ?>
                                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-semibold">Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4 text-center space-y-1">
                                                <?php if($s['status_servis'] == 'Antre'): ?>
                                                    <a href="transaksi.php?aksi=proses&id=<?= $s['id_servis']; ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition shadow-sm text-center">
                                                        Proses Mekanik
                                                    </a>
                                                    <a href="transaksi.php?aksi=hapus_servis&id=<?= $s['id_servis']; ?>" onclick="return confirm('Batalkan antrean servis ini?')" class="block w-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs px-3 py-1.5 rounded-lg font-medium transition text-center">
                                                        ❌ Batalkan
                                                    </a>
                                                <?php elseif($s['status_servis'] == 'Diproses'): ?>
                                                    <button onclick="bukaModal(<?= $s['id_servis']; ?>)" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition shadow-sm">
                                                        Selesai Servis
                                                    </button>
                                                <?php else: ?>
                                                    <a href="cetak_nota.php?id=<?= $s['id_servis']; ?>" target="_blank" class="w-full border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-lg font-medium transition inline-flex items-center justify-center gap-1">
                                                        🖨️ Nota
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4" class="py-8 text-center text-gray-400">Belum ada aktivitas antrean servis hari ini.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="modalSelesai" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl animate-fade-in">
            <h3 class="text-lg font-bold text-gray-900 mb-3">Pembaruan Selesai Servis</h3>
            <form action="" method="POST" class="space-y-4">
                <input type="hidden" name="id_servis" id="modal_id_servis">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tindakan Mekanik / Part Diganti</label>
                    <textarea name="tindakan_mekanik" rows="3" placeholder="Contoh: Pembersihan karburator, ganti kabel gas, oli MPX2" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-sm text-gray-700"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Total Biaya Servis & Part (Rp)</label>
                    <input type="number" name="total_biaya" placeholder="Contoh: 150000" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 outline-none text-sm text-gray-700">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="tutupModal()" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" name="servis_selesai" class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition shadow-sm">
                        Simpan & Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModal(id) {
            document.getElementById('modal_id_servis').value = id;
            document.getElementById('modalSelesai').classList.remove('hidden');
        }
        function tutupModal() {
            document.getElementById('modalSelesai').classList.add('hidden');
        }
    </script>
</body>
</html>