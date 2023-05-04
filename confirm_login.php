<?php

session_start();
include('conn.php');

if (isset($_GET["logar"])) {
    if (!empty($_GET["usuario"]) && !empty($_GET["senha"])) {
        function testarValor($valor){
            $valor = htmlspecialchars($valor);
            $valor = stripslashes($valor);
            $valor = trim($valor);
            return $valor;
        }
        $usuario = testarValor($_GET["usuario"]);
        $senha = testarValor($_GET["senha"]);

        $sql = "SELECT * FROM tab_usuarios WHERE usuario ='$usuario' AND senha ='$senha'";
        $result = mysqli_query($conn, $sql);
        $quantReg = mysqli_num_rows($result);

        if ($quantReg > 0) {
            while ($linha = mysqli_fetch_assoc($result)) {
                $id = $linha["id"];
            }
            $_SESSION["usuario"] = $usuario;
            $_SESSION["id"] = $id;
            header('location:index.php');
        } else {
            header('location:login.php?erro=1');
        }
    }else {
        header('location:login.php?erro=2');
    }
}
