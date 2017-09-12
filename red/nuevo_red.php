<?php @session_start();
require_once("../comun/config.php");
require_once("../comun/funciones.php");
require "../comun/conexion.php"; unset($_SESSION['barra_busqueda']); if (!isset($_GET['a'])){ ob_start(); ?>
<div class="jumbotron">
  <div class="container text-center">
    <h1 id="jumbo_nuevo_red" class="fip" > RECURSO EDUCATIVO DIGITAL </h1>      
  </div>
</div><br><br>
    <script>
$(document).ready(function(){
required_en_formulario(id_formulario="form_nuevo_red",color="red",elemento="*");
 });
</script>
    <?php
}
$tamaño_maximo = tamaño_maximo();
$formatos = formatos();
$carpeta_destino = READFILE_SERVER."/banco_red/";
$carpeta_destino_url = READFILE_URL."/banco_red/";
@mkdir($carpeta_destino);
?>
<form  id="form_nuevo_red" id="formulario" class="form-horizontal" role="form" action="" method="POST" ENCTYPE="multipart/form-data" >
<script type="text/javascript" >
    $( document ).ready(function() {
  revisar_vermas();
});
</script>
<?php
if (!isset($_GET['id_red'])){
$_GET['id_red']=0;
}
$sql='select * from red where id_red = "'.$_GET['id_red'].'" '; 
$consulta = $mysqli -> query ($sql); 
if ($row = $consulta -> fetch_assoc() or $consulta->num_rows >= 0) { 
?> 
<!--form role="form"-->
  <div class="form-group">
  <div class="col-xs-12">
      <label for="titulo_red">Titulo Red:</label>
<input placeholder="eje:Naturaleza" id="id_red"  required class="form-control"  name="titulo_red" type="text" id="titulo_red" value="<?php if (isset($row['titulo_red'])) echo $row['titulo_red'];?>">
<p><input  name="id_red" type="hidden"  value="<?php 
if (isset($row['id_red'])) echo $row['id_red']; ?>"></p>
</div>
</div>
<label for="">Icono Representativo:</label>
<div class="btn-toolbar btn-lg" role="toolbar">
<input type="hidden" name="icono_seleccionado" id="icono_seleccionado" value="11">
<img title="Pulse aqui para cambiar el icono" width="50px" id="icono_seleccionado_img" src="<?php echo SGA_COMUN_URL ?>/img/png/app.png" onclick="parent.buscar_iconos();document.getElementById('btn_elegir_icono').click();">
<span style="display:none">
<?php boton_modal_elegir_icono();?>
</span>
</div>
</p><p>
      <div class="form-group">
  <div class="col-xs-12">
    <label for="adjunto">Adjunto:</label><br><label class="checkbox-inline"><input onclick="tipoinput(this.value)" type="radio" class="" name="adjunto"  checked id="adjunto" value="si" <?php if (isset($row['adjunto']) and $row['adjunto'] =="si") echo "checked"; ?>>Si</label><label class="checkbox-inline"><input onclick="tipoinput(this.value)" type="radio" id="adjunto" class="" name="adjunto"   value="no" <?php if (isset($row['adjunto']) and $row['adjunto'] =="no") echo "checked" ; ?>>No</label><br></p>
    </div>
    </div>
    <div class="form-group">
  <div class="col-xs-12">
<p><label for="enlace">Enlace:</label><input 
<?php if (!isset($row['id_red'])) {
    echo 'required';
}
?>
 onchange="ValidarArchivo(this);validar_resolución(this)" class="form-control" name="enlace[]"  type="file" id="enlace" value="<?php if (isset($row['enlace'])) echo $row['enlace'];?>"></p>
</div>
</div>
  <div class="form-group">
  <div class="col-xs-12">
<p><label for="enlace">Cantidad de Estrellas Para Visualizar:</label><input  class="form-control" name="cantidad_estrellas"  type="number" id="cantidad_estrellas" value="<?php if (isset($row['cantidad_estrellas'])) { echo $row['cantidad_estrellas']; } else  {  echo '0'; }?>"></p>
</div>
</div>

  <div class="form-group">
  <div class="col-xs-12">
<p><label for="scorm">Scorm:</label><br/>
<label class="checkbox-inline">
    <input type="radio" class="checkbox-inline" name="scorm" id="scorm[1]"  value="si" <?php
    if(isset($row['scorm']) and $row['scorm'] =="si") echo "checked"; ?> /> 
    Si </label><label class="checkbox-inline"><input type="radio"  name="scorm" id="scorm[2]" checked ="true"  value="no" <?php if (isset($row['scorm']) and $row['scorm'] =="no") echo " checked "?>>No</label><br></p>
    </div>
    </div>
    <div class="form-group">
  <div class="col-xs-12">
    
<p><label for="label_asignatura">Asignatura:</label>
<select required class="form-control" id="asignatura"  name="asignatura" >
  <?php 
  require '../comun/conexion.php';
  $sqlm ='select * from materia where obligatoria="SI" ';
  $consultam = $mysqli ->query($sqlm);
  while($rowm=$consultam ->fetch_assoc()){  ?>
         <option <?php if (isset($row['materia_red']) and $row['materia_red'] ==$rowm['id_materia'])  echo "Selected" ; ?>
         value="<?php echo $rowm['id_materia']; ?>"><?php echo $rowm['nombre_materia']; ?> </option>
    <?php } ?>
</select>
</div></div>
  <div class="form-group">
  <div class="col-xs-12">
<p><label for="nivel_eductivo">Nivel Eductivo:</label>
<?php if(isset($row['nivel_eductivo'])) $nivel_educativo = json_decode ($row['nivel_eductivo']);  ?>
<select required class="form-control" name="nivel_eductivo[]" id="nivel_eductivo" multiple >
<option value="">Seleccione una opci&oacute;n</option>
<?php 
niveles_educativos($nivel_educativo);
/*
<option value="1" <?php if (isset($row['nivel_eductivo']) and (in_array("1", $nivel_educativo))) echo "selected"; ?>>PRIMERO</option>
<option value="2" <?php if (isset($row['nivel_eductivo']) and  (in_array("2", $nivel_educativo))) echo "selected"; ?>>SEGUNDO</option>
<option value="3"<?php if (isset($row['nivel_eductivo']) and (in_array("3", $nivel_educativo))) echo "selected"; ?> > TERCERO</option>
<option value="4" <?php if (isset($row['nivel_eductivo']) and (in_array("4", $nivel_educativo))) echo " selected "; ?>>CUARTO</option>
<option value="5" <?php if (isset($row['nivel_eductivo']) and (in_array("5", $nivel_educativo))) echo " selected " ; ?>>QUINTO</option>
*/ ?>
</select>
</p></div></div>
     <div class="form-group">
  <div class="col-xs-12">
<p><label for="descripcion">Descripción:</label>
<textarea id="descripcion" class="form-control" placeholder="Lectura comprensiva.." rows="4" cols="50" name="descripcion"><?php if (isset($row['descripcion'])) echo $row['descripcion'] ; ?></textarea><br></div></div>
<div class="checkbox2">
  <label><input onclick="revisar_vermas()" type="checkbox" id="vermas" name="vermas" value="vermas">&nbsp;Ver Más</label>
</div>
<br> 

<body >
  
<div id="toogle">
<div class="form-group">
  <div class="col-xs-12">
<label for="idioma_red">Idioma Red:</label><input class="form-control" name="idioma_red"type="text" id="idioma_red" value=" <?php if (isset($row['idioma_red'])) echo $row['idioma_red']; else{ echo 'Es'; } ?>" ></div></div>

<p><label for="dificultad">Dificultad:</label>
<div class="form-group">
  <div class="col-xs-12">
<select class="form-control"  id="dificultad" name="dificultad">
<option value="2" <?php if (isset($row['dificultad']) and $row['dificultad']=="2" ) echo "selected"; ?> >Media</option>
<option value="3" <?php if (isset($row['dificultad']) and $row['dificultad']=="3") echo "selected"; ?> >Alta</option>
<option value="1" <?php if (isset($row['dificultad']) and $row['dificultad']=="1") echo "selected"; ?> >Baja</option>
</select></div></div>
<div class="form-group">
  <div class="col-xs-12">
<br><label for="palabras_clave">Autor:</label><input class="form-control"name="autor"type="text" placeholder="eje:Andrés Paz"  id="autor" value="<?php if (isset($row['autor'])) echo $row['autor']; ?>"><br/></div></div>
<div class="form-group">
  <div class="col-xs-12">
<p><label for="palabras_clave">Palabras Clave:</label></p><p><textarea placeholder="Lenguaje,innovación,educación.." class="form-control" name="palabras_clave" cols="60" rows="10"id="palabras_clave" ><?php if (isset($row['palabras_clave'])) echo $row['palabras_clave']; ?></textarea></p>
</div></div>
<p><input class=""name="responsable"type="hidden" id="responsable" value="<?php if (isset($row['responsable'])) echo $row['responsable']; ?>"></p>
<p><input class=""name="formato"type="hidden" id="formato" value=" <?php if (isset($row['formato'])) echo $row['formato'];?>" ></p>
<p>
    <div class="form-group">
  <div class="col-xs-12">
    <label style="display:none;" for="contexto">Contexto Educativo:</label><input class="form-control" name="contexto" type="hidden" placeholder="" id="contexto" value=" <?php if (isset($row['contexto'])) echo $row['contexto']; else { echo 'Primaria'; } ?>"></p></div></div>
    <div class="form-group">
  <div class="col-xs-12">
<p><label for="tipo_interacción">Tipo de  Interacción:</label>

<input  class="form-control" placeholder="eje: Alto,Medio,Bajo"  name="tipo_interacción"type="text" id="tipo_interacción" value="<?php if (isset($row['tipo_interacción'])) echo $row['tipo_interacción']; ?>"></p></div></div>
 <div class="form-group">
  <div class="col-xs-12">
<p><label for="tipo_recurso_educativo">Tipo Recurso Educativo:</label></p><p><textarea placeholder="eje:cuestionario,software educativo,diapositiva.." class="form-control" name="tipo_recurso_educativo" cols="60" rows="10"id="tipo_recurso_educativo" ><?php if (isset($row['tipo_recurso_educativo'])) echo $row['tipo_recurso_educativo']; ?></textarea></p>
</div></div>
<p><input class=""name="estrellas"type="hidden" id="estrellas" value=" <?php if (isset($row['estrellas'])) echo $row['estrellas']; ?>"></p>
</div>
 <div class="checkbox2">
      <label><input type="checkbox" id="terminos" name="terminos" value="terminos" required value="">&nbsp;Acepto la responsabilidad por el anterior recurso digital</label></div>
<br>
<div id='mensajedeespera'></div>

<p><input class="btn btn-success" <?php 
if (isset($_GET['id_red']) and $_GET['id_red']!= ""){
$name = "Modificar" ;
}else{
$name="Guardar";
} ?> name="<?php echo $name; ?>" id="guardarred" type="<?php
if (isset($_GET['a'])){ 
echo "button"; 
} else {  
echo "submit" ; 
}
?>"  <?php
if (isset($_GET['a'])){ 
echo " onclick='Insertarredconajax()' "; 
}
?>  value="<?php echo $name; ?>"></p><br><br><br>
</form>
<?php ventana_modal_elegir_icono();?>
<?php ventana_modal_nuevo_icono('id="form_guardar_icono" method="post" class="form_ajax" resp_1="Icono creado correctamente" resp_0="icono no creado, revise su información e intentete nuevo" action="?guardar_icono" callback_1="document.getElementById(\'cerrar_modal_nuevo_icono\').click();" callback_0="false" callback="parent.buscar_iconos();"'); ?>
</div>
</div>
</div>
</div></div>

<?php 
} //Fin Consulta
#Si es adjunto
if (isset($_POST) and isset($_POST['Guardar'])){
if (isset($_POST) and isset($_POST['adjunto']) and isset($_POST['nivel_eductivo']) and $_POST['adjunto']=="si" and $_POST['nivel_eductivo']<>""){
$total = count($_FILES['enlace']['name']);
for($i=0; $i<$total; $i++) {// Recorremos cada archivo
$nombre_archivo=$_FILES['enlace']['name'][$i];  
$ruta_tmp_archivo = $_FILES['enlace']['tmp_name'][$i];
if ($ruta_tmp_archivo != ""){ 
$extensión_archivo = (pathinfo($nombre_archivo,PATHINFO_EXTENSION));
if (in_array($extensión_archivo, $formatos)){
    echo "El formato no es valido"; exit();
} 
if(filesize($_FILES['enlace']['tmp_name'][$i]) > $tamaño_maximo ) {
echo "No se puede subir archivos con tamaño mayor a ".$tamaño_maximo; 
exit(); 
}
 
if ($_POST['scorm']=="si"){
    @session_start();
    mkdir($carpeta_destino.'/'.$_SESSION['id_usuario'].$_POST['titulo_red']);
   # descomprimir_zip($ruta_tmp_archivo,$_POST['titulo_red']);
    $zip = new ZipArchive;
$zip->open($ruta_tmp_archivo);
$zip->extractTo($carpeta_destino.'/'.$_SESSION['id_usuario'].$_POST['titulo_red']);
$zip->close();
$ruta_destino2 = $carpeta_destino_url.'/'.$_SESSION['id_usuario'].$_POST['titulo_red'] ;
  insertar_red($ruta_destino2,$extensión_archivo);
}else{
     $ruta_destino = $carpeta_destino.$_SESSION['id_usuario'].$_FILES['enlace']['name'][$i];
     $ruta_destino_url = $carpeta_destino_url.$_SESSION['id_usuario'].$_FILES['enlace']['name'][$i];
  if(move_uploaded_file($ruta_tmp_archivo,$ruta_destino)) {
#echo "<pre>";print_r($_POST);print_r($_FILES);echo "</pre>";exit();
  insertar_red($ruta_destino_url,$extensión_archivo);
} 
}
                           
        }
}
  }//Cerramos el for de la lina 6 
#Fin si es adjunto



if ($_POST['adjunto']<>"si" and $_POST['titulo_red']<>""){ #Inicio si no es adjunto
    $ruta_destino = $_POST['enlace'][0];
    insertar_red($ruta_destino,$extensión_archivo="");
}#Fin si no es adjunto
}


