<div class="col-sm-4">
    <div class="card">
        <div class="card-body">
            <div class="btn-group d-flex justify-content-between align-items-center">
                <div class="col-sm">
                    <h5>Pesquisar:</h5>
                </div>
                <div class="col-sm-6"><?php require_once '../COMPONENTS/add2.php'; ?></div>
                <!-- Alterar o nome do componente depois -->
            </div>
            <input class="form-control" type="text" id="searchInput" placeholder="Digite um nome para pesquisar">
            <br>
            <table-responsive>
                <table class="table table-hover table-striped">
                    <thead class="text-uppercase">
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $listar = ListarUsuario($tipoUsuario);
                        if ($listar !== null) {
                            while ($l = $listar->fetch_array()) {
                                ?>
                                <tr data-id="<?php echo $l['Usuario_id']; ?>" onclick="mostrarDetalhes(this)">
                                    <td class="nomeusuario">
                                        <?php echo $l['Usuario_Nome']; ?>
                                    </td>
                                    <td class="emailusuario">
                                        <?php echo $l['Usuario_Email']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </table-responsive>
        </div>
    </div>
</div>