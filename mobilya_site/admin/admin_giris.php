<?php
session_start();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = $_POST["kullanici"];
    $sifre = $_POST["sifre"];

    $baglanti = new mysqli("localhost", "root", "", "mobilya");
    if ($baglanti->connect_error) {
        die("Bağlantı Hatası: " . $baglanti->connect_error);
    }

    $stmt = $baglanti->prepare("SELECT * FROM adminler WHERE kullanici_adi = ?");
    $stmt->bind_param("s", $kullanici);
    $stmt->execute();
    $sonuc = $stmt->get_result();

    if ($sonuc->num_rows == 1) {
        $admin = $sonuc->fetch_assoc();
        if (password_verify($sifre, $admin["sifre"])) {
            $_SESSION["admin"] = $admin["kullanici_adi"];
            header("Location: admin_panel.php");
            exit;
        } else {
            $hata = "Şifre yanlış.";
        }
    } else {
        $hata = "Kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Giriş</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-dark-grey.css">
</head>
<body class="w3-container w3-theme-d3">
    <div class="w3-card w3-theme w3-padding w3-margin w3-display-middle" style="width:300px">
        <h3 class="w3-center">Admin Girişi</h3>
        <form method="POST">
            <label>Kullanıcı Adı</label>
            <input class="w3-input w3-border" type="text" name="kullanici" required>
            <label>Şifre</label>
            <input class="w3-input w3-border" type="password" name="sifre" required>
            <button class="w3-button w3-black w3-margin-top w3-block" type="submit">Giriş Yap</button>
            <a href="../index.php" class="w3-button w3-amber" style="width:268px; height:38,5px; margin-top:5px">Anasayfaya Dön</a>
        </form>
        <?php if ($hata): ?>
            <div class="w3-red w3-padding w3-margin-top"><?php echo $hata; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
