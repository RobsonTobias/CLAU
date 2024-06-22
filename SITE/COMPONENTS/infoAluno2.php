<div class="card w-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações Pessoais</h5>
            <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
        </div>
        <div class="card-body bg-white sombra mb-3">
            <div class="row">
                <div class="col-sm-2 d-flex justify-content-center align-items-center m-0 p-0">
                    <img class="rounded-circle" id="imagemExibida" src="<?php echo $row['Usuario_Foto']; ?>" alt="foto">
                </div>
                <div class="col-sm p-0">
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Nome:</div>
                            <div class="info"><?php echo $row['Usuario_Nome']; ?></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">Matrícula:</div>
                            <div class="info"><?php echo $row['Usuario_Matricula']; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Nascimento:</div>
                            <div class="info">
                                <?php $nascimento = new DateTime($row['Usuario_Nascimento']);
                                echo $nascimento->format('d-m-Y'); ?>
                            </div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">Idade:</div>
                            <div class="info"><?php echo $idade ." anos"; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">CPF:</div>
                            <div class="info" id="modalCpf"><?php echo $row['Usuario_Cpf']; ?></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">RG:</div>
                            <div class="info" id="modalRg"><?php echo $row['Usuario_Rg']; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Sexo:</div>
                            <div class="info" id="modalSexo">
                                <?php if ($row['Usuario_Sexo'] === 'M') {
                                    echo 'Masculino';
                                } else {
                                    echo 'Feminino';
                                } ?>
                            </div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">E-mail:</div>
                            <div class="info" id="modalEmail"><?php echo $row['Usuario_Email']; ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Celular:</div>
                            <div class="info" id="modalCelular"><?php echo $row['Usuario_Fone']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row card-body p-0 mt-2" style="min-height: 40px;">
                <p class="m-0 p-2 text-justify w-100" id="modalObs"><?php echo $row['Usuario_Obs']; ?></p>
            </div>
        </div>
    </div>
</div>