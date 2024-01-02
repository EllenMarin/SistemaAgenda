<?php 
    //arquivo com a conexao com o banco de dados
    include_once 'conexao.php';

    //receber o id enviado pelo javascript
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    //acessa o if quando existe o id do evento
    if(!empty($id)){
        //criar query apagar evento do banco de dados
        $queryApagarEvent = "DELETE FROM events WHERE id=:id";
        //prepara a query
        $apagarEvent = $conn->prepare($queryApagarEvent);
        //substituir o link pelo valor
        $apagarEvent->bindParam(':id', $id);

        //verificar se consegui apagar corretamente
        if($apagarEvent->execute()){
            $retorna = ['status' => true, 'msg' => ' Evento apagado com sucesso!'];
        }else{
            $retorna = ['status' => false, 'msg' => ' Erro: Evento não apagado!'];
        }

    } else {//somente acessa o else quando o id estiver vazio
        $retorna = ['status' => false, 'msg' => ' Erro: Necessário enviar o id do evento!'];
    }

    //converter o array em objeto e retornar opara o javascript
    echo json_encode($retorna);


?>