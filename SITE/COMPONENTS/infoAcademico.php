<div class="card w-100 mt-4">
    <div class="card-body">
        <div class="btn-group d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações Acadêmicas</h5>
            <button class="btn btn-sm rounded-pill font-weight-bold m-0"
                style="color:#A08000; background-color:#FDE276; flex:unset" type="button"
                onclick="window.location.href = 's_alunos_turma_cad.php'">NOVA TURMA</button>
        </div>
        <?php
        // Supondo que $resultTurmas é o resultado da sua consulta ao banco de dados
        if ($resultTurmas->num_rows > 0) {
            while ($rowTurma = $resultTurmas->fetch_assoc()) {
                $alunoTurmaId = $rowTurma["Aluno_Turma_id"];
                // Início do bloco HTML para as informações de cada turma
                ?>
                <div class="card-body bg-white sombra mb-3 clicavel turma" onclick="mostrarDetalhes(this)"
                    data-turma-cod="<?php echo htmlspecialchars($rowTurma['Turma_Cod'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-curso-id="<?php echo $rowTurma['Curso_id']; ?>"
                    data-aluno-turma-id="<?php echo $rowTurma['Aluno_Turma_id']; ?>">
                    <div class="row">
                        <div class="col-sm-10 p-0">
                            <div class="row">
                                <div class="col-sm row p-0">
                                    <div class="texto">Curso:</div>
                                    <div class="info"><?php echo $rowTurma['Curso_Nome']; ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm row p-0">
                                    <div class="texto">Turma:</div>
                                    <div class="info"><?php echo $rowTurma['Turma_Cod']; ?></div>
                                </div>
                                <div class="col-sm row p-0">
                                    <div class="texto">Professor:</div>
                                    <div class="info"><?php echo $rowTurma['Professor']; ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm row p-0">
                                    <div class="texto">Horário:</div>
                                    <div class="info"><?php
                                    $horarioInicio = date('H:i', strtotime($rowTurma['Turma_Horario']));
                                    $horarioTermino = date('H:i', strtotime($rowTurma['Turma_Horario_Termino']));
                                    echo $horarioInicio . ' - ' . $horarioTermino;
                                    ?>
                                    </div>
                                </div>
                                <div class="col-sm row p-0">
                                    <div class="texto">Situação:</div>
                                    <div class="select situacaoSelect row align-items-center">
                                        <div class="col-sm row flex-nowrap w-50">
                                            <input class="situacaoRadio" type="radio"
                                                name="situacao_<?php echo $rowTurma['Aluno_Turma_id']; ?>" value="Ativo" <?php echo ($rowTurma['Aluno_Turma_Status'] === '1' ? 'checked' : ''); ?>>
                                            <div class="info">Ativo</div>
                                        </div>
                                        <div class="col-sm row flex-nowrap w-50">
                                            <input class="info situacaoRadio" type="radio"
                                                name="situacao_<?php echo $rowTurma['Aluno_Turma_id']; ?>" value="Inativo" <?php echo ($rowTurma['Aluno_Turma_Status'] === '0' ? 'checked' : ''); ?>>
                                            <div class="info">Inativo</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm flex-nowrap row p-0 align-items-center">
                                    <div class="texto">Frequência:</div>
                                    <div class="info" style="width: 10%;">
                                        <?php echo $rowTurma['Frequencia']; ?>%
                                    </div>&nbsp;&nbsp;
                                    <div class="progress bg-dark w-100">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                        style="width: <?php echo $rowTurma['Frequencia']; ?>%;" 
                                        aria-valuenow="<?php echo $rowTurma['Frequencia']; ?>%;" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div>Nenhuma turma encontrada para este aluno.</div>";
        }
        ?>
    </div>
</div>