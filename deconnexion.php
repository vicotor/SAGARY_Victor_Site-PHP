<?php

session_start();

unset($_COOKIE['sid']);

unset($verif);

header("Location: connexion.php");

?>