<?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    // Define a data atual
    $data = date('Y-m-d'); // Formato: Ano-Mês-Dia (exemplo: 2023-10-17)

    // Obtém o número do dia, nome do mês e ano
    $numeroDia = date('d', strtotime($data)); // Obtém o número do dia (exemplo: 17)
    $nomeMes = strftime('%B', strtotime($data)); // Obtém o nome do mês em português (exemplo: outubro)
    $ano = date('Y', strtotime($data)); // Obtém o ano (exemplo: 2023)

    $date = $numeroDia . ' de ' . $nomeMes . ' de ' . $ano;
?>