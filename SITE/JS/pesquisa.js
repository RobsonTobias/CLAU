document.addEventListener('DOMContentLoaded', function () {
    ocultarLinhas(); 
});

function ocultarLinhas() {
    var tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(function (row) {
        row.style.display = 'none';
    });
}

document.getElementById('searchInput').addEventListener('keyup', function (event) {
    var searchQuery = event.target.value.toLowerCase();
    var tableRows = document.querySelectorAll('.table tbody tr'); 
    if (searchQuery.trim() !== '') {
        tableRows.forEach(function (row) {
            var nameText = row.querySelector('td.nomeusuario').textContent.toLowerCase(); // Usa a classe específica para nome
            if (nameText.includes(searchQuery)) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    } else {
        ocultarLinhas(); 
    }
});