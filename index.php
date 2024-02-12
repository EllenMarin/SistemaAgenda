<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="css/custom.css">


    <title>Sistema de Agenda</title>

</head>

<body>
    <div class="container">

        <h2 class="mb-4">Agenda</h2>

        <span id="msg"></span>

        <div id='calendar'></div>
    </div>

    <!-- Modal visualizar-->
    <div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="visualizarModalLabel">Detalhes do evento</h1>

                    <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar evento</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span id="msgViewEvento"></span>

                    <!--Visualizar-->
                    <div id="visualizarEvento" style="display: none;">

                        <dl class="row">

                            <dt class="col-sm-3">Id: </dt>
                            <dd class="col-sm-9" id="visualizarClient_id"></dd>

                            <dt class="col-sm-3">Cliente: </dt>
                            <dd class="col-sm-9" id="visualizarNameClient"></dd>

                            <dt class="col-sm-3">E-mail: </dt>
                            <dd class="col-sm-9" id="visualizarEmailClient"></dd>

                            <dt class="col-sm-3">Telemóvel: </dt>
                            <dd class="col-sm-9" id="visualizarTelClient"></dd>
                            <hr>
                             
                            <dt class="col-sm-3">Id: </dt>
                            <dd class="col-sm-9" id="visualizarUser_id"></dd>

                            <dt class="col-sm-3">Profissional: </dt>
                            <dd class="col-sm-9" id="visualizarName"></dd>

                           <!-- <dt class="col-sm-3">E-mail do Profissional: </dt>
                            <dd class="col-sm-9" id="visualizarEmail"></dd>

                            <dt class="col-sm-3">Telemóvel do Profissional: </dt>
                            <dd class="col-sm-9" id="visualizarTel"></dd>-->
                            <hr>

                            <dt class="col-sm-3">ID: </dt>
                            <dd class="col-sm-9" id="visualizarId"></dd>

                            <dt class="col-sm-3">Serviço: </dt>
                            <dd class="col-sm-9" id="visualizarServiceName"></dd>

                            <dt class="col-sm-3">Observação: </dt>
                            <dd class="col-sm-9" id="visualizarObs"></dd>

                            <dt class="col-sm-3">Inicio: </dt>
                            <dd class="col-sm-9" id="visualizarStart"></dd>

                            <dt class="col-sm-3">Fim: </dt>
                            <dd class="col-sm-9" id="visualizarEnd"></dd>

                        </dl>

                        <button type="button" class="btn btn-warning" id="btnViewEditEvento">Editar</button>

                        <button type="button" class="btn btn-danger" id="btnApagarEvento">Apagar</button>

                    </div>

                    <!--Editar-->
                    <div id="editarEvento" style="display: none;">

                        <span id="msgEditEvento"></span>

                        <form method="POST" id="formEditEvento">

                            <input type="hidden" name="editId" id="editId">

                            <div class="row mb-3">
                                <label for="editClient_id" class="col-sm-2 col-form-label">Cliente</label>
                                <div class="col-sm-10">
                                    <select name="editClient_id" class="regColor" id="editClient_id">
                                        <option value="">Selecione</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editService_id" class="col-sm-2 col-form-label">Serviço</label>
                                <div class="col-sm-10">
                                    <select name="editService_id" class="regColor" id="editService_id">
                                        <option value="">Selecione</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editObs" class="col-sm-2 col-form-label">Observação</label>
                                <div class="col-sm-10">
                                    <input type="text" name="editObs" class="form-control" id="editObs" placeholder="Observação">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editStart" class="col-sm-2 col-form-label">Início</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="editStart" class="form-control" id="editStart">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editEnd" class="col-sm-2 col-form-label">Fim</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="editEnd" class="form-control" id="editEnd">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editColor" class="col-sm-2 col-form-label">Cor</label>
                                <div class="col-sm-10">
                                    <select name="editColor" class="editColor" id="editColor">
                                        <option value="">Selecione</option>
                                        <option style="color: #FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color: #FF0000;" value="#FF0000">Vermelho</option>
                                        <option style="color: #008000;" value="#008000">Verde</option>
                                        <option style="color: #3788D8;" value="#3788D8">Azul</option>
                                        <option style="color: #FF69B4;" value="#FF69B4">Rosa</option>
                                        <option style="color: #800080;" value="#800080">Roxo</option>
                                        <option style="color: #FFA500;" value="#FFA500">Laranja</option>
                                        <option style="color: #00FFFF;" value="#00FFFF">Ciano</option>
                                        <option style="color: #8B4513;" value="#8B4513">Marrom</option>
                                        <option style="color: #808080;" value="#808080">Cinza</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="editUser_id" class="col-sm-2 col-form-label">Profissional</label>
                                <div class="col-sm-10">
                                    <select name="editUser_id" class="regColor" id="editUser_id">
                                        <option value="">Selecione</option>

                                    </select>
                                </div>
                            </div>


                            <button type="button" name="btnViewEvento" class="btn btn-primary" id="btnViewEvento">Cancelar</button>

                            <button type="submit" name="btnEditEvento" class="btn btn-warning" id="btnEditEvento">Salvar</button>
                        </form>

                    </div>

                    <!--visualizarTodosClientes-->
                    <div id="visualizarTodosClientes" style="display: none;">

                        <dl id="todosClientesTable" class="row">
                        </dl>


                    </div>

                    <!--ver detalhes-->
                    <div id="verDetalheCliente" style="display: none;">



                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal registrar-->
    <div class="modal fade" id="registrarModal" tabindex="-1" aria-labelledby="registrarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="registrarModalLabel">Registrar eventos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span id="msgRegEvento"></span>

                    <form method="POST" id="formRegEvento">
                        <div class="row mb-3">
                            <label for="regClient_id" class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-10">
                                <select name="regClient_id" class="regColor" id="regClient_id">
                                    <option value="">Selecione</option>

                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regUser_id" class="col-sm-2 col-form-label">Profissional</label>
                            <div class="col-sm-10">
                                <select name="regUser_id" class="regColor" id="regUser_id">
                                    <option value="">Selecione</option>

                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regService_id" class="col-sm-2 col-form-label">Serviço</label>
                            <div class="col-sm-10">
                                <select name="regService_id" class="regColor" id="regService_id">
                                    <option value="">Selecione</option>

                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regObs" class="col-sm-2 col-form-label">Observação</label>
                            <div class="col-sm-10">
                                <input type="text" name="regObs" class="form-control" id="regObs" placeholder="Observação">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regStart" class="col-sm-2 col-form-label">Início</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="regStart" class="form-control" id="regStart">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regEnd" class="col-sm-2 col-form-label">Fim</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="regEnd" class="form-control" id="regEnd">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regColor" class="col-sm-2 col-form-label">Cor</label>
                            <div class="col-sm-10">
                                <select name="regColor" class="regColor" id="regColor">
                                    <option value="">Selecione</option>
                                    <option style="color: #FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color: #FF0000;" value="#FF0000">Vermelho</option>
                                    <option style="color: #008000;" value="#008000">Verde</option>
                                    <option style="color: #3788D8;" value="#3788D8">Azul</option>
                                    <option style="color: #FF69B4;" value="#FF69B4">Rosa</option>
                                    <option style="color: #800080;" value="#800080">Roxo</option>
                                    <option style="color: #FFA500;" value="#FFA500">Laranja</option>
                                    <option style="color: #00FFFF;" value="#00FFFF">Ciano</option>
                                    <option style="color: #8B4513;" value="#8B4513">Marrom</option>
                                    <option style="color: #808080;" value="#808080">Cinza</option>
                                </select>
                            </div>
                        </div>




                        <button type="submit" name="btnRegEvento" class="btn btn-success" id="btnRegEvento">Registrar</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!--modal criar cliente-->
    <div class="modal fade" id="criarClienteModal" tabindex="-1" aria-labelledby="criarClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="criarCliente">Criar Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form method="POST" id="formCriarCliente">
                        <div class="row mb-3">
                            <label for="criarClienteNome" class="col-sm-2 col-form-label">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarClienteNome" class="form-control" id="criarClienteNome" placeholder="Nome e sobrenome">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarClienteEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarClienteEmail" class="form-control" id="criarClienteEmail" placeholder="Email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarClienteTel" class="col-sm-2 col-form-label">Telemóvel:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarClienteTel" class="form-control" id="criarClienteTel" placeholder="Telemóvel">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarClienteNasc" class="col-sm-2 col-form-label">Ano de Nascimento:</label>
                            <div class="col-sm-10">
                                <input type="date" name="criarClienteNasc" class="form-control" id="criarClienteNasc">
                            </div>
                        </div>


                        <button type="submit" name="btnCriarCliente" class="btn btn-success" id="btnCriarCliente">Registrar</button>

                        <button type="submit" name="btnVisualizarTodosClientes" class="btn btn-success" id="btnVisualizarTodosClientes">Todos os Clientes</button>
                        <!--<i class="fa fa-search"> Clientes</i>-->
                    </form>



                </div>

            </div>
        </div>
    </div>

    <!--criar serviço-->
    <div class="modal fade" id="criarServiceModal" tabindex="-1" aria-labelledby="criarServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="criarService">Criar Serviço</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" id="formCriarService">
                        <div class="row mb-3">
                            <label for="criarServiceNome" class="col-sm-2 col-form-label">Serviço:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarServiceNome" class="form-control" id="criarServiceNome" placeholder="Nome do serviço">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarServiceDuracao" class="col-sm-2 col-form-label">Duração:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarServiceDuracao" class="form-control" id="criarServiceDuracao" placeholder="Tempo estimado">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarServicePrecoSIva" class="col-sm-2 col-form-label">Preço s/iva:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarServicePrecoSIva" class="form-control" id="criarServicePrecoSIva">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="criarServicePrecoCIva" class="col-sm-2 col-form-label">Preço c/iva:</label>
                            <div class="col-sm-10">
                                <input type="text" name="criarServicePrecoCIva" class="form-control" id="criarServicePrecoCIva">
                            </div>
                        </div>


                        <button type="submit" name="btnCriarService" class="btn btn-success" id="btnCriarService">Criar serviço</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!--visualizarTodosClientes
    <div class="modal fade" id="visualizarTodosClientesModal" tabindex="-1" aria-labelledby="visualizarTodosClientesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="visualizarTodosClientes">Todos os Clientes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="visualizarTodosClientes">

                        <dl class="row">
                            <dt class="col-sm-3">Id: </dt>
                            <dd class="col-sm-9" id="visualizarUser_id"></dd>

                            <dt class="col-sm-3">Nome: </dt>
                            <dd class="col-sm-9" id="visualizarName"></dd>

                            <dt class="col-sm-3">Telemóvel: </dt>
                            <dd class="col-sm-9" id="visualizarTel"></dd>

                            <hr>

                        </dl>

                        <button type="button" class="btn btn-warning" id="btnVerDetalhes">Ver Detalhes</button>


                    </div>

                </div>

            </div>
        </div>
    </div>-->

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="js/sweetAlert2.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src='js/index.global.min.js'></script>
    <script src="js/bootstrap5/index.global.min.js"></script>

    <script src="js/core/locales-all.global.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>