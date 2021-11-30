<?php 
$alert='';
if(empty($_POST['password'])){
  $alert='Todos los campos son obligatorios';
}else{
  include('DB.php');
  if (!$conex) {
    $alert='Error en la conexion con la base de datos: '.mysqli_error($conex);
  }else{
    $ID=$_SESSION['IDuser'];
    $password=md5($_POST['password']);
    $update="UPDATE usuarios SET password='$password' WHERE ID='$ID'";
    $query_update=mysqli_query($conex,$update);
    if($query_update){
      $alert='CONTRASEÑA ACTUALIZADO CON EXITO';
    }else {
      $alert="ERROR AL ACTUALIZAR LA COTNRASEÑA";
    }
  }
}
?>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cambiar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">NUEVA CONTRASEÑA</label>
            <input type="text" class="form-control" id="recipient-name" name="password">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">GUARDAR NUEVA CONTRASEÑA</button>
            <div class="alert"><?php echo isset($alert)?$alert:''; ?></div>
          </div>
      </form>
      </div>
    </div>
  </div>