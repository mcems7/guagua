<?php
ob_start();
@session_start();
unset($_SESSION['barra_busqueda']);
require '../comun/conexion.php';
require_once '../comun/config.php';
require_once ("../comun/funciones.php");
$sql ='select * , actividad.adjunto as adjuntom  from actividad left join red on actividad.id_red = red.id_red,asignacion_academica,usuario,materia where actividad.id_asignacion = asignacion_academica.id_asignacion and asignacion_academica.id_materia = materia.id_materia and asignacion_academica.id_docente = usuario.id_usuario and actividad.id_actividad="'.$_GET['a'].'"';
$consulta =$mysqli->query($sql);
$datos_actividad = array();
while($row=$consulta -> fetch_assoc()){
$datos_actividad = $row;
 if ($row['id_red'] != NULL){
 $formato= $row['formato'];
 if(file_exists(SGA_SERVER.'/red/'.$row['enlace']))
 $ruta= ''.SGA_RED_URL.'/'.$row['enlace'].'';
 else
 $ruta= $row['enlace'];
 }
 $nombre=$row['titulo_red'];
 $cur=$row['id_asignacion'];
 $cat= $row['id_categoria_curso'];
}
#print_r($datos_actividad);
?>
<style>
<?php
$cant = 7;//cantidad de pestañas
for ($i=1;$i<=$cant;$i++){
echo '#container_act input#tab-'.$i.':checked ~ #content #content-'.$i.'';
if ($i!=$cant) echo ',';
}

?>{
 opacity: 1;
 z-index: 100;
}
</style>
   <div id="container_act" class="colorear">
<!--Pestaña 1 activa por defecto-->
  <input id="tab-1" type="radio" name="tab-group" checked="checked" />
  <label for="tab-1">Detalle de Actividad</label>
  <!--Pestaña 2 inactiva por defecto-->
<?php  if ($datos_actividad['id_red'] != NULL and $datos_actividad['id_red']<>"" ) { ?>
  <input id="tab-2" type="radio" name="tab-group" />
  <label for="tab-2">Recurso Educativo Digital</label>
<?php } ?>
<?php  if ($datos_actividad['cuestionario'] != NULL and $datos_actividad['cuestionario']=="SI" ) { ?>
<input id="tab-3" type="radio" name="tab-group" />
  <label  for="tab-3">Cuestionario</label>
  <?php }  #if ($_SESSION['rol']=="docente"){ ?>
  <!--Pestaña 4 inactiva por defecto-->
 
 <?php
 if ($datos_actividad['adjuntom'] != NULL and strtolower($datos_actividad['adjuntom'])=="si"  ) { 
 ?>

  <input id="tab-4" type="radio" name="tab-group" />
  <label for="tab-4">Adjunto</label>

  <?php }   ?>
<?php  
$id_inscripcion=0;
if ($datos_actividad['evaluable'] != NULL and strtolower($datos_actividad['evaluable'])=="si" ) { 
   $sql_inscripcion ='SELECT * FROM `inscripcion` where id_estudiante = "'.$_SESSION['id_usuario'].'" and fecha_inscripcion like "%'.date("Y").'%" and id_asignacion="'.$cur.'"';
    $consulta_inscripcion =  $mysqli ->query($sql_inscripcion);
  if($row_inscripcion =$consulta_inscripcion->fetch_assoc() ){
      $id_inscripcion =$row_inscripcion['id_inscripcion'];
  }
$sql_actividad ='select * from seguimiento where id_actividad = "'.$_GET['a'].'" and id_inscripcion = "'.$id_inscripcion.'" ';
  $consulta =  $mysqli ->query($sql_actividad);
$resultado=  $consulta -> num_rows;
$sql_archivo ='select * from tarea_adjunto where id_actividad = "'.$_GET['a'].'" ';
 $consulta_archivo =  $mysqli ->query($sql_archivo);
$resultado_archivo=  $consulta_archivo -> num_rows;
$sql_respuesta_respuesta ='select * from respuesta where id_actividad = "'.$_GET['a'].'" ';
$consulta_respuesta =  $mysqli ->query($sql_respuesta_respuesta);
$consulta_respuesta2 = $consulta_respuesta-> num_rows;
$resultado_archivo=  $consulta_archivo -> num_rows;
if($resultado>0 or $resultado_archivo>0 or $consulta_respuesta2>0){ ?>
  <input id="tab-5" type="radio" name="tab-group" />
  <label for="tab-5">Valoración</label>
  <?php  } 
}

  ?>
