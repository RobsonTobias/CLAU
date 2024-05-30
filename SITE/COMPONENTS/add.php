<style>
    a p {
        color: #4CAF50;
        font-weight: bolder;
        margin-left: 0.5em;
    }

    a:hover {
        text-decoration: none;
        opacity: 0.5;
    }

    .teste {
        margin: 0;
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
<a href=" <?php echo $paginaDestino ?>" class="row d-flex align-items-center teste">
    <button class="adicionar" type="button">+</button>
    <p>Adicionar <?php echo $elemento ?></p>
</a>