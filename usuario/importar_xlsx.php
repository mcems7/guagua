<?php
@session_start();
require_once("../comun/funciones.php");
if (!isset($_SESSION['usuario'])){
echo '<meta http-equiv="refresh" content="1; url=login.php" />';
exit();
}
ob_start(); 
?>
<?php
@mkdir("documentos");
require("../comun/conexion.php");
require_once("../comun/config.php");
if (!isset($_GET['name_doc'])){
?>
<br><br>
<center><h3>Importar Usuarios</h3></center>
<?php
if (isset($_POST['submit'])){
if ($_FILES['imagen']['error']){
print "error";	
}else{
$ruta = $_FILES["imagen"]["tmp_name"];
$resultado = importar_xls($ruta);
if($resultado){
echo "Si";
}else{
echo "No";
}
}
}
?>
<center>
<form action="<?php echo SGA_USUARIO_URL?>/importar_xlsx.php" method="POST" ENCTYPE="multipart/form-data">
<a class="btn btn-success" href="documentos/importar_usuario_nuevo.xlsx" >Descargar Plantilla en Blanco</a>
<a class="btn btn-info" href="documentos/importar_usuario_ejemplo.xlsx" >Descargar Plantilla con Ejemplo</a>
<br>
<label for=""><i>Formato: <stong>.xls o .xlsx</stong></i></label>
<p>
    <input name="imagen" type="file" id="bnt_file" required/>
  </p>
  <p>
      <input type="hidden" name="submit" value="">
    <button class="btn btn-primary" id="btn_reporte" >Subir</button>
  </p>
</form> 
</center>
<?php
}
if (file_exists($_GET['name_doc'])){
	?>
<script>alert3('Archivo Subido Correctamente')</script>
<?php
}else{
	?>
<script>
    alert2('Hubo un error al importar, Debe subir un archivo'.'error');
    setTimeout(function(){ document.location.href="usuario.php"; }, 2000);
 </script>
<?php
}
if (isset($_GET['name_doc'])){
$ruta =  SGA_SERVER."/usuario/".$_GET['name_doc'];
$resultado = importar_xls($ruta);
if($resultado){
?>
<script>
    alert2('Documento Importado Correctamente');
    setTimeout(function(){ document.location.href="usuario.php"; }, 2000);
</script>
<?php
}else{
?>
<script>
    alert2('Hubo un error al importar','error');
    setTimeout(function(){ document.location.href="usuario.php"; }, 2000);
</script>
<?php
}
}
$contenido = ob_get_contents();
ob_clean();
require ("../comun/plantilla.php");
?>
