<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin_giris.php");
    exit;
}

$baglanti = new mysqli("localhost", "root", "", "mobilya");

if ($baglanti->connect_error) {
    die("Veritabanına bağlanılamadı: " . $baglanti->connect_error);
}

$hata = "";
$basari = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = $_POST["isim"];
    $fiyat = $_POST["fiyat"];

    if (isset($_FILES["resim"]) && $_FILES["resim"]["error"] == 0) {
        $resimAdi = basename($_FILES["resim"]["name"]);
        $hedefYol = "../uploads/" . $resimAdi;

        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $hedefYol)) {
            $sql = "INSERT INTO mobilyalar (isim, fiyat, resim_yolu) VALUES (?, ?, ?)";
            $stmt = $baglanti->prepare($sql);

            if (!$stmt) {
                die("Hata: SQL sorgusu hatalı. " . $baglanti->error);
            }

            $stmt->bind_param("sds", $isim, $fiyat, $resimAdi);

            if ($stmt->execute()) {
                $basari = "✅ Mobilya başarıyla eklendi.";
            } else {
                $hata = "❌ Veritabanına eklenemedi: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $hata = "❌ Resim yüklenirken hata oluştu.";
        }
    } else {
        $hata = "❌ Geçerli bir resim dosyası seçmelisiniz.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mobilya Ekle</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-dark-grey.css">
</head>
<body class="w3-theme-d5">

<div class="w3-container w3-padding w3-black">
    <h2>Yeni Mobilya Ekle</h2>
    <a href="admin_panel.php" class="w3-button w3-amber">← Geri Dön</a>
</div>

<div class="w3-container w3-theme-d2 w3-padding w3-margin">
    <form method="POST" class="w3-theme-d2" enctype="multipart/form-data">
        <label>Mobilya İsmi</label>
        <input class="w3-input w3-border" type="text" name="isim" required>

        <label>Fiyat (₺)</label>
        <input class="w3-input w3-border" type="number" step="0.01" name="fiyat" required>

        <label>Resim Yükle</label>
        <input class="w3-input w3-border" type="file" name="resim" accept="image/*" required>

        <button class="w3-button w3-green w3-margin-top" type="submit">Ekle</button>
    </form>

    <?php if ($hata): ?>
        <div class="w3-panel w3-red w3-margin-top"><?php echo $hata; ?></div>
    <?php endif; ?>

    <?php if ($basari): ?>
        <div class="w3-panel w3-green w3-margin-top"><?php echo $basari; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
