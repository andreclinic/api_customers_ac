<?php
$keyValueApiSend = $key_value;
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$neighborhood = isset($_POST['neighborhood']) ? $_POST['neighborhood'] : '';
$cpfResponsible = isset($_POST['cpfResponsible']) ? $_POST['cpfResponsible'] : '';
$addressNumberId = isset($_POST['addressNumberId']) ? $_POST['addressNumberId'] : '';
$cpfCnpjl = isset($_POST['cpfCnpjl']) ? $_POST['cpfCnpjl'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$zipCode = isset($_POST['zipCode']) ? $_POST['zipCode'] : '';
$plan = isset($_GET['plan']) ? $_GET['plan'] : 'Plano Mensal';

if ($plan == 'Plano Mensal') {
    $recurring = 1;
    $rate = 159;
    $description = 'Plano Mensal';
    $long_description = 'Mensal com 3 usuários e 1 número de WhatsApp.';
    // echo $plan . "<br>";
} else if ($plan == 'Plano Semestral') {
    $recurring = 6;
    $rate = 594;
    $description = 'Plano Semestral';
    $long_description = 'Semestral com 3 usuários e 1 número de WhatsApp.';
    // echo $plan . "<br>";
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $data = [
        "keyValueApiSend" => $keyValueApiSend,
        "name" => $name,
        "email" => $email,
        "telephone" => $telephone,
        "address" => $address,
        "neighborhood" => $neighborhood,
        "cpfResponsible" => $cpfResponsible,
        "addressNumberId" => $addressNumberId,
        "cpfCnpjl" => $cpfCnpjl,
        "city" => $city,
        "state" => $state,
        "country" => $country,
        "zipCode" => $zipCode,
        "plan" => $plan,
        "date" => date('d/m/Y'),
        "recurring" => $recurring,
        "adminnote" => "Cadasto do cliente feito pelo sistema.",
        "rate" => $rate,
        "description" => $description,
        "long_description" => $long_description,
        "qty_items" => 1,
        "allowed_payment_modes" => "a:1:{i:0;s:6:'stripe';}",
        "terms" => "A Chat Simples é um produto da empresa Web Inovação inscrita sob o CNPJ número 18.274.267/0001-32 situada no estado de Goiás, doravante designada simplesmente CONTRATADA.<br /><br />A CONTRATANTE será identificada pelo preenchimento do formulário de contratação de serviços e aceite dos termos deste instrumento em nosso site.<br /><br />A CONTRATANTE declara que possui capacidade legal para contrair as obrigações constantes deste contrato. Não podem utilizá-los, assim, pessoas que não gozem dessa capacidade, inclusive menores de 18 anos de idade.<br /><br />1 OBJETO DO CONTRATO<br /><br />1.1. Os serviços que constituem o objeto do presente Contrato consistem em um conjunto de ferramentas, recursos e funcionalidades web voltadas à Comunicação por meio do WhatsAppWeb, integradas em um Sistema para o atendimento automático on line dos contatos ali cadastrados pela CONTRATANTE.<br />O programa serve para empresas que queiram utilizar o WhatsApp como canal de comunicação e/ou vendas. A integração com o WhatsApp permite que o CONTRATANTE tenha vários usuários logados ao mesmo tempo, que poderão se comunicar com os seus contatos por meio de um único número de WhatsApp, podendo ainda configurar o robô para enviar mensagens programadas através de uma sequência previamente configurada pelo CONTRATANTE.<br />O serviço será executado de acordo com o Sistema colocado à disposição da CONTRATANTE pela CONTRATADA por meio do painel administrativo onde, além de visualizar o seu fluxo de comunicação, também poderá interagir respondendo as mensagens em tempo real.<br /><br />1.2. Os serviços deste CONTRATO, a serem realizados pela CONTRATADA à CONTRATANTE consideram o plano selecionado no formulário de contratação de serviços e possuem a seguinte estrutura: Cada plano, de acordo com as especificações do formulário de contratação, dá direito à criação de certa quantidade de usuários vinculados à 01 (um) número WhatsApp. O servidor poderá ser ligado a um WhatsApp por vez, possibilitando a utilização simultânea destes usuários.<br /><br />1.3. Caso seja necessário a ativação de mais números, esses planos devem ser adquiridos separadamente.<br /><br />1.4. Caso o usuário fique offline por instabilidade de sinal de internet, as mensagens ficarão paradas na fila de envios. Assim que o Chat Simples se reconectar, o sistema enviará todas as mensagens pendentes.<br /><br />1.5. O Chat Simples combina as API oficiais do WhatsApp com suas próprias API, mas não somos um produto licenciado da empresa WhatsApp, sendo assim, o cliente entende que pode ser punido pelo WhatsApp devido ao mau uso do mesmo.<br /><br />1.6. A falta de funcionamento momentânea do Chat Simples pode derivar de alguma atualização em nossos sistemas. Nestes casos, deve-se aguardar por mais detalhes ou procurar o suporte do setor de desenvolvimento para obter informações. Em caso de atualização de software do próprio WhatsApp, o sistema poderá vir a sofrer instabilidades até a devida correção, desde que seja possível.<br /><br />1.7. Não controlamos e não nos responsabilizamos por como nossos usuários utilizam os nossos serviços, recursos, interfaces fornecidas, nem as ações ou as informações (incluindo conteúdo) de nossos usuários ou de terceiros, de forma que o CONTRATANTE isenta nossa equipe, funcionários, parceiros e representantes de todas reivindicações, demandas, controvérsias, conflitos, indenizações, seja oriundas destes casos, seja em face de terceiros.<br /><br /><br /><br />VIGÊNCIA DO CONTRATO<br /><br /><br />2.1. Devido a natureza do serviço, bem como seu sigilo, o contrato entra em vigor no ato de criação da conta do cliente na plataforma.<br /><br />2.2. O presente contrato terá vigência MENSAL, SEMESTRAL ou ANUAL, limitada à quantidade de usuários e de usuários do plano selecionado no formulário de contratação dos serviços em nosso site e/ou link de pagamento enviado por e-mail e/ou pelo WhatsApp da Chat Simples.<br /><br />2.3. O atraso no pagamento implica em suspensão do serviço após o período de 24 horas da data de vencimento.<br /><br /><br /><br />ADIÇÃO E SUBTRAÇÃO DE USUÁRIOS E NÚMEROS<br /><br /><br />3.1. Poderá ser solicitado a adição ou subtração de usuários e/ou números contratados a qualquer momento na plataforma.<br /><br />3.2. Nos casos de adição será cobrado o valor de todo o exercício mensal (30 dias) até o próximo vencimento. Depois dessa data, a quantidade de usuários e/ou números anteriores serão somadas a adição, gerando uma nova mensalidade com o novo resultado do número de usuários e/ou números.<br /><br />3.3. Nos casos de subtração, o valor já contratado não será devolvido, porém, na data do próximo vencimento, esse(s) usuários subtraídos do total de usuários e/ou números já contratados e um nova mensalidade com o com o novo resultado do número de usuários e/ou números. A subtração implica na perda dos dias pagos até a data de vencimento.<br /><br />3.4. O valor a ser cobrado pelo usuário(s) e/ou números, adicionado(s) ou subtraído(s) será(ão) os que estão acordados entre as partes em um plano personalizado, ajustando o número de atendentes e/ou números com suas necessidades específicas.<br /><br />ARMAZENAMENTO DOS DADOS<br /><br /><br />4.1. A CONTRATADA se compromete a armazenar os dados dos contatos, bem como o texto das conversas proveniente do uso, por todo tempo do contrato.<br /><br />4.2. A CONTRATADA se compromete a armazenar as mídias e arquivos das conversas provenientes do uso, por 3 (três) meses a contar a partir da data de envio ou recebimento da mesma.<br /><br />CANCELAMENTO<br /><br /><br />5.1. Poderá ser rescindido o serviço a qualquer momento por qualquer das partes, sem devolução dos valores já contratados, ou seja, não haverá fracionamento do plano contratado, sendo a periodicidade mínima de 30 dias.<br /><br />5.2. A rescisão implica na perda dos dias pagos até a data de vencimento.<br /><br />5.3. Será bloqueado o serviço no caso de mora da CONTRATANTE de mais de 24 horas, a partir da data de vencimento<br /><br />5.4. O contrato também poderá ser rescindido caso uma das partes descumpra o estabelecido nas cláusulas do presente instrumento, não cabendo à nenhuma das partes parte o pagamento de multa rescisória, perdas e danos ou qualquer outro tipo de reparação cível decorrente da utilização do serviço à outra.<br /><br />5.5. O presente contrato terá vigência MENSAL, SEMESTRAL ou ANUAL selecionado no formulário de contratação dos serviços em nosso site.<br /><br />5.6. O atraso no pagamento implica na suspensão do serviço após o período de 24 horas da data de vencimento.<br /><br />5.7 O contratante fica ciente que em caso de desistência, considerando as regras vigentes pelo Código de Defesa do Consumidor, o prazo para requerer o reembolso em virtude do arrependimento da compra é de 7 dias.<br /><br />No plano mensal: Após decorridos os 7 dias para exercício do direito de arrependimento, o cancelamento poderá ocorrer a qualquer tempo, sendo que a renovação automática deixará de ocorrer a partir do final da vigência do mês já pago;<br /><br />No plano semestral: Após decorridos os 7 dias para exercício do direito de arrependimento, a desistência ou pedido de cancelamento não gera direito ao ressarcimento dos valores já pagos, o cancelamento só valerá após a expiração dos 6 meses da vigência do plano contratado inicialmente. Ao cancelar seu plano, você continuará tendo acesso ao Chat Simples pelo período restante em seu contrato e o pagamento das parcelas mensais, caso você tenha escolhido o parcelamento, não será suspenso, uma vez que trata-se de forma de pagamento avençada entre o contratante e sua instituição financeira, contudo, a renovação automática, neste caso, não acontecerá;<br /><br />No plano anual: Após decorridos os 7 dias para exercício do direito de arrependimento, a desistência ou pedido de cancelamento não gera direito ao ressarcimento dos valores já pagos, o cancelamento só valerá após a expiração dos 12 meses da vigência do plano contratado inicialmente. Ao cancelar seu plano, você continuará tendo acesso ao Chat Simples pelo período restante em seu contrato e o pagamento das parcelas mensais, caso você tenha escolhido o parcelamento, não será suspenso, uma vez que trata-se de forma de pagamento avençada entre o contratante e sua instituição financeira, contudo, a renovação automática, neste caso, não acontecerá.<br /><br />DAS RESPONSABILIDADES DAS PARTES<br /><br /><br />6.1. Cabe à parte CONTRATADA:<br /><br />Realizar e cumprir os serviços selecionados no formulário de contratação de acordo com a descrição do OBJETO DO CONTRATO;<br />Garantir a realização integral do(s) serviço(s) contratado(s) pela CONTRATANTE.<br />Efetuar a qualquer tempo a correção de qualquer bug ou falha do sistema.<br />Reserva-se à parte CONTRATADA o direito de apagar a conta da CONTRATANTE a qualquer ação ilícita, como os citados no item 5.6. sem nenhum aviso prévio.<br />A CONTRATADA precisa disponibilizar para acesso os navegadores GOOGLE CHROME, MOZILLA FIREFOX ou SAFARI, ambos em suas últimas versões. A fim de manter a Plataforma Chat Simples sempre online e estável, é de responsabilidade do USUÁRIO, caso esteja na posse do aparelho celular: Manter o equipamento SEMPRE conectado à rede segura de internet; Garantir que o programa Chat Simples esteja conectado ao celular por meio de leitura do QR CODE; Manter o aplicativo do WhatsApp sempre atualizado;<br />Durante o período de uso da plataforma, é aconselhável que não use  o celular por parte da CONTRATADA, caso o tenha em posse, para envios de mensagens via aplicativo WhatsApp. Esse fim, que é a razão de contratação da Plataforma Chat Simples, irá atrapalhar toda lógica de distribuição e gerará transtornos, por vezes irreparáveis.<br />A compreensão dos itens a serem usados é dever da CONTRATADA. Assim, a má compreensão destes termos não pode ser alegada como motivo de descumprimento contratual com o Chat Simples.<br />As mensagens recebidas via WhatsApp antes da contratação e ativação da plataforma Chat Simples, bem como os contatos salvos no aparelho celular que servirá como base para o serviço, não são automaticamente migrados para a plataforma.<br />O Recurso de Mensagem Agendadas se utilizado de forma exaustiva ou para contatos que não autorizaram o recebimento destas mensagens pela Contratante poderá gerar o bloqueio do seu número. O Whatsapp não permite SPAM (mensagens em massa). Nós da Chat Simples  não nos responsabilizamos pelo bloqueio do número conectado a Plataforma Chat Simples, que é utilizado para o envio de mensagens em agenda<br /><br /><br />6.2. Cabe à parte CONTRATANTE:<br /><br />A total responsabilização pela má utilização do serviço.<br />A responsabilização pelo uso e distribuição da senha de acesso à(s) sua(s) conta(s).<br />Não incluir ou distribuir imagens, vídeos e demais conteúdos pornográficos ou para finalidades ilegais no Brasil e em qualquer outro país. Sendo identificada esta situação, o Chat Simples poderá excluir definitivamente todos os cadastros e as informações do usuário.<br />Disponibilizar o celular contendo o aplicativo WhatsApp conectado à internet, devendo fazer a leitura do QR Code disponível para acesso ao sistema.<br />A responsabilização pela configuração do robô para enviar mensagens programadas através de uma sequência previamente configurada pelo CONTRATANTE.<br /><br />Entender que esse é um serviço não licenciado, e que qualquer ação de repreensão ou bloqueio por parte do WhatsApp é de sua responsabilidade devido ao seu uso.<br />Caso deseje a integração de terceiro sistema com o Chat Simples, é responsabilidade do CONTRATANTE manter o sistema integrado online.<br /><br /><br />DAS ATUALIZAÇÕES<br /><br />Não garantimos que nossos serviços estarão em funcionamento, livres de erros, protegidos ou seguros e que nossos serviços funcionarão sem interrupções, atrasos ou imperfeições, por isso fica acertado entre as partes que a CONTRATADA poderá, sem interferência da CONTRATANTE, realizar todas as alterações que reconhecer como necessárias de uma versão para outra do Chat Simples.<br /><br /><br />DO PRAZO DE ENTREGA DOS SERVIÇOS<br /><br />8.1. O(s) serviço(s) passa a ser contratado e realizado após o envio do formulário de contratação de serviço(s) e o aceite dos termos deste instrumento, com a disponibilização do Painel Administrativo para a configuração do(s) serviço(s) contratado(s). A disponibilização se dará de forma permanente enquanto durar o tempo de vigência do contrato, conforme cláusula 2ª.<br /><br />8.2. Caso a CONTRATADA queira aplicar qualquer desconto, inserção de pagamento, parcial ou integral, ou qualquer outra bonificação, ou período de teste grátis, ou ainda, prorrogação da data de pagamento, isso não implica a mudança da data início do contrato, que entra em vigor, conforme citado em 8.1.<br /><br /><br /><br />DA PROPRIEDADE<br /><br />9.1. Os serviços desenvolvidos pela CONTRATANTE à CONTRATADA, são de exclusiva propriedade da CONTRATADA.<br /><br />9.2. A CONTRATADA se compromete a não modificar a API de forma alguma, particularmente, sem limitação, não deve fazer engenharia reversa, adaptar, descompilar, desmontar ou tentar acessar ou descobrir o código-fonte da Chat Simples.<br /><br /><br /><br />DA PRIVACIDADE E SEGURANÇA DOS DADOS<br /><br />10.1. A CONTRATADA não divulgará nenhuma informação pessoal ou da pessoal física da CONTRATANTE<br /><br />10.2. Todas as conversas e arquivos são de propriedade do CONTRATANTE e não serão usados para nenhum outro fim pelo CONTRATADO.<br /><br />10.3. A CONTRATADA não terá acesso ao painel de controle ou a qualquer das conversas, clientes da CONTRATANTE, salvo em modalidade de suporte, e onde haja expressa autorização do CONTRATANTE concedendo o acesso, seja por telefone, email ou WhatsApp.<br /><br /><br /><br />DOS VALORES DOS SERVIÇOS<br /><br />11.1. O(s) Valor(es) estão publicados no formulário de contratação em nosso site https://chatsimples.com.br/. O valor a ser pago pelo CONTRATANTE será equivalente ao(s) serviço(s) selecionado(s) no formulário e descritos nos detalhes de pagamento.<br /><br />11.2. Os contratos firmados não contém fidelidade, ou seja, o cliente pode cancelar a qualquer momento como expressado na cláusula 5.1.<br /><br />11.3. A CONTRATADA fica livre de executar qualquer tipo de ajuste no preço dos serviços contratados, tendo que informar o novo preço pelos serviços contratados com no mínimo 30 dias de antecedência da data de vencimento do mesmo. É de livre escolha do cliente permanecer ou não após essa notificação, conforme cláusula 5.1.<br /><br /><br /><br />DAS CONDIÇÕES GERAIS<br /><br /><br />12.1. A CONTRATANTE autoriza a utilização de seu nome pela CONTRATADA, podendo esta apresentá-la como sua cliente em peças de propaganda.<br /><br />12.2. O Chat Simples é um serviço desenvolvido principalmente para o atendimento automático de comunicação iniciado por terceiros. Por isso, se houver reclamações, pelo envio de mensagens para pessoas que não pediram para receber seus conteúdos (SPAM), o WhatsApp poderá categorizar o acesso da CONTRATANTE como spam, podendo ocorrer o banimento.<br /><br />12.3. A CONTRATANTE pode ser banida / bloqueada pelo WhatsApp se não respeitar as regras de aprovação dos conteúdos enviados, que são bem rígidas, e o descumprimento dos termos fornecidos pelo WhatsApp Inc. pode importar em bloqueio do número. A responsabilização pelo banimento no WhatsApp em caso de violação das regras de utilização do aplicativo é exclusiva da CONTRATANTE.<br /><br />12.4 Em virtude do modelo de negócio contratado e do serviço adquirido, a Chat Simples apenas oferece assistência e suporte, os quais devem ser tratados via e-mail suporte@chatsimples.com.br, ou via WhatsApp no link https://api.whatsapp.com/send?phone=5562998745895. É aconselhável assistir aos vídeos de uso da Plataforma Chat Simples antes da efetiva utilização do sistema, a fim de que o mesmo possa ser operado com a máxima eficiência.<br /><br /><br /><br />DA LEI GERAL DE PROTEÇÃO DE DADOS (LGPD)<br /><br />A Chat Simples e a CONTRATANTE se comprometem a observar e cumprir integralmente com as obrigações previstas na Lei 13.709/2018, desde o início da sua vigência, bem como à legislação de dados vigente no país em que ocorrer o respectivo tratamento, inclusive com relação à eventuais obrigações de compartilhamento de dados constantes no presente contrato.<br /><br />A Chat Simples declara e se compromete por ela, seus prepostos, ou terceiros atuando em seu nome, a não violar o disposto na Lei Geral de Proteção de Dados, bem como demais legislações, regulamentos e disposições análogas que tratam da proteção de dados pessoais, nacionais ou estrangeiros.<br /><br />A Chat Simples se obriga a não realizar qualquer tratamento indevido, irregular ou ilegal, de forma direta ou indireta, ativa e/ou passiva, de dados pessoais a que tenha acesso em razão da execução dos serviços descritos no presente instrumento.<br /><br />A Chat Simples declara não realizar a retenção dos dados pessoais a que tiver acesso em razão deste contrato, por período superior ao necessário para o cumprimento das suas obrigações, nos termos do art. 5º, inciso X, da Lei 13.709/2018.<br /><br />As partes promoverão o acesso facilitado às informações sobre tratamento dos dados utilizados para a realização dos serviços ora contratados, aos Titulares de Dados, de forma clara, adequada e ostensiva.<br /><br />A Chat Simples se obriga a informar a CONTRATANTE, por seu DPO (Encarregado de Dados), de forma escrita, sempre que solicitada, todos os assuntos relacionados aos dados pessoais aos quais tenha acesso em decorrência do presente instrumento."
    ];

    // Converte os dados para JSON
    $json_data = json_encode($data);

    // Protocolo HTTP (http ou https)
    $protocolBase = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    // Nome do host
    $hostBase = $_SERVER['HTTP_HOST'];

    $ulrBase = $protocolBase . "://" . $hostBase;

    // URL da API
    $api_url = $ulrBase . "/api/create_customer";

    // Inicializa a sessão cURL
    $curl = curl_init($api_url);

    // Configuração da requisição cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ]);

    // Executa a requisição cURL
    $response = curl_exec($curl);

    // Decodifica a resposta da API
    $api_response = json_decode($response, true);


    // Verifica se a resposta possui uma mensagem
    if (isset($api_response['message'])) {
        if ($api_response['message'] == "Cadastrado com sucesso") {
            // echo "<script>alert('Mensagem da API: {$api_response['message']}');</script>";
            echo "<script>$('#notificationMessage').text('Resposta da API: {$api_response['message']}'); $('#notificationModal').modal('show');</script>";
            // Recarrega a página após 5 segundos
            echo "<meta http-equiv='refresh' content='5'>";
        }
        echo "<script>$('#notificationMessage').text('Resposta da API: {$api_response['message']}'); $('#notificationModal').modal('show');</script>";
    }
    // Fecha a sessão cURL
    curl_close($curl);
}
?>


<?php
// Protocolo HTTP (http ou https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// Nome do host
$host = $_SERVER['HTTP_HOST'];

// Parte da URL após o nome do host
$request_uri = $_SERVER['REQUEST_URI'];

// URL completa
$url = $protocol . "://" . $host . $request_uri;
$url2 = $protocol . "://" . $host;
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 0px;
            margin: 0px;
            background-color: #f8fafc;
        }

        .navbar {
            background-color: #ffffff;
            /* Fundo branco */
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            /* Linha suave */
        }

        /* Estilos para dispositivos móveis */
        @media only screen and (max-width: 768px) {
            .navbar {
                background-color: #ffffff;
                /* Fundo branco */
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                /* Linha suave */
                padding-bottom: 20px;
                /* Espaçamento inferior */
            }
        }

        .navbar-brand {
            width: 200px;
            /* Define a largura da imagem */
            font-family: 'Inter', sans-serif;
            /* Fonte Inter */
            font-weight: 400;
            color: #0f172a;
            /* Cor dos links */
            font-size: 15px;
            /* Tamanho da fonte */
            line-height: 85px;
            /* Altura da linha */
        }

        .navbar-brand img {
            width: 100%;
            height: auto;
        }

        .navbar-nav .nav-link {
            font-family: 'Inter', sans-serif;
            /* Fonte Inter */
            font-weight: 400;
            color: #0f172a;
            /* Cor dos links */
            font-size: 15px;
            /* Tamanho da fonte */
            line-height: 85px;
            /* Altura da linha */
        }

        .navbar-nav .nav-link:hover {
            color: #2563eb;
            /* Cor do hover */
        }

        .nav-item {
            display: flex;
            align-items: center;
        }

        .nav-item .active {
            background-color: #2563eb;
            /* Fundo azul */
        }

        .nav-item .active a {
            color: #ffffff;
            /* Cor do texto */
            font-weight: 400;
            /* Peso da fonte */
            background-color: #2563eb;
            /* Fundo azul */
            border-radius: 25px;
            /* Bordas arredondadas */
            padding: 10px 20px;
            /* Espaçamento interno */
            font-family: 'Inter', sans-serif;
            /* Fonte Inter */
            font-size: 16px;
            /* Tamanho da fonte */
        }

        .nav-item .active a:hover {
            background-color: #1a4cb5;
            /* Cor do hover */
        }

        .btn-entrar {
            font-family: 'Inter', sans-serif;
            /* Fonte Inter */
            font-weight: 400;
            color: #ffffff;
            /* Cor do texto */
            font-size: 16px;
            /* Tamanho da fonte */
            line-height: 18px;
            /* Altura da linha */
            background-color: #2563eb;
            /* Fundo azul */
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            /* Bordas arredondadas */
        }

        .btn-entrar:hover {
            background-color: #1a4cb5;
            /* Cor do hover */
        }

        .formulario {
            padding-top: 50px;
            padding-bottom: 50px;
            padding-left: 60px;
            padding-right: 60px;
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            /* Sombra leve */
        }

        /* Estilos para dispositivos móveis */
        @media (max-width: 768px) {
            .form-cotainer {
                padding-left: 50px;
                padding-right: 50px;

            }

            .formulario {

                padding-left: 50px;
                padding-right: 20px;
                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);

            }
        }

        .form-cotainer {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .footer {
            background-color: #f1f5f9;
            padding: 20px 0;
            color: #666;
            font-size: 14px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://erp.alsweb.com.br/uploads/company/2684ef65e8dac0acb79ccbc8f041b968.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#">Ajuda Online</a> -->
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#">Registrar-se</a> -->
                    </li>
                    <li class="nav-item active">
                        <a href="<?php echo $url2 ?>" target="_blank"><button class="btn btn-entrar">Tenho
                                Contrato</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h2 class="text-center mt-5"><?php echo $plan; ?></h2>
    <div clss="form-cotainer">
        <div class="container mt-5 formulario">
            <form action="<?php echo $url; ?>" method="post">


                <div class="form-group">
                    <label for="cpfCnpjl">CPF/CNPJ</label>
                    <input type="text" class="form-control" id="cpfCnpjl" name="cpfCnpjl"
                        placeholder="Ex: 123.456.789-00 ou 12.345.678/0001-90"
                        value="<?php echo htmlspecialchars($cpfCnpjl); ?>" required>
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Informe seu nome completo" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Ex: email123@gmail.com" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telephone">Telefone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                        placeholder="Ex: (11) 99999-9999" value="<?php echo htmlspecialchars($telephone); ?>" required>
                </div>

                <div class="form-group">
                    <label for="zipCode">CEP</label>
                    <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="Ex: 12345-678"
                        value="<?php echo htmlspecialchars($zipCode); ?>" required>
                </div>

                <div class="form-group">
                    <label for="addressNumberId">Número</label>
                    <input type="text" class="form-control" id="addressNumberId" name="addressNumberId"
                        placeholder="Número do Endereço Ex: 90"
                        value="<?php echo htmlspecialchars($addressNumberId); ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Rua, avenida, logradouro</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Ex: Rua A, 123"
                        value="<?php echo htmlspecialchars($address); ?>" required>
                </div>

                <div class="form-group">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" class="form-control" id="neighborhood" name="neighborhood"
                        placeholder="Ex: Centro" value="<?php echo htmlspecialchars($neighborhood); ?>" required>
                </div>

                <!-- <div class="form-group">
                    <label for="cpfResponsible">CPF do Responsável</label>
                    <input type="text" class="form-control" id="cpfResponsible" name="cpfResponsible"
                        placeholder="CPF do Responsável" value="<?php echo htmlspecialchars($cpfResponsible); ?>"
                        required>
                </div> -->

                <div class="form-group">
                    <label for="city">Cidade</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Ex: Goiânia"
                        value="<?php echo htmlspecialchars($city); ?>" required>
                </div>

                <div class="form-group">
                    <label for="state">Estado</label>
                    <select class="form-control" id="state" name="state" required>
                        <option value="Acre">Acre</option>
                        <option value="Alagoas">Alagoas</option>
                        <option value="Amapá">Amapá</option>
                        <option value="Amazonas">Amazonas</option>
                        <option value="Bahia">Bahia</option>
                        <option value="Ceará">Ceará</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Espírito Santo">Espírito Santo</option>
                        <option value="Goiás" selected>Goiás</option>
                        <option value="Maranhão">Maranhão</option>
                        <option value="Mato Grosso">Mato Grosso</option>
                        <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                        <option value="Minas Gerais">Minas Gerais</option>
                        <option value="Pará">Pará</option>
                        <option value="Paraíba">Paraíba</option>
                        <option value="Paraná">Paraná</option>
                        <option value="Pernambuco">Pernambuco</option>
                        <option value="Piauí">Piauí</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                        <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                        <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                        <option value="Rondônia">Rondônia</option>
                        <option value="Roraima">Roraima</option>
                        <option value="Santa Catarina">Santa Catarina</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Sergipe">Sergipe</option>
                        <option value="Tocantins">Tocantins</option>
                    </select>
                </div>


                <input type="hidden" id="country" name="country" value="32">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <button type="submit" class="btn btn-primary">CONTRATAR</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2024 Copyright ALS Web</p>
        </div>
    </footer>


    <!-- Modal de Notificação -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notificação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="notificationMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts do Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function () {
        <?php if (isset($api_response['message'])): ?>
            // Define o texto e mostra o modal
            $('#notificationMessage').text('<?php echo addslashes($api_response['message']); ?>');
            $('#notificationModal').modal('show');

            <?php if (isset($api_response['url_payment'])): ?>
                // Redireciona depois de 3 segundos
                setTimeout(function() {
                    window.location.href = "<?php echo $api_response['url_payment']; ?>";
                }, 3000);
            <?php endif; ?>
        <?php endif; ?>
    });
</script>

</body>

</html>