<header>
        <div class="title">
            <div class="nomedata closed">
                <h1><?php echo $titulo; ?></h1>
                <div class="php">
                    <?php echo $date; ?>
                    <!--  Mostrar o data atual -->
                </div>
                <?php require_once '../COMPONENTS/buttonBack.php' ?>
            </div>

            <div class="user">
                <?php echo $dropdown; ?>
                <!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>