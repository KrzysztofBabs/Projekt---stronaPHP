<?php
session_start();

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $preferences=[
        'language'=> $_POST['language'],
        'theme'=> $_POST['theme']
    ];

    // Zapisanie preferencji w sesji i ciasteczkach
    $_SESSION['preferences']=$preferences;
    setcookie('preferences', json_encode($preferences),time() +(86400*30),"/");

    // Przekierowanie na strone glowna
    header("Location:index.php");
    exit();
}
?>
