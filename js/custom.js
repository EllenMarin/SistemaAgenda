//executar quando o documento html for carregado completamente
document.addEventListener('DOMContentLoaded', function() {

    //receber o seletor calender do atributo id
    var calendarEl = document.getElementById('calendar');

    //receber seletor da janela modal
    const registrarModal = new bootstrap.Modal(document.getElementById("registrarModal"));

    //receber o SELETOR da janela modal 
    const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

    //receber o seletor msgViewEvento
    const msgViewEvento = document.getElementById('msgViewEvento');


    //instanciar fullcalender e atribuir a variavel calender
    var calendar = new FullCalendar.Calendar(calendarEl, {

        //incluir bootstrap
        themeSystem: 'bootstrap5',

        //cabeçalho
        headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
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

      /*pop up para adcionar evento na agenda
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        if (confirm('Are you sure you want to delete this event?')) {
          arg.event.remove()
        }
      },*/

      //permitir arrastar e redimencionar
      editable: true,
      dayMaxEvents: true, 
      
      //chamar os arquivos php para recuperar os arquivos
      events: 'listarEvent.php',

      //identificar o clique do usuario sobre o evento
      eventClick: function(info){

        //apresentar detalhes do evento
        document.getElementById("visualizarEvento").style.display = "block";
        document.getElementById("visualizarModalLabel").style.display = "block"; 
        
        //ocultar o formulário editar de evento
        document.getElementById("editarEvento").style.display = "none";
        document.getElementById("editarModalLabel").style.display = "none"; 
        
        //enviar para a janela do modal os dados do evento
        document.getElementById("visualizarId").innerText = info.event.id;
        document.getElementById("visualizarTitle").innerText = info.event.title;
        document.getElementById("visualizarServices").innerText = info.event.extendedProps.services;

        document.getElementById("visualizarUser_id").innerText = info.event.extendedProps.user_id;
        document.getElementById("visualizarName").innerText = info.event.extendedProps.name;
        document.getElementById("visualizarEmail").innerText = info.event.extendedProps.email;
        document.getElementById("visualizarTel").innerText = info.event.extendedProps.tel;

        document.getElementById("visualizarStart").innerText = info.event.start.toLocaleString();
        document.getElementById("visualizarEnd").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();

        //enviar os dados do evento para o formulário editar
        document.getElementById("editId").value = info.event.id;
        document.getElementById("editTitle").value = info.event.title;
        document.getElementById("editServices").value = info.event.extendedProps.services;
        document.getElementById("editStart").value = converterData(info.event.start);
        document.getElementById("editEnd").value = info.event.end !== null ? converterData(info.event.end) : converterData(info.event.start);
        document.getElementById("editColor").value = info.event.backgroundColor;
        console.log(info.event);

        //abrir janela modal
        visualizarModal.show();
      },
      //Abrir janela modal registrar quando clicar sobre o dia
      select: async function(info){

        //receber o seletor ndo campo usuario do formulario registrar
        var regUser_id = document.getElementById('regUser_id');

        //chamar arquivo php responsavel em recuperar os usuários do banco de dados
        const dados = await fetch('listarUsuarios.php');

        //ler os dados
        const resposta = await dados.json();
        //console.log(resposta);

        if(resposta['status']){
          //crie a opçao selecione para o campo select usuarios
          var opcoes = '<option value="">Selecione</option>';

          for(var i = 0; i < resposta.dados.length; i++) {
          //percorrer a lista de opçoes para o campo select usuários
          opcoes += `<option value="${resposta.dados[i]['id']}">${resposta.dados[i]['name']}</option>`;
          }

          //enviar as opçoes para o campo select no html
          regUser_id.innerHTML = opcoes;
        
        }else{

          //enviar a opçao vazia para o campo select no html
          regUser_id.innerHTML = `<option value=''>${resposta['msg']}</option>`;
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
    function converterData(data){

      const dataObj = new Date(data);

      const ano = dataObj.getFullYear();

      const mes = String(dataObj.getMonth() + 1).padStart(2, '0');

      const dia = String(dataObj.getDate()).padStart(2, '0');

      const hora = String(dataObj.getHours()).padStart(2, '0');

      const minuto = String(dataObj.getMinutes()).padStart(2, '0');

      return `${ano}-${mes}-${dia} ${hora}:${minuto}`;
    }

    //receber o seletor do formulério registrar evento
    const formRegEvento = document.getElementById("formRegEvento");

    //receber o seletor da mensagem generica
    const msg = document.getElementById("msg");

    //receber o seletor da mensagem registarr evento
    const msgRegEvento = document.getElementById("msgRegEvento");

    //receber o seletor do botao da janela modal evento
    const btnRegEvento = document.getElementById("btnRegEvento");

    //somente acessa o if quando existir o seletor "formRegEvento"
    if(formRegEvento){

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
        if(!resposta['status']){

          //enviar a mensagem para o html
          msgRegEvento.innerHTML = `<div class="alert alert-danger" role="alert">
          ${resposta['msg']}</div>`; 
        
        }else {

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
            services: resposta['services'],
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
    function removerMsg(){
      setTimeout(() => {
        document.getElementById('msg').innerHTML = "";
      }, 3000)
    }

    //receber seletor ocultar detalhes do evento e apresentar o formulário
    const btnViewEditEvento = document.getElementById("btnViewEditEvento");

    //somente acessa o IF quando existir o SELETOR "btnViewEditEvento"
    if(btnViewEditEvento){

      //aguardar o usuario clicar no botao editar
      btnViewEditEvento.addEventListener("click", async () => {
        //pcultar detalhes do evento
        document.getElementById("visualizarEvento").style.display = "none";
        document.getElementById("visualizarModalLabel").style.display = "none"; 
        
        //apresentar o formulário editar de evento
        document.getElementById("editarEvento").style.display = "block";
        document.getElementById("editarModalLabel").style.display = "block"; 

        //receber o id dos usuario resonsavel pelo evento
        var userId = document.getElementById('visualizarUser_id').innerText;

        //receber o seletor ndo campo usuario do formulario editar
        var editUser_id = document.getElementById('editUser_id');

        //chamar arquivo php responsavel em recuperar os usuários do banco de dados
        const dados = await fetch('listarUsuarios.php');

        //ler os dados
        const resposta = await dados.json();
        //console.log(resposta);

        if(resposta['status']){
          //crie a opçao selecione para o campo select usuarios
          var opcoes = '<option value="">Selecione</option>';

          for(var i = 0; i < resposta.dados.length; i++) {

          //percorrer a lista de opçoes para o campo select usuários
          opcoes += `<option value="${resposta.dados[i]['id']}" ${userId == resposta.dados[i]['id'] ? 'selected' : ""}> ${resposta.dados[i]['name']}</option>`;
          }

          //enviar as opçoes para o campo select no html
          editUser_id.innerHTML = opcoes;
        
        }else{

          //enviar a opçao vazia para o campo select no html
          editUser_id.innerHTML = `<option value=''>${resposta['msg']}</option>`;
        }
        
      });
    }

   //receber seletor ocultar formulário editar evento e apresentar o detalhe
    const btnViewEvento = document.getElementById("btnViewEvento");

    //somente acessa o IF quando existir o SELETOR "btnViewEditEvento"
    if(btnViewEvento){

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

    //receber o seletor do formulario editar evento
    const formEditEvento = document.getElementById("formEditEvento");

    //receber o seletor da mensagem editar evento
    const msgEditEvento = document.getElementById("msgEditEvento");

    //receber o seletor do botao editar evento
    const btnEditEvento = document.getElementById("btnEditEvento");

    //somente acessa o if quando existir o seletor "formEditEvento"
    if(formEditEvento) {

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
        if(!resposta['status']){
          //enviar msng para o html
          msgEditEvento.innerHTML = `<div class="alert alert-danger" role="alert">
          ${resposta['msg']}</div>`;
        }else {
          //enviar msng para o html
          msg.innerHTML = `<div class="alert alert-success" role="alert">
          ${resposta['msg']}</div>`;
          //enviar msng para o html
          msgEditEvento.innerHTML = "";

          //limpar o formulario
          formEditEvento.reset();

          //recuperar o evento no fullcadender pelo id
          const eventoExiste = calendar.getEventById(resposta['id']);

          if(eventoExiste){

            //Atualizar os atributos do evento com os novos valores do banco de dados
            eventoExiste.setProp('title', resposta['title']);
            eventoExiste.setProp('color', resposta['color']);
            eventoExiste.setExtendedProp('services', resposta['services']);
            eventoExiste.setExtendedProp('user_id', resposta['user_id']);
            eventoExiste.setExtendedProp('name', resposta['name']);
            eventoExiste.setExtendedProp('email', resposta['email']);
            eventoExiste.setExtendedProp('tel', resposta['tel']);
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

    //somente acessa o if quando existir o seletor "formEditEvento"
    if(btnApagarEvento){

      //Aguardar o usuário clicar no botão apagar
      btnApagarEvento.addEventListener("click", async () => {

        //exibir uma caixa de dialogo de confirmaçao
        const confirmacao = window.confirm("Tem a certeza de que deseja apagar este evento?");

        if(confirmacao){
          //receber o id do evento
          var idEvento  = document.getElementById("visualizarId").textContent;

          //chamar o arquivo php responsavel apagar evento
          const dados = await fetch("apagarEvento.php?id=" + idEvento);

          //realizar a leitura dos dados retornados pelo php
          const resposta = await dados.json();

          //acessa o if quando não registrar com sucesso
          if(!resposta['status']){

            //Enviar mensagem para o html
            msgViewEvento.innerHTML = `<div class="alert alert-danger" role="alert">
            ${resposta['msg']}</div>`;
          }else{
             //Enviar mensagem para o html
             msg.innerHTML = `<div class="alert alert-success" role="alert">
             ${resposta['msg']}</div>`;

              //Enviar mensagem para o html
            msgViewEvento.innerHTML = "";

            //Recuperar o evento no fullcalender
            const eventoExisteRemover = calendar.getEventById(idEvento);

            //Verificar se encontrou o evento no fullcalender
            if(eventoExisteRemover){

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

    
  });