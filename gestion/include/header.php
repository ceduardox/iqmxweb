<header class="main-header">

        <!-- Logo -->

        <a href="main" class="logo">

          iQMax

        </a>

        <!-- Header Navbar: style can be found in header.less -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

          </a>

          <div class="navbar-custom-menu ">

            <ul class="nav navbar-nav">

              <!-- Notifications: style can be found in dropdown.less --><!-- Tasks: style can be found in dropdown.less --><!-- User Account: style can be found in dropdown.less -->

              <li class="dropdown user user-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">  

                  <img src="<?php echo getAvatar($_SESSION['AVATAR_USER_CITEXBO_ADM'], $_SESSION['GENERO_USER_CITEXBO_ADM'])?>" class="user-image" alt="User">

                  <span class="hidden-xs"><?php echo $_SESSION['USER_CITEXBO_ADM'] ?></span>

                </a>

                <ul class="dropdown-menu">

                  <!-- User image -->

                  <li class="user-header">

                    <img src="<?php echo getAvatar($_SESSION['AVATAR_USER_CITEXBO_ADM'], $_SESSION['GENERO_USER_CITEXBO_ADM'])?>" width="160px" class="img-circle" alt="User Image">

                    <p>

                     <?php echo $_SESSION['NOM_USER_CITEXBO_ADM']." ".$_SESSION['APEPA_USER_CITEXBO_ADM']." ".$_SESSION['APEMA_USER_CITEXBO_ADM'] ?>

                      <small>Administrador</small>

                    </p>

                  </li>

                  <li class="user-footer">

                    <div class="pull-left">

                      <a href="page-datos" class="btn btn-default btn-flat">Mis datos</a>

                    </div>

                    <div class="pull-right">

                      <a href="salir" class="btn btn-default btn-flat">Salir</a>

                    </div>

                  </li>

                </ul>

              </li>

            </ul>

          </div>

        </nav>

      </header>