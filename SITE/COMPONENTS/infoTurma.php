<div class="card w-100 mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações da Turma</h5>
        </div>
        <div class="card sombra p-2 row">
            <div class="col-sm p-0">
                <div class="row">
                    <div class="col-sm">
                        <div class="texto">CURSO</div>
                        <div id="modalCurso" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <div class="texto">HORÁRIO</div>
                        <div id="modalHorario" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">DIA</div>
                        <div type="number" id="modalDia" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">TURMA</div>
                        <div type="number" id="modalCodigo" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-8">
                        <div class="texto">PROFESSOR</div>
                        <div id="modalProfessor" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">MÁXIMO ALUNOS</div>
                        <div id="modalMax" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm">
                        <div class="texto">OBSERVAÇÕES</div>
                        <div id="modalObsTurma" class="rounded-pill infoturmaselect d-flex align-items-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="cadastrar" type="submit" onclick="cadastrar()">ADICIONAR ALUNO</button>
        </div>
    </div>
</div>