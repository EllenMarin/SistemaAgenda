<?php 

    //arquivo com a conexao com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os eventos
    $query_events = "SELECT evt.id, usr.name as title, evt.color, evt.start, evt.end, evt.obs, evt.user_id, evt.service_id, usr.name, usr.email, usr.tel, evt.client_id, cli.name AS name_cli, cli.email AS email_cli, cli.tel AS tel_cli, svc.name AS 'service_name'
                    FROM events AS evt
                    INNER JOIN users AS usr ON usr.id = evt.user_id
                    INNER JOIN client AS cli ON cli.id = evt.client_id
                    INNER JOIN services AS svc ON svc.id = evt.service_id ";

    if(!empty($_GET["client_id"])){
        $query_events .= " WHERE evt.client_id = :client_id";
    }

    $result_events = $conn->prepare($query_events);

    if(!empty($_GET["client_id"])){
        $result_events->bindParam(":client_id",$_GET["client_id"]);
    }

    $result_events->execute();

    //criar o array que recebe os eventos
    $eventos = [];

    while($row_events = $result_events->fetch(PDO::FETCH_ASSOC)){
        
        //extrair o array
        extract($row_events);

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

    echo json_encode($eventos);
?>