<?php
// Mulai session
session_start();

// Hubungkan ke koneksi database
include 'config/koneksi.php';

// Jika user sudah login sebelumnya, langsung lempar ke dashboard tanpa harus login lagi
if (isset($_SESSION['user_logged'])) {
    header("Location: dashboard.php");
    exit;
}

$error_message = "";

// Logika ketika tombol Login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Cari user berdasarkan username di table_user
    $query = mysqli_query($conn, "SELECT * FROM table_user WHERE username = '$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        
        // Verifikasi password (menggunakan password_verify agar aman)
        if ($password == $row['password']) {
            // Set session jika login berhasil
            $_SESSION['user_logged'] = true;
            $_SESSION['id_user']     = $row['id_user'];
            $_SESSION['username']    = $row['username'];
            $_SESSION['nama_user']   = $row['nama_lengkap'];

            // Alihkan ke halaman dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Password yang Anda masukkan salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bengkel System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Bengkel System</h2>
            <p class="text-gray-500 mt-2 text-sm">Silakan login sebagai Resepsionis</p>
        </div>

        <?php if (!empty($error_message)) : ?>
            <div class="mb-5 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700">
            </div>

            <button type="submit" name="login"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition duration-200 shadow-md transform active:scale-[0.98]">
                Masuk ke Sistem
            </button>
        </form>
        
        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; <?= date('Y'); ?> Vehicle Maintenance Log System
        </div>
    </div>

</body>
</html>