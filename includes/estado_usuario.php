 		<div class="user-panel">
            <div class="pull-left image">
              <img src="imagenes/avatar_usuarios/<?php echo obtieneAvatarUsuario($_SESSION ['reservas_UserId']);  ?>" class="img-circle" alt="User Image">
            </div>
             
             <?php if ((isset( $_SESSION ['reservas_UserId'])) && ($_SESSION['reservas_UserId'] != "" ))
             	{ 

             ?>
	              <div class="pull-left info">
	              <p><?php echo obtenerNombre($_SESSION ['reservas_UserId']); ?></p>
	              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>

                   <?php 
               } 

                   ?>
          </div>