<?php 

    //arquivo com a conexao com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os eventos
    $query_events = "SELECT evt.id, evt.title, evt.color, evt.start, evt.end, evt.services, evt.user_id, usr.name, usr.email, usr.tel
                    FROM events AS evt
                    INNER JOIN users AS usr ON usr.id = evt.user_id";

    $result_events = $conn->prepare($query_events);

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
            'services' => $services,
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'tel' => $tel,
        ];
    }

    echo json_encode($eventos);
?>