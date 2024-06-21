<div class="card w-100">
    <div class="card-body">
        <div class="btn-group d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Ocorrências</h5>
        </div>
        <div class="overflow-auto" style="height: 23rem;">
            <?php
            if ($resultOcorrencias->num_rows > 0) {
                while ($rowOcorrencia = $resultOcorrencias->fetch_assoc()) {
                    $dataOcorrencia = new DateTime($rowOcorrencia['Ocorrencia_Registro']);
                    ?>
                    <div class="card-body bg-white sombra mb-3">
                        <div class="row">
                            <div class="texto">Data:</div>
                            <div class="info"><?php echo $dataOcorrencia->format('d/m/Y'); ?></div>
                        </div>
                        <div class="row">
                            <div class="info"><?php echo $rowOcorrencia['Mensagem']; ?></div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div>Nenhuma ocorrência registrada para este aluno.</div>";
            }
            ?>
        </div>
    </div>
</div>