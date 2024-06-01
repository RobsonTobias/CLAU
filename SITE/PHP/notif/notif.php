<?php

if (!function_exists('MostrarMensagem')) {
    function MostrarMensagem() {
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
                echo "Nenhuma notificação encontrada.";
                return [];
            }
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
            return [];
        }
    }
}


$listar2 = MostrarMensagem();
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
        echo "<div class='dropdown-item'>$descricao<div class='btn'><i class='bi bi-eye-fill ativo-$lida' data-id='$id' data-lida='$lida_value'></i></div><hr></div>";
    }
}
?>