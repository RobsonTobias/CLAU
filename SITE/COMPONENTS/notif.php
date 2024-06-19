<style>
    .bi.bi-eye-fill.ativo-TRUE {
        color: rgb(103, 184, 234);
    }

    .bi.bi-eye-fill.ativo-FALSE {
        color: rgb(149, 149, 149);
    }

    .bi.bi-bell-fill,
    .btn.btn-link.dropdown-toggle {
        color: #043140;
        margin: 5px;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

<script>
    $(document).on("click", ".dropleft", function (e) {
        e.stopPropagation();
    });

    $(document).on("click", ".bi-eye-fill", function () {
        var id = $(this).data("id");
        var lida = $(this).data("lida");

        $.post("../PHP/atualizar.php", { id: id, lida: lida })
            .done(function (response) {
                console.log(response);
            })
            .fail(function (xhr, status, error) {
                console.error("Erro na solicitação AJAX:", error);
            });
    });

    $(document).on("click", ".bi-eye-fill", function () {
        $(this).removeClass("ativo-FALSE");
        $(this).addClass("ativo-TRUE");
    });

    function recarregarConteudo() {
        // Faz uma solicitação AJAX para obter o novo conteúdo da página
        $.ajax({
            url: window.location.href, // URL atual da página
            type: 'GET',
            success: function (response) {
                // Atualiza apenas o conteúdo da seção desejada com a resposta
                $('#recar').html($(response).find('#recar').html());
            },
            error: function (xhr, status, error) {
                console.error("Erro na solicitação AJAX:", error);
            }
        });
    }

    setInterval(recarregarConteudo, 60000);

    // Evento que ocorre quando a página termina de carregar
    $(document).ready(function () {
        // Remove os parâmetros de consulta da URL
        var novaURL = window.location.href.split('?')[0];
        // Atualiza a URL sem os parâmetros de consulta
        window.history.replaceState({}, document.title, novaURL);
    });

</script>
<?php
include_once '../conexao.php';
if (!function_exists('MostrarMensagem')) {
    function MostrarMensagem()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['Usuario_id'])) {
            echo "Usuário não autenticado.";
            return [];
        }

        $userMenseger = $_SESSION['Usuario_id'];
        global $conn;

        $sqlMenseger = 'SELECT n.id_notificacao, n.descricao, n.lida
                        FROM notificacao n
                        INNER JOIN Usuario u ON n.Usuario_id = u.Usuario_id
                        WHERE u.Usuario_id = ?';

        if ($stmt = $conn->prepare($sqlMenseger)) {
            $stmt->bind_param('i', $userMenseger);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $notifications = array();
                while ($row = $result->fetch_assoc()) {
                    $notifications[] = $row;
                }
                $stmt->close();
                return $notifications;
            } else {
                return [];
            }
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
            return [];
        }
    }
}


$listar2 = MostrarMensagem();
?>
<div id="recar" class="dropleft">
    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-bell-fill"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <h3 class="text-center">Notificações</h3>
        <hr class="text-center">
        <?php
        if (empty($listar2)) {
            echo '<div class="dropdown-item">Sem nada aqui</div>';
        } else {
            foreach ($listar2 as $l) {
                $id = $l['id_notificacao'];
                $descricao = htmlspecialchars($l['descricao']);
                $lida = htmlspecialchars($l['lida']);

                // Converte o valor booleano para string 'true' ou 'false'
                $lida_value = $lida ? 'true' : 'false';

                // Gera o elemento <i> com os atributos data-id e data-lida
                echo "<div class='dropdown-item d-flex justify-content-between align-items-center'>$descricao<div class='btn'><i class='bi bi-eye-fill ativo-$lida' data-id='$id' data-lida='$lida_value'></i></div></div>";
            }
        }
        ?>

    </div>
</div>