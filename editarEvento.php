<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados enviado pelo javascript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//
$query_service = "SELECT id, name
FROM services
WHERE id =:id LIMIT 1";

$result_service = $conn->prepare($query_service);
$result_service->bindParam(':id', $dados['editService_id']); 
$result_service->execute();
$row_service = $result_service->fetch(PDO::FETCH_ASSOC);

//recuperar os dados do usuario do banco de dados
$query_user = "SELECT id, name, email, tel 
FROM users 
WHERE id =:id LIMIT 1";

$result_user = $conn->prepare($query_user);
$result_user->bindParam(':id', $dados['editUser_id']); 
$result_user->execute();
$row_user = $result_user->fetch(PDO::FETCH_ASSOC);

//
$query_client = "SELECT id, name, email, tel 
FROM client 
WHERE id =:id LIMIT 1";

$result_client = $conn->prepare($query_client);
$result_client->bindParam(':id', $dados['editClient_id']); 
$result_client->execute();
$row_client = $result_client->fetch(PDO::FETCH_ASSOC);

//criar query editar evento no banco de dados
$queryEditEvent = "UPDATE events SET title=:title, color=:color, start=:start, end=:end, obs=:obs, user_id=:user_id, client_id=:client_id, service_id=:service_id WHERE id=:id";

$editEvent = $conn->prepare($queryEditEvent);

//$dados['regColor'] = $dados['regColor'] ?: '#3788D8';
$colorValue = $dados['editColor'] ?? '#3788D8';
$editEvent->bindParam(':color', $colorValue);

$editEvent->bindParam(':title', $dados['editTitle']);
//$editEvent->bindParam(':color', $dados['editColor']?? '#3788D8');
$editEvent->bindParam(':start', $dados['editStart']);
$editEvent->bindParam(':end', $dados['editEnd']);
$editEvent->bindParam(':obs', $dados['editObs']);
$editEvent->bindParam(':user_id', $dados['editUser_id']);
$editEvent->bindParam(':id', $dados['editId']);
$editEvent->bindParam(':client_id', $dados['editClient_id']);
$editEvent->bindParam(':service_id', $dados['editService_id']);

//verificar se conseguiu editar corretamente
if ($editEvent->execute()) {
    $retorna = [
        'status' => true, 
        'msg' => 'Evento editado com sucesso!', 
        'id' => $dados['editId'], 
        'title' => $row_client['name'], 
        'color' => $colorValue, 
        'start' => $dados['editStart'], 
        'end' => $dados['editEnd'], 
        'obs' => $dados['editObs'],

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
    $retorna = ['status' => false, 'msg' => ' Evento não editado!'];
}

echo json_encode($retorna);
