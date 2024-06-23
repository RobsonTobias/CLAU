<div id="cadastro" class="card sombra p-2 row">
    <div class="col-sm-10 p-0">
        <div class="row">
            <div class="col-sm-8">
                <div class="texto">NOME COMPLETO<span>*</span></div>
                <input type="text" id="nome" name="nome" class="rounded-pill" required value="<?php echo $l['Usuario_Nome']; ?>">
            </div>
            <div class="col-sm-4">
                <div class="texto">APELIDO<span>*</span></div>
                <input type="text" name="apelido" id="apelido" class="rounded-pill" required value="<?php echo $l['Usuario_Apelido']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="texto">E-MAIL<span>*</span></div>
                <input type="email" id="email" name="email" class="rounded-pill" required value="<?php echo $l['Usuario_Email']; ?>">
            </div>
            <div class="col-sm-4">
                <div class="texto">SEXO<span>*</span></div>
                <select name="sexo" id="sexo" class="rounded-pill" required>
                    <option value="Feminino" <?php echo ($l['Usuario_Sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
                    <option value="Masculino" <?php echo ($l['Usuario_Sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="texto">CPF<span>*</span></div>
                <input type="text" id="cpf" name="cpf" class="rounded-pill" required maxlength="13"
                    onkeyup="handleCPF(event)" placeholder="Digite somente números" value="<?php echo formatarCPF($l['Usuario_Cpf']); ?>">
            </div>
            <div class="col-sm-4">
                <div class="texto">RG<span>*</span></div>
                <input type="text" id="rg" name="rg" class="rounded-pill" required maxlength="12"
                    placeholder="Digite somente números" onkeyup="handleRG(event)" value="<?php echo formatarRG($l['Usuario_Rg']); ?>">
            </div>
            <div class="col-sm-4">
                <div class="texto">DATA NASCIMENTO<span>*</span></div>
                <input type="date" id="nascimento" name="nascimento" class="rounded-pill" required value="<?php echo $l['Usuario_Nascimento']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="texto">ESTADO CIVIL<span>*</span></div>
                <select name="civil" id="civil" class="rounded-pill" required>
                    <option value="solteiro" <?php if ($l['Usuario_EstadoCivil'] == 'solteiro') echo 'selected'; ?>>Solteiro</option>
                    <option value="casado" <?php if ($l['Usuario_EstadoCivil'] == 'casado') echo 'selected'; ?>>Casado</option>
                    <option value="separado" <?php if ($l['Usuario_EstadoCivil'] == 'separado') echo 'selected'; ?>>Separado</option>
                    <option value="divorciado" <?php if ($l['Usuario_EstadoCivil'] == 'divorciado') echo 'selected'; ?>>Divorciado</option>
                    <option value="viuvo" <?php if ($l['Usuario_EstadoCivil'] == 'viuvo') echo 'selected'; ?>>Viúvo</option>
                </select>
            </div>
            <div class="col-sm-4">
                <div class="texto">CELULAR<span>*</span></div>
                <input type="tel" id="celular" name="celular" class="rounded-pill" required maxlength="15"
                    placeholder="11 99999-9999" onkeyup="handlePhone(event)" value="<?php echo formatarCelular($l['Usuario_Fone']); ?>">
            </div>
            <div class="col-sm-4">
                <div class="texto">TELEFONE RECADO</div>
                <input type="tel" id="recado" name="recado" class="rounded-pill" maxlength="15"
                    placeholder="11 99999-9999" onkeyup="handlePhone(event)" value="<?php echo formatarCelular($l['Usuario_Fone_Recado']); ?>">
            </div>
        </div>

        <!-- CONDIÇÃO PARA ADICIONAR O RESPONSÁVEL NA PÁGINA DE CADASTRO, APENAS PARA ALUNOS -->
        <?php if ($elemento === 'Aluno') { ?>
            <div class="row">
                <div class="col-sm-8">
                    <div class="texto">NOME RESPONSÁVEL</div>
                    <input type="text" id="nome_responsavel" name="nome_responsavel" class="rounded-pill" value="<?php echo $l['Respon_Nome']; ?>">
                </div>
                <div class="col-sm-4">
                    <div class="texto">CELULAR RESPONSÁVEL</div>
                    <input type="tel" id="celular_responsavel" name="celular_responsavel" class="rounded-pill"
                        maxlength="15" placeholder="11 99999-9999" onkeyup="handlePhone(event)" value="<?php echo $l['Respon_Fone']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="texto">CPF RESPONSÁVEL</div>
                    <input type="text" id="cpf_responsavel" name="cpf_responsavel" class="rounded-pill" maxlength="13"
                        onkeyup="handleCPF(event)" placeholder="Digite somente números" value="<?php echo $l['Respon_Cpf']; ?>">
                </div>
                <div class="col-sm-4">
                    <div class="texto">RG RESPONSÁVEL</div>
                    <input type="text" id="rg_responsavel" name="rg_responsavel" class="rounded-pill" maxlength="12"
                        placeholder="Digite somente números" onkeyup="handleRG(event)" value="<?php echo $l['Respon_Rg']; ?>">
                </div>
                <div class="col-sm-4">
                    <div class="texto">PARENTESCO</div>
                    <input type="text" id="parentesco" name="parentesco" class="rounded-pill" value="<?php echo $l['Respon_Parentesco']; ?>">
                </div>
            </div>
        <?php } ?>
        <!-- FIM DA CONDIÇÃO -->

        <div class="row">
            <div class="col-sm">
                <textarea name="obs" id="obs" class="w-100" placeholder="Observações..."><?php echo $l['Usuario_Obs']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="col-sm-2 p-0 d-flex flex-column align-items-center">
        <img id="imagemExibida" src="<?php echo $l['Usuario_Foto']; ?>" alt="foto" class="rounded-circle">
        <br>
        <label id="alterarFotoBtn" for="imagemInput" class="btn btn-sm rounded-pill font-weight-bold m-0"
            style="cursor: pointer; color:#A08000; background-color:#FDE276;">
            ALTERAR FOTO
        </label>
        <input type="file" id="imagemInput" name="imagem" accept="image/*" style="display: none;"
            onchange="exibirImagem()">
    </div>
</div>