<?php
$baglanti = new mysqli("localhost", "root", "", "mobilya");

if ($baglanti->connect_error) {
    die("Veritabanına bağlanılamadı: " . $baglanti->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $baglanti->query("SELECT * FROM mobilyalar WHERE id = $id");
    $urun = $query->fetch_assoc();
} else {
    die("Geçersiz ürün ID.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ürün Detay</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-deep-purple.css">
</head>
<body class="w3-theme-d5">

<div class="w3-container w3-deep-purple w3-padding-16">
    <h2>Ürün Detayı</h2>
</div>

<div class="w3-container w3-purple w3-padding">
    <h3><?php echo htmlspecialchars($urun['isim']); ?></h3>
    <img src="uploads/<?php echo $urun['resim_yolu']; ?>" alt="Mobilya Resmi" style="width:100%; height:300px; object-fit:cover">
    <p><strong>Fiyat: </strong>₺<?php echo number_format($urun['fiyat'], 2, ',', '.'); ?></p>
    
    <form action="sepet.php" method="post">
        <input type="hidden" name="urun_id" value="<?php echo $urun['id']; ?>">
        <input type="number" name="adet" value="1" min="1" class="w3-input w3-border w3-margin-bottom" style="width:80px;" required>
        <button class="w3-button w3-green">Sepete Ekle</button>
        <a href="index.php" class="w3-button w3-amber">Anasayfaya Dön</a>
    </form>
</div>

</body>
</html>
