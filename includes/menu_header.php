
<nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="imagenes/avatar_usuarios/<?php echo   obtieneAvatarUsuario($_SESSION ['reservas_UserId']  );  ?>" class="user-image" alt="User Image">
                
                   <?php if ((isset( $_SESSION ['reservas_UserId'])) && ($_SESSION['reservas_UserId'] != "" )){ ?>
                   
                   <span class="hidden-xs"><?php echo obtenerNombre($_SESSION ['reservas_UserId']); ?></span> 

                   <?php } ?>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="imagenes/avatar_usuarios/<?php echo   ObtieneAvatarUsuario($_SESSION ['reservas_UserId'] );  ?>" class="img-circle" alt="User Image">
                    <p>
                     <?php echo obtenerNombre($_SESSION ['reservas_UserId']); ?> - <?php echo obtenerSeccionUsuario($_SESSION ['reservas_UserId'] ); ?>
                      <small><?php echo $config['nombre_institucion']; ?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 ">
                      Correo: <?php echo  obtenerEmail($_SESSION ['reservas_UserId']); ?>
                    </div>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="usuario-salir.php" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
                         </ul>
          </div>
        </nav>
