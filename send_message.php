<?php
session_start();
$language = include "languages/".$_SESSION['preferences']['language'].".php";


function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST["name"]);
    $email = sanitize($_POST["email"]);
    $phone = sanitize($_POST["phone"]);
    $message = sanitize($_POST["message"]);

    $errors = [];

    if(empty($name) || strlen($name) < 2){
        $errors[] = $language['name_too_short'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = $language['email'];
    }

    if (!empty($phone) && !preg_match("/^[0-9\s+()-]*$/", $phone)) {
        $errors[] = $language['phone'];
    }

    if(empty($message) || strlen($message) < 10){
        $errors[] = $language['message_too_short'];
    }

    if(empty($errors)){
//        jesli error to komunikat bedzie lub zapis w BD
$db = new mysqli('localhost', 'root', '', 'abc');

                    // Check connection
                    if($db->connect_error){
                        die('Connection failed: ' . $db->connect_error);
                    }
                        $sql = "INSERT INTO tabela (Imie, Email, Telefon, Wiadomosc) VALUES ('$name', '$email', '$phone', '$message')";
                        if($db->query($sql) === TRUE){
                            echo "Added to queue successfully";
                        } else{
                            echo "Error adding to queue: " . $db->error;
                        }
        $db->close();
        echo '<script> const stop = alert("Formularz wysłano pomyślnie")</script>';
                       echo "<a href='index.php'>Powrot na strone</a>";

//        echo $language['send_success'];
    } else {
        foreach($errors as $error){
            echo "<p>$error</p>";
        }
    }
}
?>
