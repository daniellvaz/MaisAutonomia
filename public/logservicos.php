<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header('location:login.php');
    }
?>
<?php include 'config.php'; ?>
    <?php 
        $historico=$conn->prepare("SELECT * FROM servicos WHERE status_servicos= /* Inserir aqui */;");
        $historico->execute();
    if($historico->rowCount()==0){
        echo "Sem registros";
    }else{
    ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Título do serviço</th>
            <th scope="col">Descrição do serviço</th>
            <th scope="col">Prazo</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row=$historico->fetch()){ ?>
            <tr>
                <td><?php echo $row ['titulo_servicos']?></td>
                <td><?php echo $row ['desc_servicos']?></td>
                <td><?php echo $row ['prazo_servicos']?></td>
                <td><?php echo $row ['status_servicos']?></td>
            </tr>
            <?php } ?>
    </tbody>
</table>
<?php } ?>