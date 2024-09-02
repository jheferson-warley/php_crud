<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuário</title>
</head>

<body>
  <?php
  // Verifica se o ID do usuário foi passado
  if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Prepara a consulta para buscar os dados do usuário pelo ID
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Verifica se encontrou o usuário
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$row) {
      echo "<p class='alert alert-danger'>Usuário não encontrado.</p>";
      exit;
    }
  } else {
    echo "<p class='alert alert-danger'>ID de usuário não fornecido.</p>";
    exit;
  }
  ?>
  <h1>Editar Usuário</h1>
  <form action="?page=salvar" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row->id); ?>">

    <div class="form-group mb-3">
      <label>Nome</label>
      <input type="text" name="nome" value="<?php echo htmlspecialchars($row->nome); ?>" class="form-control" placeholder="Nome" required>
    </div>

    <div class="form-group mb-3">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($row->email); ?>" class="form-control" placeholder="Email" required>
    </div>

    <div class="form-group mb-3">
      <label>Senha</label>
      <input type="password" name="senha" class="form-control" placeholder="Nova Senha">
      <small>Deixe em branco se não quiser alterar a senha.</small>
    </div>

    <div class="form-group mb-3">
      <label>Data de Nascimento</label>
      <input type="date" name="data_nasc" value="<?php echo htmlspecialchars($row->data_nasc); ?>" class="form-control" placeholder="Data de Nascimento" required>
    </div>

    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </div>
  </form>
</body>

</html>