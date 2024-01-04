<?php 

    //incluir arquivo de coneção com o banco de dados
    include_once 'conexao.php';

    //query para recuperar os serviços
    $query_services = "SELECT id, name FROM services ORDER BY NAME ASC";
    //$query_services = "SELECT id, name FROM services WHERE id = 100 ORDER BY NAME ASC";

    //preparar a query
    $result_services = $conn->prepare($query_services);

    //executar a query
    $result_services->execute();

    //acessa o if quando encontrar usuario no banco de dados
    if(($result_services) and ($result_services->rowCount() != 0)){

        //ler os registros recuperados do banco de dados
        $dados = $result_services->fetchAll((PDO::FETCH_ASSOC));

        //criar o array com o status 
        $retorna = ['status' => true, 'dados' => $dados];
    } else {
        //criar os array com os status e os dados
        $retorna = ['status' => false, 'msg' => "Nenhum serviço encontrado"];
    }

    //converter o array em um obj e retornar para o javascript
    echo json_encode($retorna);



?>