<?php
$baglanti = new mysqli("localhost", "root", "", "mobilya");
$mobilyalar = $baglanti->query("SELECT * FROM mobilyalar ORDER BY id DESC");

$cookie_name = "cookie_accepted";
if (!isset($_COOKIE[$cookie_name])) {
    $cookie_message = true;
} else {
    $cookie_message = false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mobilya Vitrini</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-deep-purple.css">
    <style>
        .cookie-consent {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #222;
            color: white;
            text-align: center;
            padding: 15px;
            z-index: 1000;
            display: none;
        }
        .cookie-consent button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .cookie-consent button:hover {
            background-color: #45a049;
        }
        .cookie-consent .reject-btn {
            background-color: #f44336;
        }
        .cookie-consent .reject-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body class="w3-theme-d5">

<div class="w3-container w3-deep-purple w3-padding-16">
    <h2>Mobilya Vitrini</h2>
    <a href="admin/admin_giris.php" class="w3-button w3-red w3-right">Admin Girişi</a>
</div>

<div class="w3-row-padding w3-margin-top">
<?php while ($mobilya = $mobilyalar->fetch_assoc()): ?>
    <center>
    <div class="w3-quarter w3-margin-bottom">
        <div class="w3-card-4 w3-purple" style="width:300px; height:450px;">
            <img src="uploads/<?php echo $mobilya['resim_yolu']; ?>" alt="Mobilya" style="width:100%; height:200px; object-fit:cover">
            <div style="width" class="w3-container">
                <h4><?php echo htmlspecialchars($mobilya['isim']); ?></h4>
                <p><b>₺<?php echo number_format($mobilya['fiyat'], 2, ',', '.'); ?></b></p>
                <a href="urun_detay.php?id=<?php echo $mobilya['id']; ?>" class="w3-button w3-blue w3-margin-bottom">Ürün Detayı</a>
                <form action="sepet.php" method="post">
                    <input type="hidden" name="urun_id" value="<?php echo $mobilya['id']; ?>">
                    <input type="number" name="adet" value="1" min="1" class="w3-input w3-border w3-margin-bottom" style="width:80px;" required>
                    <button class="w3-button w3-green">Sepete Ekle</button>
                </form>
            </div>
        </div>
    </div>
    </center>
<?php endwhile; ?>
</div>

<?php if ($cookie_message): ?>
<div id="cookie-consent" class="cookie-consent">
    <p>Bu site, kullanıcı deneyimini iyileştirmek için çerezler kullanmaktadır. Çerezleri kabul etmek veya reddetmek için butonlardan birine tıklayın.</p>
    <button onclick="acceptCookies()">Çerezleri Kabul Et</button>
    <button class="reject-btn" onclick="rejectCookies()">Çerezleri Reddet</button>
</div>
<?php endif; ?>

<script>
    function acceptCookies() {
        var expiryDate = new Date();
        expiryDate.setTime(expiryDate.getTime() + (2 * 60 * 1000));
        document.cookie = "cookie_accepted=true; expires=" + expiryDate.toUTCString() + "; path=/";
        
        document.getElementById('cookie-consent').style.display = "none";
    }

    function rejectCookies() {
        document.getElementById('cookie-consent').style.display = "none";
    }

    window.onload = function() {
        if (document.cookie.indexOf("cookie_accepted=true") === -1) {
            document.getElementById('cookie-consent').style.display = "block";
        }
    };
</script>

</body>
</html>

