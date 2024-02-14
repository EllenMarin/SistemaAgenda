<?php 
 session_start();
 include_once 'conexao.php';

$dadosFormLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
/*$dadosFormLogin = [
    "email" => "ellen@hotmail.com",
    "password" => "123456"
];*/

if(empty($dadosFormLogin['email'])){
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário</div>"];
}elseif(empty($dadosFormLogin['password'])){
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo password</div>"];
}else{
    $query_usuarioLogin = "SELECT id, name, email, password
                        FROM users
                        WHERE email=:email
                        LIMIT 1";
    $result_usuarioLogin = $conn->prepare($query_usuarioLogin);
    $result_usuarioLogin->bindParam(':email', $dadosFormLogin['email'], PDO::PARAM_STR);
    $result_usuarioLogin->execute();

    if(($result_usuarioLogin) and ($result_usuarioLogin->rowCount() != 0)){
        $row_usuarioLogin = $result_usuarioLogin->fetch(PDO::FETCH_ASSOC);
        if(password_verify($dadosFormLogin['password'], $row_usuarioLogin['password'])){
            $_SESSION['id'] = $row_usuarioLogin['id'];
            $_SESSION['name'] = $row_usuarioLogin['name'];
            $retorna = ['erro' => false, 'dadosBD' => $row_usuarioLogin];
        }else{
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário ou senha inválida</div>"];
        }

        
    }else{
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário ou senha inválida</div>"];
    }

    //$retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Validar</div>"];
}

echo json_encode($retorna);


?>