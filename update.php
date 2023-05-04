<?php

include("conn.php");

if(empty($_SESSION["usuario"])){
    header('location:login.php');
}

if (isset($_GET["atualizar"])) {
    if (!empty($_GET["tarefa"]) && !empty($_GET["descricao"]) && !empty($_GET["datatarefa"]) && !empty($_GET["select"])) {
        $tarefa = $_GET["tarefa"];
        $descricao = $_GET["descricao"];
        $dataTarefa = $_GET["datatarefa"];
        $prioridade = $_GET["select"];
        $id = $_GET["id"];

        //Inserindo o comando de SQL para Atualizar algum dados e salvando em uma variavel para o BD
        $sql = "UPDATE tab_tarefas SET nome_tarefa = '$tarefa', desc_tarefa = '$descricao', data_tarefa = '$dataTarefa', prioridade = '$prioridade' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            
            // Caso não encontre o ID ele vai retornar a página index.php
            header("location:index.php?msg=2");
        } else {
            print_r("<script>alert('Erro!!!')</script>");
        }
    } else {
        print_r("<script>alert('Preencha os campos')</script>");
    }    
}

if(isset($_GET["idTarefa"])){
    $idTarefa = $_GET['idTarefa'];
    $sqlTarefaConcluida = "UPDATE tab_tarefas SET status_tarefa = '1' WHERE id = '$idTarefa'";

    if(mysqli_query($conn,$sqlTarefaConcluida)){
        header("location:index.php");
    }
}