<?php  if ($datos_actividad['foro'] != NULL and $datos_actividad['foro']=="SI" ) { ?>
  <input id="tab-6" type="radio" name="tab-group" />
  <label for="tab-6">Foro</label>
     <?php } 
 require '../comun/conexion.php';
$sql_actividad='Select * from seguimiento,inscripcion,usuario where
seguimiento.id_inscripcion =inscripcion.id_inscripcion and
inscripcion.id_estudiante = usuario.id_usuario and
seguimiento.id_actividad = "'.$datos_actividad['id_actividad'].'" order by apellido desc';
$ConsultaActividad = $mysqli-> query($sql_actividad);      
     $resultadosActividad = $ConsultaActividad ->num_rows;
     ?>
     
     <?php if($resultadosActividad>0 and $_SESSION['rol']<>"estudiante" and $_SESSION['rol']<>"acudiente") { ?>
     <input id="tab-7" type="radio" name="tab-group" />
  <label for="tab-7">Seguimiento</label> 
  <?php } ?>
<div id="content">
      <div id="content-7">
<h1>Seguimiento Valorativo:</h1>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
  </script>
 <script type="text/javascript" src="../comun/js/funciones.js"></script>
   <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(DibujarColumnas);

function DibujarColumnas() {
var data = google.visualization.arrayToDataTable([
        ["Persona", "Valoración", { role: "style" }  ],
     <?php
   @session_start();
   require '../comun/conexion.php';
$sql_actividad='Select * from seguimiento,inscripcion,usuario where
seguimiento.id_inscripcion =inscripcion.id_inscripcion and
inscripcion.id_estudiante = usuario.id_usuario and
seguimiento.id_actividad = "'.$datos_actividad['id_actividad'].'" order by apellido desc';
$ConsultaActividad = $mysqli-> query($sql_actividad); 
 while ($rowActividad = $ConsultaActividad -> fetch_assoc() ) {          ?> 
 ["<?php  echo $rowActividad['apellido'].' '.$rowActividad['nombre']; ?>", <?php echo $rowActividad['valoracion']; ?>, colorvaloracion(<?php echo $rowActividad['valoracion']; ?>) ],
<?php } ?>
]);
  var options = {
        title: "Estudiante", 
        width: 1024, 
        height: 600,
        bar: {groupWidth: "95%"}, 
      }; 
      var chart = new google.visualization.BarChart(document.getElementById("Contenedor_p")); 
      chart.draw(data, options);
}
      </script>
