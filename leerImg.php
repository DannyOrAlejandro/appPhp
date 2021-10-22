<?php
$query="SELECT perfil_img,tipoDeImg FROM usuarios WHERE ID='$ID'";
$result=mysqli_query($conex,$query);
?>
<!--image/png tipo de archivo png o con variable de tip de archivo para que me reciava png jpg todo tip de imagenes
en base64 encode para -->
<img src="data:<?php echo $tipoImg ?>;base64,<?php echo base64_encode($row['perfil_img']) ?>"" alt="Girl of anime" class="card-img-top">
<?php
?>