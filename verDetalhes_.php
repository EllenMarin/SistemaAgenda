<?php 

// Arquivo com a conexão com o banco de dados
include_once 'conexao.php';

// Verifica se o parâmetro client_id foi passado na solicitação GET
if (!isset($_GET["client_id"])) {
    // Se o client_id não estiver presente, retorna uma mensagem de erro
    echo json_encode(["error" => "client_id não especificado"]);
    exit(); // Encerra o script
}

// Recupera o client_id da solicitação GET
$client_id = $_GET["client_id"];

// Consulta SQL para recuperar os eventos filtrados por user_id
$query_events = "SELECT evt.id, usr.name as title, evt.color, evt.start, evt.end, evt.obs, evt.user_id, evt.service_id, usr.name, usr.email, usr.tel, evt.client_id, cli.name AS name_cli, cli.email AS email_cli, cli.tel AS tel_cli, svc.name AS 'service_name'
                FROM events AS evt
                INNER JOIN users AS usr ON usr.id = evt.user_id
                INNER JOIN client AS cli ON cli.id = evt.client_id
                INNER JOIN services AS svc ON svc.id = evt.service_id 
                WHERE evt.client_id = :client_id";

$result_events = $conn->prepare($query_events);

// Vincula o valor de client_id à consulta preparada
$result_events->bindParam(":client_id", $user_id);

$result_events->execute();

// Cria o array que recebe os eventos
$eventos = [];

while ($row_events = $result_events->fetch(PDO::FETCH_ASSOC)) {
    
    // Extrai o array
    extract($row_events);

    // Adiciona cada evento ao array de eventos
    $eventos[] = [
        'id' => $id,
        'title' => $name_cli,
        'color' => $color,
        'start' => $start,
        'end' => $end,
        'obs' => $obs,

        'service_id' => $service_id,
        'service_name' => $service_name,

        'user_id' => $user_id,
        'name' => $name,
        'email' => $email,
        'tel' => $tel,

        'client_id' => $client_id,
        'client_name' => $name_cli,
        'client_email' => $email_cli,
        'client_tel' => $tel_cli
    ];
}

// Converte o array de eventos em JSON e retorna para o cliente
echo json_encode($eventos);
?>
