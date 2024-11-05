<?php

namespace MaisAutonomia\Controllers\Web;

use PDO;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;
use Slim\Psr7\UploadedFile;

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
    $consemail = $conn->query()->prepare("SELECT * FROM `usuario` WHERE `email_usuario` = :email");
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
      INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`, `cpf_cnpj`, `cep_usuario`)
      VALUES (NULL, :nome, :email, :senha, :telefone, :cpf_cnpj, :cep);
    ");
    $gravar->bindValue(":nome", $nome);
    $gravar->bindValue(":email", $email);
    $gravar->bindValue(":senha", $senha_segura); // Senha criptografada
    $gravar->bindValue(":telefone", $telefone);
    $gravar->bindValue(":cpf_cnpj", $cpf_cnpj);
    $gravar->bindValue(":cep", $cep);
    $gravar->execute();

    $usuario_consulta = $conn->query()->prepare("SELECT * FROM usuario WHERE  email_usuario = :email");
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

        $gravar_perfil->execute(["usuario" => $usuario[0]['id_usuario'],
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
      INSERT INTO `usuario_perfil` (`id_usuario`, `id_perfil`)
      VALUES (:id_usuario, :id_perfil);
    ");
    $gravar_perfil->execute(["id_usuario" => $usuario[0]['id_usuario'],
      "id_perfil"  => $perfis[0]['id_perfil']
    ]);

    $_SESSION['user'] = $usuario[0];

    return $response
      ->withHeader('Location', $_ENV['BASE_URL'] . "/login?sucesso=Conta%20criada%20com%20sucesso!")
      ->withStatus(301);
  }

  public function update(Request $request, Response $response): Response
  {
    $id = $request->getAttribute('id');
    $body = $request->getParsedBody();

    $nome     = $body['nome_usuario'];
    $email    = $body['email_usuario'];
    $telefone = $body['telefone_usuario'];
    $cpf_cnpj = $body['cpf_cnpj'];
    $cep      = $body['cep_usuario'];

    $query = "
      UPDATE usuario 
      SET 
        nome_usuario = :nome, 
        email_usuario = :email, 
        telefone_usuario = :telefone,
        cpf_cnpj = :cpf_cnpj,
        cep_usuario = :cep
      WHERE id_usuario = :id
    ";

    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id"       => $id,
      "nome"     => $nome,
      "email"    => $email,
      "telefone" => $telefone,
      "cpf_cnpj" => $cpf_cnpj,
      "cep"      => $cep,
    ]);

    $query = "SELECT * FROM usuario u WHERE u.id_usuario = :id";

    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id" => $id
    ]);

    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $usuario[0];

    return $response
      ->withHeader("Location",  "{$_ENV['BASE_URL']}/me/perfil?message=Perfil%20atualizado%20com%20sucesso!")
      ->withStatus(301);
  }

  public function drop(Request $request, Response $response): Response
  {
    $id = $request->getAttribute('id');

    $query = "
      DELETE
      FROM usuario
      WHERE usuario.id_usuario = :id
    ";

    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id"       => $id
    ]);

    return $response
      ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=Perfil%deletado%20com%20sucesso!")
      ->withStatus(301);
  }

  public function upload_avatar(Request $request, Response $response): Response
  {
    $file = $request->getUploadedFiles();

    /**
     * @var UploadedFile 
     */
    $avatar = $file['avatar'];
    $maxFileSize = 2 * 1024 * 1024;
    $allowedTypes = ['jpg', 'jpeg', 'png'];

    if (!isset($avatar) || $avatar->getError() !== UPLOAD_ERR_OK) {
      return $response
        ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=Nenhum%20arquivo%20foi%20enviado%20ou%20ocorreu%20um%20erro.")
        ->withStatus(301);
    }

    if ($avatar->getSize() > $maxFileSize) {
      return $response
        ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=O%20arquivo%20excede%20o%20tamanho%20máximo%20permitido.")
        ->withStatus(301);
    }

    [$type, $extension] = explode('/', $avatar->getClientMediaType());

    if (!in_array($extension, $allowedTypes)) {
      return $response
        ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=Tipo%20de%20arquivo%20não%20permitido.%20Apenas%20JPG,%20JPEG,%20PNG%20e%20são%20aceitos.")
        ->withStatus(301);
    }

    $newFileName = uniqid('avatar_', true) . '.' . $extension;
    $uploadPath = __DIR__ . '/../../..' . $_ENV['UPLOAD_DIR'];

    if (!file_exists($uploadPath)) {
      $response
        ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=Pasta%20de%20uploads%20não%20existe!")
        ->withStatus(301);
    }

    $avatar->moveTo($uploadPath . $newFileName);
    $query = "UPDATE usuario SET usuario.avatar_usuario = :avatar_url WHERE usuario.id_usuario = :id";
    $stmt = (new Database())->query()->prepare($query);

    $id_usuario = $_SESSION['user']['id_usuario'];

    $stmt->execute([
      "id" => $id_usuario,
      "avatar_url" => "{$_ENV['BASE_URL']}/assets/upload/{$newFileName}"
    ]);

    $query = "SELECT * FROM usuario WHERE usuario.id_usuario = :id";
    $stmt = (new Database())->query()->prepare($query);

    $stmt->execute([
      "id" => $id_usuario
    ]);

    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $usuario[0];

    return $response
      ->withHeader("Location",  "{$_ENV['BASE_URL']}/?message=Foto%20enviada%20com%20sucesso!")
      ->withStatus(301);
  }
}
