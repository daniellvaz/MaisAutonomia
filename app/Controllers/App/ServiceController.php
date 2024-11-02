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
    $desc_servicos= $_POST['desc_servicos'];
    $valor_servicos = $_POST['valor_servicos'];
    $prazo_servicos= $_POST['prazo_servicos'];

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
      (titulo_servicos, desc_servicos, valor_servicos, prazo_servicos) 
      VALUES 
      (:titulo_servicos, :desc_servicos, :valor_servicos, :prazo_servicos)
    ");
    $stmt->execute([$titulo_servicos, $desc_servicos, $valor_servicos, $prazo_servicos]);

    // Redireciona para a página inicial (pode ser uma página de dashboard)
    return $response
      ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?mensagem=Serviço%20cadastrado%20com%20sucesso")
      ->withStatus(301);
  }
}