<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require_once 'contato.php';?>
                <?php $contactsUpdate = getAllContactsUpdate();if (!empty($contactsUpdate)): ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - editar contato <?php echo $contactsUpdate[0]['id_user'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/teste">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

</nav>

    <div class="container">
    <h1>Editar Contato</h1>
    <div class="campo-formulario">



        <h2>Formulário</h2>
        <form class="row g-3" action="contato.php" method="post">

  <div class="col-md-6">

  <input type="hidden" name="acao" value="update">

  <input type="hidden" name="id" value=" <?php echo $contactsUpdate[0]['id_user'] ?> " >

    <label for="validationDefault01" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $contactsUpdate[0]['nome'] ?>" required>
  </div>

  <div class="col-md-6">
    <label for="validationDefaultUsername" class="form-label">E-mail</label>
    <div class="input-group">
      <span class="input-group-text" id="inputGroupPrepend2">@</span>
      <input type="text" class="form-control" name="email"  id="email" value="<?php echo $contactsUpdate[0]['email'] ?>"  aria-describedby="inputGroupPrepend2" required>
    </div>
  </div>



  <div class="col-md-3">
    <label for="validationDefault05"  class="form-label">CEP</label>
    <input type="text"  name="cep" placeholder="00000-000" value="<?php echo $contactsUpdate[0]['cep'] ?>" class="form-control" id="cep" required>
  </div>


  <div class="col-md-3">
    <label for="validationDefault03" class="form-label">Estado</label>
    <input type="text" class="form-control" name="estado" value="<?php echo $contactsUpdate[0]['estado'] ?>" id="estado" >
  </div>

  <div class="col-md-6">
    <label for="validationDefault03" class="form-label">Cidade</label>
    <input type="text" class="form-control" name="cidade" value="<?php echo $contactsUpdate[0]['cidade'] ?>" id="cidade" >
  </div>


  <div class="col-md-6">
    <label for="validationDefault03" class="form-label">Endereço</label>
    <input type="text" class="form-control" name="endereco" value="<?php echo $contactsUpdate[0]['endereco'] ?>" id="endereco" >
  </div>

  <div class="col-md-6">
    <label for="validationDefault03" class="form-label">Bairro</label>
    <input type="text" class="form-control" name="bairro" value="<?php echo $contactsUpdate[0]['bairro'] ?>" id="bairro" >
  </div>

  <div id="telefones" class="col-md-6">
    <label for="validationDefault02" class="form-label">Telefone </label>
    <?php
// Verifica se o campo de telefone está definido e não está vazio
if (isset($contactsUpdate[0]['telefone']) && !empty($contactsUpdate[0]['telefone'])) {
    // Decodifica a string JSON para obter um array de telefones
    $telefones = json_decode($contactsUpdate[0]['telefone']);

    // Verifica se a decodificação foi bem sucedida e se é um array
    if ($telefones !== null && is_array($telefones)) {
        // Loop para gerar os inputs de telefone com os valores dos números de telefone
        foreach ($telefones as $telefone) {
            echo '<input type="text" class="form-control telefone" placeholder="(00) 9 0000-0000" name="telefone[]" value="' . $telefone . '" required>';
        }
    }
}
?>
</div>
<div class="col-6">
    <button class="btn btn-primary botaoplus" onclick="adicionarTelefone()"  type="button">+ Telefone</button>
  </div>
  </div>




  <div class="col-12">
    <button class="btn btn-primary"  type="submit">Alterar contato</button>
  </div>
  <?php endif;?>
</form>

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
