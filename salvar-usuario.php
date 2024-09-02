<?php
// Incluir a conexão

include 'conexao.php';
switch (@$_REQUEST["acao"]) {

  case 'cadastrar':

    // Verifica se os parâmetros POST necessários existem
    if (isset($_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["data_nasc"])) {
      $nome = $_POST["nome"];
      $email = $_POST["email"];
      $senha = $_POST["senha"];
      $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
      $data_nasc = $_POST["data_nasc"];


      try {
        // Prepara a declaração SQL para evitar injeção de SQL
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, data_nasc) VALUES (:nome, :email, :senha, :data_nasc)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);  // Armazena o hash da senha
        $stmt->bindParam(':data_nasc', $data_nasc);

        // Executa a consulta
        if ($stmt->execute()) {
          echo "Usuário cadastrado com sucesso.";
          print "<script>location.href='?page=listar';</script>";
        } else {
          echo "Erro ao cadastrar o usuário.";
          print "<script>location.href='?page=listar';</script>";
        }
      } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
      }
    } else {
      echo "Todos os campos são obrigatórios.";
    }
    break;

  case 'editar':

    // Verifica se os parâmetros POST necessários existem
    if (isset($_POST["id"], $_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["data_nasc"])) {
      $id = $_POST["id"];  // ID do usuário que será editado
      $nome = $_POST["nome"];
      $email = $_POST["email"];
      $senha = $_POST["senha"];
      $data_nasc = $_POST["data_nasc"];

      // Se a senha foi alterada, cria um novo hash; caso contrário, não muda a senha
      if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
      } else {
        // Não alterar a senha se o campo de senha estiver vazio
        $senha_hash = null;
      }

      try {
        // Monta a consulta SQL dinamicamente dependendo se a senha foi alterada ou não
        if ($senha_hash) {
          $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, data_nasc = :data_nasc WHERE id = :id");
          $stmt->bindParam(':senha', $senha_hash);
        } else {
          $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, data_nasc = :data_nasc WHERE id = :id");
        }

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':id', $id); // Vincula o ID do usuário

        // Executa a consulta
        if ($stmt->execute()) {
          echo "Usuário atualizado com sucesso.";
          print "<script>alert('Editado com sucesso');</script>";
          print "<script>location.href='?page=listar';</script>";
        } else {
          echo "Erro ao atualizar o usuário.";
          print "<script>location.href='?page=listar';</script>";
        }
      } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
      }
    } else {
      echo "Todos os campos são obrigatórios.";
    }
    break;
  case 'excluir':

    // Verifica se o ID foi passado via GET ou POST
    if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
      $id = $_REQUEST["id"];

      try {
        // Prepara a declaração SQL para excluir o usuário
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a consulta
        if ($stmt->execute()) {
          echo "Usuário excluído com sucesso.";
          print "<script>alert('Usuário excluído com sucesso');</script>";
          print "<script>location.href='?page=listar';</script>";
        } else {
          echo "Erro ao excluir o usuário.";
          print "<script>alert('Erro ao excluir o usuário');</script>";
          print "<script>location.href='?page=listar';</script>";
        }
      } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
      }
    } else {
      echo "ID do usuário não fornecido.";
      print "<script>alert('ID do usuário não fornecido');</script>";
    }
    break;
}
