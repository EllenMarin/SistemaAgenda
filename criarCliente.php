<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados enviado pelo javascript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


//criar a query registrar eventos no banco de dados
$queryCriarClient = "INSERT INTO client (name, email, tel, nascimento) VALUES (:name, :email, :tel, :nascimento)";



//
$criarClient = $conn->prepare($queryCriarClient);


$criarClient->bindParam(':name', $dados['criarClienteNome']);
$criarClient->bindParam(':email', $dados['criarClienteEmail']);
$criarClient->bindParam(':tel', $dados['criarClienteTel']);
$criarClient->bindParam(':nascimento', $dados['criarClienteNasc']);


if ($criarClient->execute()) {
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
