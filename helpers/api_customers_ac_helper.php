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
        return 'Chave não cadastro!';
        // return $default; // Se não encontrado, retorna o valor padrão
    }
}