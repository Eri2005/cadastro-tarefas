<?php

include("conn.php");

if(isset($_GET["finalizar"])){
    $idFinalizar = $_GET["finalizar"];

    $sql = "UPDATE tab_tarefas
            set status_tarefa ='1'
            where id='$idFinalizar' ";
    
    if(mysqli_query($conn, $sql)){
        header('location:index.php');
    }else{
        header('location:index.php?error');
    }
}