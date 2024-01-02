<?php 

    //incluir arquivo de coneção com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os usuários
    $query_users = "SELECT id, name FROM users ORDER BY NAME ASC";
    //$query_users = "SELECT id, name FROM users WHERE id = 100 ORDER BY NAME ASC";

    //preparar a query
    $result_users = $conn->prepare($query_users);

    //executar a query
    $result_users->execute();

    //acessa o if quando encontrar usuario no banco de dados
    if(($result_users) and ($result_users->rowCount() != 0)){

        //ler os registros recuperados do banco de dados
        $dados = $result_users->fetchAll((PDO::FETCH_ASSOC));

        //criar o array com o status 
        $retorna = ['status' => true, 'dados' => $dados];
    } else {
        //criar os array com os status e os dados
        $retorna = ['status' => false, 'msg' => "Nenhum cliente encontrado"];
    }

    //converter o array em um obj e retornar para o javascript
    echo json_encode($retorna);



?>