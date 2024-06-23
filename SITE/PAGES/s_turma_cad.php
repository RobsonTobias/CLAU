<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$titulo = 'CADASTRO DE TURMAS'; //Título da página, que fica sobre a data
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLAU - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="../PHP/sidebar/menu.css">
    <link rel="stylesheet" href="../STYLE/botao.css" />
    <link rel="stylesheet" href="../STYLE/data.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">

    <style>
        @media (max-width: 300px) {
            .card-body {
                padding: 0;
            }
        }

        @media (max-width: 1000px) {
            .card {
                margin-left: 80px;
            }
        }

        main {
            padding: 0;
        }

        input[type=text],
        input[type=number],
        input[type=time],
        input[type=date],
        select,
        textarea {
            background-color: #949494;
            color: white;
        }

        input[type=text]:focus,
        input[type=number]:focus,
        input[type=time]:focus,
        input[type=date]:focus,
        select:focus,
        textarea:focus {
            background-color: #949494;
            color: white;
            border: black;
            box-shadow: none;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .card {
            padding: 0;
            background: #E7E7E7;
        }

        .rounded-pill {
            border-radius: 50px !important;
        }

        #Turma_Cod {
            background-color: #949494;
            color: white;
        }
    </style>

</head>

<body>



    <?php require_once '../COMPONENTS/header.php' ?>


    <main class="container-fluid mt-4">
        <div class="card col-sm-12">
            <div class="card-header">
                <h2 class="text-center">Cadastro de Turmas</h2>
            </div>
            <div class="card-body">
                <form action="../PHP/cad_turma.php" method="post" id="formDias">
                    <div class="form-group">
                        <label for="Turma_Cod">Código da Turma:</label>
                        <input type="text" class="form-control rounded-pill" id="Turma_Cod" name="Turma_Cod" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="Curso_id">Curso</label>
                        <select class="form-control rounded-pill" id="Curso_id" name="Curso_id" onchange="atualizarCodigoTurma()">
                            <?php
                            include '../conexao.php';

                            if ($conn->connect_error) {
                                die("Conexão falhou: " . $conn->connect_error);
                            }

                            $sql = "SELECT Curso_id, Curso_Nome, Curso_Sigla FROM Curso";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Curso_Sigla"] . "'>" . $row["Curso_Nome"] . "</option>";
                                }
                            } else {
                                echo "<option>Nenhum curso encontrado</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group d-flex flex-wrap">
                        <div class="form-group">
                            <label for="Turma_Horario_inicio">Horário de início:</label>
                            <input type="time" class="form-control rounded-pill" min="08:00" max="18:00" id="Turma_Horario_inicio" name="Turma_Horario_inicio" required>
                        </div>

                        <div class="form-group pl-2">
                            <label for="Turma_Horario_termino">Horário de término:</label>
                            <input type="time" class="form-control rounded-pill" min="10:00" max="20:00" id="Turma_Horario_termino" name="Turma_Horario_termino" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Turma_Vagas">Vagas:</label>
                        <input type="number" class="form-control rounded-pill" id="Turma_Vagas" name="Turma_Vagas" required>
                    </div>

                    <div class="form-group d-flex flex-wrap">
                        <label for="Turma_Dias">Dias:</label><br>
                        <?php
                        $dias_semana = array(
                            1 => 'Segunda-feira',
                            2 => 'Terça-feira',
                            3 => 'Quarta-feira',
                            4 => 'Quinta-feira',
                            5 => 'Sexta-feira',
                            6 => 'Sábado'
                        );

                        foreach ($dias_semana as $id_dia => $nome_dia) {
                            echo "<div class='form-check pl-5'>
                                    <input class='form-check-input' type='checkbox' name='Turma_Dias[]' value='$id_dia' id='dia_$id_dia'>
                                    <label class='form-check-label' for='dia_$id_dia'>$nome_dia</label>
                                  </div>";
                        }
                        ?>
                        <input type="hidden" id="codigo_dias" name="codigo_dias" readonly>
                    </div>

                    <div class="form-group">
                        <label for="Turma_Obs">Observações:</label>
                        <textarea class="form-control" id="Turma_Obs" name="Turma_Obs" required></textarea>
                    </div>
                    <div class="form-group d-flex flex-wrap">
                        <div class="form-group">
                            <label for="Turma_Inicio">Data de Início:</label>
                            <input type="date" class="form-control rounded-pill" id="Turma_Inicio" name="Turma_Inicio" required>
                        </div>

                        <div class="form-group pl-2">
                            <label for="Turma_Termino">Data de Término:</label>
                            <input type="date" class="form-control rounded-pill" id="Turma_Termino" name="Turma_Termino" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Professor_id">Professor:</label>
                        <select class="form-control rounded-pill" id="Professor_id" name="Professor_id">
                            <?php
                            include '../conexao.php';

                            $sql = "SELECT U.Usuario_id, U.Usuario_Nome FROM Usuario U
                                    INNER JOIN Registro_Usuario RU ON U.Usuario_id = RU.Usuario_Usuario_cd
                                    INNER JOIN Tipo T ON RU.Tipo_Tipo_cd = T.Tipo_id
                                    WHERE T.Tipo_id = 4";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Usuario_id"] . "'>" . $row["Usuario_Nome"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhum professor encontrado</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill">Enviar</button>
                </form>
            </div>
        </div>
    </main>


    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="Turma_Dias[]"]');
            const codigoDias = document.getElementById('codigo_dias');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
                    if (checkedCheckboxes.length > 3) {
                        alert('Você pode selecionar no máximo 3 dias de aula.');
                        checkbox.checked = false;
                        return;
                    }

                    let codigo = '';
                    checkedCheckboxes.forEach(function(cb) {
                        codigo += cb.value;
                    });
                    codigoDias.value = codigo;

                    atualizarCodigoTurma(); // Atualiza o código da turma, se necessário
                });
            });

            const horarioInicioInput = document.getElementById('Turma_Horario_inicio');
            const dataInicioInput = document.getElementById('Turma_Inicio');
            const codigoTurmaInput = document.getElementById('Turma_Cod');

            function atualizarCodigoTurma() {
                const cursoSelect = document.getElementById('Curso_id');
                const siglaCurso = cursoSelect.value;
                const horarioInicio = horarioInicioInput.value;
                const dataInicio = new Date(dataInicioInput.value);
                let diasCodigo = '';
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    diasCodigo += checkbox.value;
                });

                const horarioCodigo = horarioInicio.replace(':', '').substring(0, 2);
                const mesInicio = (dataInicio.getMonth() + 1).toString().padStart(2, '0');
                const anoInicio = dataInicio.getFullYear().toString().substring(2, 4);

                const codigoTurma = `${siglaCurso}${horarioCodigo}${diasCodigo}${mesInicio}${anoInicio}`;
                codigoTurmaInput.value = codigoTurma;
            }

            horarioInicioInput.addEventListener('change', atualizarCodigoTurma);
            dataInicioInput.addEventListener('change', atualizarCodigoTurma);

            // Inicializa o código da turma ao carregar a página, caso já existam valores predefinidos
            atualizarCodigoTurma();
        });

        document.getElementById('formDias').addEventListener('submit', function(event) {
            var checkboxes = document.querySelectorAll("input[type='checkbox'][name='Turma_Dias[]']");
            var isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isAnyChecked) {
                alert('Por favor, selecione pelo menos um dia da semana.');
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    </script>

    <script>
        document.getElementById('formDias').addEventListener('submit', function(event) {
            var checkboxes = document.querySelectorAll("input[type='checkbox'][name='Turma_Dias[]']");
            var isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isAnyChecked) {
                alert('Por favor, selecione pelo menos um dia da semana.');
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</body>

</html>