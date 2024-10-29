<?php

namespace MaisAutonomia\Controllers\Web;

use MaisAutonomia\Controllers\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WebController extends Controller
{
  public function home(Request $request, Response $response)
  {
    return $this->view->render($response, 'index.html');
  }

  public function login(Request $request, Response $response)
  {
    $error = isset($_GET['erro']) ? $_GET['erro'] : null;

    return $this->view->render($response, 'login.html', [
      "error" => $error
    ]);
  }

  public function register(Request $request, Response $response)
  {
    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

    return $this->view->render($response, 'register.html', [
      "erro" => $erro
    ]);
  } 

  public function servicos(Request $request, Response $response)
  {
    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;
    
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       // Captura os dados do formulário
       $nomeCompleto = $_POST['nomeCompleto'];
       $cpf = $_POST['cpf'];
       $email = $_POST['email'];
       $telefone = $_POST['telefone'];
       $logradouro = $_POST['logradouro'];
       $uf = $_POST['uf'];
       $cidade = $_POST['cidade'];
       $tipoServico = $_POST['tipoServico'];

       $uploadsDir = "uploads/";
       $imagens = ["", "", ""]; // Inicializa array para imagens

       // Processa até 3 imagens
       for ($i = 0; $i < 3; $i++) {
           if (!empty($_FILES["imagem"]["name"][$i])) {
               $imagemTmp = $_FILES["imagem"]["tmp_name"][$i];
               $imagemNome = $uploadsDir . uniqid() . "_" . basename($_FILES["imagem"]["name"][$i]);
               if (move_uploaded_file($imagemTmp, $imagemNome)) {
                   $imagens[$i] = $imagemNome; // Adiciona o nome da imagem ao array
               }
           }
       }

       try {
           // Criar uma nova conexão PDO
           $conn = new PDO(
               "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8",
               getenv('DB_USER'),
               getenv('DB_PASS')
           );
           // Configurar o PDO para lançar exceções em erros
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           // Preparar e executar a instrução SQL
           $stmt = $conn->prepare("INSERT INTO servicos (nome_completo, cpf, email, telefone, logradouro, uf, cidade, tipo_servico, imagem1, imagem2, imagem3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
           $stmt->execute([$nomeCompleto, $cpf, $email, $telefone, $logradouro, $uf, $cidade, $tipoServico, $imagens[0], $imagens[1], $imagens[2]]);

           echo '<div class="alert alert-success">Serviço cadastrado com sucesso!</div>'; // Mensagem de sucesso
       } catch (PDOException $e) {
           echo '<div class="alert alert-danger">Erro ao cadastrar o serviço: ' . $e->getMessage() . '</div>'; // Mensagem de erro
       }
   }
   
    return $this->view->render($response, 'cadastroservicos.html', [
      "erro" => $erro
    ]);
  }
}
