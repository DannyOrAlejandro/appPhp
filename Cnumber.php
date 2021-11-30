<?php 
$alert='';
if(empty($_POST['number'])){
  $alert='Todos los campos son obligatorios';
}else{
  include('DB.php');
  if (!$conex) {
    $alert='Error en la conexion con la base de datos: '.mysqli_error($conex);
  }else{
    $ID=$_SESSION['IDuser'];
    $number=$_POST['number'];
    $update="UPDATE usuarios SET number='$number' WHERE ID='$ID'";
    $query_update=mysqli_query($conex,$update);
    if($query_update){
      $alert='NUMERO DE TELEFONO ACTUALIZADO CON EXITO';
    }else {
      $alert="ERROR AL ACTUALIZAR EL NUMERO DE TELEFONO";
    }
  }
}
?>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cambiar Numero De Telefono</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">NUEVO NUMERO DE TELEFONO</label>
            <input type="number" class="form-control" id="recipient-name" name="number">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">GUARDAR NUEVO NUMERO DE TELEFONO</button>
            <div class="alert"><?php echo isset($alert)?$alert:''; ?></div>
          </div>
      </form>
      </div>
    </div>
  </div>