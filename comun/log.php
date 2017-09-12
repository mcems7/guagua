<?php
require 'conexion.php';
$datosrecibidos = $_POST['datos'];
  $sql = "select * from usuario where id_usuario ='1'";
$consulta = $mysqli -> query($sql);
if ( $row = $consulta -> fetch_assoc() ) {
 echo $row['foto'];
}
else { 
   echo $sql;
}


?>