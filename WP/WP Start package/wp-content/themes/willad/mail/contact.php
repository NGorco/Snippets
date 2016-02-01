<?php
    $to = 'your_mail@yourmail.com';
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $subject = 'Subject';
    $messages = 'From site your.com: '.$fname.'</br>'.$lname.'</br>'.$email.'</br>'.$phone.'</br>'.$message.'</br>';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: info@your.com' . "\r\n";
    
    mail($to, $subject, $messages, $headers);
?>