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
    }


    public function set_option_key_ac() {
        // Chave e valor que deseja adicionar ou atualizar
        $key = 'api_customers_ac_key';
        $value = 'eiqfj;oj;qwi0r0928r409282';

        // Usa o método do modelo para definir a opção
        $this->Api_customers_ac_model->set_option_key($key, $value);

        echo "Opção $key atualizada para $value.";
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

        // Carregar a view
        // Load the view
        $this->load->view('api_customers_ac/api_clientes_tela');
    }

}