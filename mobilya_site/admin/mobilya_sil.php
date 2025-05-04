<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin_giris.php");
    exit;
}

$baglanti = new mysqli("localhost", "root", "", "mobilya");

$id = $_GET["id"] ?? 0;

$stmt = $baglanti->prepare("SELECT resim_yolu FROM mobilyalar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$sonuc = $stmt->get_result();

if ($sonuc->num_rows === 1) {
    $veri = $sonuc->fetch_assoc();
    $resimYolu = "../uploads/" . $veri["resim_yolu"];

    $sil = $baglanti->prepare("DELETE FROM mobilyalar WHERE id = ?");
    $sil->bind_param("i", $id);
    $sil->execute();

    if (file_exists($resimYolu)) {
        unlink($resimYolu);
    }
}

header("Location: admin_panel.php");
exit;
?>
