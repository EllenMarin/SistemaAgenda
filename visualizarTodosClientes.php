<?php 
//incluir arquivo de coneção com o banco de dados
include_once 'conexao.php';


$pagina = filter_input(INPUT_GET,"pagina", FILTER_SANITIZE_NUMBER_INT);

$qnt_result_pg = 40;
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

$query_usuarios = "SELECT id, name, email, tel, nascimento FROM users ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";

if(!empty($pagina)){
    $qnt_result_pg = 40;
    $inicio = ($pagina * $qnt_result_pg)
}else{
    
}


?>