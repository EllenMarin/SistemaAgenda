<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>


    <link rel="stylesheet" href="/css/custom.css">
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

                    <div id="visualizarEvento">

                        <dl class="row">
                            <dt class="col-sm-3">ID: </dt>
                            <dd class="col-sm-9" id="visualizarId"></dd>

                            <dt class="col-sm-3">Titulo: </dt>
                            <dd class="col-sm-9" id="visualizarTitle"></dd>

                            <dt class="col-sm-3">Serviços: </dt>
                            <dd class="col-sm-9" id="visualizarServices"></dd>

                            <dt class="col-sm-3">Inicio: </dt>
                            <dd class="col-sm-9" id="visualizarStart"></dd>

                            <dt class="col-sm-3">Fim: </dt>
                            <dd class="col-sm-9" id="visualizarEnd"></dd>


                            <dt class="col-sm-3">Id: </dt>
                            <dd class="col-sm-9" id="visualizarUser_id"></dd>

                            <dt class="col-sm-3">Nome: </dt>
                            <dd class="col-sm-9" id="visualizarName"></dd>

                            <dt class="col-sm-3">E-mail: </dt>
                            <dd class="col-sm-9" id="visualizarEmail"></dd>

                            <dt class="col-sm-3">Telemóvel: </dt>
                            <dd class="col-sm-9" id="visualizarTel"></dd>

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
                                <label for="editTitle" class="col-sm-2 col-form-label">Titulo</label>
                                <div class="col-sm-10">
                                    <input type="text" name="editTitle" class="form-control" id="editTitle" placeholder="Título do evento">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="editServices" class="col-sm-2 col-form-label">Serviços</label>
                                <div class="col-sm-10">
                                    <input type="text" name="editServices" class="form-control" id="editServices" placeholder="Serviços">
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
                            <label for="editUser_id" class="col-sm-2 col-form-label">Cliente</label>
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
                            <label for="regTitle" class="col-sm-2 col-form-label">Titulo</label>
                            <div class="col-sm-10">
                                <input type="text" name="regTitle" class="form-control" id="regTitle" placeholder="Título do evento">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regServices" class="col-sm-2 col-form-label">Serviços</label>
                            <div class="col-sm-10">
                                <input type="text" name="regServices" class="form-control" id="regServices" placeholder="Serviço pretendido">
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

                        <div class="row mb-3">
                            <label for="regUser_id" class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-10">
                                <select name="regUser_id" class="regColor" id="regUser_id">
                                    <option value="">Selecione</option>
                                    
                                </select>
                            </div>
                        </div>
                        

                        <button type="submit" name="btnRegEvento" class="btn btn-success" id="btnRegEvento">Registrar</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src='js/index.global.min.js'></script>
    <script src="js/bootstrap5/index.global.min.js"></script>

    <script src="js/core/locales-all.global.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>