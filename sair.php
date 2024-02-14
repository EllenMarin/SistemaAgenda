<?php 

//iniciar sessão, destruir as duas variaveis globais id e nome, depois redirecionar o usuário index.php
session_start();

unset($_SESSION['id'], $_SESSION['name']);
header("Location: index.php");
?>