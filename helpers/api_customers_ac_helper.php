<?php

defined('BASEPATH') or exit('No direct script access allowed');



function get_api_customers_ac_key(){
    // Obtenha a instância do CI
    $CI =& get_instance();

    $CI->db->where('name', 'api_customers_ac_key');
    $query = $CI->db->get('tbloptions');
    if ($query->num_rows() > 0) {
        $option = $query->row(); // Obtém o resultado
        return $option->value; // Retorna o valor associado à chave
    } else {
        return 'Chave Não Cadastrada!';
        // return $default; // Se não encontrado, retorna o valor padrão
    }
}


function api_customers_ac_add_custom_fiels($name){
    // Obtenha a instância do CI
    $CI =& get_instance();

    $CI->db->where('name', $name);
    $query = $CI->db->get('tblcustomfields');

    if ($query->num_rows() > 0) {
        // O nome já existe, retorna um erro ou faz alguma outra coisa
        return false;
    }

            // Trata o slug
            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '_', $name));

            $data = array(
                'fieldto' => 'customers',
                'name' => $name,
                'slug' => $slug,
                'required' => 0,
                'type' => 'input',
                'options' => '',
                'display_inline' => 0,
                'field_order' => 12,
                'active' => 1,
                'show_on_pdf' => 1,
                'show_on_ticket_form' => 0,
                'only_admin' => 0,
                'show_on_table' => 1,
                'show_on_client_portal' => 1,
                'disalow_client_to_edit' => 0,
                'bs_column' => 12,
                'default_value' => null
            );
            // Insere os dados na tabela 'tblcustomfields'
            return $CI->db->insert('tblcustomfields', $data);
}

function sanitize_data_ac($data) {
    $sanitized_data = [];

    // Usar htmlspecialchars para sanitizar strings
    $sanitized_data['name'] = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); // Este ainda é válido
    $sanitized_data['telephone'] = filter_var($data['telephone'], FILTER_SANITIZE_NUMBER_INT); // Para números
    $sanitized_data['address'] = htmlspecialchars($data['address'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['neighborhood'] = htmlspecialchars($data['neighborhood'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['cpfResponsible'] = htmlspecialchars($data['cpfResponsible'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['addressNumberId'] = filter_var($data['addressNumberId'], FILTER_SANITIZE_NUMBER_INT);
    $sanitized_data['cpfCnpjl'] = filter_var($data['cpfCnpjl'], FILTER_SANITIZE_NUMBER_INT);
    $sanitized_data['city'] = htmlspecialchars($data['city'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['state'] = htmlspecialchars($data['state'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['country'] = filter_var($data['country'], FILTER_SANITIZE_NUMBER_INT);
    $sanitized_data['zipCode'] = filter_var($data['zipCode'], FILTER_SANITIZE_NUMBER_INT);
    $sanitized_data['plan'] = htmlspecialchars($data['plan'], ENT_QUOTES, 'UTF-8');

    return $sanitized_data;
}

function validate_cnpj_ac($cnpj) {
    $cnpj = clean_numeric($cnpj); // Limpa o CNPJ

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        return false; // CNPJ inválido ou com dígitos repetidos
    }

    // Calcula o primeiro dígito verificador
    $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $sum = 0;
    for ($i = 0; $i < 12; $i++) {
        $sum += $cnpj[$i] * $weights1[$i];
    }
    $first_digit = 11 - ($sum % 11);
    if ($first_digit >= 10) {
        $first_digit = 0;
    }

    // Calcula o segundo dígito verificador
    $sum = 0;
    $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for ($i = 0; $i < 13; $i++) {
        $sum += $cnpj[$i] * $weights2[$i];
    }
    $second_digit = 11 - ($sum % 11);
    if ($second_digit >= 10) {
        $second_digit = 0;
    }

    return $first_digit == $cnpj[12] && $second_digit == $cnpj[13];
}



function validate_cpf_ac($cpf) {
    $cpf = clean_numeric($cpf); // Limpa o CPF

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false; // CPF inválido ou com dígitos repetidos
    }

    // Calcula o primeiro dígito verificador
    $sum = 0;
    for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
        $sum += $cpf[$i] * $j;
    }
    $first_digit = ($sum * 10) % 11;
    if ($first_digit == 10) {
        $first_digit = 0;
    }

    // Calcula o segundo dígito verificador
    $sum = 0;
    for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
        $sum += $cpf[$i] * $j;
    }
    $second_digit = ($sum * 10) % 11;
    if ($second_digit == 10) {
        $second_digit = 0;
    }

    return $first_digit == $cpf[9] && $second_digit == $cpf[10];
}


function identify_and_validate_cpf_cnpj_ac($value) {
    $cleaned_value = clean_numeric($value); // Limpa o valor

    if (strlen($cleaned_value) == 11) {
        return validate_cpf_ac($cleaned_value); // Valida como CPF
    }

    if (strlen($cleaned_value) == 14) {
        return validate_cnpj_ac($cleaned_value); // Valida como CNPJ
    }

    return false; // Se não for CPF ou CNPJ válido
}

function clean_numeric($value) {
    return preg_replace('/[^\d]/', '', $value);
}
