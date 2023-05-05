<?php

include('conn.php');

// Verificando se foi clicado
if (isset($_GET["cadastrar"])) {
    if (!empty($_GET["tarefa"]) && !empty($_GET["descricao"]) && !empty($_GET["datatarefa"]) && !empty($_GET["select"])) {
        $tarefa = $_GET["tarefa"];
        $descricao = $_GET["descricao"];
        $dataTarefa = $_GET["datatarefa"];
        $prioridade = $_GET["select"];

        $id = $_SESSION['id'];

        // Inserindo o comando de SQL para gravar algum dados salvando em uma variavel para o BD
        $sql = "INSERT INTO tab_tarefas(nome_tarefa,desc_tarefa,data_tarefa,id_usuario,prioridade) VALUES ('$tarefa','$descricao','$dataTarefa','$id','$prioridade')";

        if (mysqli_query($conn, $sql)) {
            print_r("<script>alert('Cadastro Realizado!!!')</script>");

            // Aqui vai chamar a pagina informada e colocaremos depois de location:index.php ?msg=1 para  
            header('location:index.php?msg=1');
        } else {
            print_r("<script>alert('Erro!!!')</script>");
        }
    } else {
        print_r("<script>alert('Preencha os campos')</script>");
    }
}
