<?php

include("conn.php");

$tarefaFinalizada = (!empty($_GET["concluidas"]) ? 1 : 0);
$valorBuscar = (isset($_GET['txtbuscarId']) ? $_GET['txtbuscarId'] : "");
$valor = (isset($_GET['btnBuscar']) ? $_GET['txtbuscar'] : $valorBuscar);

if (isset($_GET["btnBuscar"])) {
    $valor = $_GET["txtbuscar"];
    $id = $_SESSION['id'];

    // Comando abaixo vai trazer somente as tarefas do usuario logado ao clicar no botao BUSCAR que estão com status da tarefa for ZERO
    $sqlSelect = "SELECT t.id, t.nome_tarefa, t.desc_tarefa, t.data_tarefa, t.id_usuario, t.prioridade, t.status_tarefa, u.usuario 
                from tab_tarefas as t 
                inner join tab_usuarios as u 
                where t.id_usuario = u.id and t.id_usuario = '$id' 
                and data_tarefa LIKE '$valor%'";
} else {

    $id = $_SESSION['id'];
    // Comando para salvar informacao do tipo data
    $data = date('Y-m-d');

    // Pegando todas as tarefas do usuario logado com status da tarefa for ZERO
    $sqlSelect = "SELECT t.id, t.nome_tarefa, t.desc_tarefa, t.data_tarefa, t.id_usuario, t.prioridade, t.status_tarefa, u.usuario 
                from tab_tarefas as t 
                inner join tab_usuarios as u 
                where t.id_usuario = u.id  and t.id_usuario = '$id' and t.status_tarefa = '$tarefaFinalizada' 
                and data_tarefa LIKE '$valor%'";

    // O comando $data% vai pegar uma determina letra a partir do inicio da string contido no banco de dados
    //$sqlSelect = "SELECT * FROM tab_tarefas WHERE data_tarefa LIKE '$data%'";

}

$result = mysqli_query($conn, $sqlSelect);

// Buscando quantidade de registro no banco e dividindo pela quantidade por pagina
// Ex: 16 registro e dividir por 6 que foi a quantidade que defini por pagina
// 16 / 6 = 3 paginas

$quntRegistro = mysqli_num_rows($result);

// Verificando se o usuario clicou no botao de paginação
// Se nao. Vai mostrar a primeira pagina
$pag = (isset($_GET["pagina"]) ? $_GET["pagina"] : 1);

// Definindo a quantidade por pagina
$quntPorPagina = 6;

$numDePagina = ceil($quntRegistro / $quntPorPagina);

// Criando o calculo para gerar outra lista para proxima pagina
// Ex: (2 * 6) - 6 
$inicio = ($pag * $quntPorPagina) - $quntPorPagina;

// Realizando a consulta no banco de dados
$sqlPaginacao = "SELECT t.id, t.nome_tarefa, t.desc_tarefa, t.data_tarefa, t.id_usuario, t.prioridade, t.status_tarefa, u.usuario 
from tab_tarefas as t 
inner join tab_usuarios as u 
where t.id_usuario = u.id 
and t.id_usuario = '$id' 
and data_tarefa LIKE '$valor%'
and t.status_tarefa = '$tarefaFinalizada' limit $inicio, $quntPorPagina";

// Salvando em uma variavel o resultado da solicitação
$result = mysqli_query($conn, $sqlPaginacao);
