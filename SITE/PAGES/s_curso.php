<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$home = 's_home.php';
$titulo = 'RELATÓRIO DE CURSOS';
$paginaDestino = 's_curso_cad.php';
$elemento = 'Curso';
?>

<style>
    .curso path {
        fill: #043140;
    }
    .campoModulo label {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }


</style>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex form-group justify-content-center mt-3" style="margin-left: 76px;">
            <?php require_once '../COMPONENTS/pesquisaCurso.php'; ?>
            <?php require_once '../COMPONENTS/infoCurso.php'; ?>
        </div>
    </div>

    <div class="buttons">
        <?php echo $redes; ?>
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>

    <script>
        function mostrarDetalhes(cursoId) {
            $.ajax({
                url: '../PHP/det_curso.php',
                type: 'GET',
                data: { cursoId: cursoId },
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        console.error("Erro ao obter dados do curso:", response.error);
                        alert(response.error);
                    } else {
                        exibirDetalhesCurso(response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Erro ao obter dados do curso:", error);
                    alert("Erro ao obter dados do curso.");
                }
            });
        }

        function exibirDetalhesCurso(curso) {
            if (curso) {
                document.getElementById('modalNome').value = curso.Curso_Nome || 'Não informado';
                document.getElementById('sigla').value = curso.Curso_Sigla || 'Não informado';
                document.getElementById('carga_horaria').value = curso.Curso_Carga_horaria || '';
                document.getElementById('duracao').value = curso.Curso_Duracao || '';
                document.getElementById('pre_requisito').value = curso.Curso_PreRequisito || 'Não informado';
                document.getElementById('descricao').value = curso.Curso_Desc || 'Não informado';

                var camposModulos = document.getElementById('camposModulos');
                camposModulos.innerHTML = '';

                if (curso.modulos && curso.modulos.length > 0) {
                    curso.modulos.forEach(function (modulo) {
                        var campoModulo = document.createElement('div');
                        campoModulo.className = 'campoModulo';
                        var label = document.createElement('label');
                        label.innerHTML = '<div class="texto">Módulo</div>';
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'modulos[]';
                        input.className = 'rounded-pill';
                        input.value = modulo.Modulo_Nome || 'Não informado';
                        label.appendChild(input);
                        campoModulo.appendChild(label);
                        camposModulos.appendChild(campoModulo);
                    });
                } else {
                    var campoModulo = document.createElement('div');
                    campoModulo.className = 'campoModulo';
                    var label = document.createElement('label');
                    label.innerHTML = '<div class="texto">Módulo</div>';
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'modulos[]';
                    input.className = 'rounded-pill';
                    input.value = 'Não informado';
                    label.appendChild(input);
                    campoModulo.appendChild(label);
                    camposModulos.appendChild(campoModulo);
                }
            } else {
                alert('Nenhum dado encontrado para este curso.');
            }
        }


    </script>
</body>

</html>