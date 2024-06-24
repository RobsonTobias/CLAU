<div class="col-sm p-0">
    <div class="card">
        <div class="card-body">
            <div class="col-sm pl-0">
                <h5>Turmas Cadastradas</h5>
            </div>
            <div class="col-sm-6 d-flex flex-row pl-0" style="gap:10px;">
                <select id="filtroCurso" class="rounded-lg" style="background-color: #4D4D4D;">
                    <option value="">CURSO</option>
                    <?php
                    $sqlCursos = "SELECT Curso_id, Curso_Sigla, Curso_Nome FROM Curso";
                    $resultCursos = $conn->query($sqlCursos);
                    if ($resultCursos->num_rows > 0) {
                        while ($curso = $resultCursos->fetch_assoc()) {
                            echo "<option value='" . $curso['Curso_Nome'] . "'>" . $curso['Curso_Nome'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <select id="filtroProfessor" class="rounded-lg" style="background-color: #4D4D4D;">
                    <option value="">PROFESSOR</option>
                    <?php
                    $sqlProfessores = "SELECT Usuario_id, Usuario_Apelido FROM Usuario
            INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
            WHERE Registro_Usuario.Tipo_Tipo_cd = 4;";
                    $resultProfessores = $conn->query($sqlProfessores);
                    if ($resultProfessores->num_rows > 0) {
                        while ($professor = $resultProfessores->fetch_assoc()) {
                            echo "<option value='" . $professor['Usuario_Apelido'] . "'>" . $professor['Usuario_Apelido'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <table-responsive>
                <table class="table table-hover table-striped mt-2">
                    <tr>
                        <th>CURSO</th>
                        <th class="text-center">TURMA</th>
                        <th>PROFESSOR</th>
                        <th class="text-center">MAX. ALUNOS</th>
                        <th class="text-center">MATRICULADOS</th>
                    </tr>
                    <?php
                    $sql = "SELECT Turma.*, Curso.Curso_Nome AS curso, COUNT(Aluno_Turma.Usuario_Usuario_cd) AS matriculados, Usuario.Usuario_Apelido AS professor FROM Turma
                    INNER JOIN Curso ON Turma.curso_cd = Curso.Curso_id
                    INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_id 
                    LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
                    GROUP BY Curso.Curso_id, Turma.Turma_Cod";


                    $resultado = $conn->query($sql);
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) { ?>

                            <tr data-id="<?php echo $row['Turma_Cod'] ?>" onclick="mostrarDetalhes(this)">
                                <td class='sigla'><?php echo $row["curso"] ?></td>
                                <td class='turma_cod text-center'><?php echo $row["Turma_Cod"]?></td>
                                <td class='professor_id'><?php echo $row["professor"] ?></td>
                                <td class='maxalunos text-center'><?php echo $row["Turma_Vagas"] ?></td>
                                <td class='matriculados text-center'><?php echo $row["matriculados"] ?></td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='5'>Nenhuma tumra encontrada.</td></tr>";
                    }
                    ?>
                </table>
            </table-responsive>
        </div>
    </div>
</div>