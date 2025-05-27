// Listar Laudo Info
function listar() {
  console.log("Hello World");
  // Loader enquanto Aguarda  o Status da Requisição com AJax
  Swal.fire({
    title: "Carregando...",
    didOpen: () => {
      Swal.showLoading();
    },
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
  });
  // Inicio Requisição HTTP GET
  $.ajax({
    url: "api/lista.php",
    method: "GET",
    dataType: "json", // Json Especify
    success: function (data) {
      Swal.close(); // Status 200 -> Close Loader
      Swal.fire("Pronto!", "Dados carregados com sucesso!!", "success"); // Notifica Status e Exibe Mensagem
      if (!Array.isArray(data)) {
        console.error("Resposta não é um array:", data);
        return;
      }

      $("#data-table").empty(); // Limpa a tabela antes de popular

      data.forEach(function (item) {
        // Cria um For Each e Incrementa com Dados do DB
        $("#data-table").append(`
          <tr>
            <td>${item.pacienteId}</td>
            <td>${item.nome_cliente}</td>
            <td>${item.nome_procedimento}</td>
            <td>${item.nome_medico}</td>
          </tr>
        `);
      });
    },
    error: function (err) {
      console.error("Erro na requisição AJAX:", err); // Error Message Status != 200
    },
  });
}

console.log(":)");

// Inicio Função Pesquisar Detalhes Paciente
function pesquisarUser() {
  const idBusca = $("#idBusca").val().trim(); // Captura Input pelo ID

  // Validação se Input == ''
  if (!idBusca) {
    Swal.fire({
      icon: "info",
      title: "Codigo Invalido",
      text: "Digite um Codigo Numerico para Consultar Laudos.",
    });

    return; // Retorna e Exibe Mensagem com Instruções pra Busca
  }

  // Inicia Requisição HTTP
  $.ajax({
    url: "api/selectbyid.php", // Consulta tendo como Base IdPaciente
    method: "GET",
    data: { pacienteId: idBusca },
    dataType: "json", // Json SPecify
    success: function (data) {
      const $tableBody = $("#modalPesquisarLaudos tbody"); // Captura Table para Manipular de Forma Dinamica
      $tableBody.empty(); // Clean
      Swal.close();
      Swal.fire("Pronto!", " Requisição efetuada com Sucesso !", "success"); // Notifica User Status Requisição

      if (Array.isArray(data) && data.length > 0) {
        data.forEach(function (item) {
          $tableBody.append(`
            <tr>
              <td>${item.idLaudo}</td>               
              <td>${item.pacienteId}</td>  
              <td>${item.nome_cliente}</td>
              <td>${item.nome_procedimento}</td>
              <td>${item.nome_medico}</td>
             <td><button class="btn btn-success" onclick="editarLaudo(${item.idLaudo})">Editar</button></td>         
              <td><button class="btn btn-danger " onclick="editarLaudo(${item.idLaudo})">Remover</button></td>
            </tr>
          `);
        });
      } else {
        $tableBody.append(
          `<tr><td colspan="6" class="text-center">Nenhum laudo encontrado</td></tr>` // Caso Não encontre o Dados
        );
      }
    },
    error: function (err) {
      console.error("Erro ao buscar laudos:", err);
    },
  });
}
function editarLaudo(id_laudo) {
  Swal.fire({
    title: "Aguarde...",
    didOpen: () => {
      Swal.showLoading();
    },
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
  });
  $.ajax({
    url: "api/selectLaudoById.php",
    type: "GET",
    data: { id: id_laudo },
    dataType: "json",
    success: function (laudo) {
      Swal.close(); // Fecha o loader quando der certo
      if (laudo.error) {
        alert("Erro: " + laudo.error);
        return;
      }

      $("#id_laudo").val(laudo.idLaudo); // Certifique que o PHP retorna 'idLaudo'
      $("#id_cliente").val(laudo.pacienteId);
      $("#nome").val(laudo.nome_cliente);
      $("#procedimento").val(laudo.nome_procedimento);
      $("#medico").val(laudo.nome_medico);

      $("#modalPesquisarLaudos").modal("hide"); // Fecha o modal
    },
    error: function (xhr) {
      Swal.fire({
        icon: "info",
        title: "Ops!",
        text: "Estamos trabalhando nisso!",
      });
    },
  });
}

function salvarLaudo() {
  const id_laudo = $("#id_laudo").val();
  const id_cliente = $("#id_cliente").val();
  const nome_cliente = $("#nome").val().trim();
  const nome_procedimento = $("#procedimento").val().trim();
  const nome_medico = $("#medico").val().trim();

  if (!nome_cliente || !nome_procedimento || !nome_medico) {
    Swal.fire("Atenção!", "Preencha todos os campos!", "warning");
    return;
  }

  $.ajax({
    //url: "api/updateLaudo.php",
    type: "POST",
    dataType: "json",
    data: {
      id_laudo: id_laudo,
      id_cliente: id_cliente,
      nome_cliente: nome_cliente,
      nome_procedimento: nome_procedimento,
      nome_medico: nome_medico,
    },
    success: function (response) {
      alert("Laudo atualizado com sucesso!");
      $("#formCadastroLaudo")[0].reset();
    },
    error: function (xhr) {
      Swal.fire("Ops!", "Estamos trabalhando nisso!");
    },
  });
}

function newUser() {
  document.getElementById("formCadastroLaudo").reset();

  Swal.fire("Pronto!", "Formulario Limpo com Sucesso ", "success");
}

/*
$.ajax({
  url: "api/criar_laudo.php",
  type: "POST",
  data: {
    nome_cliente: "João da Silva",
    nome_procedimento: "Ultrassonografia",
    nome_medico: "Dr. Carlos Souza",
  },
  dataType: "json",
  success: function (response) {
    if (response.success) {
      Swal.fire("Sucesso!", response.message, "success");
    } else {
      Swal.fire("Erro!", response.error, "error");
    }
  },
});*/
