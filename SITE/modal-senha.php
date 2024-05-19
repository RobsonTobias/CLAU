<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Alterar Senha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="PATH_TO_YOUR_UPDATE_SCRIPT.php" method="POST">
          <div class="form-group">
            <label for="newPassword">Nova Senha:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        // Verifica se o parâmetro 'changePassword' está definido
        if (new URLSearchParams(window.location.search).has('changePassword')) {
            $('#changePasswordModal').modal('show');
        }
    });
</script>