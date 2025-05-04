<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: admin_giris.php");
    exit;
}

$baglanti = new mysqli("localhost", "root", "", "mobilya");
if ($baglanti->connect_error) {
    die("Bağlantı Hatası: " . $baglanti->connect_error);
}

$mobilyalar = $baglanti->query("SELECT * FROM mobilyalar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-dark-grey.css">
</head>
<body class="w3-theme-d5">

<div class="w3-container w3-padding w3-black">
    <h2>Mobilya Sitesi - Admin Panel</h2>
    <a href="mobilya_ekle.php" class="w3-button w3-green w3-right">+ Yeni Mobilya Ekle</a>
    <a href="admin_giris.php" style="margin-right:5px;" class="w3-button w3-red w3-right">Çıkış Yap</a>
</div>

<div class="w3-container w3-margin-top">
    <table class="w3-table-all">
        <thead>
            <tr class="w3-black">
                <th>ID</th>
                <th>Resim</th>
                <th>İsim</th>
                <th>Fiyat</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody >
        <?php while ($satir = $mobilyalar->fetch_assoc()): ?>
            <tr class="w3-theme">
                <td><?php echo $satir["id"]; ?></td>
                <td><img src="../uploads/<?php echo $satir["resim_yolu"]; ?>" style="height:60px"></td>
                <td><?php echo $satir["isim"]; ?></td>
                <td>₺<?php echo number_format($satir["fiyat"], 2, ',', '.'); ?></td>
                <td>
                    <a class="w3-button w3-blue w3-small" href="mobilya_duzenle.php?id=<?php echo $satir['id']; ?>">Düzenle</a>
                    <a class="w3-button w3-red w3-small" href="mobilya_sil.php?id=<?php echo $satir['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
