<?php
session_start();
if(!isset($_SESSION["user"])){
    header('location:login.php');
}
if($_SESSION['id_usuario']==2){
    echo "Area restrita!";
    exit;
}
?>
<?php include 'config.php'; ?>
<form action="formexp.php" method="post">
    <textarea name="exp">Insira aqui sua formação/experiência...</textarea>
    <input type="submit" name="envia" value="Enviar">
</form>

<?php
    if(isset($_POST['envia'])){
        $formexp=$_POST['exp'];

    if ($formexp==""){
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        O campo <strong>NÃO</strong> pode ser enviado em branco!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    }else{
        $gravar=$conn->prepare("INSERT INTO `formacao_experiencia` (`id_form_exp`, `titulo_form_exp`, `id_usuario`) VALUES (NULL, :titulo, :usuario;");
        $gravar->bindValue(":titulo",$formexp);
        $gravar->execute();
    }
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Gravado com Sucesso!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
   <?php } ?>