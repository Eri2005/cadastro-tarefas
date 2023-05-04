<?php
session_start();
if (empty($_SESSION["usuario"])) {
  header('location:login.php');
}

include("tabela.php");
include("buscar.php");
include("update.php");
include("deletar.php");
include("finalizar_tarefa.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Tarefas - Senac</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <?php include("estrutura/menu_superior.php") ?>

  <?php
  if (isset($_GET["msg"]) && $_GET["msg"] == 1) {
  ?>
    <div class="alert alert-success alert-dismissible fade show w-25 p-3 container col-2 text-center mt-2" role="alert">
      <strong>Tarefa Cadastrada!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php
  }
  ?>
  <?php
  if (isset($_GET["msg"]) && $_GET["msg"] == 2) {
  ?>
    <div class="alert alert-success alert-dismissible fade show w-25 p-3 container col-2 text-center mt-5" role="alert">
      <strong>Tarefa Atualizado!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php
  }
  ?>
  <?php
  if (isset($_GET["msg"]) && $_GET["msg"] == 3) {
  ?>
    <div class="alert alert-warning alert-dismissible fade show w-25 p-3 container col-2 text-center mt-2" role="alert">
      <strong>Tarefa Excluída!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php
  }
  ?>

<!-- Modal para sair do sistema -->
  <div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-danger">
        <div class="modal-header text-warning">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Sair</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-warning modal-title fs-5 text-center">
          Deseja sair do sistema?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
          <a href="sair.php">
            <button type="button" class="btn btn-primary">Sim</button>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link" href="index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Home
            </a>
            <div class="sb-sidenav-menu-heading"></div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Sistema
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Cadastro de Tarefas</a>
                <a class="nav-link" href="index.php?concluidas=1">Tarefas concluídas</a>
              </nav>
            </div>
          </div>
        </div>
      </nav>
    </div>


    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Gerenciador de tarefas</h1>
          <ol class="breadcrumb mb-4">
          </ol>

          <div class="row">

            <div class="col-xl-2 col-md-3">
              <div class="card bg-primary text-white mb-4">
                <button type="button" class="btn btn-success" id="btn_entrada" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Incluir <i class="fa fa-plus"></i></button>
              </div>
            </div>

          </div>
          <table class="table table-hover">
            <thead>
              <tr class="col-12">
                <th scope="col-2">Editar</th>
                <th scope="col-2">Excluir</th>
                <th scope="col-2">Nome</th>
                <th scope="col-4">Descrição</th>
                <th scope="col-4">Prazo</th>
                <th scope="col-4">Prioridade</th>
                <th scope="col-2">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $dataAtual = new DateTime('now');
              $dataAtualFormatada = $dataAtual->format('Y-m-d');

              while ($linha = mysqli_fetch_assoc($result)) {

                $idExcluir = 'delete' . $linha['id'];
                $idEditar = 'editar' . $linha['id'];
                $idFinalizar = 'finalizar' . $linha['id'];
                $dataBanco = new DateTime($linha['data_tarefa']);
                $dataBancoFormatada = $dataBanco->format('Y-m-d');
                $dataExibir = $dataBanco->format('d-m-Y H:i');

              ?>
                <tr class="<?php if ($dataAtualFormatada > $dataBancoFormatada) {
                              echo "bg-danger bg-opacity-25";
                            } else if ($dataAtualFormatada == $dataBancoFormatada) {
                              echo "bg-warning bg-opacity-25";
                            } else {
                              echo "bg-success bg-opacity-25";
                            } ?>">
                  <th style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#<?= $idEditar ?>">
                    <i class="fa-solid fa-pen" style="color: #236c1e;"></i>
                  </th>
                  <th style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#<?= $idExcluir ?>">
                    <i class="fa-solid fa-trash" style="color: #f01414;"></i>
                  </th>
                  <td><?= $linha["nome_tarefa"] ?></td>
                  <td><?= $linha['desc_tarefa'] ?></td>
                  <td><?= $dataExibir ?></td>
                  <td><?php if ($linha['prioridade'] == "baixa") {
                        echo "Baixa";
                      } else if ($linha['prioridade'] == "media") {
                        echo "Média";
                      } else {
                        echo "Alta";
                      } ?></td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" data-bs-toggle="modal" data-bs-target="#<?= $idFinalizar ?>" role="switch" id="flexSwitchCheckChecked">
                      <label class="form-check-label" for="flexSwitchCheckChecked">Finalizar</label>
                    </div>
                  </td>
                </tr>

                <!-- Modal Finalizar -->

                <div class="modal fade" id="<?= $idFinalizar ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Finalizar Tarefa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Deseja finalizar esta tarefa?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="Resetar()" id="btnNaoFinalizar" data-bs-dismiss="modal">Fechar</button>
                        <a href="index.php?finalizar=<?= $linha["id"] ?>">
                          <button type="button" class="btn btn-primary">Sim</button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal Atualizar Tarefa -->
                <div class="modal fade text-dark" id="<?= $idEditar //define um nome dinamico para o modal 
                                                      ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog text-dark">
                    <div class="modal-content text-dark">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Tarefa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-dark">
                        <form class="form-group text-white">
                          <div class="mb-3">
                            <label class="form-label text-dark" hidden>ID da Tarefa</label>
                            <input type="text" class="form-control" name="id" value="<?= $linha["id"] ?>" hidden>
                          </div>
                          <div class="mb-3">
                            <label class="form-label text-dark">Nome da Tarefa</label>
                            <input type="text" class="form-control" name="tarefa" value="<?= $linha["nome_tarefa"] ?>">
                          </div>
                          <div class="mb-3">
                            <label class="form-label text-dark">Descrição da tarefa</label> <textarea class="form-control" name="descricao" rows="3"> <?= $linha["desc_tarefa"] ?></textarea>
                          </div>
                          <div class="row">
                            <div class="mb-3 col-6">
                              <label class="form-label text-dark">Data / Prazo</label>
                              <input type="datetime-local" value="<?= $linha["data_tarefa"] ?>" class="form-control" name="datatarefa">
                            </div>
                            <div class="mb-3 col-6">
                              <label class="form-label text-dark">Prioridade</label>
                              <select name="select" class="form-select">
                                <option value="baixa" <?php if ($linha["prioridade"] == "baixa") echo "selected"; ?>>Baixa</option>
                                <option value="media" <?php if ($linha["prioridade"] == "media") echo "selected"; ?>>Média</option>
                                <option value="alta" <?php if ($linha["prioridade"] == "alta") echo "selected"; ?>>Alta</option>
                              </select>
                            </div>

                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" name="atualizar" value="Atualizar Tarefa" class="btn btn-primary">Salvar</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal Excluir-->
                <div class="modal fade text-dark" id="<?= $idExcluir ?>" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-theme="dark" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir Tarefa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-warning modal-title fs-5 text-center bg-danger">
                        Deseja excluir mesmo?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        <a href="index.php?delete=<?= $linha["id"] ?>">
                          <input type="submit" value="Sim" name="delete" class="btn btn-danger text-white">
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </tbody>

          </table>

          <div class="container mt-5">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item">
                <li class="page-item">

                  <?php
                  $paginaAnterior = $pag - 1;
                  $paginaPosterior = $pag  + 1;

                  if ($paginaAnterior != 0) { ?>
                    <a class="page-link bg-dark text-white" href="index.php?pagina=<?= $paginaAnterior ?>&concluidas=<?= $tarefaFinalizada ?>&txtbuscarId=<?= $valor ?>" tabindex="-1" arial-label="Previous">
                      <span aria-hidden="true">
                        &laquo;
                      </span>
                    </a>
                  <?php } else { ?>
                    <a class="page-link bg-dark text-white" arial-label="Previous">
                      <span aria-hidden="true">
                        &laquo;
                      </span>
                    </a>
                  <?php } ?>
                </li>
                <?php for ($i = 1; $i <= $numDePagina; $i++) { ?>
                  <li class="page-item <?php if ($i == $pag) echo "active" ?>">
                    <a class="page-link bg-dark text-warning" href="index.php?pagina=<?= $i ?>&concluidas=<?= $tarefaFinalizada ?>&txtbuscarId=<?= $valor ?>">
                      <?= $i ?>
                    </a>
                  </li>
                <?php } ?>
                <li class="page-item">
                  <?php if ($paginaPosterior <= $numDePagina) { ?>
                    <a class="page-link bg-dark text-white" href="index.php?pagina=<?= $paginaPosterior ?>&concluidas=<?= $tarefaFinalizada ?>&txtbuscarId=<?= $valor ?>" aria-label="Next">
                      <span aria-hidden="true">
                        &raquo;
                      </span>
                    </a>
                  <?php } else { ?>
                    <a class="page-link bg-dark text-white" aria-label="Next">
                      <span aria-hidden="true">
                        &raquo;
                      </span>
                    </a>
                  <?php } ?>
                </li>
              </ul>
            </nav>
          </div>

      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Website 2023</div>

          </div>
        </div>
      </footer>

      <div class="modal fade text-dark" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog text-dark">
          <div class="modal-content text-dark">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Nova Tarefa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
              <form class="form-group text-white">
                <div class="mb-3">
                  <label class="form-label text-dark">Nome da Tarefa</label>
                  <input type="text" class="form-control" name="tarefa" autocomplete="off" required="true">
                </div>
                <div class="mb-3">
                  <label class="form-label text-dark">Descrição da tarefa</label> <textarea class="form-control" name="descricao" rows="3" required="true"></textarea>
                </div>
                <div class="row">
                  <div class="mb-3 col-6">
                    <label class="form-label text-dark">Data / Prazo</label>
                    <input type="datetime-local" value="<?= date("Y-m-d\TH:i:s") ?>" class="form-control" name="datatarefa">
                  </div>
                  <div class="mb-3 col-6">
                    <label class="form-label text-dark">Prioridade</label>
                    <select name="select" class="form-select">
                      <option value="baixa">baixa</option>
                      <option value="media">média</option>
                      <option value="alta">alta</option>
                    </select>
                  </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" value="Cadastrar Tarefa" name="cadastrar" class="btn btn-primary">Cadastrar</button>
            </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>

  <script>
    /*
    var myModalEl = document.getElementById('exampleModa2')
    let checkFinalizar = document.getElementsByClassName('form-check-input')
    myModalEl.addEventListener('hidden.bs.modal', function(event) {
      for (let i = 0; i < checkFinalizar.length; i++) {
        checkFinalizar[i].checked = false
      }
    })
*/

    function Resetar() {
      let checkFinalizar = document.getElementsByClassName('form-check-input')
      for (let i = 0; i < checkFinalizar.length; i++) {
        checkFinalizar[i].checked = false
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>