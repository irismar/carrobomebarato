<?php 
    $con = mysqli_connect('localhost', 'root', '', 'u386698969_carro');

    $id = $_GET['id'];

    echo $sql = "select * from estoque where Id_estoque = $id";

    $query = mysqli_query($con, $sql);
    $resultado = mysqli_fetch_assoc($query);

        $retorna = $resultado['modelotexto'];
        echo $retorna;
?>