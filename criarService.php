<?php
//arquivo com a conexao com o banco de dados
include_once 'conexao.php';

//receber dados enviado pelo javascript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_service_existe = "SELECT count(*) FROM services WHERE name =:name LIMIT 1";

//prepara a query
$result_service_existe = $conn->prepare($query_service_existe);

//substituir o link pelo valor
$result_service_existe->bindParam(':name', $dados['criarServiceNome']);

//execute a query  
$result_service_existe->execute();

//ler os dados do ususario
$row_service_existe = $result_service_existe->fetch(PDO::FETCH_COLUMN);

if(!empty($row_service_existe)){
    $retorna = [
        'status' => false, 
        'msg' => 'Serviço já existe!'
    ];
    echo json_encode($retorna);
    die();
}


//criar a query registrar eventos no banco de dados
$queryCriarService = "INSERT INTO services (name, duracao, price, price_iva) VALUES (:name, :duracao, :price, :price_iva)";



//
$criarService = $conn->prepare($queryCriarService);
$dados['criarServicePrecoSIva']=$dados['criarServicePrecoSIva']?: $dados['criarServicePrecoCIva']/1.23;

$dados['criarServicePrecoCIva'] =$dados['criarServicePrecoCIva']?: $dados['criarServicePrecoSIva']*1.23;

$criarService->bindParam(':name', $dados['criarServiceNome']);
$criarService->bindParam(':duracao', $dados['criarServiceDuracao']);
$criarService->bindParam(':price', $dados['criarServicePrecoSIva']);
$criarService->bindParam(':price_iva', $dados['criarServicePrecoCIva']);


if ($criarService->execute()) {
    $retorna = [
        'status' => true,
        'msg' => ' Serviço criado com sucesso!',
        'id' => $conn->lastInsertId(),
        'name' => $dados['criarServiceNome'],
        'duracao' => $dados['criarServiceDuracao'],
        'price' => $dados['criarServicePrecoSIva'],
        'price_iva' => $dados['criarServicePrecoCIva'],

    ];
} else {
    $retorna = ['status' => false, 'msg' => 'Serviço não criado!'];
}

echo json_encode($retorna);

