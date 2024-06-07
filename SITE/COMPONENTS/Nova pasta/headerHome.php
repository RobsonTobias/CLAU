<style>
    header {
        display: flex;
        width: 100%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .nomedata {
        display: flex;
        flex-direction: column;
        margin-left: 250px;
        transition: margin-left 0.5s ease;
    }

    .nomedata.closed {
        margin-left: 80px;
    }

    /* Estiliza a div dentro do cabeçalho */
    .title {
        margin: 0;
        display: flex;
        justify-content: space-between;
        width: 100%;
        align-items: center;
        padding: 10px 30px;
    }

    /* Estiliza o texto do cabeçalho */
    .title h1 {
        font-size: 30px;
        font-weight: bold;
        color: #233939;
        margin-bottom: 0;
    }

    /* Estiliza a imagem de perfil no cabeçalho */
    .title img {
        border-radius: 50%;
        width: 70px;
        border: solid 3px var(--cor-primaria);
        height: 70px;
    }

    /* Estiliza informações do usuário no cabeçalho */
    .user {
        display: flex;
        align-items: center;
    }

    /* Estiliza o texto do usuário no cabeçalho */
    .user p {
        margin-right: 20px;
        font-size: 15px;
        color: #233939;
        font-weight: bold;
    }

    /* Estiliza a linha horizontal */
    hr {
        background-color: #313131;
        width: 95%;
        height: 1px;
    }
</style>
<header>
    <div class="title">
        <div class="nomedata closed">
            <h1><?php echo $titulo; ?></h1>
            <div class="php">
                <?php echo $date; ?>
                <!--  Mostrar o data atual -->
            </div>
        </div>

        <div class="user">
            <?php require_once '../COMPONENTS/notif/notif.php'; ?>
            <?php echo $dropdown; ?>
            <!-- Mostra o usuario, foto e menu dropdown -->
        </div>
    </div>
    <hr>
</header>