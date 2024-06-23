<div id="cadastro" class="card sombra p-2 row">
    <div class="col-sm-10 p-0">
        <div class="row">
            <div class="col-sm-8">
                <div class="texto">NOME COMPLETO<span>*</span></div>
                <input type="text" id="nome" name="nome" class="rounded-pill" required>
            </div>
            <div class="col-sm-4">
                <div class="texto">APELIDO<span>*</span></div>
                <input type="text" name="apelido" id="apelido" class="rounded-pill" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="texto">E-MAIL<span>*</span></div>
                <input type="email" id="email" name="email" class="rounded-pill" required>
            </div>
            <div class="col-sm-4">
                <div class="texto">SEXO<span>*</span></div>
                <select name="sexo" id="sexo" class="rounded-pill" required>
                    <option value="Feminino">Feminino</option>
                    <option value="Masculino">Masculino</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="texto">CPF<span>*</span></div>
                <input type="text" id="cpf" name="cpf" class="rounded-pill" required maxlength="13"
                    onkeyup="handleCPF(event)" placeholder="Digite somente números">
            </div>
            <div class="col-sm-4">
                <div class="texto">RG<span>*</span></div>
                <input type="text" id="rg" name="rg" class="rounded-pill" required maxlength="12"
                    placeholder="Digite somente números" onkeyup="handleRG(event)">
            </div>
            <div class="col-sm-4">
                <div class="texto">DATA NASCIMENTO<span>*</span></div>
                <input type="date" id="nascimento" name="nascimento" class="rounded-pill" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="texto">ESTADO CIVIL<span>*</span></div>
                <select name="civil" id="civil" class="rounded-pill" required>
                    <option value="solteiro">Solteiro</option>
                    <option value="casado">Casado</option>
                    <option value="separado">Separado</option>
                    <option value="divorciado">Divorciado</option>
                    <option value="viuvo">Viúvo</option>
                </select>
            </div>
            <div class="col-sm-4">
                <div class="texto">CELULAR<span>*</span></div>
                <input type="tel" id="celular" name="celular" class="rounded-pill" required maxlength="15"
                    placeholder="11 99999-9999" onkeyup="handlePhone(event)">
            </div>
            <div class="col-sm-4">
                <div class="texto">TELEFONE RECADO</div>
                <input type="tel" id="recado" name="recado" class="rounded-pill" maxlength="15"
                    placeholder="11 99999-9999" onkeyup="handlePhone(event)">
            </div>
        </div>

        <!-- CONDIÇÃO PARA ADICIONAR O RESPONSÁVEL NA PÁGINA DE CADASTRO, APENAS PARA ALUNOS -->
        <?php if ($elemento === 'Aluno') { ?>
            <div class="row">
                <div class="col-sm-8">
                    <div class="texto">NOME RESPONSÁVEL</div>
                    <input type="text" id="nome_responsavel" name="nome_responsavel" class="rounded-pill">
                </div>
                <div class="col-sm-4">
                    <div class="texto">CELULAR RESPONSÁVEL</div>
                    <input type="tel" id="celular_responsavel" name="celular_responsavel" class="rounded-pill"
                        maxlength="15" placeholder="11 99999-9999" onkeyup="handlePhone(event)">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="texto">CPF RESPONSÁVEL</div>
                    <input type="text" id="cpf_responsavel" name="cpf_responsavel" class="rounded-pill" maxlength="13"
                        onkeyup="handleCPF(event)" placeholder="Digite somente números">
                </div>
                <div class="col-sm-4">
                    <div class="texto">RG RESPONSÁVEL</div>
                    <input type="text" id="rg_responsavel" name="rg_responsavel" class="rounded-pill" maxlength="12"
                        placeholder="Digite somente números" onkeyup="handleRG(event)">
                </div>
                <div class="col-sm-4">
                    <div class="texto">PARENTESCO</div>
                    <input type="text" id="parentesco" name="parentesco" class="rounded-pill">
                </div>
            </div>
        <?php } ?>
        <!-- FIM DA CONDIÇÃO -->

        <div class="row">
            <div class="col-sm">
                <textarea name="obs" id="obs" class="w-100" placeholder="Observações..."></textarea>
            </div>
        </div>
    </div>
    <div class="col-sm-2 p-0 d-flex flex-column align-items-center">
        <img id="imagemExibida" src="../ICON/perfil.svg" alt="foto" class="rounded-circle">
        <br>
        <label for="imagemInput" class="btn btn-sm rounded-pill font-weight-bold m-0"
            style="cursor: pointer; color:#0D4817; background-color:#6EC77D;">
            INSERIR FOTO
        </label>
        <input type="file" id="imagemInput" name="imagem" accept="image/*" style="display: none;"
            onchange="exibirImagem()">
    </div>
</div>