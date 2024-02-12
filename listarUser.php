<?php 

    //incluir arquivo de coneção com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os usuários
    $query_user = "SELECT id, name ,tel FROM users ORDER BY NAME ASC";
    //$query_user = "SELECT id, name FROM user WHERE id = 100 ORDER BY NAME ASC";

    //preparar a query
    $result_user = $conn->prepare($query_user);

    //executar a query
    $result_user->execute();

    //acessa o if quando encontrar usuario no banco de dados
    if(($result_user) && ($result_user->rowCount() != 0)){

        //ler os registros recuperados do banco de dados
        $dados = $result_user->fetchAll((PDO::FETCH_ASSOC));

        //criar o array com o status 
        $retorna = ['status' => true, 'dados' => $dados];
    } else {
        //criar os array com os status e os dados
        $retorna = ['status' => false, 'msg' => "Nenhum usuário encontrado"];
    }

    //converter o array em um obj e retornar para o javascript
    echo json_encode($retorna);



?>