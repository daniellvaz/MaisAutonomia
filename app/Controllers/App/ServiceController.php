<?php
namespace MaisAutonomia\Controllers\App\ServiceController;

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

    $stmt = $conn->query()->prepare("INSERT INTO servicos (titulo_servicos, desc_servicos, valor_servicos, prazo_servicos, imagem1, imagem2, imagem3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nomeCompleto, $cpf, $email, $telefone, $logradouro, $uf, $cidade, $tipoServico, $imagens[0], $imagens[1], $imagens[2]]);

    echo '<div class="alert alert-success">Serviço cadastrado com sucesso!</div>'; // Mensagem de sucess
  }
}