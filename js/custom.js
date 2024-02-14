
const loginForm = document.getElementById("loginForm");
const msgAlertLogin = document.getElementById("msgAlertLogin");
const loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
const agenda = document.getElementById("agenda");

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if(document.getElementById("email").value === ""){
      msgAlertLogin.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário</div>";
    }else if(document.getElementById("password").value === ""){
      msgAlertLogin.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo password</div>";
    }else{
      const dadosForm = new FormData(loginForm);

      const dadosFormLogin = await fetch("validar.php", {
        method: "POST",
        body: dadosForm
      });

      const respostaDadosFormLogin = await dadosFormLogin.json();
      

      if(respostaDadosFormLogin['erro']){
        msgAlertLogin.innerHTML = respostaDadosFormLogin['msg'];
      }else{
        document.getElementById("dadosUsuario").innerHTML = "<h2>Bem vindo " + respostaDadosFormLogin['dadosBD'].name + "<br></h2><a href='sair.php'><i class='bi bi-box-arrow-left' style='font-size: 24px; color: grey;'></i></a><br>";
        loginForm.reset();
        loginModal.hide();
        agenda.style.display = "block";
      }
    }
  });
  
  document.addEventListener('DOMContentLoaded', function () {

  var calendarEl = document.getElementById('calendar');

  const registrarModal = new bootstrap.Modal(document.getElementById("registrarModal"));
  const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));
  const criarClienteModal = new bootstrap.Modal(document.getElementById("criarClienteModal"));
  const criarServiceModal = new bootstrap.Modal(document.getElementById("criarServiceModal"));

  //receber o seletor msgViewEvento
  const msgViewEvento = document.getElementById('msgViewEvento');

  function exibirModal(viewId) {
    const views = document.querySelectorAll("#visualizarModal .modal-body > *");
    for (const ele of views) {
      ele.style.display = "none";
    }
    document.getElementById(viewId).style.display = "block";
  }
  //instanciar fullcalender e atribuir a variavel calender
  var calendar = new FullCalendar.Calendar(calendarEl, {

    //incluir bootstrap
    themeSystem: 'bootstrap5',

    //cabeçalho
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay btnCreateClient btnCreateService'
    },
    customButtons: {
      btnCreateClient: {
        text: '+ Cliente',
        click: function () {
          criarClienteModal.show();

        }
      },
      btnCreateService: {
        text: '+ Serviço',
        click: function () {
          criarServiceModal.show();
        }
      }
    },

    locale: 'pt-pt',

    //data inicializada
    initialDate: '2023-12-14',
    //permite clicar nos nomes dos dias da semana
    navLinks: true,
    //permite clicar e arrastar o mouse sobre um ou varios dias
    selectable: true,
    //visualmente a area selecionada
    selectMirror: true,

    //permitir arrastar e redimencionar
    editable: true,
    dayMaxEvents: true,

    //chamar os arquivos php para recuperar os arquivos
    events: 'listarEvent.php',

    //identificar o clique do usuario sobre o evento
    eventClick: function (info) {

      //apresentar detalhes do evento
      document.getElementById("visualizarEvento").style.display = "block";
      document.getElementById("visualizarModalLabel").style.display = "block";

      //ocultar o formulário editar de evento
      document.getElementById("editarEvento").style.display = "none";
      document.getElementById("editarModalLabel").style.display = "none";

      document.getElementById("visualizarTodosClientes").style.display = "none";

      //enviar para a janela do modal os dados do evento
      document.getElementById("visualizarId").innerText = info.event.id;
      // document.getElementById("visualizarTitle").innerText = info.event.title;
      document.getElementById("visualizarObs").innerText = info.event.extendedProps.obs;

      document.getElementById("visualizarUser_id").innerText = info.event.extendedProps.user_id;
      document.getElementById("visualizarServiceName").innerText = info.event.extendedProps.service_name;
      document.getElementById("visualizarName").innerText = info.event.extendedProps.name;
      //document.getElementById("visualizarEmail").innerText = info.event.extendedProps.email;
      //document.getElementById("visualizarTel").innerText = info.event.extendedProps.tel;

      document.getElementById("visualizarClient_id").innerText = info.event.extendedProps.client_id;
      document.getElementById("visualizarNameClient").innerText = info.event.extendedProps.client_name;
      document.getElementById("visualizarEmailClient").innerText = info.event.extendedProps.client_email;
      document.getElementById("visualizarTelClient").innerText = info.event.extendedProps.client_tel;

      document.getElementById("visualizarStart").innerText = info.event.start.toLocaleString();
      document.getElementById("visualizarEnd").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();

      //enviar os dados do evento para o formulário editar
      document.getElementById("editId").value = info.event.id;
      // document.getElementById("editTitle").value = info.event.title;
      document.getElementById("editObs").value = info.event.extendedProps.obs;
      document.getElementById("editStart").value = converterData(info.event.start);
      document.getElementById("editEnd").value = info.event.end !== null ? converterData(info.event.end) : converterData(info.event.start);
      document.getElementById("editColor").value = info.event.backgroundColor;


      //abrir janela modal
      visualizarModal.show();
    },

    //Abrir janela modal registrar quando clicar sobre o dia
    select: async function (info) {

      new Choices(document.getElementById("regColor"));

      //receber o seletor do campo service do formulario registrar
      var regService_id = document.getElementById('regService_id');
      const dadosServices = await fetch('listarServices.php');
      const respostaServices = await dadosServices.json();
      if (respostaServices['status']) {
        new Choices(regService_id).setChoices(respostaServices.dados, 'id', 'name', true);
      } else {
        new Choices(regService_id).setChoices([], 'id', 'name', true);
      }

      //client
      const dadosClient = await fetch('listarClient.php');
      var regClient_id = document.getElementById('regClient_id');
      const respostaClient = await dadosClient.json();
      if (respostaClient['status']) {
      new Choices(regClient_id).setChoices(respostaClient.dados, 'id', 'name', true);

      } else {
      new Choices(regClient_id).setChoices([], 'id', 'name', true);
      }

      //chamar arquivo php responsavel em recuperar os usuários do banco de dados
      const dados = await fetch('listarUser.php');

      //receber o seletor do campo usuario do formulario registrar
      var regUser_id = document.getElementById('regUser_id');

      //ler os dados
      const resposta = await dados.json();
      //console.log(resposta);

      if (resposta['status']) {
        new Choices(regUser_id).setChoices(resposta.dados, 'id', 'name', true);

      } else {

        //enviar a opçao vazia para o campo select no html
        new Choices(regUser_id).setChoices([], 'id', 'name', true);
      }


      //receber seletor da janela modal registrar
      document.getElementById("regStart").value = converterData(info.start);
      document.getElementById("regEnd").value = converterData(info.start);

      //abrir janela modal registrar
      registrarModal.show();
    }

  });


  //renderizar calendario
  calendar.render();


  //converter data
  function converterData(data) {

    const dataObj = new Date(data);

    const ano = dataObj.getFullYear();

    const mes = String(dataObj.getMonth() + 1).padStart(2, '0');

    const dia = String(dataObj.getDate()).padStart(2, '0');

    const hora = String(dataObj.getHours()).padStart(2, '0');

    const minuto = String(dataObj.getMinutes()).padStart(2, '0');

    return `${ano}-${mes}-${dia} ${hora}:${minuto}`;
  }

  const formRegEvento = document.getElementById("formRegEvento");
  const msg = document.getElementById("msg");
  const msgRegEvento = document.getElementById("msgRegEvento");
  const btnRegEvento = document.getElementById("btnRegEvento");

  //somente acessa o if quando existir o seletor "formRegEvento"
  if (formRegEvento) {

    //Aguardar o usuério clicar no botao registrar
    formRegEvento.addEventListener("submit", async (e) => {

      //nao permitir a atualização da pagina
      e.preventDefault();

      //Apresentar o botao de texto
      btnRegEvento.value = "Salvando...";

      //receber os dados do formulario
      const dadosForm = new FormData(formRegEvento);

      //chamar o arquivo php responsavel em salvar o evento
      const dados = await fetch("registrarEvento.php", {
        method: "POST",
        body: dadosForm
      });

      //realizar a leitura dos dados retornados pelo php
      const resposta = await dados.json();

      //acessa o if quando não registrar com sucesso
      if (!resposta['status']) {

        //enviar a mensagem para o html
        msgRegEvento.innerHTML = `<div class="alert alert-danger" role="alert">
          ${resposta['msg']}</div>`;

      } else {

        //enviar a mensagem para o html
        msg.innerHTML = `<div class="alert alert-success" role="alert">
          ${resposta['msg']}</div>`;

        //
        msgRegEvento.innerHTML = "";

        //limpar formulario
        formRegEvento.reset();

        //criar obj com os dados do evento
        const novoEvento = {
          id: resposta['id'],
          title: resposta['title'],
          color: resposta['color'],
          start: resposta['start'],
          end: resposta['end'],
          obs: resposta['obs'],

          regService_id: resposta['service_id'],
          service_name: resposta['service_name'],
          
          client_id: resposta['client_id'],
          client_name: resposta['client_name'],
          client_email: resposta['client_email'],
          client_tel: resposta['client_tel'],
          
          user_id: resposta['user_id'],
          name: resposta['name'],
          email: resposta['email'],
          tel: resposta['tel'],
        }

        //adicionar evento ao calendario
        calendar.addEvent(novoEvento);

        //chamar a funçao para remover a msg apos 3 segundos
        removerMsg();

        //fechar a janela modal
        registrarModal.hide();
      }

      //Apresentar o botao de texto registrar
      btnRegEvento.value = "Registrar";


    });
  }

  //função para remover a mensagem apos 3 segundo
  function removerMsg() {
    setTimeout(() => {
      document.getElementById('msg').innerHTML = "";
    }, 3000)
  }

  const btnViewEditEvento = document.getElementById("btnViewEditEvento");

  //somente acessa o IF quando existir o SELETOR "btnViewEditEvento"
  if (btnViewEditEvento) {

    //aguardar o usuario clicar no botao editar
    btnViewEditEvento.addEventListener("click", async () => {
      //pcultar detalhes do evento
      document.getElementById("visualizarEvento").style.display = "none";
      document.getElementById("visualizarModalLabel").style.display = "none";

      //apresentar o formulário editar de evento
      document.getElementById("editarEvento").style.display = "block";
      document.getElementById("editarModalLabel").style.display = "block";

      //receber o id dos cliente resonsavel pelo evento
      var clientId = document.getElementById('visualizarClient_id').innerText;

      //receber o seletor ndo campo client do formulario editar
      var editClient_id = document.getElementById('editClient_id');
      const dadosClient = await fetch('listarClient.php');
      const respostaClient = await dadosClient.json();
      //console.log(resposta);
      if (respostaClient['status']) {
        new Choices(editClient_id).setChoices(respostaClient.dados, 'id', 'name', true);
        
      } else {
        new Choices(editClient_id).setChoices([], 'id', 'name', true);
      }
      

      //receber o id dos usuario resonsavel pelo evento
      var userId = document.getElementById('visualizarUser_id').innerText;

      var editUser_id = document.getElementById('editUser_id');
      //chamar arquivo php responsavel em recuperar os usuários do banco de dados
      const dados = await fetch('listarUser.php');
      const resposta = await dados.json();
      //console.log(resposta);
      if (resposta['status']) {
        new Choices(editUser_id).setChoices(resposta.dados, 'id', 'name', true);

      } else {
        new Choices(editUser_id).setChoices([], 'id', 'name', true);
      }

      var editService_id = document.getElementById('editService_id');
      const dadosServices = await fetch('listarServices.php');
      const respostaServices = await dadosServices.json();
      if (respostaServices['status']) {
        new Choices(editService_id).setChoices(respostaServices.dados, 'id', 'name', true);
      } else {
        new Choices(editService_id).setChoices([], 'id', 'name', true);
      }

    });
  }

  //receber seletor ocultar formulário editar evento e apresentar o detalhe
  const btnViewEvento = document.getElementById("btnViewEvento");

  //somente acessa o IF quando existir o SELETOR "btnViewEditEvento"
  if (btnViewEvento) {

    //aguardar o usuario clicar no botao editar
    btnViewEvento.addEventListener("click", () => {
      //apresentar detalhes do evento
      document.getElementById("visualizarEvento").style.display = "block";
      document.getElementById("visualizarModalLabel").style.display = "block";

      //ocultar o formulário editar de evento
      document.getElementById("editarEvento").style.display = "none";
      document.getElementById("editarModalLabel").style.display = "none";

    });
  }
  const formEditEvento = document.getElementById("formEditEvento");
  const msgEditEvento = document.getElementById("msgEditEvento");
  const btnEditEvento = document.getElementById("btnEditEvento");

  //somente acessa o if quando existir o seletor "formEditEvento"
  if (formEditEvento) {
    new Choices(document.getElementById("editColor"));

    //Aguardar o usuário clicar no botao editar
    formEditEvento.addEventListener("submit", async (e) => {

      //Nao permetir a apresentação da pagina
      e.preventDefault();

      //Apresentar no boato o trxto salvando
      btnEditEvento.value = "Salvando...";

      //receber os dados do formulário
      const dadosForm = new FormData(formEditEvento);

      //chamar o arquivo em editar o evento
      const dados = await fetch("editarEvento.php", {
        method: "POST",
        body: dadosForm
      });

      //realizar a leitura dos dados retornados pelo php
      const resposta = await dados.json();

      //acessa o if quandonão editar com sucessso
      if (!resposta['status']) {
        //enviar msng para o html
        msgEditEvento.innerHTML = `<div class="alert alert-danger" role="alert">
          ${resposta['msg']}</div>`;
      } else {
        //enviar msng para o html
        msg.innerHTML = `<div class="alert alert-success" role="alert">
          ${resposta['msg']}</div>`;
        //enviar msng para o html
        msgEditEvento.innerHTML = "";

        //limpar o formulario
        formEditEvento.reset();

        //recuperar o evento no fullcadender pelo id
        const eventoExiste = calendar.getEventById(resposta['id']);

        if (eventoExiste) {

          //Atualizar os atributos do evento com os novos valores do banco de dados
          eventoExiste.setProp('title', resposta['title']);
          eventoExiste.setProp('color', resposta['color']);
          eventoExiste.setExtendedProp('obs', resposta['obs']);

          eventoExiste.setExtendedProp('service_id', resposta['service_id']);
          eventoExiste.setExtendedProp('service_name', resposta['service_name']);

          eventoExiste.setExtendedProp('user_id', resposta['user_id']);
          eventoExiste.setExtendedProp('name', resposta['name']);
          eventoExiste.setExtendedProp('email', resposta['email']);
          eventoExiste.setExtendedProp('tel', resposta['tel']);

          eventoExiste.setExtendedProp('client_id', resposta['client_id']);
          eventoExiste.setExtendedProp('client_name', resposta['client_name']);
          eventoExiste.setExtendedProp('client_email', resposta['client_email']);
          eventoExiste.setExtendedProp('client_tel', resposta['client_tel']);
          
          eventoExiste.setStart(resposta['start']);
          eventoExiste.setEnd(resposta['end']);

        }

        //Chamar a função para remover apos 3 segundos
        removerMsg();

        //fechar a janela modal
        visualizarModal.hide();
      }

      //apresentar no botao o texto salvar
      btnEditEvento.value = "Salvar";
    });
  }

  //receber o seletor apagar evento
  const btnApagarEvento = document.getElementById("btnApagarEvento");

  //somente acessa o if quando existir o seletor "btnApagarEvento"
  if (btnApagarEvento) {

    //Aguardar o usuário clicar no botão apagar
    btnApagarEvento.addEventListener("click", async () => {

      //exibir uma caixa de dialogo de confirmaçao
      const confirmacao = window.confirm("Tem a certeza de que deseja apagar este evento?");

      if (confirmacao) {
        //receber o id do evento
        var idEvento = document.getElementById("visualizarId").textContent;

        //chamar o arquivo php responsavel apagar evento
        const dados = await fetch("apagarEvento.php?id=" + idEvento);

        //realizar a leitura dos dados retornados pelo php
        const resposta = await dados.json();

        //acessa o if quando não registrar com sucesso
        if (!resposta['status']) {

          //Enviar mensagem para o html
          msgViewEvento.innerHTML = `<div class="alert alert-danger" role="alert">
            ${resposta['msg']}</div>`;
        } else {
          //Enviar mensagem para o html
          msg.innerHTML = `<div class="alert alert-success" role="alert">
             ${resposta['msg']}</div>`;

          //Enviar mensagem para o html
          msgViewEvento.innerHTML = "";

          //Recuperar o evento no fullcalender
          const eventoExisteRemover = calendar.getEventById(idEvento);

          //Verificar se encontrou o evento no fullcalender
          if (eventoExisteRemover) {

            //remover o evento do calendario
            eventoExisteRemover.remove();
          }

          //chamar função para remover a mensagem apos 3 segundos
          removerMsg();

          //fechar janela modal
          visualizarModal.hide();
        }
      }

    });
  }

  //receber o seletor do botao da janela modal criar cliente

  const btnCriarCliente = document.getElementById("btnCriarCliente");
  const formCriarCliente = document.getElementById("formCriarCliente");

  //somente acessa o if quando existir o seletor "formRegEvento"
  if (formCriarCliente) {

    //Aguardar o usuério clicar no botao registrar
    formCriarCliente.addEventListener("submit", async (e) => {

      //nao permitir a atualização da pagina
      e.preventDefault();

      //Apresentar o botao de texto
      btnCriarCliente.value = "Salvando...";

      //receber os dados do formulario
      const dadosForm = new FormData(formCriarCliente);

      //chamar o arquivo php responsavel em salvar o evento
      const dados = await fetch("criarCliente.php", {
        method: "POST",
        body: dadosForm
      });

      //realizar a leitura dos dados retornados pelo php
      const resposta = await dados.json();

      //acessa o if quando não registrar com sucesso
      if (!resposta['status']) {

        Swal.fire("ERRO", resposta.msg, "error");

      } else {

        //enviar a mensagem para o html
        Swal.fire("SUCESSO", resposta.msg, "success");

        //limpar formulario
        formCriarCliente.reset();
        //fechar a janela modal
        criarClienteModal.hide();
      }

      //Apresentar o botao de texto registrar
      btnCriarCliente.value = "Registrar";


    });
  }

  //criar serviço
  const btnCriarService = document.getElementById("btnCriarService");
  const formCriarService = document.getElementById("formCriarService");

  //somente acessa o if quando existir o seletor "formCriarService"
  if (formCriarService) {

    //Aguardar o usuério clicar no botao registrar
    formCriarService.addEventListener("submit", async (e) => {

      //nao permitir a atualização da pagina
      e.preventDefault();

      //Apresentar o botao de texto
      btnCriarService.value = "Salvando...";

      //receber os dados do formulario
      const dadosForm = new FormData(formCriarService);

      //chamar o arquivo php responsavel em salvar o evento
      const dados = await fetch("criarService.php", {
        method: "POST",
        body: dadosForm
      });

      //realizar a leitura dos dados retornados pelo php
      const resposta = await dados.json();

      //acessa o if quando não registrar com sucesso
      if (!resposta['status']) {

        Swal.fire("ERRO", resposta.msg, "error");

      } else {

        //enviar a mensagem para o html
        Swal.fire("SUCESSO", resposta.msg, "success");

        //limpar formulario
        formCriarService.reset();



        //fechar a janela modal
        criarServiceModal.hide();
      }

      //Apresentar o botao de texto registrar
      btnCriarService.value = "Registrar";


    });
  }


  const btnVisualizarTodosClientes = document.getElementById("btnVisualizarTodosClientes");

  //somente acessa o IF quando existir o SELETOR "btnVisualizarTodosClientes"
  if (btnVisualizarTodosClientes) {

    //aguardar o usuario clicar no botao visualizarTodosClientes
    btnVisualizarTodosClientes.addEventListener("click", async () => {
      exibirModal("visualizarTodosClientes");

      // gerar tabela lista de clientes
      let tabela = '';

      /*/chamar o arquivo php responsavel em salvar o evento
const usuarios = await fetch("listarUsuarios.php", {
  method: "GET",
});
debugger;*/

      try {
        const response = await fetch("listarClient.php", {
          method: "GET",
        });

        if (!response.ok) {
          throw new Error(`Erro ao obter os dados: ${response.statusText}`);
        }

        const usuarios = await response.json();


        for (const client of usuarios.dados) {
          tabela += `<dt class="col-sm-3">Id: </dt>
        <dd class="col-sm-9">${client.id}</dd>
  
        <dt class="col-sm-3">Nome: </dt>
        <dd class="col-sm-9" >${client.name}</dd>
  
        <dt class="col-sm-3">Telemóvel: </dt>
        <dd class="col-sm-9">${client.tel}</dd>
  
        <!--<button type="button" class="btn btn-small btn-warning" id="btnVerDetalhes">Ver Detalhes</button>-->
        <a href="#" class="verDetalheLink" data-client-id="${client.id}"  data-client-name="${client.name}" >Ver Detalhes</a>
        <hr>
        `;
        }

        document.getElementById("todosClientesTable").innerHTML = tabela;


        visualizarModal.show();
        criarClienteModal.hide();

        // Adicionar evento de clique aos links "Ver Detalhes"
        const detalheLinks = document.querySelectorAll(".verDetalheLink");
        detalheLinks.forEach(link => {
          link.addEventListener('click', (event) => {
            event.preventDefault();
            const clientId = event.target.dataset.clientId;
            const clientName = event.target.dataset.clientName;
            exibirDetalhesDoUsuario(clientId, clientName);
          });
        });

      } catch (error) {
        console.error("Erro:", error);
      }
    });

  }

  const verDetalheCliente = document.getElementById("verDetalheCliente");

  // Função para exibir detalhes do usuário ao clicar no link "Ver Detalhes"
  async function exibirDetalhesDoUsuario(clientId, clientName) {

    const response = await fetch(`listarEvent.php?client_id=${clientId}`, {
      method: "GET",
    });
    console.log(clientId);

    if (!response.ok) {
      throw new Error(`Erro ao obter os detalhes do usuário: ${response.statusText}`);
    }

    const detalhesUsuario = await response.json();

    //  manipular os detalhes do usuário e exibi-los na interface
    //console.log('Detalhes do Usuário:', detalhesUsuario);

    var listaDetalhesCliente = `<dl class="row">
    <div class="d-flex gap-2 mb-3">
    <button type="button" class="btn btn-secundary" id="btnVoltar">
    <i class="bi bi-arrow-left-square" style="font-size: 25px; color: #a7a6a6; " ></i>
    </button>
    </div>

    <dt class="col-sm-3">Id: </dt>
    <dd class="col-sm-9">${clientId}</dd>

    <dt class="col-sm-3">Nome: </dt>
    <dd class="col-sm-9" >${clientName}</dd>
    </dl>
    `;
    for (const event of detalhesUsuario) {
      listaDetalhesCliente += `
      <div class="evento">
      
      <dl class="row">
          

          <dt class="col-sm-3">ID: </dt>
          <dd class="col-sm-9">${event.id}</dd>

          <dt class="col-sm-3">Serviço: </dt>
          <dd class="col-sm-9">${event.service_name}</dd>

          <dt class="col-sm-3">Observação: </dt>
          <dd class="col-sm-9">${event.obs}</dd>

          <dt class="col-sm-3">Inicio: </dt>
          <dd class="col-sm-9">${event.start}</dd>

          <dt class="col-sm-3">Fim: </dt>
          <dd class="col-sm-9">${event.end}</dd>

      </dl>
      

      <!--<button type="button" class="btn btn-warning" id="btnViewEditEvento">Editar</button>-->

      <button type="button" class="btn btn-danger btnApagarEvento" data-event-id=${event.id}>Apagar</button>
      </div>
      <hr>
      `;
    }
    verDetalheCliente.innerHTML = listaDetalhesCliente;
    exibirModal("verDetalheCliente");

    //btnVoltar
    const btnVoltar = document.getElementById("btnVoltar");

    if (btnVoltar) {
      btnVoltar.addEventListener("click", () => {
        //apresentar detalhes do evento
        document.getElementById("visualizarTodosClientes").style.display = "block";

        document.getElementById("editarEvento").style.display = "none";
        document.getElementById("verDetalheCliente").style.display = "none";
        document.getElementById("visualizarEvento").style.display = "none";

      });
    }

    //btnApagarTodosClientes
    const btnsApagarEvento = document.querySelectorAll(".btnApagarEvento");
    btnsApagarEvento.forEach(btn => (
      btn.addEventListener("click", async () => {
        const idEvento = btn.getAttribute('data-event-id');
        const confirmacao = window.confirm("Tem a certeza de que deseja apagar este evento?");

        if (confirmacao) {
          // Remover o evento do calendário, se existir
          const eventoExisteRemover = calendar.getEventById(idEvento);
          if (eventoExisteRemover) {
            eventoExisteRemover.remove();
          }

          // Enviar solicitação para apagar o evento no banco de dados
          const dados = await fetch("apagarEvento.php?id=" + idEvento);
          const resposta = await dados.json();

          if (!resposta.status) {
            console.error("Erro ao apagar evento:", resposta.msg);
            // Exibir mensagem de erro, se necessário
          } else {
            msg.innerHTML = `<div class="alert alert-success" role="alert">
             ${resposta['msg']}</div>`;

          //Enviar mensagem para o html
          msgViewEvento.innerHTML = "";

          //Recuperar o evento no fullcalender
          const eventoExisteRemover = calendar.getEventById(idEvento);

          //Verificar se encontrou o evento no fullcalender
          if (eventoExisteRemover) {

            //remover o evento do calendario
            eventoExisteRemover.remove();
          }

          //chamar função para remover a mensagem apos 3 segundos
          removerMsg();

          //visualizarModal.hide();
          window.location.reload();
        }
        }

      })
      
    ));
  }








});