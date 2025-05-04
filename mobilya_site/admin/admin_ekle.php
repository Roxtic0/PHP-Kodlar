<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$baglanti = new mysqli("localhost", "root", "", "mobilya");
if ($baglanti->connect_error) {
    die("Veritabanına bağlanılamadı: " . $baglanti->connect_error);
}

$kullanici_adi = 'admin';
$sifre = password_hash('1234', PASSWORD_DEFAULT);

$sql = "INSERT INTO adminler (kullanici_adi, sifre) VALUES (?, ?)";
$stmt = $baglanti->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $kullanici_adi, $sifre);

    if ($stmt->execute()) {
        echo "✅ Admin hesabı başarıyla oluşturuldu. <br>Kullanıcı adı: <b>admin</b> | Şifre: <b>1234</b>";
    } else {
        echo "❌ Admin oluşturulamadı: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ SQL sorgusu hatalı: " . $baglanti->error;
}

$baglanti->close();
?>
