<div class="card w-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0">Informações da Turma</h5>
            <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
        </div>
        <div class="card sombra p-2 row">
            <div class="col-sm p-0">
                <div class="row">
                    <div class="col-sm">
                        <div class="texto">CURSO</div>
                        <input type="text" id="modalCurso" class="rounded-pill" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <div class="texto">HORÁRIO</div>
                        <input type="text" id="modalHorario" class="rounded-pill" disabled>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">DIA</div>
                        <input type="number" id="modalDia" class="rounded-pill" disabled>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">TURMA</div>
                        <input type="number" id="modalCodigo" class="rounded-pill" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-8">
                        <div class="texto">PROFESSOR</div>
                        <input type="text" id="modalProfessor" class="rounded-pill" disabled>
                    </div>
                    <div class="col-sm-4">
                        <div class="texto">MÁXIMO ALUNOS</div>
                        <input type="text" id="modalMax" class="rounded-pill" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm">
                        <div class="texto">OBSERVAÇÕES</div>
                        <input type="text" id="modalObsTurma" class="rounded-pill" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>