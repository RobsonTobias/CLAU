<div class="card w-100 mt-4">
    <div class="card-body">
        <div class="btn-group d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Troca de Turma</h5>
            <button class="editar editarSituacao" id="editarSalvarTurma" type="button">
                TROCAR TURMA
            </button>
        </div>
        <div class="card-body bg-white sombra mb-3">
            <div class="row">
                <div class="col-sm-10 p-0">
                    <div class="row">
                        <div class="col-sm row p-0">
                            <div class="texto">Turma Atual:</div>
                            <div class="info" id="turmaAtual"></div>
                        </div>
                        <div class="col-sm row p-0">
                            <div class="texto">Turma Destino:</div>
                            <div class="info" id="turmaTexto"> -- </div>
                            <div class="select info" id="turmaDestinoSelect" style="display:none;">
                                <select name="turmaDestino" id="turmaDestino">
                                    <!-- As opções serão preenchidas dinamicamente pelo JavaScript -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>