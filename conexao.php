<?php 
    //inicio da conexão usando pdo
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "sistemaAgenda";
    $port = 3306;
ini_set("display_errors",1);
    try{
        //conexao coma porta
        //$con = new PDO("mysql:host|=$host;port=$port;dbname=$dbname=".$dbname, $user, $pass);

        //conexão sem a porta
        $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
        //echo "Coneção com banco de dados realizada com sucesso.";

    }catch (PDOException $err){
        die("Erro: Conexão com banco de dados não realizada".$err->getMessage());

    }
?>