<?php
ini_set('default_charset', 'UTF-8'); // Força o charset padrão para UTF-8
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Define a data atual
$data = date('Y-m-d'); // Formato: Ano-Mês-Dia

// Obtém o número do dia, nome do mês e ano
$numeroDia = date('d', strtotime($data)); // Obtém o número do dia
$nomeMes = strftime('%B', strtotime($data)); // Obtém o nome do mês em português
$ano = date('Y', strtotime($data)); // Obtém o ano

$nomeMes = utf8_encode($nomeMes); // Solução alternativa para garantir UTF-8

$date = $numeroDia . ' de ' . $nomeMes . ' de ' . $ano;// Exibe a data formatada
?>
