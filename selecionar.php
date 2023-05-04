<?php

include("conn.php");

if (!empty($_GET["id"])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tab_tarefas WHERE id='$id'";
    $result = mysqli_query($conn, $sql); // Salvar em uma variavel o comando para consulta no banco de dados


    // Vai verificar quantos campos vai ter o resultado do ID
    if (mysqli_num_rows($result) > 0) {
        // 
        while ($linha = mysqli_fetch_assoc($result)) {
            $nome = $linha["nome_tarefa"];
            $descricao = $linha["desc_tarefa"];
            $data = $linha["data_tarefa"];
            $prioridade = $linha["prioridade"];
            $id = $linha["id"];
        }
    } else {
        header("location:index.php"); // Caso não encontre o ID ele vai retornar a página index.php
    }
}
