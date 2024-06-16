<div id="cadastro" class="card sombra p-2 row">
    <div class="col-sm-10 p-0">
        <div class="row">
            <div class="col-sm-3">
                <div class="texto">CEP<span>*</span></div>
                <input type="text" id="cep" name="cep" class="rounded-pill" required maxlength="9"
                    onkeyup="handleZipCode(event)" placeholder="Digite somente números">
            </div>
            <div class="col-sm-7">
                <div class="texto">LOGRADOURO<span>*</span></div>
                <input type="text" id="logradouro" name="logradouro" class="rounded-pill" required>
            </div>
            <div class="col-sm-2">
                <div class="texto">Nº<span>*</span></div>
                <input type="text" id="numero" name="numero" class="rounded-pill" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="texto">BAIRRO<span>*</span></div>
                <input type="text" id="bairro" name="bairro" class="rounded-pill" required>
            </div>
            <div class="col-sm">
                <div class="texto">COMPLEMENTO</div>
                <input type="text" id="complemento" name="complemento" class="rounded-pill">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="texto">CIDADE<span>*</span></div>
                <input type="text" id="cidade" name="cidade" class="rounded-pill" required>
            </div>
            <div class="col-sm-2">
                <div class="texto">UF<span>*</span></div>
                <input type="text" id="estado" name="estado" class="rounded-pill" required>
            </div>
        </div>
    </div>
    <div class="col-sm-2 p-0 d-flex flex-column align-items-center justify-content-center">
        <img src="../ICON/endereco.svg" alt="endereco">
    </div>
</div>