<?php
session_start();

if (!isset($_SESSION['sepet'])) {
    $_SESSION['sepet'] = [];
}
if (isset($_GET['remove'])) {
    $urun_id = $_GET['remove'];
    // Sepetteki ürünü çıkartıyoruz
    unset($_SESSION['sepet'][$urun_id]);
}

// Sepeti temizleme işlemi
if (isset($_GET['clear'])) {
    $_SESSION['sepet'] = []; // Sepeti tamamen temizliyoruz
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['urun_id'])) {
    $urun_id = $_POST['urun_id'];
    $adet = $_POST['adet'];

    $baglanti = new mysqli("localhost", "root", "", "mobilya");
    $query = $baglanti->query("SELECT * FROM mobilyalar WHERE id = $urun_id");
    $urun = $query->fetch_assoc();

    $sepet_urun = [
        'id' => $urun['id'],
        'isim' => $urun['isim'],
        'fiyat' => $urun['fiyat'],
        'adet' => $adet
    ];

    $_SESSION['sepet'][] = $sepet_urun;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sepet</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-deep-purple.css">
</head>
<body class="w3-theme-d5">
    <div class="w3-container w3-deep-purple w3-padding-16">
        <h2>Sepetim</h2>
    </div>

    <?php if (empty($_SESSION['sepet'])): ?>
        <div class="w3-container w3-padding-16">
            <p>Sepetiniz boş.</p>
        </div>
    <?php else: ?>
        <table class="w3-table w3-bordered">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Adet</th>
                    <th>Fiyat</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $toplam_tutar = 0;
                foreach ($_SESSION['sepet'] as $urun_id => $urun):
                    $urun_fiyat = $urun['fiyat'];
                    $urun_adet = $urun['adet'];
                    $toplam_tutar += $urun_fiyat * $urun_adet;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($urun['isim']); ?></td>
                        <td><?php echo $urun_adet; ?></td>
                        <td>₺<?php echo number_format($urun_fiyat * $urun_adet, 2, ',', '.'); ?></td>
                        <td><a href="sepet.php?remove=<?php echo $urun_id; ?>" class="w3-button w3-red">Çıkar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="w3-container w3-padding-16">
            <h3>Toplam Tutar: ₺<?php echo number_format($toplam_tutar, 2, ',', '.'); ?></h3>
            <form action="siparis_ver.php" method="post">
            <a href="sepet.php?clear=true" class="w3-button w3-red">Sepeti Temizle</a>
            <button class="w3-button w3-green">Siparişi Ver</button>
        </form>
        </div>
    <?php endif; ?>
    <a href="index.php" class="w3-button w3-amber" style="margin-left:16px;">Anasayfaya Dön</a>
</body>
</html>
</body>
</html>
