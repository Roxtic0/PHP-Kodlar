<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin_giris.php");
    exit;
}

$baglanti = new mysqli("localhost", "root", "", "mobilya");

$id = $_GET['id'] ?? 0;
$hata = "";
$basari = "";

$stmt = $baglanti->prepare("SELECT * FROM mobilyalar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$sonuc = $stmt->get_result();

if ($sonuc->num_rows !== 1) {
    die("Mobilya bulunamadı.");
}

$mobilya = $sonuc->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = $_POST["isim"];
    $fiyat = $_POST["fiyat"];
    $yeniResim = $mobilya["resim_yolu"];

    if (isset($_FILES["resim"]) && $_FILES["resim"]["error"] == 0) {
        $resimAdi = basename($_FILES["resim"]["name"]);
        $hedefYol = "../uploads/" . $resimAdi;

        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $hedefYol)) {
            $yeniResim = $resimAdi;
        } else {
            $hata = "Resim yüklenemedi.";
        }
    }

    if (!$hata) {
        $stmt = $baglanti->prepare("UPDATE mobilyalar SET isim = ?, fiyat = ?, resim_yolu = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $isim, $fiyat, $yeniResim, $id);

        if ($stmt->execute()) {
            $basari = "✅ Mobilya başarıyla güncellendi.";
            $mobilya["isim"] = $isim;
            $mobilya["fiyat"] = $fiyat;
            $mobilya["resim_yolu"] = $yeniResim;
        } else {
            $hata = "Veritabanı hatası.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mobilya Güncelle</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-dark-grey.css">
</head>
<body class="w3-theme-d5">

<div class="w3-container w3-black w3-padding">
    <h2>Mobilya Güncelle</h2>
    <a href="admin_panel.php" class="w3-button w3-amber">← Geri Dön</a>
</div>

<div class="w3-container w3-theme-d2 w3-padding w3-margin">
    <form method="POST" class="w3-theme-d2" enctype="multipart/form-data">
        <label>Mobilya İsmi</label>
        <input class="w3-input w3-border" type="text" name="isim" value="<?php echo htmlspecialchars($mobilya['isim']); ?>" required>

        <label>Fiyat (₺)</label>
        <input class="w3-input w3-border" type="number" step="0.01" name="fiyat" value="<?php echo $mobilya['fiyat']; ?>" required>

        <label>Mevcut Resim</label><br>
        <img src="../uploads/<?php echo $mobilya['resim_yolu']; ?>" style="height:80px"><br><br>

        <label>Yeni Resim (isteğe bağlı)</label>
        <input class="w3-input w3-border" type="file" name="resim" accept="image/*">

        <button class="w3-button w3-green w3-margin-top" type="submit">Güncelle</button>
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
