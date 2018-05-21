<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Acceder</h4>
      </div>
      <div class="modal-body">
       <form action="acceso.php" method="post" name="formacceso" class="form-horizontal" id="formacceso"  onSubmit="javascript:return validaracceso();" >
  <div class="form-group">
    <label for="strEmail" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input name="strEmail" type="email" class="form-control" id="strEmail" placeholder="Email">
    </div>
  </div>
    <div class="alert alert-danger oculto" role="alert" id="avisoalta1"><span class="glyphicon glyphicon-remove" ></span> Introduce tu e-mail.</div>
  <div class="form-group">
    <label for="strPassword" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input name="strPassword" type="password" class="form-control" id="strPassword" placeholder="Password">
    </div>
  </div>
    <div class="alert alert-danger oculto" role="alert" id="avisoalta2"><span class="glyphicon glyphicon-remove" ></span> Introduce tu password.</div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input name="idRecordar" type="checkbox" id="idRecordar"> Recordarme
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Acceder</button>
    </div>
  </div>
    <input type="hidden" class="form-control" id="MM_Acceso" name="MM_Acceso" value="accesousuario">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <a href="usuario-alta.php" class="btn btn-primary" role="button">Registrarme</a>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal de condiciones de uso-->
<div class="modal fade" id="condicionesuso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Condiciones de uso</h4>
      </div>
      <div class="modal-body">
        La presente aplicación es para uso de la Oficina de Divulgación de la Universidad de Costa Rica. <br>
        Los horarios de reservación quedan sujetos a que el chofer este disponible.
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<!--APARTADO DE SCRIPTS DE VALIDACION, Y JAVASCRIPT EN GENERAL-->
<script>
function validaralta()
{
    valid = true;
	$("#aviso1").hide("slow");
	$("#aviso2").hide("slow");
	$("#aviso3").hide("slow");
	$("#aviso4").hide("slow");
	$("#aviso5").hide("slow");
	$("#aviso6").hide("slow");
	$("#aviso7").hide("slow");
	$("#aviso10").hide("slow");
	//COLORES
	if (document.altausuario.strNombre.value == ""){
		$("#aviso1").show("slow");
	    valid = false;
	}
	if (document.altausuario.strEmail.value == ""){
		$("#aviso2").show("slow");
	    valid = false;
	}
	if (document.altausuario.strEmail2.value == ""){
		$("#aviso3").show("slow");
	    valid = false;
	}
	if (document.altausuario.strPassword.value == ""){
		$("#aviso5").show("slow");
	    valid = false;
	}
	if (document.altausuario.strPassword2.value == ""){
		$("#aviso6").show("slow");
	    valid = false;
	}
	if (document.altausuario.intAcepto.checked == false)
		{
			$("#aviso10").show("slow");
	        valid = false;
		}
	//FIN ERRORES DE CAMPOS VACIOS
	//FIN DE ERRORES DE EMAIL
	if (document.altausuario.strEmail.value != document.altausuario.strEmail2.value){
		$("#aviso4").show("slow");
	    valid = false;
	}
	if (document.altausuario.strPassword.value != document.altausuario.strPassword2.value){
		$("#aviso7").show("slow");
	    valid = false;
	}

	return valid;
}


function validaracceso()
{
    valid = true;
	$("#avisoalta1").hide("slow");
	$("#avisoalta2").hide("slow");
	//COLORES
	if (document.formacceso.strEmail.value == ""){
		$("#avisoalta1").show("slow");
	    valid = false;
	}
	if (document.formacceso.strPassword.value == ""){
		$("#avisoalta2").show("slow");
	    valid = false;
	}
	
	//FIN ERRORES DE CAMPOS VACIOS
	//FIN DE ERRORES DE EMAIL

	return valid;
}