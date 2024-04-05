<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turmaCod = mysqli_real_escape_string($conn, $_POST['turma']);
    $moduloId = mysqli_real_escape_string($conn, $_POST['modulo']);
    $dataAula = mysqli_real_escape_string($conn, $_POST['dataAula']);

    // Primeiro, verifica se já existe aula naquele dia e módulo
    $sql = "SELECT COUNT(*) AS total FROM aula 
            WHERE cod_turma = '$turmaCod' 
            AND id_modulo = '$moduloId' 
            AND data_aula = '$dataAula'";
    $resultado = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($resultado);

    if ($row['total'] > 0) {
        echo "existente"; // Aula já existe
        exit;
    }

    // Agora, verifica se o dia da semana da aula está de acordo com os dias permitidos para a turma
    $sqlTurmaDias = "SELECT turma_dias FROM turma WHERE turma_cod = '$turmaCod'";
    $resultadoTurmaDias = mysqli_query($conn, $sqlTurmaDias);
    $rowTurmaDias = mysqli_fetch_assoc($resultadoTurmaDias);

    if ($rowTurmaDias) {
        $turmaDias = str_split($rowTurmaDias['turma_dias']); // Transforma em array
        $diaSemanaAula = date('N', strtotime($dataAula)); // 'N' retorna o dia da semana (1 para Segunda, 7 para Domingo)

        if (!in_array($diaSemanaAula, $turmaDias)) {
            echo "dia_incorreto"; // Dia da semana não permitido para a turma
            exit;
        }
    }

    echo "inexistente"; // Tudo certo, pode prosseguir
}
?>
