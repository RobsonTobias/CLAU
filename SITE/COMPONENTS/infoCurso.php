<div  class="card sombra p-2 row h-100">
    <div class="col-sm p-0">
        <div class="row">
            <div class="col-sm">
                <div class="texto">NOME DO CURSO</div>
                <input type="text" id="modalNome" name="nome" class="rounded-pill" disabled>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4">
                <div class="texto">SIGLA</div>
                <input type="text" id="sigla" name="sigla" maxlength="3" class="rounded-pill" required disabled>
            </div>
            <div class="col-sm-4">
                <div class="texto">CARGA HORÁRIA</div>
                <input type="number" id="carga_horaria" name="carga_horaria" oninput="limitarValor(this, 400)" class="rounded-pill" required disabled>
            </div>
            <div class="col-sm-4">
                <div class="texto">DURAÇÃO (meses)</div>
                <input type="number" id="duracao" name="duracao" min="0" oninput="limitarValor(this, 36)" class="rounded-pill"  disabled>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm">
                <div class="texto">PRÉ-REQUISITO</div>
                <input type="text" id="pre_requisito" name="pre_requisito" rows="4" cols="50" class="rounded-pill" value="Sem pré-requisito!" disabled>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm">
                <div class="texto">DESCRIÇÃO</div>
                <input id="descricao" name="descricao" placeholder="Descrição do curso" class="rounded-pill" required disabled></input>
            </div>
        </div>
        <div class="row mt-2">
                <div class="col-sm">
                    <div class="modulo" id="camposModulos">
                        <div class="campoModulo">
                            <label for="modulo">
                                <div class="texto">Módulo</div>
                                <input type="text" name="modulos[]" class="rounded-pill" disabled>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>