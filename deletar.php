<?php

include("conn.php");

if (isset($_GET["delete"])) {
    $idExcluirTarefa = $_GET["delete"];
    $id = $_GET["id"];

    //Inserindo o comando de SQL para Atualizar algum dados e salvando em uma variavel para o BD
    $sql = "DELETE FROM tab_tarefas WHERE id = '$idExcluirTarefa'";

    if (mysqli_query($conn, $sql)) {
        header("location:index.php?msg=3"); // Caso não encontre o ID ele vai retornar a página index.php
    } else {
        print_r("<script>alert('Error na Exclusão!!!')</script>");
    }
}
