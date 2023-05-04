<?php
session_start();

// Para remover as chaves do array do usuario
session_unset();

// Vai remove toda as sessoes
session_destroy();

header('location:login.php');