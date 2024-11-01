<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Mais Autonomia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="card p-4 shadow">
            <h3 class="text-center mb-4">Crie sua Conta</h3>
            <form action="" method="POST">
                <!-- Nome -->
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome completo" required />
                </div>

                <!-- E-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required />
                </div>

                <!-- Senha -->
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha" required />
                </div>

                <!-- Telefone -->
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required />
                </div>

                <!-- CPF/CNPJ -->
                <div class="mb-3">
                    <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" placeholder="Digite seu CPF ou CNPJ" required />
                </div>

                <!-- CEP -->
                <div class="mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required />
                </div>

                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $telefone = $_POST['telefone'];
                $cpfcnpj = $_POST['cpf_cnpj'];
                $cep = $_POST['cep'];

                // Validação de campos
                if ($nome == "" || $email == "" || $senha == "" || $telefone == "" || $cpfcnpj == "" || $cep == "") {
                    echo "<div class='alert alert-danger'>Todos os campos são obrigatórios!</div>";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='alert alert-danger'>E-mail inválido!</div>";
                } else {
                    // Verificação do e-mail no banco de dados
                    $consemail = $pdo->prepare("SELECT * FROM usuario WHERE email_user = :email");
                    $consemail->execute(['email' => $email]);

                    if ($consemail->rowCount() > 0) {
                        echo "<div class='alert alert-danger'>O e-mail já está cadastrado!</div>";
                    } else {
                        // Criptografia da senha
                        $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

                        // Gravação no banco de dados
                        $gravar = $pdo->prepare("INSERT INTO usuario (nome_user, email_user, senha_user, telefone_user, cpf_cnpj, cep_user) VALUES (:nome, :email, :senha, :telefone, :cpf_cnpj, :cep)");
                        $gravar->execute([
                            'nome' => $nome,
                            'email' => $email,
                            'senha' => $senha_segura,
                            'telefone' => $telefone,
                            'cpf_cnpj' => $cpfcnpj,
                            'cep' => $cep
                        ]);
                        echo "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
