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

        // Enviar email de validação (opcional)
        // ...

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
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        <br>
        <input type="submit" value="Login">
    </form>

    <?php if (isset($_SESSION['id_user'])): ?>
        <h2>Bem-vindo, Usuário ID: <?php echo $_SESSION['id_user']; ?></h2>
        <a href="logout.php">Sair</a>
    <?php endif; ?>
</body>
</html>

