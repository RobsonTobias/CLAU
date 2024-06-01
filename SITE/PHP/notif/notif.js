$(document).on("click", ".dropleft", function(e) {
    e.stopPropagation();
  });
  
$(document).on("click", ".bi-eye-fill", function() {
    var id = $(this).data("id");
    var lida = $(this).data("lida");
  
$.post("../PHP/notif/atualizar.php", { id: id, lida: lida })
      .done(function(response) {
        console.log(response);
})
      .fail(function(xhr, status, error) {
        console.error("Erro na solicitação AJAX:", error);
      });
});

$(document).on("click", ".bi-eye-fill", function() {
    $(this).removeClass("ativo-FALSE");
    $(this).addClass("ativo-TRUE");
});

function recarregarConteudo() {
    // Faz uma solicitação AJAX para obter o novo conteúdo da página
    $.ajax({
        url: window.location.href, // URL atual da página
        type: 'GET',
        success: function(response) {
            // Atualiza apenas o conteúdo da seção desejada com a resposta
            $('#recar').html($(response).find('#recar').html());
        },
        error: function(xhr, status, error) {
            console.error("Erro na solicitação AJAX:", error);
        }
    });
}

setInterval(recarregarConteudo, 60000); 

// Evento que ocorre quando a página termina de carregar
$(document).ready(function() {
    // Remove os parâmetros de consulta da URL
    var novaURL = window.location.href.split('?')[0];
    // Atualiza a URL sem os parâmetros de consulta
    window.history.replaceState({}, document.title, novaURL);
});

