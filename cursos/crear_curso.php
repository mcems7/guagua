<?php
ob_start();
@session_start();
unset($_SESSION['barra_busqueda']);
if ($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" ){ ?>
<script >
$(document).ready(function(){
required_en_formulario(id_formulario="form_nuevo_curso",color="red",elemento="*");
 });
</script>

<div class="jumbotron">
  <div class="container text-center">
    <h1 class="fip">CREAR CURSO</h1>      
  </div>
</div>
<div class="container-fluid bg-3 text-center">    
 <div class="row">
    <br/>
    <form id="form_nuevo_curso" action="" method="POST" ENCTYPE="multipart/form-data">
        <div class="form-group">
   <div class="col-xs-12">
<label  for="">Nombre Curso</label>
	<input  placeholder="curso de ejemplo" class="form-control" required type="text" name="curso" id="curso"/></div>
</div>
           <div class="form-group">
   <div class="col-xs-12">  
	         <label for="">Docente</label>
<?php if($_SESSION['rol']=="admin"){ ?>
<input  class="form-control" required placeholder="Seleccione el docente" autocomplete="off" list="suggestionList" id="answerInput">
<datalist  id="suggestionList">

  <?php 
require '../comun/conexion.php';
    $sqles = 'SELECT * FROM usuario order by usuario.apellido asc';
$consultaes = $mysqli -> query ($sqles);
while ($rowes = $consultaes ->fetch_assoc()) {?>
   <option label ="<?php echo $rowes['id_usuario']; ?>" data-value="<?php echo $rowes['id_usuario'] ; ?>" ><?php echo $rowes['nombre'].' '.$rowes['apellido']  ; ?></option>
<?php 
}
?>
</datalist>
<input type="hidden" name="doc" id="answerInput-hidden"></p>

<script>
    document.querySelector('input[list]').addEventListener('input', function(e) {
    var input = e.target,
        list = input.getAttribute('list'),
        options = document.querySelectorAll('#' + list + ' option'),
        hiddenInput = document.getElementById(input.id + '-hidden'),
        inputValue = input.value;
    hiddenInput.value = inputValue;
    for(var i = 0; i < options.length; i++) {
        var option = options[i];
        if(option.innerText === inputValue) {
            hiddenInput.value = option.getAttribute('data-value');
            break;
        }
    }
});
</script>
<?php } ?>
<?php if($_SESSION['rol']=="docente"){?>
<p><input type="hidden" name="doc" value="<?php echo $_SESSION['id_usuario'] ?>">
<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?></p>
<?php } ?>
</div></div>
    <div class="form-group">
   <div class="col-xs-12">  
<label for="">Categoria</label>
	    <select id="categoria_curso" class="form-control" required name="categoria_curso">
	        <?php 
	        require '../comun/conexion.php';
	        $sqlcategoria ='select * from categoria_curso ';
	        $consultacategoria= $mysqli ->query($sqlcategoria);
	  while ($rowcategoria = $consultacategoria ->fetch_Assoc()){ ?>
<option value="<?php echo $rowcategoria['id_categoria_curso']; ?>"><?php 
echo $rowcategoria['nombre_categoria_curso'];
?></option>
	        <?php } ?>
	    </select>
</div></div>
	    <label for="">Año Lectivo</label>
	    <?php   
require '../comun/conexion.php';
$sql ='select * from ano_lectivo'; ?>
<select required class="form-control" required id="ano_lectivo" name="ano_lectivo">
  <?php
    $consulta = $mysqli->query ($sql);
    while ($row= $consulta ->fetch_assoc()){   ?>
    <option <?php if ($row['nombre_ano_lectivo']==date('Y')) echo 'selected';  ?> value="<?php echo $row['id_ano_lectivo']; ?>" >
<?php echo $row['nombre_ano_lectivo']; ?>
    </option> <?php } ?>
</select>
  <div class="form-group">
   <div class="col-xs-12">  
<?php
echo '<p><label for="area">Área:</label>';
$sql4= "SELECT * FROM area;";
echo '<select class="form-control" name="area" id="area"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta4 = $mysqli->query($sql4);
while($row4=$consulta4->fetch_assoc()){
echo '<option value="'.$row4['id_area'].'"'; if (isset($row['area']) and $row['area'] == $row4['id_area']) echo " selected ";echo '>'.$row4['nombre_area'].'</option>';
}
echo '</select></p>';



?></div></div>
 <div class="form-group">
   <div class="col-xs-12"> 
	    <label for="">Descripción Curso</label><br/>
</div></div>
<textarea class="form-control" placeholder="Observación.." name="descripcion" rows="4" cols="50"></textarea>
 <div class="form-group">
   <div class="col-xs-12"> 
	    <label for="">Visible</label><br/>
	    <select required class="form-control" required id="visible" name="visible">
<option value="SI">SI</option>
<option value="NO">NO</option>

</select>
</div></div>


<div class="form-group">
   <div class="col-xs-12">
    	    <label for="">Imagen Portada del Curso</label><br/>
 <input id="subirportada" onchange="ValidarArchivo(this);validar_resolución(this)" name="portada[]" class="form-control" type="file" multiple="multiple" />
       </div></div><br/><br/><br/>
   <div class="form-group">
   <div class="col-xs-12"> 
  <br/>
   <label for="">Icono Representativo:</label>
<div class="btn-toolbar btn-lg" role="toolbar">
    <input type="hidden" name="icon" id="icono_seleccionado" value="11">
<img title="Pulse aqui para cambiar el icono" width="50px" id="icono_seleccionado_img" src="<?php echo SGA_COMUN_URL ?>/img/png/app.png" onclick="parent.buscar_iconos();document.getElementById('btn_elegir_icono').click();">
<span style="display:none">
<?php boton_modal_elegir_icono();?>
</span>
<?php /*
   <span   data-toggle="modal" data-target="#myModal" style="background-size: 40px 40px;margin-top:-50px;margin-left:160px" onclick="selecciona_icono(this)" id="icono" class="<?php if (isset($row['icono_red'])) echo $row['icono_red']; else { echo 'icon-sga-books'; } ?>"></span onclick="selecciona_icono(this)">
<input type="hidden" id="icon" name="icon" value="
<?php if(isset($row['icono_red'])) {
    echo $row['icono_red']; 
} else {
echo 'icon-sga-books';
} ?>"/>
*/ ?>
</div>
<?php /*
<script type="text/javascript" src="../comun/js/funciones.js"></script>
<script type="text/javascript" >
  function selecciona_icono(icono){
    document.getElementById("icono").className = icono.className;
     document.getElementById("icon").value = icono.className;
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo SGA_COMUN_URL ?>/img/icono_curso/icon-cursos.php">
<div class="container">
  <!-- Modal -->
  <div class="modal modal-fullscreen fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Click sobre el icono para seleccionar y luego cierra</h4>
      </div>
        <div class="modal-body">
        <input onkeyup="mostrarSugerenciaiconos(this.value)" type="search" placeholder="Buscar" id="busqueda">
<div id="resultadoBusqueda">
  <ul class="bs-glyphicons">
    <?php
    require_once ("../comun/config.php");
    require_once ("../comun/lib/Zebra_Pagination/Zebra_Pagination.php");
    $paginacion = new Zebra_Pagination();
if(isset($_POST['valorBusqueda'])){
    $valorBusqueda = $_POST['valorBusqueda'];
}
    $resultados_por_página = 4; 
$cookiepage = 'page_red';//cookie para mandar el parametro de la página
$paginacion->cookie_page($cookiepage);//requerida para que se envíe el parametro en la paginacion
    $paginacion->fn_js_page('mostrarSugerenciaiconos();');//funcion para buscar despues de pasar la pagina
    $paginacion->records_per_page($resultados_por_página);
    $paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"]; 
  $encontrados = glob("../comun/img/icono_curso/*.png");
$valorBusqueda='';
  if ($valorBusqueda!=""){
  foreach ($encontrados as $id => $nombre){
  if (preg_match('/'.$valorBusqueda.'/',$nombre,$coincidencias)){
  
  }else{
    unset($encontrados[$id]);
  }
  }
  }
  $total_resultados = count($encontrados);
  $paginacion->records($total_resultados);
foreach(array_slice($encontrados, $paginacion->get_page() - 1, $resultados_por_página) as $archivo){ #delimitamos la parte del array que queremos mostrar con array_slice
	$nombre = str_replace(".png","",$archivo);
	$nombre = str_replace("../comun/img/icono_curso/","",$nombre);

	?>
  <li><span  style="margin-left: 0;background-size: 40px 40px;margin-top: 40px;" onclick="selecciona_icono(this);"  class="<?php echo $nombre; ?>"   ></span><?php echo $nombre ; ?></li>
<?php } ?>
  </ul> 
    <?php echo $paginacion->render2();
  
  
</div>
    </div><!--div class="modal-body"-->

      </div>

    */
  ?>
    </div>
  </div>

</div>

</p><p>
      </div></div>
   
              <button type="submit" class="btn btn-success btn-md">Crear</button>

</form>
<?php ventana_modal_elegir_icono();?>
<?php ventana_modal_nuevo_icono('id="form_guardar_icono" method="post" class="form_ajax" resp_1="Icono creado correctamente" resp_0="icono no creado, revise su información e intentete nuevo" action="?guardar_icono" callback_1="document.getElementById(\'cerrar_modal_nuevo_icono\').click();" callback_0="false" callback="parent.buscar_iconos();"'); ?>
<?php 
if (isset($_POST['doc'])){
    require '../comun/conexion.php';
 $_POST['icon'] = str_replace("icon-sga-","",$_POST['icon']);
$sql = 'insert into materia (nombre_materia,area,icono_materia) VALUES ("'.$_POST['curso'].'","'.$_POST['area'].'","'.$_POST['icon'].'")' ;
    $consulta = $mysqli -> query ($sql) ;
         $id_materia = $mysqli->insert_id ;
       // session_start();
 $sqli = 'INSERT INTO `asignacion_academica`(ano_lectivo,`id_docente`, `id_materia`, `descripcion`,id_categoria_curso,visible) VALUES
("'.$_POST['ano_lectivo'].'","'.$_POST['doc'].'","'.$id_materia.'","'.$_POST['descripcion'].'","'.$_POST['categoria_curso'].'","'.$_POST['visible'].'")';
$consultai = $mysqli ->query($sqli);
 $asignacion = $mysqli->insert_id; 
 $categoria =$_POST['categoria_curso'];
 $ano_lectivo=$_POST['ano_lectivo'];
require_once '../comun/funciones.php';
echo inscribir_estudiante_materia($asignacion,$categoria,$ano_lectivo);

  $tamaño_maximo=tamaño_maximo();
$formatos=formatos();
$total = count($_FILES['portada']['name']);// Contamos la cantidad de archivos

for($i=0; $i<=$total; $i++) {// Recorremos cada archivo
      $nombre_archivo=$_FILES['portada']['name'][$i];
    $ruta_tmp_archivo = $_FILES['portada']['tmp_name'][$i]; 
    if ($ruta_tmp_archivo != ""){
$extensión_archivo = (pathinfo($nombre_archivo,PATHINFO_EXTENSION));
if (in_array($extensión_archivo, $formatos)){echo "El formato no es valido";  exit(); } 
if(filesize($_FILES['portada']['tmp_name'][$i]) > $tamaño_maximo ) {
              echo "No se puede subir archivos con tamaño mayor a ".$tamaño_maximo;
              exit(); 
            }
$ruta_destino = "portada/".$asignacion.'.'.$extensión_archivo;
echo 'tmp'.$ruta_tmp_archivo;
echo 'des'.$ruta_destino;

 if(move_uploaded_file($ruta_tmp_archivo,$ruta_destino)) {
$sql_actualizar_banner='UPDATE `asignacion_academica` SET `portada_asignacion`="'.$ruta_destino.'" WHERE id_asignacion="'.$asignacion.'"';
$consulta_banner=$mysqli->query($sql_actualizar_banner);
 }
   }
}

 /*
 $sqlcur='select * from estudiante where categoria_curso ="'.$_POST['categoria_curso'].'" ';
$consultacur = $mysqli ->query($sqlcur);
$cantidad_estudiantes = $mysqli -> num_rows;
if($cantidad_estudiantes > 0){
require '../comun/conexion.php';
while ($rowcur = $consultacur ->fetch_assoc()){
    $sqlinsertarestudiantes = 'INSERT INTO `inscripcion`( `id_estudiante`, `id_asignacion`, `fecha_inscripcion`) VALUES ("'.$rowcur['id_estudiante'].'","'.$asignacion_Academica.'","'.date('Y-m-d').'")' ;
    $queryinsertarestudiantes = $mysqli ->query($sqlinsertarestudiantes    );*/ 

//}
//}
?>
<script type="text/javascript">
   alert2('Curso Creado correctamente');
   setTimeout(function(){
   window.location="mis_cursos.php"; 
   },3000);

</script>
  <?php                  }
}
$contenido = ob_get_clean();
require ("../comun/plantilla.php");



?>