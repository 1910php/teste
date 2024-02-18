<?php

require_once 'src/config.php';

if (isset($_POST['acao']) && $_POST['acao'] === 'create') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //print_r($_POST);

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cep = $_POST['cep'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];
        $bairro = $_POST['bairro'];
        $telefones = $_POST['telefone'];

        if (isset($telefones) && !empty($telefones)) {
            $telefonesJson = json_encode($telefones);

        } else {
            $telefonesJson = '[""]';
        }

        $sql = "INSERT INTO user (nome, email, telefone, cep, cidade, estado, endereco,bairro) VALUES ('$nome', '$email', '$telefonesJson', '$cep', '$cidade', '$estado', '$endereco', '$bairro')";

        // Executa a instrução SQL
        if ($conn->query($sql) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao adicionar contato: " . $conn->error;
            // header("Location: index.php");
            exit();
        }

    }
} elseif (isset($_POST['acao']) && $_POST['acao'] === 'update') {

    $id = $_POST['id']; // ID do contato a ser atualizado
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $telefones = $_POST['telefone'];

    if (isset($telefones) && !empty($telefones)) {
        $telefonesJson = json_encode($telefones);
    } else {
        $telefonesJson = '[]'; // Define como um array vazio
    }

    $sql = "UPDATE user SET nome='$nome', email='$email', telefone='$telefonesJson', cep='$cep', cidade='$cidade', estado='$estado', endereco='$endereco', bairro='$bairro' WHERE id_user=$id";

    // Executa a instrução SQL
    if ($conn->query($sql) === true) {
        header("Location: index.php"); // Redireciona de volta para a página principal
        exit();
    } else {
        echo "Erro ao atualizar contato: " . $conn->error;
        exit();
    }
}

// Array ( [action] => create [nome] => Cassiano [email] => teste@gmail.com [cep] => 06732588 [cidade] => Vargem Grande Paulista [estado] => SP [bairro] => Jardim São Marcos [endereco] => Rua Olegário Maciel [Telefone] => Array ( [0] => ) )
// exit;

function getAllContacts()
{
    global $conn;

    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    $contacts = [];
    if ($result->num_rows > 0) {
        // Exibe os dados de cada linha
        while ($row = $result->fetch_assoc()) {
            $contacts[] = [
                'nome' => $row["nome"],
                'email' => $row["email"],
                'id_user' => $row["id_user"],
            ];
        }
    }

    return $contacts;
}

function getAllContactsUpdate()
{

    global $conn;

    // Consulta SQL para selecionar os contatos com limite e deslocamento para a paginação
    $sql = "SELECT * FROM user where id_user = {$_GET['id']} limit 1";
    $result = $conn->query($sql);

    $contactsUpdate = [];
    if ($result->num_rows > 0) {
        // Exibe os dados de cada linha
        while ($row = $result->fetch_assoc()) {
            $contactsUpdate[] = [
                'nome' => $row["nome"],
                'id_user' => $row["id_user"],
                'email' => $row["email"],
                'telefone' => $row["telefone"],
                'cep' => $row["cep"],
                'cidade' => $row["cidade"],
                'estado' => $row["estado"],
                'endereco' => $row["endereco"],
                'bairro' => $row["bairro"],
            ];
        }
    }

    return $contactsUpdate;
}

function getAllContactsPaginated($offset, $limit)
{
    global $conn;

    // Consulta SQL para selecionar os contatos com limite e deslocamento para a paginação
    $sql = "SELECT * FROM user ORDER BY `user`.`nome` ASC LIMIT $offset, $limit";
    $result = $conn->query($sql);

    $contactsUpdate = [];
    if ($result->num_rows > 0) {
        // Exibe os dados de cada linha
        while ($row = $result->fetch_assoc()) {
            $contactsUpdate[] = [
                'nome' => $row["nome"],
                'id_user' => $row["id_user"],
                'email' => $row["email"],
                'telefone' => $row["telefone"],
                'cep' => $row["cep"],
                'cidade' => $row["cidade"],
                'estado' => $row["estado"],
                'endereco' => $row["endereco"],
                'bairro' => $row["bairro"],
            ];
        }
    }

    return $contactsUpdate;
}

// Defina o número de registros por página
$registros_por_pagina = 4;

// Obtenha o número total de contatos
$sqlTotalContatos = "SELECT COUNT(*) AS total_contatos FROM user";
$resultTotalContatos = $conn->query($sqlTotalContatos);
$total_contatos = $resultTotalContatos->fetch_assoc()['total_contatos'];

// Calcule o número total de páginas
$total_paginas = ceil($total_contatos / $registros_por_pagina);

// Verifique se foi especificada uma página na URL
if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina_atual = $_GET['pagina'];
} else {
    $pagina_atual = 1;
}

// Verifique se a página atual está dentro do intervalo válido
if ($pagina_atual < 1) {
    $pagina_atual = 1;
} elseif ($pagina_atual > $total_paginas) {
    $pagina_atual = $total_paginas;
}

// Calcule o deslocamento para a consulta SQL
$offset = ($pagina_atual - 1) * $registros_por_pagina;

// Obtenha os contatos para a página atual
$contacts = getAllContactsPaginated($offset, $registros_por_pagina);
