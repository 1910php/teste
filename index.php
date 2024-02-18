<?php
require_once 'contato.php';

// Defina o número de registros por página
$registros_por_pagina = 4;

// Obtenha o número total de contatos
$total_contatos = count(getAllContacts());

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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="/teste/listagem.php">Listagem</a>
      <!-- <a class="nav-item nav-link" href="#">Pricing</a> -->
    </div>
  </div>
</nav>

<div class="container card">
    <div class="mb-2 link-create">
        <div class="row">
            <a href="/teste/create.php"><span class="text-craete">Adicionar novo contato</span></a>
        </div>
    </div>
    <div class="card-body">
        <h2 class="card-title">Listagem dos Contatos</h2>
        <?php if (!empty($contacts)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo $contact['nome']; ?></td>
                            <td><?php echo $contact['email']; ?></td>
                            <td class="table-btn">
                                <div class="btn-delete">
                                    <samp onclick="deletarContato('<?php echo $contact['id_user']; ?>','delete')" class="text-full" >Remove</samp>
                                </div>
                                <div class="btn-update">
                                    <a href="/teste/update.php?id=<?php echo $contact['id_user']; ?>" > <samp class="text-full">Alterar</samp> </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <!-- Exibição da paginação -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <spam class="pagina"><a href="?pagina=<?php echo $i; ?>" <?php if ($i == $pagina_atual) {
    echo 'class="active"';
}
?>><?php echo $i; ?></a></spam>
                <?php endfor;?>
            </div>

        <?php else: ?>
            <p>No contacts found.</p>
        <?php endif;?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="script.js"></script>

</body>
</html>
