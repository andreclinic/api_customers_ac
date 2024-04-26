<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_customers_cadastro_ac extends ClientsController { // Não herda de AdminController
    public function __construct() {
        parent::__construct();
        // Carregar modelo, helpers, ou outras dependências
        $this->load->model('Api_customers_ac_model');
        $this->load->helper('api_customers_ac');
        // Carrega a biblioteca de validação de formulários
        $this->load->library('form_validation');
        // Nenhuma verificação de sessão ou autenticação necessária
    }

    public function index() {

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
        $this->load->view('api_clientes_cadastro', $data);
        // Código para processar a requisição
        // echo 'Acesso sem autenticação!';
    }
}
