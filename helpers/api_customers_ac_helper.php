<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once dirname(dirname(__DIR__)).'/api_customers_ac/vendor/autoload.php';

function get_api_customers_ac_key()
{
    // Obtenha a instância do CI
    $CI =& get_instance();
    $prifix = db_prefix();
    $tbloptions = $prifix . 'options';

    $CI->db->where('name', 'api_customers_ac_key');
    $query = $CI->db->get($tbloptions);
    if ($query->num_rows() > 0) {
        $option = $query->row(); // Obtém o resultado
        return $option->value; // Retorna o valor associado à chave
    } else {
        return 'Chave Não Cadastrada!';
        // return $default; // Se não encontrado, retorna o valor padrão
    }
}


function api_customers_ac_add_custom_fiels($name)
{
    // Obtenha a instância do CI
    $CI =& get_instance();
    $prifix = db_prefix();
    $tblcustomfields = $prifix . 'customfields';

    $CI->db->where('name', $name);
    $query = $CI->db->get($tblcustomfields);

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
    return $CI->db->insert($tblcustomfields, $data);
}

function sanitize_data_ac($data)
{
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
    $sanitized_data['plan'] = htmlspecialchars($data['recurring'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['recurring'] = filter_var($data['recurring'], FILTER_SANITIZE_NUMBER_INT);
    $sanitized_data['adminnote'] = htmlspecialchars($data['adminnote'], ENT_QUOTES, 'UTF-8');
    $terms_safe_html = strip_tags($data['terms'], '<br><b><br />');
    $sanitized_data['terms'] = htmlspecialchars($terms_safe_html, ENT_QUOTES, 'UTF-8');
    $sanitized_data['description'] = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['long_description'] = htmlspecialchars($data['long_description'], ENT_QUOTES, 'UTF-8');
    $sanitized_data['qty_items'] = filter_var($data['qty_items'], FILTER_SANITIZE_NUMBER_INT);

    return $sanitized_data;
}

function validate_cnpj_ac($cnpj)
{
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



function validate_cpf_ac($cpf)
{
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


function identify_and_validate_cpf_cnpj_ac($value)
{
    $cleaned_value = clean_numeric($value); // Limpa o valor

    if (strlen($cleaned_value) == 11) {
        return validate_cpf_ac($cleaned_value); // Valida como CPF
    }

    if (strlen($cleaned_value) == 14) {
        return validate_cnpj_ac($cleaned_value); // Valida como CNPJ
    }

    return false; // Se não for CPF ou CNPJ válido
}

function clean_numeric($value)
{
    return preg_replace('/[^\d]/', '', $value);
}


function add_invoice_ac($invoice_data)
{
    // Obtenha a instância do CI
    $CI =& get_instance();
    $prifix = db_prefix();
    $tbloptions = $prifix . 'options';
    $tblinvoices = $prifix . 'invoices';

    // Acesse o último número de fatura armazenado nas configurações
    $last_number = (int) $CI->db->select('value')
        ->where('name', 'next_invoice_number')
        ->get($tbloptions)
        ->row()
        ->value;

    // Incrementa o número
    $next_number = $last_number;


    // Gerar um hash único para a fatura
    $invoice_hash = md5(uniqid(rand(), true));

    // Adicionar o número e o hash ao array de dados da fatura
    $invoice_data['number'] = $next_number;
    $invoice_data['hash'] = $invoice_hash;
    $invoice_data['prefix'] = 'INV-';
    $invoice_data['number_format'] = '1';
    $invoice_data['currency'] = '3';
    $invoice_data['datecreated'] = get_current_datetime();
    $invoice_data['status'] = '1';
    $invoice_data['adjustment'] = 0;
    if (!array_key_exists('allowed_payment_modes', $invoice_data)) {
        $invoice_data['allowed_payment_modes'] = '';  // Atribui uma string vazia se 'adminnote' não existir
    }
    if (!array_key_exists('adminnote', $invoice_data)) {
        $invoice_data['adminnote'] = '';  // Atribui uma string vazia se 'adminnote' não existir
    }

    if (!array_key_exists('terms', $invoice_data)) {
        $invoice_data['terms'] = '';  // Atribui uma string vazia se 'adminnote' não existir
    }
    $invoice_data['discount_percent'] = 0;
    $invoice_data['discount_total'] = 0;
    $invoice_data['adjustment'] = 0;
    $invoice_data['sale_agent'] = 1;
    $invoice_data['show_shipping_on_invoice'] = 1;
    $invoice_data['include_shipping'] = 0;
    $invoice_data['show_quantity_as'] = 1;
    $invoice_data['project_id'] = 0;
    $invoice_data['subscription_id'] = 0;

    // Inserir a nova fatura no banco de dadosr
    $CI->db->insert($tblinvoices, $invoice_data);

    // Obtém o ID da fatura recém-inserida
    $invoice_id = $CI->db->insert_id();

    $nuber_update = $CI->db->insert_id() + 2;

    // Atualiza o número na configuração
    $CI->db->where('name', 'next_invoice_number')
        ->update($tbloptions, ['value' => $nuber_update]);

    // Retorna o ID da nova fatura inserida
    return $invoice_id;
}



function add_items_to_invoice($invoice_id, $items)
{
    $CI =& get_instance();
    $prifix = db_prefix();
    $tblitemable = $prifix . 'itemable';

    foreach ($items as $item) {
        $item_data = [
            'rel_id' => $invoice_id,
            'rel_type' => 'invoice',
            'description' => $item['description'],
            'long_description' => isset($item['long_description']) ? $item['long_description'] : null,  // Inclui descrição longa
            'qty' => $item['qty'],
            'rate' => $item['rate'],
            'unit' => isset($item['unit']) ? $item['unit'] : null,
            'item_order' => isset($item['order']) ? $item['order'] : null,
            'wh_delivered_quantity' => isset($item['delivered_quantity']) ? $item['delivered_quantity'] : 0.00
        ];

        // Insere o item na tabela tblitemable
        $CI->db->insert($tblitemable, $item_data);
    }
}




function get_current_datetime()
{
    // Retorna a data e hora atual no formato 'YYYY-MM-DD HH:MM:SS'
    return date('Y-m-d H:i:s');
}


function convert_date_format($date)
{
    // Cria um objeto DateTime a partir da data no formato DD/MM/YYYY
    $dateObject = DateTime::createFromFormat('d/m/Y', $date);
    // Verifica se a data é válida
    if ($dateObject) {
        // Formata a data para o formato YYYY-MM-DD e retorna
        return $dateObject->format('Y-m-d');
    } else {
        // Retorna null ou uma mensagem de erro se a data for inválida
        return null; // Ou uma mensagem de erro personalizada
    }
}


function add_days_to_date($date, $days)
{
    // Cria um objeto DateTime a partir da data fornecida
    $dateObject = new DateTime($date);

    // Adiciona um intervalo de dias ao objeto DateTime
    $dateObject->modify("+$days days");

    // Retorna a data modificada no formato YYYY-MM-DD
    return $dateObject->format('Y-m-d');
}



function sanitize_html_ac($dirty_html) {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('Core.Encoding', 'UTF-8');  // Define a codificação de caracteres para UTF-8
    $config->set('HTML.Doctype', 'HTML 4.01 Transitional');  // Define o doctype

    // Configura as tags HTML que são permitidas
    $config->set('HTML.Allowed', 'br,b,strong,i,em');

    $purifier = new HTMLPurifier($config);

    // Limpa o HTML
    $clean_html = $purifier->purify($dirty_html);

    return $clean_html;
}

function getInvoiceUrl($invoiceId) {
    $CI =& get_instance();  // Obtenha a instância do CI se estiver usando CodeIgniter
    $prifix = db_prefix();
    $tblinvoices = $prifix . 'invoices';
    $CI->load->database();  // Certifique-se de que o banco de dados está carregado

    // Buscar o hash da fatura pelo ID
    $CI->db->select('hash');
    $CI->db->from($tblinvoices);
    $CI->db->where('id', $invoiceId);
    $query = $CI->db->get();

    if ($query->num_rows() == 1) {
        $hash = $query->row()->hash;
        // Construir a URL
        $baseUrl = getBaseUrlAc().'/invoice/'; // Modifique conforme necessário para o domínio principal
        $invoiceUrl = $baseUrl . $invoiceId . '/' . $hash;
        return $invoiceUrl;
    } else {
        return "Fatura não encontrada.";
    }
}

function getBaseUrlAc() {
    // Detectar o protocolo (HTTP ou HTTPS)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    // Nome do host
    $host = $_SERVER['HTTP_HOST'];

    // Construir e retornar a base da URL
    return $protocol . '://' . $host;
}

