<div class="card w-100">
    <div class="card-body">
        <div class="btn-group d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações Pessoais</h5>
            <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
            <button class="btn btn-sm rounded-pill font-weight-bold m-0"
                style="color:#A08000; background-color:#FDE276; flex:unset" type="button"
                onclick="window.location.href = 's_alunos_editar.php'"><?php echo $informacao; ?></button>
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
                            <div class="info"><?php echo $row['Idade'] . " anos"; ?></div>
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
                        <div class="col-sm row p-0">
                            <div class="texto">Data de Ingresso:</div>
                            <div class="info" id="modalIngresso"><?php $ingresso = new DateTime($row['Registro_Data']); echo $ingresso->format('d-m-Y'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row card-body p-0 mt-2" style="min-height: 40px;">
                <p class="m-0 p-2 text-justify w-100" id="modalObs"><?php echo $row['Usuario_Obs']; ?></p>
            </div>
        </div>
        <div class="card-body bg-white sombra">
            <div class="row">
                <div class="texto">Logradouro:</div>
                <div class="info" id="modalLogradouro"><?php echo $row['Enderecos_Rua']; ?></div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">Nº:</div>
                    <div class="info" id="modalNumero"><?php echo $row['Enderecos_Numero']; ?></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">Complemento:</div>
                    <div class="info" id="modalComplemento"><?php echo $row['Enderecos_Complemento']; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">Bairro:</div>
                    <div class="info" id="modalBairro"><?php echo $row['Enderecos_Bairro']; ?></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">Cidade:</div>
                    <div class="info" id="modalCidade"><?php echo $row['Enderecos_Cidade']; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">UF:</div>
                    <div class="info" id="modalUf"><?php echo $row['Enderecos_Uf']; ?></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">CEP:</div>
                    <div class="info" id="modalCep"><?php echo $row['Enderecos_Cep']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>