<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api_admin_customers_ac extends AdminController//AdminController
{

    public function __construct()
    {
        parent::__construct();
        // Load the model
        // Carregar o modelo
        $this->load->model('Api_customers_ac_model');

        // Carregar o helper
        // Load the helper
        $this->load->helper('api_customers_ac');

    }

    public function index()
    {
        // Verificar se o módulo está ativo
        // Check if the module is active
        $activeModule = $this->Api_customers_ac_model->is_module_active('Api_customers_ac');
        if (!$activeModule) {
            echo 'Módulo Desativado<br>';
            echo 'Module Disabled';
            exit;
        }
        $data = [];
        $data['key_value'] = get_api_customers_ac_key();

        // Carregar a view
        // Load the view
        $this->load->view('api_customers_ac/api_clientes_tela', $data);
    }


    public function set_option_key_ac()
    {
        // Chave e valor que deseja adicionar ou atualizar
        $key = 'api_customers_ac_key';
        $value = $this->input->get('key_value', true);

        // Usa o método do modelo para definir a opção
        $return = $this->Api_customers_ac_model->set_option_key($key, $value);

        if ($return) {
            // Redireciona para a URL desejada
            redirect('/admin/api_customers_ac/api_admin_customers_ac/?response=Atualizado'); // Redireciona para a rotas do módulo
        } else {
            // Redireciona para a URL desejada
            redirect('/admin/api_customers_ac/api_admin_customers_ac/?response=Erro'); // Redireciona para a rotas do módulo
        }
    }

    public function cadastro()
    {
        // Verificar se o módulo está ativo
        // Check if the module is active
        $activeModule = $this->Api_customers_ac_model->is_module_active('Api_customers_ac');
        if (!$activeModule) {
            echo 'Módulo Desativado<br>';
            echo 'Module Disabled';
            exit;
        }
        $data = [];
        $data['key_value'] = get_api_customers_ac_key();

        // Carregar a view
        // Load the view
        $this->load->view('api_customers_ac/api_clientes_cadastro', $data);
    }


}