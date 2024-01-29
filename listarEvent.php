<?php 

    //arquivo com a conexao com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os eventos
    $query_events = "SELECT evt.id, usr.name as title, evt.color, evt.start, evt.end, evt.obs, evt.user_id, evt.service_id, usr.name, usr.email, usr.tel, svc.name as 'service_name'
                    FROM events AS evt
                    INNER JOIN users AS usr ON usr.id = evt.user_id
                    INNER JOIN services AS svc ON svc.id = evt.service_id ";

    if(!empty($_GET["user_id"])){
        $query_events .= " WHERE evt.user_id = :user_id";
    }

    $result_events = $conn->prepare($query_events);

    if(!empty($_GET["user_id"])){
        $result_events->bindParam(":user_id",$_GET["user_id"]);
    }

    $result_events->execute();

    //criar o array que recebe os eventos
    $eventos = [];

    while($row_events = $result_events->fetch(PDO::FETCH_ASSOC)){
        
        //extrair o array
        extract($row_events);

        $eventos[] = [
            'id' => $id,
            'title' => $title,
            'color' => $color,
            'start' => $start,
            'end' => $end,
            'obs' => $obs,
            'user_id' => $user_id,
            'service_id' => $service_id,
            'service_name' => $service_name,
            'name' => $name,
            'email' => $email,
            'tel' => $tel,
        ];
    }

    echo json_encode($eventos);
?>