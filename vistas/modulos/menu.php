<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="ti ti-search"></i>
                </a>
            </li>
        </ul>
        <div class="d-block d-lg-none">
            <img src="../../dist/images/logos/dark-logo.svg" class="dark-logo" width="180" alt="" />
            <img src="../../dist/images/logos/light-logo.svg" class="light-logo" width="180" alt="" />
        </div>
        <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between">
                <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                    <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">



                    <!-- Perfil de usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="user-profile-img">
                                    <img src="<?php echo $_SESSION['foto']; ?>" class="rounded-circle" width="35" height="35" alt="<?php echo $_SESSION['nombre']; ?>" />

                                </div>
                            </div>
                        </a>

                        <?php
                        $perfilNombre = '';

                        switch ($_SESSION['perfil']) {
                            case 1:
                                $perfilNombre = 'Administrador';
                                break;
                            case 2:
                                $perfilNombre = 'Recepción';
                                break;
                            case 3:
                                $perfilNombre = 'Delivery';
                                break;
                            case 4:
                                $perfilNombre = 'Ayudante';
                                break;
                            default:
                                $perfilNombre = 'Desconocido';
                                break;
                        }
                        ?>


                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                            <div class="profile-dropdown position-relative" data-simplebar>
                                <div class="py-3 px-7 pb-0">
                                    <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                </div>
                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                    <!-- Aquí se muestra la foto del usuario -->
                                    <img src="<?php echo $_SESSION['foto']; ?>" class="rounded-circle" width="80" height="80" alt="" />
                                    <div class="ms-3">
                                        <!-- Aquí se muestra el nombre completo del usuario -->
                                        <h5 class="mb-1 fs-3"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></h5>
                                        <!-- Aquí se muestra el perfil del usuario -->
                                        <span class="mb-1 d-block text-dark"><?php echo $perfilNombre; ?></span>
                                    </div>
                                </div>
                                <div class="message-body">
                                    <a href="./page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="../../dist/images/svgs/icon-account.svg" alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                                            <span class="d-block text-dark">Account Settings</span>
                                        </div>
                                    </a>
                                    <!-- Botón para cerrar sesión -->
                                    <a href="logout.php" class="py-8 px-7 d-flex align-items-center">
                                        <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="../../dist/images/svgs/icon-logout.svg" alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold"> Logout </h6>
                                            <span class="d-block text-dark">Cerrar sesión</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>



                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>