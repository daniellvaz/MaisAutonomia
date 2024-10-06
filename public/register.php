<?php include 'config.php'; ?>
<?php
function cadastroUser(){
    if (isset($_POST['enviar'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $cpfcnpj = $_POST['cpfcnpj'];
        $cep = $_POST['cep'];
        $avatar = $_POST['avatar'];

        //Verificação se todos os campos foram preenchidos
        if ($nome == "" || $email == "" || $senha == "" || $telefone == "" || $cpfcnpj == "" || $cep == "" || $avatar == "") {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Os campos <strong>nome</strong> e <strong>e-mail</strong> são obrigatórios!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>  
            <?php  
            // Verificação se o email é válido
        } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|com\.br)$/", $email)) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                O <strong>e-mail</strong> está inválido!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        } else {
            // Verificação do email caso tenha registro
            $consemail = $conn->prepare("SELECT * FROM `usuario` WHERE `email_user` = :email");
            $consemail->bindValue(":email", $email);
            $consemail->execute();

            if ($consemail->rowCount() >= 1) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    O <strong>e-mail</strong> já está cadastrado!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            } else {
                // Criptografando a senha
                $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

                // Grava os dados no banco
                $gravar = $conn->prepare("INSERT INTO `usuario` (`id_user`, `nome_user`, `email_user`, `senha_user`, `telefone_user`, `cpf_cnpj`, `cep_user`, `avatar_user`)
                                          VALUES (NULL, :nome, :email, :senha, :telefone, :cpf_cnpj, :cep, :avatar);");
                $gravar->bindValue(":nome", $nome);
                $gravar->bindValue(":email", $email);
                $gravar->bindValue(":senha", $senha_segura); // Senha criptografada
                $gravar->bindValue(":telefone", $telefone);
                $gravar->bindValue(":cpf_cnpj", $cpfcnpj);
                $gravar->bindValue(":cep", $cep);
                $gravar->bindValue(":avatar", $avatar);
                $gravar->execute();
            }
        }
    }
}
?>
