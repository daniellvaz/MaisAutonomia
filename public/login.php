<?php
session_start();
include 'config.php'; // Inclui o arquivo de configuração

// Processa o login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica o usuário no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email_user = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha_user'])) {
        $_SESSION['id_user'] = $usuario['id_user'];

        // Redireciona para a página inicial (pode ser uma página de dashboard)
        header("Location: index.php?login=success");
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Login</h3>
        
        <!-- Exibe a mensagem de erro se houver -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Lembrar de mim</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <p class="text-center mt-3">
                <a href="#">Esqueceu sua senha?</a>
            </p>
            <p class="text-center">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
        </form>
    </div>
</div>
</body>
</html>
