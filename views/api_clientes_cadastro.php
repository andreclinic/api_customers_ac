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
        "plan" => $plan
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
$url2 = $protocol . "://" . $host ;
echo $url2;


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
                        <a href="<?php echo $url2 ?>" target="_blank"><button class="btn btn-entrar">Tenho Contrato</button></a>
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
                    <input type="text" class="form-control" id="state" name="state" placeholder="Ex: Goiás"
                        value="<?php echo htmlspecialchars($state); ?>" required>
                </div>


                <input type="hidden" id="country" name="country" value="32">
                <input type="hidden" id="plan" name="plan" value="Mensal">
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
                $('#notificationMessage').text('<?php echo $api_response['message']; ?>');
                $('#notificationModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>

</html>