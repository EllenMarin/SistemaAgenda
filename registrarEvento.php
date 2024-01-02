<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados enviado pelo javascript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//recuperar os dados do usuario do banco de dados
$query_user = "SELECT id, name, email, tel FROM users WHERE id =:id LIMIT 1";

//prepara a query
$result_user = $conn->prepare($query_user);

//substituir o link pelo valor
$result_user->bindParam(':id', $dados['regUser_id']);

//execute a query  
$result_user->execute();

//ler os dados do ususario
$row_user = $result_user->fetch(PDO::FETCH_ASSOC);

//criar a query registrar eventos no banco de dados
$queryRegEvent = "INSERT INTO events (title, color, start, end, services, user_id) VALUES (:title, :color, :start, :end, :services, :user_id)";



//
$regEvent = $conn->prepare($queryRegEvent);

$dados['regColor'] = $dados['regColor'] ?: '#3788D8';

$regEvent->bindParam(':title', $dados['regTitle']);
$regEvent->bindParam(':color', $dados['regColor']);
$regEvent->bindParam(':start', $dados['regStart']);
$regEvent->bindParam(':end', $dados['regEnd']);
$regEvent->bindParam(':services', $dados['regServices']);
$regEvent->bindParam(':user_id', $dados['regUser_id']);

if ($regEvent->execute()) {
    $retorna = [
        'status' => true,
        'msg' => ' Evento registrado com sucesso!',
        'id' => $conn->lastInsertId(),
        'title' => $dados['regTitle'],
        'color' => $dados['regColor'],
        'start' => $dados['regStart'],
        'end' => $dados['regEnd'],
        'services' => $dados['regServices'],
        'user_id' => $row_user['id'],
        'name' => $row_user['name'],
        'email' => $row_user['email'],
        'tel' => $row_user['tel'],

    ];
} else {
    $retorna = ['status' => true, 'msg' => ' Evento não registrado!'];
}

echo json_encode($retorna);
