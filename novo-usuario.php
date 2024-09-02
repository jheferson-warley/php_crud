<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Usuário</title>
</head>

<body>
  <h1>Novo Usuário</h1>
  <form action="?page=salvar" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="form-group mb-3">
      <label>Nome</label>
      <input type="text" name="nome" class="form-control" placeholder="Nome" required>


      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>


    <div class="form-group mb-3">
      <label>Password</label>
      <input type="password" name="senha" class="form-control" placeholder="Senha" required>
    </div>


    <div class="form-group mb-3">
      <label>Data de Nascimento</label>
      <input type="date" name="data_nasc" class="form-control" name="data_nasc" placeholder=" Data de Nascimento" required>
    </div>

    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </form>
</body>

</html>