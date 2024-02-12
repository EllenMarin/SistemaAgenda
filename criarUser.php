<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados enviado pelo javascript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


//criar a query registrar eventos no banco de dados
$queryCriarUsers = "INSERT INTO users (name, email, tel, nascimento) VALUES (:name, :email, :tel, :nascimento)";



//
$criarUsers = $conn->prepare($queryCriarUsers);


$criarUsers->bindParam(':name', $dados['criarClienteNome']);
$criarUsers->bindParam(':email', $dados['criarClienteEmail']);
$criarUsers->bindParam(':tel', $dados['criarClienteTel']);
$criarUsers->bindParam(':nascimento', $dados['criarClienteNasc']);


if ($criarUsers->execute()) {
    $retorna = [
        'status' => true,
        'msg' => ' Cliente criado com sucesso!',
        'id' => $conn->lastInsertId(),
        'name' => $dados['criarClienteNome'],
        'email' => $dados['criarClienteEmail'],
        'tel' => $dados['criarClienteTel'],
        'nascimento' => $dados['criarClienteNasc'],

    ];
} else {
    $retorna = ['status' => false, 'msg' => 'Cliente não criado!'];
}

echo json_encode($retorna);
