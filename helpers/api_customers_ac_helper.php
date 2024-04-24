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