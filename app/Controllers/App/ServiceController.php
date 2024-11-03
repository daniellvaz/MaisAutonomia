<?php

namespace MaisAutonomia\Controllers\App;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;

class ServiceController extends Controller
{
  public function store (Request $request, Response $response): Response
  {
    $conn = new Database();

    $titulo_servicos = $_POST['titulo_servicos'];
    $desc_servicos   = $_POST['desc_servicos'];
    $valor_servicos  = $_POST['valor_servicos'];
    $prazo_servicos  = $_POST['prazo_servicos'];

    $uploadsDir = "uploads/";
    $imagens = ["", "", ""]; 

    for ($i = 0; $i < 3; $i++) {
        if (!empty($_FILES["imagem"]["name"][$i])) {
            $imagemTmp = $_FILES["imagem"]["tmp_name"][$i];
            $imagemNome = $uploadsDir . uniqid() . "_" . basename($_FILES["imagem"]["name"][$i]);
            if (move_uploaded_file($imagemTmp, $imagemNome)) {
                $imagens[$i] = $imagemNome; // Adiciona o nome da imagem ao array
            }
        }
    }

    $stmt = $conn->query()->prepare("
      INSERT INTO servicos 
      (titulo_servicos, desc_servicos, valor_servicos, prazo_servicos, id_cliente) 
      VALUES 
      (:titulo, :descricao, :valor, :prazo, :cliente)
    ");
    $stmt->execute([
      "titulo"    => $titulo_servicos,
      "descricao" => $desc_servicos,
      "valor"     => $valor_servicos,
      "prazo"     => $prazo_servicos,
      "cliente" => $_SESSION['user']['id_usuario']
    ]);

    // Redireciona para a página inicial (pode ser uma página de dashboard)
    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?mensagem=Serviço%20cadastrado%20com%20sucesso")
      ->withStatus(301);
  }

  public function update(Request $request, Response $response): Response
  {
    $conn = new Database();
    $id              = $request->getAttribute('id');
    $titulo_servicos = $_POST['titulo_servicos'];
    $desc_servicos   = $_POST['desc_servicos'];
    $valor_servicos  = $_POST['valor_servicos'];
    $prazo_servicos  = $_POST['prazo_servicos'];
    $status_servicos = $_POST['status_servicos'];

    $stmt = $conn->query()->prepare("
      UPDATE servicos 
      SET  
        titulo_servicos = :titulo,
        desc_servicos   = :desc,
        valor_servicos  = :valor,
        prazo_servicos  = :prazo,
        status_servicos = :status
      WHERE id_servicos = :id
    ");
    $stmt->execute([
      "titulo" => $titulo_servicos,
      "desc"   => $desc_servicos,
      "valor"  => $valor_servicos,
      "prazo"  => $prazo_servicos,
      "status" => $status_servicos,
      "id"     => $id
    ]);

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/servicos/{$id}?message=Serviço%20atualizado%20com%20sucesso")
      ->withStatus(301);
  }

  public function delete(Request $request, Response $response): Response
  {
    $id    = $request->getAttribute('id');
    $query = "DELETE FROM servicos s WHERE s.id_servicos = :id";
    $stmt  = (new Database())->query()->prepare($query);

    $stmt->execute([
      'id' => $id
    ]);

    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?message=Serviço%20deletado%20com%20sucesso")
      ->withStatus(301);
  }
}