<?php

include('conn.php');

if (isset($_GET["cadastrar"])) {

    if (!empty($_GET["usuario"]) && !empty($_GET["senha"]) && !empty($_GET["confirmar_senha"])) {
        
        // Comando abaixo vai tratar todos os campos para evitar um SqlInjection
        function testarValor($valor){
            $valor = htmlspecialchars($valor);
            $valor = stripslashes($valor);
            $valor = trim($valor);
            return $valor;
        }

        $usuario = testarValor($_GET["usuario"]);
        $senha = testarValor($_GET["senha"]);
        $confirmsenha = testarValor($_GET["confirmar_senha"]);

        $loginOk = false;
        $senhaOk = false;

        if ($senha == $confirmsenha) {
            $senhaOk = true;
        } else {
            header('location:cadastrar.php?erro=senha');
        }

        $sql = "SELECT * FROM tab_usuarios WHERE usuario ='$usuario'";
        $result = mysqli_query($conn, $sql);
        $quantRegistro = mysqli_num_rows($result);

        if ($quantRegistro > 0) {
            header('location:cadastrar.php?erro=login');
        } else {
            $loginOk = true;
        }

        if ($loginOk && $senhaOk) {
            $sql = "INSERT INTO tab_usuarios (usuario, senha) VALUES ('$usuario','$senha')";

            if (mysqli_query($conn, $sql)) {
                header('location:login.php?cadastro=OK');
            } else {
                header('location:cadastrar.php?erro=cadastro');
            }
        }
    } else {
        header('location:cadastrar.php?erro=cadastronaopreenchico');
    }
}
