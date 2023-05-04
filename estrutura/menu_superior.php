<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Sistema Web</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="date" value="<?= date("Y-m-d\TH:i:s") ?>" name="txtbuscar" placeholder="" aria-describedby="btnNavbarSearch" />
                <button class="btn btn-danger" id="btnNavbarSearch" type="submit" name="btnBuscar"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configurações</a></li>                   
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <!-- Deve passar o data-bs-target do modal da pagina index -->
                    <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modalSair">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>