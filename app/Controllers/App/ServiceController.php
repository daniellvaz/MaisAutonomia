<?php

namespace MaisAutonomia\Controllers\App;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use MaisAutonomia\Database\Database;
use MaisAutonomia\Controllers\Controller;

class ServiceController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $database = new Database();
        $stmt = $database->query()->prepare("
            SELECT 
            * 
            FROM servicos s 
            WHERE s.id_servicos = :id
        ");

        $stmt->execute([
            "id" => $id
        ]);

        $servico = $stmt->fetchAll();

        $stmt = $database->query()->prepare("
            SELECT 
            * 
            FROM propostas p
            LEFT JOIN usuario u ON u.id_usuario = p.id_usuario
            WHERE 1 = 1
            AND p.id_servico = :servico
        ");

        $stmt->execute([
            "servico" => $servico[0]['id_servicos']
        ]);

        $propostas = $stmt->fetchAll();

        return $this->view->render($response, 'details.html', [
            "servico" => $servico[0],
            "propostas" => $propostas
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $conn = new Database();

        $titulo_servicos = $_POST['titulo_servicos'];
        $desc_servicos   = $_POST['desc_servicos'];
        $valor_servicos  = $_POST['valor_servicos'];
        $prazo_servicos  = $_POST['prazo_servicos'];

        $hora_atual = new \DateTime(); 
        $hora_limite = clone $hora_atual;
        $hora_limite->modify('+24 hours');

        if (new \DateTime($prazo_servicos) < $hora_limite) {
            return $response
                ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?message=O%20prazo%20para%20os%20serviços%20deve%20ser%20superior%20a%2024%20horas%20a%20partir%20do%20momento%20atual.")
                ->withStatus(301);
        }

        if (!isset($_SESSION['user']['id_usuario'])) {
            return $response
                ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?message=Erro: id_cliente não está definido na sessão.")
                ->withStatus(301);
        }

        $id_cliente = $_SESSION['user']['id_usuario'];

        // Verificação se o id_cliente existe na tabela usuario
        $stmt = $conn->query()->prepare("
            SELECT COUNT(*) 
            FROM usuario 
            WHERE id_usuario = :id_cliente
        ");
        $stmt->execute([
            "id_cliente" => $id_cliente
        ]);

        if ($stmt->fetchColumn() == 0) {
            echo "Erro: id_cliente não corresponde a um usuário válido.";
            exit;
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
            "cliente"   => $id_cliente
        ]);

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
        $query = "DELETE FROM `servicos` WHERE `servicos`.`id_servicos` = :id";
        $stmt  = (new Database())->query()->prepare($query);

        $stmt->execute([
            'id' => $id
        ]);

        return $response
        ->withHeader("Location", $_ENV['BASE_URL'] . "/me/inicio?message=Serviço%20deletado%20com%20sucesso")
        ->withStatus(301);
    }
}
