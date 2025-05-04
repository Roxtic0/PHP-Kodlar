<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
}

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "Lütfen tüm alanları doldurduğunuzdan emin olun!";
    exit;
}

try {
    $mail->isSMTP();                                      
    $mail->Host = 'smtp.gmail.com';                       
    $mail->SMTPAuth = true;                               
    $mail->Username = 'E-mail adresiniz';                  
    $mail->Password = 'google uygulama şifresi';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
    $mail->Port = 587;                                    

    $mail->setFrom($email, $name);   
    $mail->addAddress('email-adresiniz', 'Gönderen kişinin Adı Soyadı');  

    $mail->isHTML(true);                                  
    $mail->Subject = $subject;
    $mail->Body    = "<h2>İçeriği Gönderen: $name</h2>
                      <p><strong>E-Posta:</strong> $email</p>
                      <p><strong>Konu:</strong> $subject</p>
                      <p><strong>Mesaj:</strong> $message</p>";

    $mail->send();  
    echo 'Mail başarıyla gönderildi';
} catch (Exception $e) {
    echo "Mesaj gönderilemedi. Hata: {$mail->ErrorInfo}";
}
?>