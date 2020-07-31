<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try {
    //Server settings

    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'help@trueskills.ru';                    // SMTP username
    $mail->Password   = 'nxbkwdwrshlcquau';                            // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('help@trueskills.ru', 'TrueSkills Support');
    $mail->addAddress("info@trueskills.ru", "Info");
//    $mail->addAddress("info@trueskills.ru", "Info");
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if($name == "") {
        echo json_encode(["status" => 400, "messages" => "Необходимо ввести ваше имя"]);
        die();
    }else if($phone == "") {
        echo json_encode(["status" => 400, "messages" => "Необходимо ввести ваш телефон"]);
        die();
    } else if($message == "") {
        echo json_encode(["status" => 400, "messages" => "Необходимо ввести сообщение"]);
        die();
    }

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Заявка с сайта trueskills.ru';
    $mail->Body    = "<h5>Пришла заявка на оформление договора на проведение ДЭ</h5>
                    <p><b>Имя:</b> $name</p>
                    <br /> 
                    <p><b>Телефон:</b> $phone</p>
                    <br /> <b>Комментарий: </b> $message";

    $mail->send();
    echo json_encode(["status" => 200, "messages" => "Наш специалист скоро свяжется с вами."]);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}