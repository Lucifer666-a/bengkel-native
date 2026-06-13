<?php
// 1. Jalankan session agar PHP tahu session mana yang mau dihapus
session_start();

// 2. Hapus semua data yang tersimpan di dalam array session
$_SESSION = array();

// 3. Hancurkan / dekonstruksi session yang ada di server
session_destroy();

// 4. Bersihkan cookie session di browser jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 5. Alihkan resepsionis kembali ke halaman login utama
header("Location: index.php");
exit;
?>