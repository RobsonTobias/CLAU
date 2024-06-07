<?php
// Função para formatar CPF em PHP
function formatarCPF($cpf) {
    // Remove tudo que não for dígito
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    // Formata o CPF
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

// Função para formatar RG em PHP
function formatarRG($rg) {
    // Remove tudo que não for dígito ou letra
    $rg = preg_replace('/[^a-zA-Z0-9]/', '', $rg);
    
    // Formata o RG (exemplo: 12.345.678-9 ou AB-12.345.678)
    if (strlen($rg) > 8) {
        $rg = preg_replace('/^([a-zA-Z]{0,2})?(\d{2})(\d{3})(\d{3})([a-zA-Z0-9])?$/', '$1$2.$3.$4-$5', $rg);
    } else {
        $rg = preg_replace('/^(\d{2})(\d{3})(\d{3})([a-zA-Z0-9])?$/', '$1.$2.$3-$4', $rg);
    }
    
    return $rg;
}

// Função para formatar celular em PHP
function formatarCelular($celular) {
    // Remove tudo que não for dígito
    $celular = preg_replace('/[^0-9]/', '', $celular);
    
    // Formata o celular (exemplo: (11) 91234-5678)
    if (strlen($celular) === 11) {
        $celular = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $celular);
    } elseif (strlen($celular) === 10) {
        $celular = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $celular);
    }
    
    return $celular;
}

// Função para formatar CEP em PHP
function formatarCEP($cep) {
    // Remove tudo que não for dígito
    $cep = preg_replace('/[^0-9]/', '', $cep);
    
    // Formata o CEP (exemplo: 12345-678)
    return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);
}
?>