if (isset($_POST) and isset($_POST['Modificar']) and $_POST['Modificar']){
$total = count($_FILES['enlace']['name']);

if($_FILES['enlace']['error']){
actualizar_red ($ruta_destino="null",$extensión_archivo="null");

}
else{
$total = count($_FILES['enlace']['name']);
for($i=0; $i<$total; $i++) {// Recorremos cada archivo
 $nombre_archivo=$_FILES['enlace']['name'][$i];$_FILES['nombre_campo_file']['name']['posición'];
$ruta_tmp_archivo = $_FILES['enlace']['tmp_name'][$i];
if ($ruta_tmp_archivo != ""){ 
$extensión_archivo = (pathinfo($nombre_archivo,PATHINFO_EXTENSION));
if (!in_array($extensión_archivo, $formatos)){echo "El formato no es valido"; } 
if(filesize($_FILES['enlace']['tmp_name'][$i]) > $tamaño_maximo ) {
echo "No se puede subir archivos con tamaño mayor a ".$tamaño_maximo; 
exit(); 
}
 $ruta_destino = $carpeta_destino.$_SESSION['id_usuario'].$_FILES['enlace']['name'][$i];
 $ruta_destino_url = $carpeta_destino_url.$_SESSION['id_usuario'].$_FILES['enlace']['name'][$i]; 
                if(move_uploaded_file($ruta_tmp_archivo,$ruta_destino)) { 
            actualizar_red($ruta_destino_url,$extensión_archivo);
                }                    
        }

}
}

if ($_POST['adjunto']<>"si" and $_POST['titulo_red']<>""){#Inicio si no es adjunto
    actualizar_red($ruta_destino="null",$extensión_archivo="");
}#Fin si no es adjunto
}
?>
<?php
if (!isset($_GET['a'])){
$contenido = ob_get_clean();
require ("../comun/plantilla.php");
}
 ?>