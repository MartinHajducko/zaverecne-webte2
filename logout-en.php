<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
session_start();

// Uvolni vsetky session premenne.
session_unset();

// Vymaz vsetky data zo session.
session_destroy();
*/
// Ak nechcem zobrazovat obsah, presmeruj pouzivatela na hlavnu stranku.
// header('location:index.php');

?>


<?php

session_start();

// Uvolnenie session premennych. Tieto dva prikazy su ekvivalentne.
$_SESSION = array();
session_unset();

// Vymazanie session.
session_destroy();

// Presmerovanie na hlavnu stranku.
header("location: index-en.php");
exit;
