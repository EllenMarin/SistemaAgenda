<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados através do metodo post
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(!is_numeric($dados['regClient_id'])){
    die(json_encode(['status' => false, 'msg' => 'Selecione um cliente']));
}

if(!is_numeric($dados['regUser_id'])){
    die(json_encode(['status' => false, 'msg' => 'Selecione um profissional']));
}

if(!is_numeric($dados['regService_id'])){
    die(json_encode(['status' => false, 'msg' => 'Selecione um serviço']));
}

$query_service = "SELECT id, name
FROM services
WHERE id =:id LIMIT 1";

$result_service = $conn->prepare($query_service);
$result_service->bindParam(':id', $dados['regService_id']); 
$result_service->execute();
$row_service = $result_service->fetch(PDO::FETCH_ASSOC);

$query_client = "SELECT id, name, email, tel 
                FROM client 
                WHERE id =:id LIMIT 1";
$result_client = $conn->prepare($query_client);
$result_client->bindParam(':id', $dados['regClient_id']);
$result_client->execute();
$row_client = $result_client->fetch(PDO::FETCH_ASSOC);


//recuperar os dados do usuario do banco de dados
$query_user = "SELECT id, name, email, tel 
                FROM users 
                WHERE id =:id LIMIT 1";
//prepara a query
$result_user = $conn->prepare($query_user);
//substituir o link pelo valor
$result_user->bindParam(':id', $dados['regUser_id']);
//execute a query  
$result_user->execute();
//ler os dados do ususario
$row_user = $result_user->fetch(PDO::FETCH_ASSOC);

//criar a query registrar eventos no banco de dados
$queryRegEvent = "INSERT INTO events (title, color, start, end, obs, user_id, client_id, service_id) VALUES (:title, :color, :start, :end, :obs, :user_id, :client_id, :service_id)";

$regEvent = $conn->prepare($queryRegEvent);

$dados['regColor'] = $dados['regColor'] ?: '#3788D8';

$regEvent->bindParam(':title', $dados['regTitle']);
$regEvent->bindParam(':color', $dados['regColor']);
$regEvent->bindParam(':start', $dados['regStart']);
$regEvent->bindParam(':end', $dados['regEnd']);
$regEvent->bindParam(':obs', $dados['regObs']);
$regEvent->bindParam(':user_id', $dados['regUser_id']);
$regEvent->bindParam(':client_id', $dados['regClient_id']);
$regEvent->bindParam(':service_id', $dados['regService_id']);

if ($regEvent->execute()) {
    $retorna = [
        'status' => true,
        'msg' => ' Evento registrado com sucesso!',
        'id' => $conn->lastInsertId(),
        'title' => $row_client['name'],
        'color' => $dados['regColor'],
        'start' => $dados['regStart'],
        'end' => $dados['regEnd'],
        'obs' => $dados['regObs'],
        
        'service_id' => $row_service['id'],
        'service_name' => $row_service['name'],

        'user_id' => $row_user['id'],
        'name' => $row_user['name'],
        'email' => $row_user['email'],
        'tel' => $row_user['tel'],

        'client_id' => $row_client['id'],
        'client_name' => $row_client['name'],
        'client_email' => $row_client['email'],
        'client_tel' => $row_client['tel'],

    ];
} else {
    $retorna = ['status' => false, 'msg' => ' Evento não registrado!'];
}

//convertendo array a cima em obj para retornar js
echo json_encode($retorna);
