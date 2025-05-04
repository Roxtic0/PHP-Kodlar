<?php
session_start();

if (empty($_SESSION['sepet'])) {
    die("Sepetinizde ürün yok.");
}

unset($_SESSION['sepet']);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sipariş Tamamlandı</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-deep-purple w3-padding-16">
    <h2>Sipariş Tamamlandı</h2>
</div>

<div class="w3-container w3-white w3-padding">
    <p>Teşekkür ederiz, siparişiniz başarıyla alınmıştır.</p>
    <a href="index.php" class="w3-button w3-amber">Anasayfaya Git</a>
</div>

</body>
</html>
