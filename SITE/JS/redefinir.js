document.getElementById('redefinir').addEventListener('click', function() {
    var userEmail = document.getElementById('emailUsuario').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './PHP/redefinir.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Usando a resposta do servidor para mostrar um alerta
            alert(xhr.responseText);
        }
    };
    xhr.send('email=' + encodeURIComponent(userEmail));
});
