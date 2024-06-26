<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api_customers_ac_model extends CI_Model
{
    // Varialvel da Tabela tblclients
    // tblclients Table Variable
    private $tblclients;

    // Varialvel da Tabela tblcustomfields
    // tblcustomfields Table Variable
    private $tblcustomfields;
    // Varialvel da Tabela tblcustomfieldsvalues
    // tblcustomfieldsvalues Table Variable
    private $tblcustomfieldsvalues;

    // Varialvel da Tabela tbloptions
    // tbloptions Table Variable
    private $tbloptions;

    // Construtor
    public function __construct()
    {
        // Carrega o a tabela tblclients
        // Load the tblclients table
        $this->tblclients = db_prefix() . 'clients';
        // Carrega o a tabela tblcustomfields
        // Load the tblcustomfields table
        $this->tblcustomfields = db_prefix() . 'customfields';
        // Carrega o a tabela tblcustomfieldsvalues
        // Load the tblcustomfieldsvalues table
        $this->tblcustomfieldsvalues = db_prefix() . 'customfieldsvalues';

        // Carrega o a tabela tblcustomfieldsvalues
        // Load the tblcustomfieldsvalues table
        $this->tbloptions = db_prefix() . 'tbloptions';
    }

    // Função para retornar todos os clientes
    // Function to return all customers
    public function allClients()
    {
        return $this->db->get($this->tblclients)->result_array();
    }

    // Função para verificar se o CNPJ já existe
    // Function to check if CNPJ already exists
    // public function check_cnpj_exists($cnpj)
    // {
    //     $query = $this->db->get_where($this->tblclients, array('vat' => $cnpj));
    //     $result = $query->row();
    //     return count($result) > 0 ? $result = true : $result = false;
    // }

    public function check_cnpj_exists($cnpj) {
        // Remove todos os caracteres não numéricos do CNPJ de entrada
        $cleaned_cnpj = preg_replace('/[^\d]/', '', $cnpj);

        // Obtém todos os CNPJs do banco de dados para limpeza e comparação
        $query = $this->db->get($this->tblclients); // Busca todos os registros na tabela
        $results = $query->result(); // Retorna todos os registros como um array de objetos

        // Limpa os CNPJs do banco de dados
        foreach ($results as $result) {
            $stored_cnpj = preg_replace('/[^\d]/', '', $result->vat); // Limpa o CNPJ armazenado

            if ($stored_cnpj === $cleaned_cnpj) {
                return true; // Se os CNPJs limpos forem iguais, o CNPJ já existe
            }
        }
        // Se não houver correspondência, o CNPJ não existe no banco de dados
        return false;
    }

    // Função para retornar o ID do campo personalizado
    // Function to return the ID of the custom field
    public function get_custom_field_id($name)
    {
        $query = $this->db->get_where($this->tblcustomfields, array('name' => $name));
        $result = $query->row();
        return $result ? $result->id : null;
    }


    // Função para adicionar um valor no campo personalizado
    // Function to add a custom field
    public function add_custom_field($clientid, $fieldid, $value)
    {
        $data = array(
            // 'relid' é o ID do cliente
            // 'relid' is the customer ID
            'relid' => $clientid,
            // 'fieldid' é o ID do campo personalizado
            // 'fieldid' is the custom field ID
            'fieldid' => $fieldid,
            // 'fieldto' e o tipo de cadastro que o campo personalizado pertence
            // 'fieldto' is the type of registration that the custom field belongs to
            'fieldto' => 'customers',
            // 'value' é o valor do campo personalizado
            // 'value' is the value of the custom field
            'value' => $value
        );

        return $this->db->insert($this->tblcustomfieldsvalues, $data);
    }


    // Função para criar um cliente
    // Function to create a customer
    public function create_customer($data)
    {
        // Insere os dados na tabela 'tblclients'
        // Insert data into 'tblclients' table
        $this->db->insert($this->tblclients, $data);

        // Retorna o ID do cliente recém-criado
        // Return the ID of the newly created customer
        return $this->db->insert_id();
    }

    // Método para verificar se um módulo está ativo
    public function is_module_active($module_name)
    {
        // Consulte a tabela 'tblmodules' para verificar o status do módulo
        $this->db->select('active'); // Seleciona a coluna 'active'
        $this->db->from('tblmodules'); // Especifica a tabela
        $this->db->where('module_name', $module_name); // Define a condição

        $query = $this->db->get(); // Executa a consulta
        $result = $query->row(); // Retorna uma linha ou null

        // Verifica se o resultado é válido e se o módulo está ativo
        return $result && $result->active == 1; // Retorna true se ativo, false se desativado
    }

    // Adiciona ou atualiza uma opção na tabela 'tbloptions'
    // Add or update an option in the 'tbloptions' table
    public function set_option_key($key, $value = '')
    {
        // Dados para inserção ou atualização
        // Data for insertion or update
        $data = array(
            'name' => 'api_customers_ac_key', // Chave exclusiva para a opção
            'value' => $value, // Valor a ser armazenado
        );

        // Verifica se a chave já existe
        // Check if the key already exists
        $this->db->where('name', $key);
        $query = $this->db->get($this->tbloptions);

        if ($query->num_rows() == 0) {
            // Se a chave não existe, insira o valor
            // If the key does not exist, insert the value
            $this->db->insert($this->tbloptions, $data);
        } else {
            // Se a chave já existe, atualize o valor
            // If the key already exists, update the value
            if (!$key == '' || !$key == null) {
                $this->db->where('name', $key);
                $this->db->update($this->tbloptions, $data);
                return true;
            }
        }
    }

}