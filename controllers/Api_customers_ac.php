<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api_customers_ac extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the model
        // Carregar o modelo
        $this->load->model('Api_customers_ac_model');
        $this->load->helper('api_customers_ac');
        // Carrega a biblioteca de validação de formulários
        $this->load->library('form_validation');
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
        // $this->load->view('api_customers_ac/api_clientes_tela');
        echo '<h1>API para cadastro de clientes</h1>';
    }

    public function create()
    {
        // Verificar se o módulo está ativo
        // Check if the module is active
        $activeModule = $this->Api_customers_ac_model->is_module_active('Api_customers_ac');
        if (!$activeModule) {
            echo 'Módulo Desativado<br>';
            echo 'Module Disabled';
            exit;
        }

        // Lê os dados brutos da entrada
        $json = file_get_contents('php://input');

        // Decodifica o JSON para um array
        $data = json_decode($json, TRUE);


        // Validação dos dados
        // Data validation
        $errors = [];

        if (!isset($data['name']) || empty($data['name'])) {
            $errors['name'] = 'Nome é obrigatório.';
        }

        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email é inválido.';
        }

        if (!isset($data['telephone']) || empty($data['telephone'])) {
            $errors['telephone'] = 'Telefone deve ser um número.';
        }

        if (!isset($data['address']) || empty($data['address'])) {
            $errors['address'] = 'Endereço é obrigatório.';
        }

        if (!isset($data['neighborhood']) || empty($data['neighborhood'])) {
            $errors['neighborhood'] = 'Bairro é obrigatório.';
        }

        if (!isset($data['cpfResponsible']) || empty($data['cpfResponsible'])) {
            $errors['cpfResponsible'] = 'CPF do responsável deve ser um número.';
        }

        if (!isset($data['addressNumberId']) || empty($data['addressNumberId'])) {
            $errors['addressNumberId'] = 'Número do endereço deve ser um número.';
        }

        if (!isset($data['cpfCnpjl']) || empty($data['cpfCnpjl'])) {
            $errors['cpfCnpjl'] = 'CPF/CNPJ deve ser um número.';
        }

        if (!isset($data['city']) || empty($data['city'])) {
            $errors['city'] = 'Cidade é obrigatória.';
        }

        if (!isset($data['state']) || empty($data['state'])) {
            $errors['state'] = 'Estado é obrigatório.';
        }

        if (!isset($data['country']) || empty($data['country'])) {
            $errors['country'] = 'País é obrigatório.';
        }

        if (!isset($data['zipCode']) || empty($data['zipCode'])) {
            $errors['zipCode'] = 'CEP deve ser um número.';
        }

        if (!isset($data['plan']) || empty($data['plan'])) {
            $errors['plan'] = 'Plano é obrigatório.';
        }

        if (!empty($errors)) {
            // Se houver erros, retorna um JSON com os erros
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit;
        }

        $sanitized_data = sanitize_data_ac($data); // Sanitiza o array de dados


        // Agora use os dados sanitizados para preencher variáveisß
        $nameValue = $sanitized_data['name'];
        $emailValue = $sanitized_data['email'];
        $telephoneValue = $sanitized_data['telephone'];
        $addressValue = $sanitized_data['address'];
        $neighborhoodValue = $sanitized_data['neighborhood'];
        $cpfResponsibleValue = $sanitized_data['cpfResponsible'];
        $addressNumberIdValue = $sanitized_data['addressNumberId'];
        $cpfCnpjlValue = clean_numeric($sanitized_data['cpfCnpjl']);

        $check_cnpj_exists = $this->Api_customers_ac_model->check_cnpj_exists($cpfCnpjlValue);

        if (!identify_and_validate_cpf_cnpj_ac($cpfCnpjlValue)) {
            echo json_encode(["message" => "CNPJ ou cpf incorreto"]);
            exit;
        }

        if ($check_cnpj_exists) {
            echo json_encode(["message" => "CNPJ já existe"]);
            exit;
        }
        $cityValue = $sanitized_data['city'];
        $stateValue = $sanitized_data['state'];
        $countryValue = $sanitized_data['country'];
        $zipCodeValue = $sanitized_data['zipCode'];
        $planValue = $sanitized_data['plan'];





        // Prepare customer data for insertion
        // Preparar os dados do cliente para inserção
        $data = array(
            'company' => $nameValue,
            'phonenumber' => $telephoneValue,
            'address' => $addressValue,
            'city' => $cityValue,
            'state' => $stateValue,
            'country' => $countryValue,
            'zip' => $zipCodeValue,
            'vat' => $cpfCnpjlValue,
        );

        // Criar o cliente
        // Create the customer
        $clientId = $this->Api_customers_ac_model->create_customer($data);

        // Obter o ID do campo personalizado 'Bairro'
        // Get the ID of the 'Neighborhood' custom field
        $neighborhoodId = $this->Api_customers_ac_model->get_custom_field_id('Bairro');
        // Adicionar o Numero do endereço ao cliente
        // Add the Customer address number
        $this->Api_customers_ac_model->add_custom_field($clientId, $neighborhoodId, $neighborhoodValue);

        // Obter o ID do campo personalizado 'CPF do Responsavel'
        // Get the ID of the 'CPF do Responsavel' custom field
        $cpfResponsibleId = $this->Api_customers_ac_model->get_custom_field_id('CPF do Responsavel');

        // Adicionar o Numero do endereço ao cliente
        // Add the Customer address number
        $this->Api_customers_ac_model->add_custom_field($clientId, $cpfResponsibleId, $cpfResponsibleValue);

        // Obter o ID do campo personalizado 'Numero do endereço'
        // Get the ID of the 'Numero do endereço' custom field
        $addressNumberId = $this->Api_customers_ac_model->get_custom_field_id('Numero do endereço');

        // Adicionar o camppo personalizado Numero do endereço ao cliente
        // Add the address number to the customer custom field
        $this->Api_customers_ac_model->add_custom_field($clientId, $addressNumberId, $addressNumberIdValue);

        // Obter o ID do campo personalizado 'Endereço, bairro, cidade, CEP, cidade, estado do Responsável'
        // Get the ID of the 'Endereço, bairro, cidade, CEP, cidade, estado do Responsável' custom field
        $addressId = $this->Api_customers_ac_model->get_custom_field_id('Endereço, bairro, cidade, CEP, cidade, estado do Responsável');

        // Adicionar o camppo personalizado 'Endereço, bairro, cidade, CEP, cidade, estado do Responsável' ao cliente
        // Add the 'Address, neighborhood, city, zip code, city, state of the person responsible' to the customer custom field
        $this->Api_customers_ac_model->add_custom_field($clientId, $addressId, $addressValue);

        // Obter o ID do campo personalizado 'Email do cliente'
        // Get the ID of the 'Email do cliente' custom field
        $emailId = $this->Api_customers_ac_model->get_custom_field_id('Email do cliente');

        // Adicionar o camppo personalizado 'Email do cliente' ao cliente
        // Add the 'email' to the customer custom field
        $this->Api_customers_ac_model->add_custom_field($clientId, $emailId, $emailValue);

        // Obter o ID do campo personalizado 'CPF/CNPJ'
        // Get the ID of the 'CPF/CNPJ' custom field
        $cpfCnpjlId = $this->Api_customers_ac_model->get_custom_field_id('CPF/CNPJ');

        // Adicionar o camppo personalizado 'CPF/CNPJ' ao cliente
        // Add the 'CPF/CNPJ' to the customer custom field
        $this->Api_customers_ac_model->add_custom_field($clientId, $cpfCnpjlId, $cpfCnpjlValue);

        // Obter o ID do campo personalizado 'Plano'
        // Get the ID of the 'Plano' custom field
        $planId = $this->Api_customers_ac_model->get_custom_field_id('Plano');

        // Adicionar o camppo personalizado 'Plano' ao cliente
        // Add the 'Plano' to the customer custom field
        $this->Api_customers_ac_model->add_custom_field($clientId, $planId, $planValue);

        // Verificar se o cliente foi criado com sucesso
        // Check if the customer was created successfully
        if ($clientId) {
            echo json_encode(["message" => "Cadastrado com sucesso"]);
            // die("<script>alert('Cliente criado com sucesso. ID do cliente: " . $clientId . "');</script>");
        } else {
            echo json_encode(["message" => "Ocorreu algun erro!"]);
            // die("<script>alert('Erro ao criar cliente.');</script>");
        }

    }

}