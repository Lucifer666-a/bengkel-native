<?php
session_start();
include 'config/koneksi.php';


if (!isset($_SESSION['user_logged'])) {
    header("Location: index.php");
    exit;
}
?>