<div id="Contenedor_p" style="width: 700px; height: 300px;"></div>
    </div>
    <div style="margin-top:-30px;"  id="content-1" >
     <h1 id="titulo" ><?php require_once ("../comun/funciones.php");
     
 echo deletrear(strtoupper($datos_actividad['nombre_materia']));  ; 
   $sql_categoria ='select * from categoria_curso where id_categoria_curso = "'.$datos_actividad['id_categoria_curso'].'"';
  foreach (consultar_datos($sql_categoria ) as $value => $valor ) {
 echo deletrear(' ('.$valor[1].')');
  }
     ?><a href="curso.php?asignacion=<?php echo $cur; ?>&curso=<?php echo $datos_actividad['nombre_materia'] ;?>"><input title="Ver Actividades de <?php echo $datos_actividad['nombre_materia']; ?>" style="margin-left:10px;height:45px; width:50px;" type="image" src="<?php echo consultar_link_icono($datos_actividad['icono_materia']); ?>"/></a> <?php if(($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" )){ ?> 
    <a href="actividad.php?actividad=<?php echo $_GET['a'] ?>">
  <img src="<?php echo SGA_COMUN_URL.'/'.'img/modificar.png' ; ?>" title = "Modificar <?php if(isset($rowa)) echo $rowa['nombre_materia'];  ?>"></img></a> <?php } ?></h1>
  <form method="post" action="<?php echo SGA_MENSAJE_URL ?>/redactar.php"; target="_blank">
<input type="hidden" name="responder_a" value="<?php if (isset($datos_actividad)) echo $datos_actividad['id_usuario'];?>">
<input type="hidden" name="responder_n" value="<?php if (isset($datos_actividad)) echo $datos_actividad['nombre']." ".$datos_actividad['apellido'];?>">
<input type="hidden" name="responder_mensaje" value="">
<input type="image" id="imgdocente2" title="Enviar Mensaje a <?php echo  $datos_actividad['nombre'].' '. $datos_actividad['apellido']; ?>"  src="<?php echo READFILE_URL.'/foto/'.$datos_actividad['foto']; ?>" >
</form>
  <span><strong>Docente:</strong> </span><?php echo $datos_actividad['nombre'].' '. $datos_actividad['apellido'].'<br>'; ?>
   <span><strong>Nombre Actividad:</strong></span>  <?php echo $datos_actividad['nombre_actividad'].'<br>'; ?>
   <span><strong>Período académico :</strong></span>  <?php echo $datos_actividad['periodo'].'<br>'; ?>
   <span><strong>Fecha y Hora Publicación:</strong></span>  <?php echo formatofecha($datos_actividad['fecha_publicacion']).' / '.formatohora($datos_actividad['hora_publicacion']).'<br>'; ?>
   <span><strong>Descripción:</strong></span>  <?php echo $datos_actividad['Observaciones'].'<br>'; ?>
  <span><strong>Actividad Evaluable:</strong></span>  <?php 
  echo $datos_actividad['evaluable'].'<br>';  ?>
  <span><strong>Cuestionario:</strong></span>  <?php 
  echo $datos_actividad['cuestionario'].'<br>';  ?>
  <span><strong>Adjuntar Archivo:</strong></span>  <?php echo $datos_actividad['adjuntom'].'<br>'; //} ?>
<?php if ($datos_actividad['evaluable']=="SI"){ ?>
  <span><strong>Fecha y hora Entrega :</strong></span> <?php
   if($datos_actividad['fecha_entrega'] != "0000-00-00"){
  echo formatofecha($datos_actividad['fecha_entrega']).'/'.formatohora($datos_actividad['hora_entrega']).'<br>';
  }
list($dia, $mes,$año) = diferenciaentrefechas($datos_actividad['fecha_publicacion'],$datos_actividad['fecha_entrega']);
list($dia2, $mes2,$año2) = diferenciaentrefechas($datos_actividad['fecha_entrega'],date('Y-m-d'));
@list($uno,$dos) = colores($dia,$dia2);
 if($dia2 > 0) {
    if($dia2>1){ $s = 's'; } else { $s = ''; } 
    if(date('Y-m-d')>$datos_actividad['fecha_entrega']){ $tiempo = 'Hace'; } else { $tiempo = 'Restan'; } 

     echo '<strong>"'.$tiempo.'": </strong>'.$dia2.' día'.$s; 
 } 
else {
#echo '<strong>Actividad Vencida el</strong> '.$fecha_entreg ;    
}

?>

<?php } ?>  
 

<form method="post" action="<?php echo SGA_MENSAJE_URL ?>/redactar.php"; target="_blank">
<input type="hidden" name="responder_a" value="<?php echo $datos_actividad['id_docente'];?>">
<input type="hidden" name="responder_n" value="<?php echo $datos_actividad['nombre']." ".$datos_actividad['apellido'];?>">
<input type="hidden" name="responder_mensaje" value="">
<input type="image" id="imgdocente" title="Enviar Mensaje a <?php echo  $datos_actividad['nombre'].' '. $datos_actividad['apellido']; ?>"  src="<?php echo READFILE_URL.'/foto/'.$datos_actividad['foto']; ?>" >
</form>
</div>
    

    <div style="margin-top:-35px;" id="content-2"  >
        
        <?php
    
        if ($datos_actividad['id_red'] != NULL and $datos_actividad['id_red']<>"" ){ ?>
<h1 align:center ><!--a onclick="return mostrar_pantalla_completa('miframe');"  >Pantalla Completa</a--></h1>
<?php
reproductor($formato,$ruta);?>  
    <?php }else{ ?>
    No hay Red
    <?php }
if (isset($datos_actividad['id_red'])){
/*
require(dirname(__FILE__)."/../comun/conexion.php");
  $sql_red= 'select * from red,usuario,materia where
  red.materia_red = materia.id_materia and
  red.responsable = usuario.id_usuario 
  and id_red = '.$datos_actividad['id_red'].'' ;
 $consulta = $mysqli->query($sql_red);
 $metadatos= array();
 if($row_red = $consulta->fetch_assoc()){
  $metadatos = $row_red ;
    if (isset($datos_actividad['id_red'])){
  */
  $metadatos = $datos_actividad;
 echo '<div style="position:absolute;margin-top:-35%;margin-left:65%;">';
 echo '<h2>'.$metadatos['titulo_red'].'</h2>'; 
  echo '<span>Responsable:  '.$metadatos['nombre'].' '.$metadatos['apellido'].'</span><br>'; 
  echo '<span>Materia :'.$metadatos['nombre_materia'].'</span><br>'; 
 # $metadatos['nivel_eductivo'] = explode(",",json_decode($metadatos['nivel_eductivo'],true));
 $metadatos['nivel_eductivo'] = str_replace("[", "", $metadatos['nivel_eductivo']);$metadatos['nivel_eductivo'] = str_replace("]", "", $metadatos['nivel_eductivo']);
 str_replace('"', '', $metadatos['nivel_eductivo']);
  echo '<span>Nivel Educativo :'.$metadatos['nivel_eductivo'].'</span><br>'; 
  echo '<span>Fecha Publicación : '.formatofecha2($metadatos['fecha']).'</span><br>'; 
  echo '<span>Descripción :'.$metadatos['descripcion'].'</span><br>'; 
  echo '<span>Autor :'.$metadatos['autor'].'</span><br>'; 
  echo '<span>Dificultad :'.$metadatos['dificultad'].' (1 a 5)</span><br>';  ?>
  <span>Estrellas : <span id="num_fav_red"><?php $array_estrellas = json_decode($metadatos['estrellas'],true); echo count($array_estrellas) ?></span>&nbsp;<span class="fav_visor"><?php  echo mis_red_favoritos($metadatos['id_red'], $metadatos['estrellas']); ?></span>
  </span>
  <br/>
  <?php
  echo '<span>Palabras Clave :'.$metadatos['palabras_clave'].'</span><br>'; 
  echo '<span>Icono :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="'.$metadatos['icono_red'].'"></span></span><br><br/>'; 
 ?> <input style="color:#FFF" onclick="window.open('../comun/funciones.php?ruta_red=<?php echo $metadatos['enlace']; ?>&formato=<?php echo $metadatos['formato']; ?>&scorm=<?php echo $metadatos['scorm']; ?>')" type="button" class="btn btn-primary" value="Descargar"/>
<?php
#echo '<button type="submit" class="btn btn-success">Descargar Scorm</button>';

 echo '</div>';
}
 #}#consulta metadatos
#}  #consulta metadatos
    ?>
    
    
    
    </div>
    
  
    
    <div id="content-3" style="width:100%;height:100%">

    <?php 
    if (isset($datos_actividad['cuestionario']) and $datos_actividad['cuestionario']=="SI"){ ?>
   <button onclick="mostrar_pantalla_completa('span-3');document.getElementById('botonpc-3').style.color='red'" type="button" class="btn btn-primary">Pantalla completa</button>
   
    <!--button onclick="mostrar_pantalla_completa('span-3');document.getElementById('botonpc-3').style.color='red'">Pantalla completa</button-->
    <br>
    <span id='span-3' style="position:absolute;width:100%;height:100%">
    <iframe style="width:100%;height:100%" id="iframe-3" class="frame_cuestionario" src="<?php echo SGA_URL ?>/cuestionario/ver_cuestionario.php?embebido&enc=<?php echo $datos_actividad['id_cuestionario']?>&a=<?php echo $_GET['a']?>"></iframe>
    </span>
    <?php }else{ ?>
    No hay Cuestionario
    <?php } ?>
    </div>
    <div id="content-4">
    <?php
    if ($_SESSION['rol']=="estudiante"){ ?>
    <?php
        revisar_adjunto($datos_actividad['fecha_entrega'],$datos_actividad['id_actividad']);
    }
    ?>
    <?php if ($_SESSION['rol']=="docente"){ 

} ?>
    </div>
    
    <div id="content-5">
    <?php  ?>
    <?php
   //hacer insert into de valoraciones 
   
    $sql_ver_val = '    select * from seguimiento,inscripcion where seguimiento.id_inscripcion =inscripcion.id_inscripcion and seguimiento.valoracion <> "" and seguimiento.id_actividad="'.$datos_actividad['id_actividad'].'" and inscripcion.id_asignacion="'.$cur.'"    ';
    $consulta_ver_val = $mysqli ->query($sql_ver_val);
    if($consulta_ver_val -> num_rows>0 and $_SESSION['rol']<>'admin' and $_SESSION['rol']<>'docente'){
        while($row_ver_val=$consulta_ver_val->fetch_assoc()){
            echo '<h2>Valoración : '.$row_ver_val['valoracion'].'</h2>  ';
            echo "<br>";
            echo '<h2>Observación :</h2><h4>'.$row_ver_val['observacion'].'</h4>';
            echo "<br>";
 echo '<h2>Fecha y Hora valoración : </h2><h4>'.formatofechayhora($row_ver_val['fechayhora_valoracion']).'</h4>';

        } ?>
        <form method="post" action="<?php echo SGA_MENSAJE_URL ?>/redactar.php"; target="_blank">
<input type="hidden" name="responder_a" value="<?php echo $row['remite'];?>">
<input type="hidden" name="responder_n" value="<?php echo $datos_actividad['nombre']." ".$datos_actividad['apellido'];?>">
<input type="hidden" name="responder_mensaje" value="">
        <input style="margin-top:-50px;margin-left:120px;width:32%!important;" type="image" id="imgdocente" title="Enviar Mensaje a <?php echo  $datos_actividad['nombre'].' '. $datos_actividad['apellido']; ?>"  src="<?php echo READFILE_URL.'/foto/'.$datos_actividad['foto']; ?>" ></form>
        <?php
        
    }else{
        echo "Aún no hay valoración de esta actividad";
    }
    ?>
    <?php //} ?>
    <?php if ($_SESSION['rol']=="docente"){ ?>
        <?php
        //SELECT *,inscripcion.id_inscripcion,`estudiante`.`id_estudiante` FROM inscripcion left join `seguimiento` on `inscripcion`.`id_inscripcion` = `seguimiento`.`id_inscripcion` and '70' = `seguimiento`.`id_actividad` ,`estudiante`, usuario left join `tarea_adjunto` on `usuario`.`id_usuario` = `tarea_adjunto`.`id_estudiante` and '70' = `tarea_adjunto`.`id_actividad` WHERE inscripcion.id_asignacion= "151" and usuario.id_usuario = estudiante.id_estudiante and estudiante.id_estudiante = inscripcion.id_estudiante and concat(estudiante.id_estudiante," ", usuario.clave," ", LOWER ( usuario.nombre )," ", LOWER (usuario.apellido)," ", LOWER (usuario.direccion)," ",usuario.direccion," ", LOWER ( usuario.direccion)," ") LIKE LOWER ( "%%" ) and estudiante.id_categoria_curso = "1" ORDER BY estudiante.id_estudiante LIMIT 10
        ?>
        
        <div class="row">
          
<div class="col-md-1">
<label>
  <input hidden checked mostrarocultar='div_val_act' type="checkbox" id="checkboxdiv_lista" value="SI"><span title="Ver/Ocultar Listado de Estudiantes" style="margin-left:180px;width: 40px;height: 40px;background-size: 40px 40px;margin-top: 2px;" class="icon-sga-test"></span></label>  
</div>
</div>
<div class="row">
<div class="col-md-5" id="div_val_act">
<input type='search' id='buscar_estudiante_actividad' placeholder='Buscar Estudiante..' onkeyup="buscar_estudiantes_actividad(<?php echo $_GET['a']; ?>,this.value)">
<span id="txt_val_act">
<?php buscar_estudiantes_actividad($_GET['a']); ?>
</span>
</div>
<div class="col-md-7">
<label>
<input mostrarocultar='div_vista_tarea_cue' type="checkbox" id="checkboxdiv_cue" value="SI">Ver Tarea Estudiante</label>
<br>
<div class="foro" id="div_vista_tarea_cue" style="display: none;">
<p id="txtrevisar_adjunto"></p>
<p id="txtrevisar_cuestionario"></p>
</div>
Valoración de la actividad <?php echo $datos_actividad['nombre_actividad']; ?>
<form>
    <!-- NO TOCAR -->
    <!-- id_act_val, id_seguimiento, id_inscripcion se utilizan en la función guardar valoración -->
        <p>
        <input type="hidden" id="id_act_val" placeholder="id_act_val" value="<?php echo $_GET['a']; ?>">
        <input type="hidden" id="id_seguimiento" placeholder="id_seguimiento" value="">
        <input type="hidden" id="id_inscripcion" placeholder="id_inscripcion" value="">
        </p>
    <!-- NO TOCAR -->   
        <label>Valoración </label>&nbsp;&nbsp;<input type="text" id="valoracion"><br>
        <label>Observación</label>
        <p><textarea id="observacion" cols="60" rows="10"></textarea></p>
     </form>
     <button class="btn btn-primary" onclick="guardar_valoracion()">Guardar</button>
</div>
</div>
    <?php } ?>
    </div>
<?php  if ($datos_actividad['foro'] != NULL and $datos_actividad['foro']=="SI" ) { ?>
    <div id="content-6" style="
    width: 100%;
">
<span id="txt_entradas">
<script>listar_entradas(<?php echo $datos_actividad['id_foro']?>);</script>
</span>
    </div>
    <?php } ?>
   
</div><!--div id="content"-->
 
</div><!--div id="container"-->
<?php
$contenido = ob_get_clean();
require ("../comun/plantilla.php");

?>