<?php

namespace MaisAutonomia\Controllers\Web;

use PDO;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;

class AccountController extends Controller
{
  public function store(Request $request, Response $response): Response
  {
    $conn = new Database();
    $body = $request->getParsedBody();

    $nome     = $body['nome'];
    $email    = $body['email'];
    $senha    = $body['senha'];
    $telefone = $body['telefone'];
    $cpf_cnpj = $body['cpf_cnpj'];
    $cep      = $body['cep'];
    $eu_quero = $body['eu_quero'];

    //Verificação se todos os campos foram preenchidos
    if ($nome == "" || $email == "" || $senha == "" || $telefone == "" || $cpf_cnpj == "" || $cep == "") {
      return $response->withHeader('Location', '/cadastro?erro=Todos%20os%20campos%20são%20obrigatórios!');
    }

    $email_e_valido = !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|com\.br)$/", $email);

    if ($email_e_valido) {
      return $response
        ->withHeader('Location', $_ENV['BASE_URL'] . '/cadastro?erro=Por%20favor,%20insira%20um%20email%20válido!')
        ->withStatus(302);
    }

    // Verificação do email caso tenha registro
    $consemail = $conn->query()->prepare("SELECT * FROM `usuario` WHERE `email_user` = :email");
    $consemail->bindValue(":email", $email);
    $consemail->execute();

    if ($consemail->rowCount() > 0) {
      return $response
        ->withHeader('Location', $_ENV['BASE_URL'] . '/cadastro?erro=Usuário%20já%20cadastrado!')
        ->withStatus(301);
    }
    // Criptografando a senha
    $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

    // Grava os dados no banco
    $gravar = $conn->query()->prepare("
      INSERT INTO `usuario` (`id_user`, `nome_user`, `email_user`, `senha_user`, `telefone_user`, `cpf_cnpj`, `cep_user`)
      VALUES (NULL, :nome, :email, :senha, :telefone, :cpf_cnpj, :cep);
    ");
    $gravar->bindValue(":nome", $nome);
    $gravar->bindValue(":email", $email);
    $gravar->bindValue(":senha", $senha_segura); // Senha criptografada
    $gravar->bindValue(":telefone", $telefone);
    $gravar->bindValue(":cpf_cnpj", $cpf_cnpj);
    $gravar->bindValue(":cep", $cep);
    $gravar->execute();

    $usuario_consulta = $conn->query()->prepare("SELECT * FROM usuario WHERE  email_user = :email");
    $usuario_consulta->execute([
      "email" => $email
    ]);
    $usuario = $usuario_consulta->fetchAll(PDO::FETCH_ASSOC);

    if ($eu_quero === "ambos") {
      $perfis_consulta = $conn->query()->prepare("SELECT * FROM perfil");
      $perfis_consulta->execute();

      $perfis = $perfis_consulta->fetchAll();

      foreach ($perfis as $perfil) {
        $gravar_perfil = $conn->query()->prepare("
          INSERT INTO `usuario_perfil` (`id_user`, `id_perfil`)
          VALUES (:usuario, :perfil);
        ");

        $gravar_perfil->execute([
          "usuario" => $usuario[0]['id_user'],
          "perfil"  => $perfil['id_perfil']
        ]);
      }

      $_SESSION['user'] = $usuario[0];

      return $response
        ->withHeader('Location', $_ENV['BASE_URL'] . "/?sucesso=Conta%20criada%20com%20sucesso!")
        ->withStatus(301);
    }

    $perfis_consulta = $conn->query()->prepare("SELECT * FROM perfil WHERE titulo_perfil = :titulo");
    $perfis_consulta->execute([
      "titulo" => $eu_quero
    ]);

    $perfis = $perfis_consulta->fetchAll();

    $gravar_perfil = $conn->query()->prepare("
      INSERT INTO `usuario_perfil` (`id_user`, `id_perfil`)
      VALUES (:id_usuario, :id_perfil);
    ");
    $gravar_perfil->execute([
      "id_usuario" => $usuario[0]['id_user'],
      "id_perfil"  => $perfis[0]['id_perfil']
    ]);

    $_SESSION['user'] = $usuario[0];

    return $response
      ->withHeader('Location', $_ENV['BASE_URL'] . "/login?sucesso=Conta%20criada%20com%20sucesso!")
      ->withStatus(301);
  }
}
