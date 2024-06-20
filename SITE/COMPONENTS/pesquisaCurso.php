<div class="col-sm-4">
    <div class="card">
        <div class="card-body">
            <div class="btn-group d-flex justify-content-between align-items-center">
                <div class="col-sm">
                    <h5>Lista de Cursos</h5>
                </div>
                <div><?php require_once '../COMPONENTS/add2.php'; ?></div>
            </div>
            <table-responsive>
                <table class="table table-hover table-striped">
                    <thead class="text-uppercase">
                        <tr>
                            <th>Curso</th>
                            <th class="text-center">Sigla</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $listar = ListarCurso();
                        if ($listar !== null) {
                            while ($l = $listar->fetch_array()) {
                                ?>
                                <tr onclick="mostrarDetalhes(<?php echo $l['Curso_id']; ?>)">
                                    <td class="nomecurso">
                                        <?php echo $l['Curso_Nome']; ?>
                                    </td>
                                    <td class="sigla text-center">
                                        <?php echo $l['Curso_Sigla']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='2'>Nenhum curso encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </table-responsive>
        </div>
    </div>
</div>