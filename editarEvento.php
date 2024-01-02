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
$result_user->bindParam(':id', $dados['editUser_id']);

//execute a query  
$result_user->execute();

//ler os dados do ususario
$row_user = $result_user->fetch(PDO::FETCH_ASSOC);

//criar query editar evento no banco de dados
$queryEditEvent = "UPDATE events SET title=:title, color=:color, start=:start, end=:end, services=:services, user_id=:user_id WHERE id=:id";

$editEvent = $conn->prepare($queryEditEvent);

//$dados['regColor'] = $dados['regColor'] ?: '#3788D8';

$editEvent->bindParam(':title', $dados['editTitle']);
$editEvent->bindParam(':color', $dados['editColor']);
$editEvent->bindParam(':start', $dados['editStart']);
$editEvent->bindParam(':end', $dados['editEnd']);
$editEvent->bindParam(':services', $dados['editServices']);
$editEvent->bindParam(':user_id', $dados['editUser_id']);
$editEvent->bindParam(':id', $dados['editId']);

//verificar se conseguiu editar corretamente
if ($editEvent->execute()) {
    $retorna = [
        'status' => true, 
        'msg' => 
        ' Evento editado com sucesso!', 
        'id' => $dados['editId'], 
        'title' => $dados['editTitle'], 
        'color' => $dados['editColor'], 
        'start' => $dados['editStart'], 
        'end' => $dados['editEnd'], 
        'services' => $dados['editServices'],
        'user_id' => $row_user['id'],
        'name' => $row_user['name'],
        'email' => $row_user['email'],
        'tel' => $row_user['tel'],
    ];
} else {
    $retorna = ['status' => false, 'msg' => ' Evento não editado!'];
}

echo json_encode($retorna);
