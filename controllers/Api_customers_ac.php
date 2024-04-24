<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api_customers_ac extends CI_Controller//AdminController
{

    public function __construct()
    {
        parent::__construct();
        // Load the model
        // Carregar o modelo
        $this->load->model('Api_customers_ac_model');
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
        // $this->load->view('api_customers_ac/api_clientes_tela');
        echo 'Hello World';
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
        // Collect customer data
        // Coletar dados do cliente
        $nameValue = 'André Teste';
        $emailValue = 'andreclinic1@gmail.com';
        $telephoneValue = '62981762590';
        $addressValue = 'Rua CP10.';
        $neighborhoodValue = 'Centro';
        $cpfResponsibleValue = '123456';
        $addressNumberIdValue = '100';
        $cpfCnpjlValue = '86623176187';
        $cityValue = 'Goiania';
        $stateValue = 'Goias';
        $countryValue = '32';
        $zipCodeValue = '74000000';
        $planValue = 'Mensal';

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

        // Adicionar o bairro ao cliente
        // Add the neighborhood to the customer
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
            die("<script>alert('Cliente criado com sucesso. ID do cliente: " . $clientId . "');</script>");
        } else {
            die("<script>alert('Erro ao criar cliente.');</script>");
        }

    }

}