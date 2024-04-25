<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: API para Cadastro de Clientes
Description: O módulo API Cadastro de Cliente foi desenvolvido para proporcionar um cadastramento de Clientes de forma automatizada.
Author: André Corrêa
Author URI: https://alsweb.com.br/
Version: 1.0.0
Requires at least: 2.3.*
*/

/**
 * Adiciona o hook de inicialização do módulo
 * Add module initialization hook
 */

// Define  uma constante slug para o módulo
// Define a slug constant for the module
define('API_CUSTOMERS_AC', 'api_customers_ac');

// Define uma variável com slug para módulo
// Define a variable with slug for module
$module = "api_customers_ac";

$CI = &get_instance();

register_language_files(API_CUSTOMERS_AC, [API_CUSTOMERS_AC]);

// Adiciona o hook de inicialização de menu para o módulo
// Add menu initialization hook for the module
hooks()->add_action('admin_init', 'api_customers_ac_menu');


/**
 * Função de ativação do módulo
 * Chamada quando o módulo é ativado
 */
register_activation_hook(API_CUSTOMERS_AC, 'rest_customers_ac_activation_hook');

function rest_customers_ac_activation_hook()
{
    // Código para executar quando o módulo é ativado
    // Por exemplo, criar tabelas no banco de dados, inicializar configurações, etc.
    $routes_path = APPPATH . 'config/routes.php';
    $content = file_get_contents($routes_path);
    // Caminho para o helper

    $protection_line = "defined('BASEPATH') or exit('No direct script access allowed');";
    $new_route = "\$route['api/create_customer'] = 'api_customers_ac/Api_customers_ac/create';\n";

    // Verifica se a rota já existe
    if (strpos($content, $new_route) === false) {
        // Insere a nova rota após a linha de proteção
        $content = str_replace($protection_line, $protection_line . "\n" . $new_route, $content);
        file_put_contents($routes_path, $content);
    }
    // Obtenha a instância do CI
    // Get the CI instance
    $CI =& get_instance();

    $CI->load->helper(API_CUSTOMERS_AC.'/api_customers_ac');
    api_customers_ac_add_custom_fiels('CPF do Responsavel');
    api_customers_ac_add_custom_fiels('Nome do Responsavel');
    api_customers_ac_add_custom_fiels('Carteira de Identidade nº Responsável');
    api_customers_ac_add_custom_fiels('Endereço, bairro, cidade, CEP, cidade, estado do Responsável');
    api_customers_ac_add_custom_fiels('Cargo do Responsável');
    api_customers_ac_add_custom_fiels('Usuários e Senhas');
    api_customers_ac_add_custom_fiels('IP do Servidor');
    api_customers_ac_add_custom_fiels('Segmentação da Empresa');
    api_customers_ac_add_custom_fiels('Website');
    api_customers_ac_add_custom_fiels('Horário');
    api_customers_ac_add_custom_fiels('CPF/CNPJ');
    api_customers_ac_add_custom_fiels('Numero do endereço');
    api_customers_ac_add_custom_fiels('Email do cliente');
    api_customers_ac_add_custom_fiels('Plano');
    api_customers_ac_add_custom_fiels('Bairro');
    // Defina nome do campo para armazenamento da chave
    // Define field name for key storage
    $key = 'api_customers_ac_key';

    $CI->db->where('name', $key);
    $query = $CI->db->get('tbloptions');

    $data = array(
        'name' => $key, // Chave exclusiva para a opção
    );

    // Verifica se a chave já existe
    $CI->db->where('name', $key);
    $query = $CI->db->get('tbloptions');

    if ($query->num_rows() == 0) {
        // Se a chave não existe, insira o valor
        $CI->db->insert('tbloptions', $data);
    } else {
        // Se a chave já existe, atualize o valor
        if ($key != '' && $key != null) {
            $CI->db->where('name', $key);
            $CI->db->update('tbloptions', $data); // Atualize o valor aqui
            return true;
        }
    }
}


/**
 * Função de desativação do módulo
 * Chamada quando o módulo é desativado
 */
register_deactivation_hook(API_CUSTOMERS_AC, 'rest_customers_ac_deactivation_hook');
function rest_customers_ac_deactivation_hook()
{
    // Código para executar quando o módulo é desativado
    // Por exemplo, limpar configurações, remover tabelas do banco de dados, etc.
    $routes_path = APPPATH . 'config/routes.php';
    $content = file_get_contents($routes_path);

    // Remove a rota do arquivo
    $content = str_replace("\$route['api/create_customer'] = 'api_customers_ac/Api_customers_ac/create';\n", '', $content);
    file_put_contents($routes_path, $content);

}

// Função para adicionar o menu do módulo
// Function to add the module menu
function api_customers_ac_menu()
{
    $CI = &get_instance();

    if (has_permission('api_customers_ac', '', 'view')) {

        // Adiciona o item do menu principal
        // Add the main menu item
        $CI->app_menu->add_sidebar_menu_item('api_customers_ac_item_collapsible', [
            'name' => _l('API Customers AC'), // O nome do item
            'collapse' => true, // Indica que este item terá subitens
            'position' => 31, // A posição do item no menu
            'icon' => 'fa fa-users', // Ícone FontAwesome relacionado a pessoas
            'badge' => []
        ]);

        // Adiciona o subitem do menu
        // Add the menu subitem
        $CI->app_menu->add_sidebar_children_item('api_customers_ac_item_collapsible', [
            'slug' => 'api_customers_ac', // ID/slug obrigatório e ÚNICO para o subitem do menu // ID/slug required and UNIQUE for the menu subitem
            'name' => _l('Cofiguration'), // Nome do subitem // Subitem name
            'icon' => 'fa fa-pencil-square-o', // Ícone FontAwesome relacionado a assinatura // FontAwesome icon related to signature
            'href' => admin_url('api_customers_ac/api_admin_customers_ac'), // URL do subitem // Subitem URL
            'position' => 11, // Posição do subitem no menu // Subitem position in the menu
        ]);
    }

    // Adiciona o hook para permissões do módulo
// Add hook for module permissions
    hooks()->add_action('admin_init', 'api_customers_ac_permissions');

    // Função para adicionar permissões do módulo
// Function to add module permissions
    function api_customers_ac_permissions($permissions)
    {
        $capabilities = [];
        $capabilities['capabilities'] = [
            'view' => _l('ver'),
            'create' => _l('criar'),
            'edit' => _l('editar'),
            'delete' => _l('excluir'),
        ];
        register_staff_capabilities('api_customers_ac', $capabilities, _l('API Customers AC'));
        return $permissions;
    }

}