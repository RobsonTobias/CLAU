<style>
    a:hover {
        text-decoration: none;
        opacity: 0.5;
    }
    .teste {
        margin: 0;
        justify-content: space-between;
    }
    .adicionar {
        border-radius: 50%;
        height: 1.25rem;
        width: 1.25rem;
        font-size: 1em;
        font-weight: bolder;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #4CAF50;
        border: none;
        color: #FFFFFF;
    }
</style>
<a href=" <?php echo $paginaDestino ?>" class="row d-flex align-items-center teste"
    style="gap: 0; text-decoration:none;">
    <button class="adicionar" type="button">+</button>
    <p style="color: #4CAF50; font-weight: bolder; margin-left: 0.5em;">Adicionar <?php echo $elemento ?></p>
</a>