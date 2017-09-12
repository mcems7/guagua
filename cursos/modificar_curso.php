<?php
ob_start();
@session_start(); if (isset($_SESSION['rol']) and $_SESSION['rol']<>"estudiante") { ?>
<?php
require '../comun/conexion.php';
require_once '../comun/funciones.php';
$sqlget='select * from asignacion_academica,materia,usuario where 
asignacion_academica.id_materia =materia.id_materia and
asignacion_academica.id_docente = usuario.id_usuario 
and
asignacion_academica.id_asignacion ="'.$_GET['asignacion'].'" ';
$consulta = $mysqli ->query ($sqlget) ;
while ($row = $consulta ->fetch_Assoc()){
   $_GET['icon'] =$row['icono_materia'];
      $_GET['ano_lectivo'] =$row['ano_lectivo'];
      $_GET['id_materia'] =$row['id_materia'];
       $_GET['nombre_materia'] =$row['nombre_materia'];
       $_GET['id_doc'] = $row['id_usuario'] ;
        $_GET['nombre_docente'] = $row['nombre'].' '.$row['apellido'] ;
$_GET['asignacion'] = $row['id_asignacion'];
$_GET['descripcion'] = $row['descripcion'];
$_GET['visible'] = $row['visible'];
$portada_asignacion = $row['portada_asignacion'];



    $_SESSION['id_categoria_curso']=$row['id_categoria_curso'];
}
if($_SESSION['rol']<>"admin" and $_GET['id_doc']<>$_SESSION['id_usuario']){
echo 'acceso no autorizado :(';
  exit();  
}
$consulta_area ='select * from materia where    id_materia ="'.$_GET['id_materia'].'" ';
foreach (consultar_datos($consulta_area) as $clave => $valor) {
    $area = $valor[3];
}


?>
<div class="jumbotron" <?php if(isset($portada_asignacion) and $portada_asignacion<>""){ ?>
style="
background-image: url('<?php echo SGA_CURSOS_URL.'/'.  $portada_asignacion; ?>');no-repeat left center;
     -webkit-background-size: cover;
     -moz-background-size: cover;
     -o-background-size: cover; 
"
<?php } ?>>
  <div class="container text-center">
    <h1 <?php if(isset($portada_asignacion) and $portada_asignacion<>""){ ?>
  style="opacity:0.01"> <?php } ?> class="fip">MODIFICAR CURSO</h1>      
  </div>
</div>
<div class="container-fluid bg-3 text-center">    
 <div class="row">
    <br/>
    <form action="" method="POST"  ENCTYPE="multipart/form-data">
         <div class="form-group">
  <div class="col-xs-12">
             <label for="">Modificar Curso</label>
	<input Placeholder="Nombre Curso" type="text" class="form-control" name="curso" value="<?php echo $_GET['nombre_materia'] ; ?>"/></div></div><br/>
	<br>
<?php @session_start(); if ($_SESSION['rol'] <> "docente" ) {   ?>
       <div class="form-group">
  <div class="col-xs-12">
      <br/>
        <label for="">Docente</label>

<input class="form-control" placeholder="Seleccione el docente" value="<?php if (isset($_GET['nombre_docente'])) echo $_GET['nombre_docente'] ?>"  autocomplete="off" list="suggestionList" id="answerInput">

<datalist id="suggestionList">
  <?php 
require '../comun/conexion.php';
    $sqles = 'SELECT * FROM usuario where usuario.rol like "%docente%" order by usuario.apellido asc';
$consultaes = $mysqli -> query ($sqles);
while ($rowes = $consultaes ->fetch_assoc()) {?>
   <option label ="<?php echo $rowes['id_docente']; ?>" data-value="<?php echo $rowes['id_docente'] ; ?>" ><?php echo $rowes['nombre'].' '.$rowes['apellido']  ; ?></option>
<?php 
}
?>
</datalist>
</div></div>

<input value="<?php if (isset($_GET['id_doc'])) echo $_GET['id_doc']; ?>" type="hidden" name="doc" id="answerInput-hidden"></p>
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

<?php  } ?>
 <div class="form-group">
  <div class="col-xs-12">
      <br/>
<laabel for="">Categoria</label><br/>
	    <select class="form-control" name="categoria_curso">
	        <?php 
	        require '../comun/conexion.php';
	        $sqlcategoria ='select * from categoria_curso ';
	        $consultacategoria= $mysqli ->query($sqlcategoria);
	  while ($rowcategoria = $consultacategoria ->fetch_Assoc()){ ?>
<option   <?php @session_Start(); if($rowcategoria['id_categoria_curso']==$_SESSION['id_categoria_curso']) echo "selected"; ?> value="<?php echo $rowcategoria['id_categoria_curso']; ?>"><?php 
echo $rowcategoria['nombre_categoria_curso'];
?></option>
	        <?php } ?>
	    </select></div></div>
<br/><br/><br/><br/>
<div class="form-group">
  <div class="col-xs-12"><br/>
   <label for="">Año Lectivo</label><br/>
	    <?php   
require '../comun/conexion.php';
$sql ='select * from ano_lectivo'; ?>
<select class="form-control" name="ano_lectivo">
    <?php
    $consulta = $mysqli->query ($sql);
    while ($row= $consulta ->fetch_assoc()){   ?>
    <option <?php if ($row['id_ano_lectivo']==$_GET['ano_lectivo']) echo 'selected';  ?> value="<?php echo $row['id_ano_lectivo']; ?>" >
<?php echo $row['nombre_ano_lectivo']; ?>
    </option> <?php } ?>
</select><br/></div></div>
<div class="form-group">
  <div class="col-xs-12">
<?php
echo '<p><label for="area">Área:</label>';
$sql4= "SELECT * FROM area;";
echo '<select class="form-control" name="area" id="area"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta4 = $mysqli->query($sql4);
while($row4=$consulta4->fetch_assoc()){
echo '<option value="'.$row4['id_area'].'"';if ( $row4['id_area'] ==$area) echo " selected ";echo '>'.$row4['nombre_area'].'</option>';
}
echo '</select></p>';
?></div></div>
<div class="form-group">
  <div class="col-xs-12">
      <label for="">Descripción Curso</label><br/>
<textarea placeholder="Una breve descripción de prueba..." class="form-control" name="descripcion" rows="4" cols="50"><?php echo $_GET['descripcion'] ; ?></textarea><br/>
<div class="form-group">
   <div class="col-xs-12"> 
	    <label for="">Visible</label><br/>
	    <select  class="form-control"  id="visible" name="visible">
<option <?php if($_GET['visible'] =="SI") echo 'selected'; ?> value="SI">SI</option>
<option  <?php if($_GET['visible'] =="NO") echo 'selected'; ?> value="NO">NO</option>

</select>
</div></div>
<div class="form-group">
   <div class="col-xs-12">
    	    <label for="">Imagen Portada del Curso <?php
    	    if(isset($_GET['portada_asignacion']) and  $_GET['portada_asignacion']<>""){
    	        echo '<a target="_blank" href="'.$_GET['portada_asignacion'].'">Ver Actual</a>';
    	    }
    	    
    	    ?></label>
    	    
    	    
    	    <br/>
 <input id="subirportada" onchange="ValidarArchivo(this);validar_resolución(this)" name="portada[]" class="form-control" type="file" multiple="multiple" /><br/>
       </div></div><br/><br/><br/><br/>
<label for="">Icono Representativo:</label>
<br/><div class="btn-toolbar btn-lg" role="toolbar">
    <input type="hidden" name="icon" id="icono_seleccionado" value="11">
<img title="Pulse aqui para cambiar el icono" width="50px" id="icono_seleccionado_img" src="<?php echo SGA_COMUN_URL ?>/img/png/app.png" onclick="parent.buscar_iconos();document.getElementById('btn_elegir_icono').click();">
<span style="display:none">
<?php boton_modal_elegir_icono();?>
</span>
<?php
/*
   <span  width="120px!important" data-toggle="modal" data-target="#myModal" style="background-size: 80px 80px;margin-top:-50px;margin-left:80px" onclick="selecciona_icono(this)" id="icono" class="<?php if (isset($_GET['icon'])) echo 'icon-sga-'.$_GET['icon']; else { echo 'icon-sga-books'; } ?>"></span onclick="selecciona_icono(this)">
<input style="display:none" type="text" id="icon" name="icon" value="
<?php if(isset($_GET['icon'])) {
    echo $_GET['icon']; 
} else {
echo 'icon-sga-books';
} ?>"/>
*/?>
</div>
<?php /*
<script type="text/javascript" src="../comun/js/funciones.js"></script>
<script type="text/javascript" >
  function selecciona_icono(icono){
    document.getElementById("icono").className = icono.className;
     document.getElementById("icon").value = icono.className;
}
</script><link rel="stylesheet" type="text/css" href="<?php echo SGA_COMUN_URL ?>/img/icono_curso/icon-cursos.php">
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
    $valorBusqueda = $_POST['valorBusqueda'];
    $resultados_por_página = 4; 
$cookiepage = 'page_red';//cookie para mandar el parametro de la página
$paginacion->cookie_page($cookiepage);//requerida para que se envíe el parametro en la paginacion
    $paginacion->fn_js_page('mostrarSugerenciaiconos();');//funcion para buscar despues de pasar la pagina
    $paginacion->records_per_page($resultados_por_página);
    $paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"]; 
  $encontrados = glob("../comun/img/icono_curso/*.png");
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
  ?>
  
  
</div>
    </div><!--div class="modal-body"-->

      </div>

    </div>
  </div>
</div>
*/?>

</p><p>
      </div></div>


<input class="btn-success" type ="submit" name="" value="Modificar"></input>
    </form>
</form>
<?php ventana_modal_elegir_icono();?>
<?php ventana_modal_nuevo_icono('id="form_guardar_icono" method="post" class="form_ajax" resp_1="Icono creado correctamente" resp_0="icono no creado, revise su información e intentete nuevo" action="?guardar_icono" callback_1="document.getElementById(\'cerrar_modal_nuevo_icono\').click();" callback_0="false" callback="parent.buscar_iconos();"'); ?>

</div>
</div>
<?php 

if (isset($_POST['curso'])){
if (isset($_FILES['portada'])){

    $total = count($_FILES['portada']['name']);// Contamos la cantidad de archivos

for($i=0; $i<=$total-1; $i++) {
        require_once '../comun/funciones.php';

    $formatos = formatos();
    $tamaño_maximo= tamaño_maximo(); 
    $nombre_archivo=$_FILES['portada']['name'][$i];
$ruta_tmp_archivo = $_FILES['portada']['tmp_name'][$i];
 
 if ($nombre_archivo != ""){
     
$extensión_archivo = (pathinfo($nombre_archivo,PATHINFO_EXTENSION));
 if (in_array($extensión_archivo, $formatos)){echo "El formato no es valido"; exit(); }
 if(filesize($_FILES['portada']['tmp_name'][$i]) > $tamaño_maximo ) {
              echo "No se puede subir archivos con tamaño mayor a ".$tamaño_maximo; 
              exit(); 
            }
$ruta_destino = "portada/".$_GET['asignacion']. '.'.$extensión_archivo;

 move_uploaded_file($ruta_tmp_archivo,$ruta_destino);
     
 }
}
   
}
   
   
   
    require '../comun/conexion.php';
    $sql = 'insert into materia (nombre_materia) VALUES ("'.$_POST['curso'].'")' ;
    $consulta = $mysqli -> query ($sql) ;
         $id_materia = $mysqli->insert_id ;
 $_POST['icon'] = str_replace("icon-sga-","",$_POST['icon']);

 $sqli2 = 'UPDATE `materia` SET `icono_materia` = "'.$_POST['icon'].'" ,  `area`= "'.$_POST['area'].'", `nombre_materia`= "'.$_POST['curso'].'" ';
 
 $sqli2.=' WHERE `id_materia` ="'.$_GET['id_materia'].'"';
$consulta2 = $mysqli -> query ($sqli2) ;
@session_start(); if ($_SESSION['rol'] <> "docente" ) {  

 $sqli = 'UPDATE `asignacion_academica` SET ano_lectivo="'.$_POST['ano_lectivo'].'",id_categoria_curso="'.$_POST['categoria_curso'].'", id_docente ="'.$_POST['doc'].'" , `descripcion`="'.$_POST['descripcion'].'" ';
                                                        }
else {
   $sqli = 'UPDATE `asignacion_academica` SET id_categoria_curso="'.$_POST['categoria_curso'].'", `descripcion`="'.$_POST['descripcion'].'" ';

}
if (isset($nombre_archivo) and $nombre_archivo <> ""){
      $sqli.= ' , portada_asignacion= "'.$ruta_destino.'" '; 
 }
 
$sqli.=' WHERE id_asignacion ="'.$_GET['asignacion'].'" ';

if ($consultai = $mysqli -> query ($sqli) ) { ?>
 <script type="text/javascript" >
      alert2('Curso modificado correctamente');
      setTimeout(function(){
        window.location="curso.php?asignacion=<?php echo $_GET['asignacion'] ?>"; 
      },3000);
</script>
<?php }else{ ?>

    <?php //session_start();
     if ($_SESSION['rol']=="docente") { ?> 
  <script type="text/javascript" >
      alert2('Verificar datos');
      setTimeout(function(){
        window.location="curso.php?asignacion=<?php echo $_GET['asignacion'] ?>"; 
      },3000);
</script>	
<?php } else { ?>
  <script type="text/javascript" >
        alert ('Verificar datos');
  window.location="curso.php?asignacion=<?php echo $_GET['asignacion'] ?>"; 
</script>
<?php } ?>
    
    
    
<?php  }
}
}
$contenido = ob_get_clean();
require ("../comun/plantilla.php");
?>