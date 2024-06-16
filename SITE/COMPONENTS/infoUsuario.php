<div class="card">
    <div class="card-body">
        <div class="btn-group d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações Pessoais</h5>
            <button class="btn btn-sm rounded-pill font-weight-bold m-0"
                style="color:#A08000; background-color:#FDE276; flex:unset" type="button" onclick="editar()"><?php echo $informacao; ?></button>
        </div>
        <div class="card-body bg-white sombra mb-3">
            <div class="row">
                <div class="col-sm-2 d-flex justify-content-center align-items-center m-0 p-0">
                    <img class="rounded-circle" id="imagemExibida" src="../ICON/perfil.svg" alt="foto">
                </div>
                <div class="col-sm-10 p-0">
                    <div class="row">
                        <div class="texto">Nome:</div>
                        <div class="info" id="modalNome"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Nascimento:</div>
                            <div class="info" id="modalNascimento"></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">Idade:</div>
                            <div class="info" id="modalIdade"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">CPF:</div>
                            <div class="info" id="modalCpf"></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">RG:</div>
                            <div class="info" id="modalRg"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Sexo:</div>
                            <div class="info" id="modalSexo"></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">E-mail:</div>
                            <div class="info" id="modalEmail"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Celular:</div>
                            <div class="info" id="modalCelular"></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">Data de Ingresso:</div>
                            <div class="info" id="modalIngresso"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row card-body p-0 mt-2" style="min-height: 40px;">
                <p class="m-0 p-2 text-justify w-100" id="modalObs">Nenhuma informação cadastrada!</p>
            </div>
        </div>
        <div class="card-body bg-white sombra">
            <div class="row">
                <div class="texto">Logradouro:</div>
                <div class="info" id="modalLogradouro"></div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">Nº:</div>
                    <div class="info" id="modalNumero"></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">Complemento:</div>
                    <div class="info" id="modalComplemento"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">Bairro:</div>
                    <div class="info" id="modalBairro"></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">Cidade:</div>
                    <div class="info" id="modalCidade"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm p-0 row">
                    <div class="texto">UF:</div>
                    <div class="info" id="modalUf"></div>
                </div>
                <div class="col-sm p-0 row">
                    <div class="texto">CEP:</div>
                    <div class="info" id="modalCep"></div>
                </div>
            </div>
        </div>
    </div>
</div>