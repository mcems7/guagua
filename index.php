<?php require("comun/funciones.php");
@session_start(); 

$ano_lectivo = ano_lectivo();
unset($_SESSION['login']);
if (isset($_GET['logout'])){
    unset ($_SESSION['clave']);
    unset ($_SESSION['apellido']);
    unset ($_SESSION['id_usuario']);
    unset ($_SESSION['usuario']);
    unset ($_SESSION['foto']);
    unset ($_SESSION['rol']);
    unset ($_SESSION['roles']);
    unset ($_SESSION['num_visitas']);
    unset ($_SESSION['puntos']);
    session_destroy();
    header("Location: /index.php");
}
if(isset($_SESSION['rol'])){
require("comun/conexion.php");
$sql ='select * from config';
    $consulta = $mysqli ->query($sql);
    if($row=$consulta->fetch_assoc()){
setcookie('tipos',$row['formatos_no_permitidos']);
setcookie('tamaño',$row['tamano_maximo_adjunto']);
   }
}
/* inicio favoritos */
function eventos_favoritos($id,$estrellas_array){
//eventos_favoritos($row['id'],$row['estrellas']);

$estrellas = json_decode(stripslashes($estrellas_array),true);
$estrellasmias=$estrellas[$_SESSION['id_usuario']];
if ($estrellasmias>="1"){
?>
<span id="span_eve_<?php echo $id ?>" onclick="fav_eve('<?php echo $id ?>','span_eve_<?php echo $id ?>')" estado="NO" title="Favoritos <?php echo count($estrellas) ?>" class="glyphicon glyphicon-star estrella_eve"></span>
<?php }else{ ?>
<span id="span_eve_<?php echo $id ?>" onclick="fav_eve('<?php echo $id ?>','span_eve_<?php echo $id ?>')" estado="SI" title="Favoritos <?php echo count($estrellas) ?>" class="glyphicon glyphicon-star-empty estrella_eve"></span>
<?php }
}//fin function
/* fin favoritos */
@session_start();
require_once(dirname(__FILE__)."/comun/config.php");
require_once(dirname(__FILE__)."/comun/funciones.php");
$_SESSION['modulo']="inicio";
$_SESSION['barra_busqueda']= "";
ob_start(); ?>

<?php
if(isset($_SESSION['id_usuario'])){ 
$_COOKIE['repetidas']="";
    }

# Aquí inicia la sección de Revista (Noticias)-->
?>
<style type="text/css">
body{
    background-color:#31708f!important;
}
 #cloud:after {
	width: 100px; height: 100px;
	top: -30px; left: 50px;
	border-radius: 100px;
		background: linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -webkit-linear-gradient(top, #FFF 1%, #BFF 100%);
	background: -moz-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -ms-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -o-linear-gradient(top, #BFF 5%, #DFF 100%);
	animation: nube1 5s infinite
}

#cloud:before {
	width: 200px; height: 200px;
	top: -35px; right: 50px;
	border-radius: 200px;
		background: linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -webkit-linear-gradient(top, #FFF 1%, #BFF 100%);
	background: -moz-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -ms-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -o-linear-gradient(top, #BFF 5%, #DFF 100%);
		animation: nube2 5s infinite

}

#cloud:after, #cloud:before {
	content: '';
	position: absolute;
	background: #FFF;
	z-index: -1

}
#cloud {

	width: 350px; height: 150px;
	background: #BFF;
	background: linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -webkit-linear-gradient(top, #FFF 1%, #BFF 100%);
	background: -moz-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -ms-linear-gradient(top, #BFF 5%, #DFF 100%);
	background: -o-linear-gradient(top, #BFF 5%, #DFF 100%);
	top: 30px; left: 500px;
	border-radius: 100px;
	position: absolute;
	margin: 120px auto 20px;
	    			animation: nube3 5s infinite

}
.shadow {
	width: 350px;
	position: absolute; bottom: -10px; 
	background: #000;
	z-index: -1;
	box-shadow: 0 0 25px 8px rgba(0, 0, 0, 0.4);
	border-radius: 50%;
}

@keyframes nube1 {
0%  {top: -30px;width:100px; }
50%  {top: -20px;width:110px;}
100% {top: -30px;width:100px;}

}

@keyframes nube2 {
0%  {top: -35px; }
50%  {top: -25px;}
100% {top: -35px}
}

@keyframes nube3 {
0%  {width: 350px;height: 150px; }
50%  {width: 370px;height: 160px;}
100% {width: 350px;height: 150px;}
}
.panel-heading h4{
    font-size: 24px !important;
    text-align: center;
}

</style>
<!--autoplay -->
<audio   id="player" src="<?php echo  SGA_COMUN_URL.'/audio/fondo.mp3' ?>"> </audio>
<script>   

//playclip("fondo.mp3");            </script>
<div class="container">
    <?php if(!isset($_SESSION['rol'])){ ?>
<a style="text-decoration: none!important;" href="<?php echo SGA_USUARIO_URL.'/login.php'; ?>"> <?php } ?>
<div style="width:100%!important; height:auto;!important" id = "cloud"><span class='shadow'></span></div>
  <div class="container">
        <div class="row text-center" >
            <div id="bienvenido" class="col-md-12">
           <br/> <?php if(!isset($_SESSION['rol'])){
               echo '<a style="text-decoration: none!important;" href="'.SGA_URL.'/usuario/login.php">';
           }   ?> 
<?php if(isset($_SESSION['rol']) and $_SESSION['rol']=='estudiante'){  echo '<h1  id="titulo">'.deletrear("Mi Cuento").'</h1>'; 
}
else {
    echo '<h1 id="titulo">'.deletrear("Inicio").'</h1>';
}
 if(!isset($_SESSION['rol'])){  
echo '</a>'; ?>
    <?php if(!isset($_SESSION['rol'])){ ?>
</a>
<?php } ?>


                <?php } ?>
            </div>
        </div>
        </div>
        <div class="container">
           <div class="row " style="padding-top:40px;">
  <!--aa -->
             <?php


             if (isset($_SESSION['rol']) and ($_SESSION['rol']=="acudiente" or $_SESSION['rol']=="estudiante")) { ?>
           <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                             <h4>Valoraciones 
                             <?php
  if (isset($_SESSION['rol']) and $_SESSION['rol']=="estudiante"){ $estudiante = $_SESSION['id_usuario'];}
  $estudiante ='';
   if (isset($_SESSION['rol']) and $_SESSION['rol']=="acudiente" and isset($_SESSION['hijo'])){ 
       $estudiante =$_SESSION['hijo']; }
                            echo  '('.categoria_de_estudiante($estudiante,$ano_lectivo).')';
                             ?>
                             
                             </h4>
                             <img align="right" style="margin-top:-10%;" width="10%" src="////guagua-proinfox.c9users.io//comun/img/png/notebook.png">
                            </div>
                            <div style="overflow: scroll;" class="panel-body">
                 
                                
                                
                                
                                
                                
                                
                                
                              <p>
                              <?php
                       require("comun/conexion.php");
  if (isset($_SESSION['rol']) and $_SESSION['rol']=="estudiante"){ $estudiante = $_SESSION['id_usuario'];}
   if (isset($_SESSION['rol']) and $_SESSION['rol']=="acudiente"){ $estudiante =$_SESSION['id_usuario']; }

 $sql=' select * from seguimiento,inscripcion,actividad where
 actividad.id_actividad = seguimiento.id_actividad and
 seguimiento.id_inscripcion =inscripcion.id_inscripcion and inscripcion.id_estudiante = "'.$estudiante.'" and Year(inscripcion.fecha_inscripcion) = "'.$ano_lectivo.'" and seguimiento.valoracion <> "" order by seguimiento.fechayhora_valoracion desc';
                       $consulta = $mysqli -> query ($sql);
                       if ($consulta -> num_rows == 0){
                           echo 'No hay nuevas valoraciones :)' ;
                       }
                       
                 $contador_eventos = 0 ;
                       while ($row= $consulta ->fetch_assoc()){
              $contador_eventos++ ;
              
          echo '<a  href="'.SGA_CURSOS_URL.'/visor_actividad.php?a='.$row['id_actividad'].'"><strong> Actividad :'.$row['nombre_actividad'].', Valoración =  </strong> '.$row['valoracion'].'</a> <br/>';
                       }
                       
                       ?>          
                                </p>
                               
                              <p>
                                                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_URL ?>/cursos" class="btn btn-danger ">Ver más</a>
                            </div>
                        </div>
                    </div>
                              <?php }                
       
           
              
      if (isset($_SESSION['rol'])) { ?>         
               <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                             <h4>Mensajes   <a href="<?php echo SGA_MENSAJE_URL ?>"> <img class="img-responsive" align="right" style="margin-top:-5%;max-width: 100%;" width="15%" src="<?php echo SGA_COMUN_URL.'/img/icono_curso/mensaje.png'; ?>"></img></a></h4>
                                        

                            </div>
                            <div style="overflow: scroll;" class="panel-body">
                              <p>
                              <?php
                       require("comun/conexion.php");
                       $sql='SELECT * FROM `mensaje` where leido="NO" and usuario="'.$_SESSION['id_usuario'].'" order by fecha desc ';
                       $consulta = $mysqli -> query ($sql);
                 $contador_eventos = 0 ;
                 $cantidad_mensaje = $consulta -> num_rows;
                 if($cantidad_mensaje<= 0){
                     echo 'No hay nuevos mensajes :)';
                 }
                       while ($row= $consulta ->fetch_assoc()){
              $contador_eventos++ ;
               echo $contador_eventos.'.'.$row['mensaje'].'<strong> Fecha: </strong> '.formatofechayhora($row['fecha']).' <br/>';
                       }
                       
                       ?>          
                                </p>
                                <?php
                                $sql='SELECT * FROM `mensaje` where favorito="SI" and usuario="'.$_SESSION['id_usuario'].'" order by fecha desc limit 1 ';
                       $consulta = $mysqli -> query ($sql);
                       if ($consulta->num_rows>0){
                       ?>
                              <h3>Favoritos</h3>
                              <?php } ?>
                              <p>
                                  <?php
                                  
                 $contador_eventros = 0 ;
                       while ($row= $consulta ->fetch_assoc()){
              $contador_eventos++ ;
             ?>
              <img width="10%" src="<?php echo SGA_COMUN_URL.'/img/png/mensaje.png'; ?>"></img>
             <?php
               echo $contador_eventos.'.'.$row['mensaje'].'<strong> Fecha:  </strong> '.formatofechayhora($row['fecha']).' <br/>';
                       }
                       ?>
                              </p>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_MENSAJE_URL ?>" class="btn btn-primary ">Ver más</a>
                            </div>
                        </div>
                    </div>
        
        <?php } ?>         
                      
                    <!-- Fin -->    
            <?php if (isset($_SESSION['rol']) and ($_SESSION['rol']=="acudiente" or $_SESSION['rol']=="estudiante")) { ?>
           <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                
                             <h4>Mis Actividades  <?php                             echo  '('.categoria_de_estudiante($estudiante,$ano_lectivo).')';
 ?></h4>
                            </div>
                            <div style="overflow: scroll;"  class="panel-body">
                              <p>
                              <?php
require("comun/conexion.php");
$inscripcion_actual =inscripcion_actual($estudiante);

 $sql ='select * from asignacion_academica,actividad,materia  where 
materia.id_materia = asignacion_academica.id_materia and
asignacion_academica.id_asignacion = actividad.id_asignacion and evaluable ="SI" and actividad.visible="SI" and actividad.fecha_entrega >= "'.date('Y-m-d').'" and actividad.id_asignacion in (Select asignacion_academica.id_asignacion from inscripcion,asignacion_academica,materia where inscripcion.id_asignacion = asignacion_academica.id_asignacion and materia.id_materia = asignacion_academica.id_materia and inscripcion.id_estudiante ="'.$estudiante.'") limit 10';
if (empty(consultar_datos($sql))) {
        echo 'No hay nuevas actividades  :)' ;
}else{
foreach (consultar_datos($sql) as $value) {


 $sql_tareas ='select * from seguimiento where id_actividad = "'.$value[9].'"  and id_inscripcion = "'.$inscripcion_actual.'"';                  
$consulta_tareas = $mysqli ->query($sql_tareas);
if ($consulta_tareas ->num_rows == 0){
$cantidad_tareas[$value[9]] = $consulta_tareas ->num_rows ;
}
 $sql_adjuntos = 'select * from tarea_adjunto where id_actividad = "'.$value[9].'" and id_estudiante =  "'.$estudiante.'"';
$consulta_adjuntos = $mysqli ->query($sql_adjuntos);
if ($consulta_adjuntos ->num_rows == 0){
$cantidad_adjuntos[$value[9]] = $consulta_adjuntos ->num_rows ;
}

        }
        if(!empty($cantidad_tareas)){
    foreach($cantidad_tareas as $actividad_seguimiento => $valor_seguimiento){
        foreach($cantidad_adjuntos as $actividad_adjunto => $valor_adjunto){
    if($actividad_seguimiento==$actividad_adjunto){
$actividades_por_desarrollar[] = $actividad_seguimiento ;

    }
        }
    }
}
        if(!empty($cantidad_tareas)){

foreach($actividades_por_desarrollar as $clave => $valor){


$sql_info_actividades = 'select * from actividad,asignacion_academica,materia where 
actividad.id_asignacion = asignacion_academica.id_asignacion and
materia.id_materia = asignacion_academica.id_materia and
id_actividad= "'.$valor.'"' ;
#echo $sql_info_actividades ;
$consulta_activiades = $mysqli ->query($sql_info_actividades);



#print_r($cantidad_tareas).'<br>';        
#print_r($cantidad_adjuntos).'<br>' ;
                       $contador_eventos = 0 ;
                       while ($row= $consulta_activiades ->fetch_assoc() ){
              #++ ;
               echo '<a class="'.$clases_colores[$claves_aleatorias[0]].'" href="'.SGA_CURSOS_URL.'/visor_actividad.php?a='.$row['id_actividad'].'">'.$row['nombre_actividad'].'
               </a><a target="_blank" href="'.SGA_CURSOS_URL.'/visor_actividad.php?a='.$row['id_actividad'].'">
               <br/> <img title="'.$row['nombre_materia'].'" align="right" style="margin-top:-10%;" width="10%" src="'.consultar_link_icono($row['icono_materia']).'"></a><br/>';
                      }
                    }
        }//cierre empty
}
                       ?>          
                         </p>                                
                                
                                
                                
                                
               
                               
                              <p>
                                                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_CURSOS_URL ?>/" class="btn btn-warning ">Ver más</a>
                            </div>
                        </div>
                    </div>
          <?php }
          
            

            if (isset($_SESSION['rol']) and ($_SESSION['rol']=="docente" or $_SESSION['rol']=="estudiante")) { ?>
        <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                             <h4>
                        <?php if($_SESSION['rol']=="docente"){
                            echo 'Mi Asignación Acádemica ';
                        }         else {
                            echo 'Mis Cursos';
                        } ?>
                                    <a  href="<?php echo 'cursos/mis_cursos.php'; ?>"> <img align="right" style="margin-top:-5%;" width="15%" src="<?php echo SGA_COMUN_URL.'/img/png/notebook.png'; ?>"></a></img></h4>
                            </div>
                            <div style="overflow: scroll;" class="panel-body">
                              <p>
                              <?php
                       require("comun/conexion.php");
 if($_SESSION['rol']=='estudiante'){
     $sql='SELECT *, usuario.nombre as nombre_docente, usuario.apellido as apellido_docente FROM asignacion_academica, materia , ano_lectivo, usuario,inscripcion , categoria_curso where asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso and usuario.id_usuario= usuario.id_usuario and inscripcion.id_asignacion = asignacion_academica.id_asignacion and inscripcion.id_estudiante = "'.$_SESSION['id_usuario'].'" and ano_lectivo.id_ano_lectivo = asignacion_academica.ano_lectivo and materia.id_materia = asignacion_academica.id_materia and ano_lectivo.nombre_ano_lectivo like "%'.$ano_lectivo.'" and asignacion_academica.visible="SI"  Order By materia.nombre_materia asc';
 }
 else {
     $sql='SELECT * FROM asignacion_academica,materia,usuario,ano_lectivo,categoria_curso where 
                     asignacion_academica.id_categoria_curso =categoria_curso.id_categoria_curso and
                       asignacion_academica.id_materia = materia.id_materia and asignacion_academica.ano_lectivo = ano_lectivo.id_ano_lectivo and ano_lectivo.nombre_ano_lectivo like "%'.$ano_lectivo.'" and usuario.id_usuario = asignacion_academica.id_docente and asignacion_academica.id_docente ="'.$_SESSION['id_usuario'].'" order by nombre_materia asc';
 }
 
 
 
                       $consulta = $mysqli -> query ($sql);
                 $contador_eventos = 0 ;
                       while ($row= $consulta ->fetch_assoc()){
             $asignaciones_docente[] =$row; 
              $contador_eventos++ ;
               echo $contador_eventos ; ?>
 <a title="<?php echo $row['nombre_materia']; ?>" href="<?php echo SGA_CURSOS_URL.'/curso.php?asignacion='.$row['id_asignacion']; ?>" > <?php echo puntos_suspensivos($row['nombre_materia'],20).'('.$row['nombre_categoria_curso'].') <br/>'?></a><a title="Reporte valorativo de 
 <?php echo $row['nombre_materia']; ?>
 " href="
 <?php echo SGA_URL.'/reportes/informe_valorativo.php?asignacion='.$row['id_asignacion']; ?>"><?php echo '<img align="right" style="margin-top:-10%;" width="10%" src="'.consultar_link_icono($row['icono_materia']).'"></a>'; ?>

 <?php echo '<br/>';
                       }
                    
                       ?>          
                                </p>
                                                       </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_URL ?>/cursos" class="btn btn-warning ">Ver más</a>
                            </div>
                        </div>
                    </div>
  
               <?php 
            }
           @session_start();
           if (isset($_SESSION['rol']) and $_SESSION['rol']=="estudiante") { ?>
           <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                             <h4>Entretenmiento </h4>  <a href="<?php echo SGA_URL ?>/red"></a>
                                 <a href="<?php echo SGA_REPORTES_URL.'/RED/estadisticas_red.php'; ?>">
                                 <img title="Reporte general de Recursos Educativos Digitales" align="right" style="margin-top:-10%;margin-left:-100%;" width="10%" src="<?php echo SGA_COMUN_IMAGES  ?>/png/app.png"></a>
                            </div>
                            <div style="overflow: scroll;"  class="panel-body">
                              <p>
                              <?php
                       require("comun/conexion.php");
 $sql='select * from red where  cantidad_estrellas<= "'.$_SESSION['puntos'].'" order by estrellas desc   ';
                       $consulta = $mysqli -> query ($sql);
                       if ($consulta -> num_rows == 0){
                           echo 'No hay recursos con entretenimiento' ;
                       }
                       
                 $contador_eventos = 0 ;
                           while ($row= $consulta ->fetch_assoc()){
             $asignaciones_docente[] =$row; 
              $contador_eventos++ ;
               echo $contador_eventos ;
            $row['icono_red']= str_replace('icon-sga-','',$row['icono_red']);
               ?>
 <a title="<?php echo $row['titulo_red']; ?>" href="<?php echo SGA_RED_URL.'/visor_red.php?red='.$row['id_red'].'&formato='.$row['formato'].'&enlace='.$row['enlace'].'&scorm='.$row['scorm']; ?>" > <?php echo puntos_suspensivos($row['titulo_red'],20).'<br/> <img align="right" style="margin-top:-10%;" width="10%" src="'.SGA_COMUN_IMAGES.'/png/'.$row['icono_red'].'.png"></a>'; ?>

 <?php echo '<br/>';
                       }             
                 
                    ?>          
                                </p>
                               
                              <p>
                                                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_URL ?>/red" class="btn btn-success ">Ver más</a>
                            </div>
                        </div>
                    </div>
          <?php } 
          
          
          
       if (isset($_SESSION['rol']) and $_SESSION['rol']=="docente") { ?>
        <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                             <h4>ACTIVIDADES PENDIENTES    <a  href="<?php echo 'cursos/mis_cursos.php'; ?>"> <img align="right" style="margin-top:-5%;" width="15%" src="<?php echo SGA_COMUN_URL.'/img/png/notebook.png'; ?>"></a></img></h4>
                            </div>
                            <div style="overflow: scroll;" class="panel-body">
                              <p>
                              <?php
/* Espacio de trabajo tmp */


#Seleccionar todas actividades pendientes sin valorar

$asignaciones_de_un_docente = asignaciones_de_un_docente($_SESSION['id_usuario']);
                 require("comun/conexion.php");
#$asignaciones_de_un_docente[] = '241';
if(!empty($asignaciones_de_un_docente)){
foreach ($asignaciones_de_un_docente as $posicion => $asignacion) {
    
  $sql_estudiante_asignacion='select count(id_inscripcion) from inscripcion where id_asignacion ="'.$asignacion.'" ';
$consulta_estudiante_asignacion =  $mysqli -> query($sql_estudiante_asignacion);
 $cantidad_estudiante_asignacion[$asignacion] = $consulta_estudiante_asignacion ->num_rows ;

 
 $sql_actividades = 'select * from actividad  where id_asignacion="'.$asignacion.'" and evaluable="SI" and   visible="SI"  and fecha_entrega>= "'.date('Y-m-d').'"  ' ;
 $consulta_actividades  =  $mysqli -> query($sql_actividades);
while($row_actividades = $consulta_actividades ->fetch_assoc()){
    $actividades[]=$row_actividades['id_actividad'].'<br/>';
}
 
 
}
}
if(!empty($actividades)){
foreach ($actividades as $actividad) {
	$sql_seguimiento ='Select count(id_seguimiento) from seguimiento where id_actividad = "'.$actividad.'" ;';
		$consulta_seguimiento = $mysqli -> query($sql_seguimiento);
		$cantidad_seguimiento[$actividad] = $consulta_seguimiento -> num_rows;
  
  
 $sql='select * from actividad where id_actividad = "'.$actividad.'" and evaluable ="SI" ';
$consulta= $mysqli ->query($sql);
while($row = $consulta ->fetch_assoc()){
	if($row['cuestionario']=='SI'){ 
		$sql_respuesta ='Select count(id) from respuesta where id_actividad = "'.$actividad.'" ';
		$consulta_respuesta = $mysqli ->query($sql_respuesta);
		$cantidad_respuestas[$actividad] = $consulta_respuesta -> num_rows;
	  }
	if($row['adjunto']=='SI' and isset($activiad)){ 
		$sql_adjunto ='Select count(id_tarea_adjunto) from tarea_adjunto where id_actividad = "'.$activiad.'" ';
		$consulta_adjunto = $mysqli ->query($sql_adjunto);
		$cantidad_adjunto[$actividad] = $consulta_adjunto -> num_rows;
	  }
	 
}
	
}
}
$tareas_pendientes_adjuntos = 0;

if(!empty($cantidad_adjunto)  )  {
foreach ($cantidad_adjunto as $value => $val) {
if(array_key_exists($value, $cantidad_adjunto) and current($cantidad_adjunto)<$val){
$tareas_pendientes_adjuntos = 1;
$actividades[]=$value;
}
}
}
$tareas_pendientes_respuestas=0;
if(!empty($cantidad_seguimiento) and !empty($cantidad_respuestas) )  {
foreach ($cantidad_seguimiento as $value => $val) {
if(array_key_exists($value, $cantidad_respuestas) and current($cantidad_respuestas)<$val){
$tareas_pendientes_respuestas = 1;
$actividades[]=$value;
}
}
}
if($tareas_pendientes_adjuntos==1 or $tareas_pendientes_respuestas==1){
 $actividades = array_unique($actividades);
foreach($actividades as $posicion => $actividad){
 $sql_actividad ='select * from actividad ,asignacion_academica,materia where
 actividad.id_asignacion = asignacion_academica.id_asignacion and
 materia.id_materia =asignacion_academica.id_materia and
 actividad.id_actividad="'.$actividad.'"';
 $consulta_actividad = $mysqli ->query($sql_actividad);
while($row= $consulta_actividad ->fetch_assoc()){
    echo '<a href="'.SGA_CURSOS_URL.'/visor_actividad.php?a='.$row['id_actividad'].'">'.$row['nombre_actividad'].'</a>';
    ?>
    <a href="<?php echo SGA_CURSOS_URL.'/curso.php?asignacion='.$row['id_asignacion']; ?>" > <?php echo $row['nombre_categoria_curso'].'<br/> <img title="'.$row['nombre_materia'].'" align="right" style="margin-top:-10%;" width="10%" src="'.consultar_link_icono($row['icono_materia']).'"></a><br>'; 
    
    
}
 
}    
    
}
else {
    echo 'No hay tareas pendientes';
}
                       ?>          
                                </p>
                                                       </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_URL ?>/cursos" class="btn btn-success ">Ver más</a>
                            </div>
                        </div>
                    </div>
        
        
        <!--- Fin atajos -->
             <?php } ?>
                    
       
                <div class="col-xs-12 col-md-6  col-lg-4">
    
                    <!-- Desde aquí -->
<?php if (isset($_SESSION['rol']) and $_SESSION['rol']=="admin"){ ?>
<div id="myModal_nuevo_evento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="span_nombre_evento">Nuevo Evento</span> <span id="span_favoritos"></span></h4>
      </div>
      <div class="modal-body modal-lg">
      <div method="post" role="form">
          <div class="row">
            <div class="col-lg-8">
              <input type="hidden" id ="id_eve">
              <div class="form-group">
                  <label>Nombre</label>
                  <input class="form-control" type="text" id ="nombre_eve">
              </div>
              <div class="form-group">
                  <label>Descripción:</label>
                  <textarea class="form-control"  id ="descripcion_eve"></textarea>
              </div>
              
           
        <div class="row">
            <div class="col-lg-4 col-xs-10 col-sm-6">
                <div class="form-group">
                  <label>Fecha</label>
                  <input class="form-control" type="date" id ="fecha_eve">
              </div>
             </div>
            <div class="col-lg-4 col-xs-10 col-sm-6">
              <div class="form-group">
                  <label>Hora de Inicio</label>
                  <input class="form-control" type="time" id ="hora_inicio_eve">
              </div>
             </div>
             <div class="col-lg-4 col-xs-10 col-sm-6">
              <div class="form-group">
                  <label>Hora de Fin</label>
                  <input class="form-control" type="time" id ="hora_fin_eve">
              </div>
             </div>
             </div>
             <span id="txt_resp_evento"></span>
              <div class="form-group" align="center">
                  <button onclick="guardar_evento();" class="btn btn-primary">Crear Evento</button>
              </div>
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal_evento">Cerrar</button>
      </div>
    </div>
    </div>
    </div>
    <?php } ?>
    
    <div class="panel panel-default" >
                            <div class="panel-heading">
      <h4><?php if (isset($_SESSION['rol']) and $_SESSION['rol']=="admin"){ ?><span data-toggle="modal" data-target="#myModal_nuevo_evento" title="Nuevo Evento" class="icon-sga-add-1"></span><?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;Eventos Institucionales   
      <?php if(isset($_SESSION['rol']) ){ ?>
      <a href="<?php echo SGA_COMUN_URL ?>/eventos.php"><?php } ?><h4><img align="right" title="Administrar Eventos" style="margin-top:-10%;" width="10%" src="<?php echo SGA_COMUN_URL.'/img/png/calendario.png'; ?>"></img></h4>   <?php if(isset($_SESSION['rol']) and ($_SESSION['rol']=="docente" or $_SESSION['rol']=="admin" )){ ?> </a> <?php } ?>
</h4> 
                            </div>
                            <div class="panel-body" style="text-align:center">
        <p>
            <!-- Prueba datapicker-->
            <input type="hidden" name="date" id="date">
            <div id="cont_datepicker" align="center">
            <div id="datepicker"></div>
            </div>
<?php
require("comun/conexion.php");
           $sql='SELECT * FROM `eventos`';
           $consulta = $mysqli -> query ($sql);
     //$contador_eventos = 0 ;
              $eventos = array();
              while ($row= $consulta ->fetch_assoc()){
              if (isset($$row['fecha']))
              @$eventos[$row['fecha']] .= ",";
              @$eventos[$row['fecha']] .= $row['nom'];
              @$$row['fecha']=true;
              //' Inicia: '.formatohora($row['hora_inicio']).' Finaliza: '.formatohora($row['hora_fin']).". ";
              }
              #print_r($eventos);
?>
<script>

	$( "#datepicker" ).datepicker({
	    
	    
		beforeShowDay: function( date ) {
			 <?php 
              foreach ($eventos as $fecha=>$evento){
              ?>
              if ( date.getFullYear() == <?php echo date("Y",strtotime($fecha)); ?> && date.getDate() == <?php echo date("d",strtotime($fecha)); ?> && date.getMonth() == <?php echo date("m",strtotime($fecha))-1; ?> ) {
				return [ true, "ui-festivo dia-<?php echo date("d",strtotime($fecha)) ?>", "<?php echo $evento?>" ];
			}
            <?php } ?>
			return [ true ];
		}
	})
	.datepicker( "option", $.datepicker.regional['es'] );
</script>
<style>
.ui-festivo a{
	color: #7bba3f !important;
}
.ui-datepicker .ui-festivo span {
	color: red !important;
	/*background: #FFF;*/
}
.ui-state-default{
    font-size: 20px !important;
    text-align: center !important;
}
#ui-datepicker-div{
width:100% !important;;
}
.ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all{
width:100% !important;;
}
.ui-datepicker-title span{
font-size: 25px !important;
text-transform:capitalize !important;
}
#datepicker{
    margin-top: -20px;
    margin-left: -5px;
}
	</style>

<!-- Prueba datapicker-->
                                </p>
                            
                            </div>
                            <div class="panel-footer sugerencias" title="Aquí puede ver detalles de todos los eventos">
                                <a href="<?php echo SGA_COMUN_URL ?>/eventos.php" class="btn btn-default ">Ver más</a>
                            </div>
                        </div>
                    </div>
                   
                    
                    
                        <!-- Hasta aquí -->
         
        <!-- Inicio atajos -->
   
        
        <!--- Fin atajos -->
             <?php # } ?>
             
             
                <div class="col-xs-12 col-md-6  col-lg-4">
                        <div  class="panel panel-success">
                            <div class="panel-heading">
    <h4>Temas Foros    <a href="<?php echo SGA_FOROS_URL ?>"> <img align="right" title="Administrar Foros" style="margin-top:-5%;" width="15%" src="<?php echo SGA_COMUN_URL.'/img/png//foro.png'; ?>"></img></a></h4>
                            </div>
                            <div  style="overflow: scroll;" class="panel-body">

                               <p>
                                        <?php
                       $cantidad_foros=20;
                       require("comun/conexion.php");
                       $sql='SELECT * FROM `entrada` limit '.$cantidad_foros.'';
                      // $rol = 'invitado';
                       //$sqlrol = ' like "%'.$rol.'%" ';
                       $sqlrol = "";
if (isset($_SESSION['rol']) and $_SESSION['rol']=="admin"){
$rol = $_SESSION['rol'];
$sqlrol = 'like "%'.$rol.'%"';
$sql = 'SELECT * FROM `entrada`, `grupo_foro` where `entrada`.`grupo` = `grupo_foro`.`id_grupo_foro` and `grupo_foro`.`roles_grupo` '.$sqlrol.' order by fecha desc';
}elseif (isset($_SESSION['rol']) and $_SESSION['rol']=="docete"){
$rol = $_SESSION['rol'];
$sqlrol = 'like "%'.$rol.'%"';
$sql = 'SELECT * FROM `entrada`, `grupo_foro` where `entrada`.`grupo` = `grupo_foro`.`id_grupo_foro` and `grupo_foro`.`roles_grupo` '.$sqlrol.' order by fecha desc';
}elseif (isset($_SESSION['rol']) and $_SESSION['rol']=="estudiante"){
$rol = $_SESSION['rol'];
$sqlrol = 'like "%'.$rol.'%"';
$sql = 'SELECT * FROM `entrada`, `grupo_foro` where `entrada`.`grupo` = `grupo_foro`.`id_grupo_foro` and `grupo_foro`.`roles_grupo` '.$sqlrol.' order by fecha desc';
}elseif (isset($_SESSION['rol']) and $_SESSION['rol']=="acudiente"){
$rol = $_SESSION['rol'];
$sqlrol = 'like "%'.$rol.'%"';
$sql = 'SELECT * FROM `entrada`, `grupo_foro` where `entrada`.`grupo` = `grupo_foro`.`id_grupo_foro` and `grupo_foro`.`roles_grupo` '.$sqlrol.' order by fecha desc';
}else{
$sql = 'SELECT * FROM `entrada`, `grupo_foro` where `entrada`.`grupo` = `grupo_foro`.`id_grupo_foro` and `grupo_foro`.`contexto` like "%general%" order by fecha desc ';    
}

                       $consulta = $mysqli -> query ($sql);
                 $contador_eventos = 0 ;
                 $actual_nombre_grupo = "";
while ($row= $consulta ->fetch_assoc()){

    if ($row['nombre_grupo'] != $actual_nombre_grupo){
        $actual_nombre_grupo = $row['nombre_grupo'];
        echo "<h1>".$actual_nombre_grupo."</h1>";
    }
              $contador_eventos++ ;
              ?>
              <img width="10%" src="<?php echo SGA_COMUN_URL.'/img/png/foro.png'; ?>"></img>
               <?php echo $contador_eventos.'. <strong>'.substr($row['contenido'], 0, 20).'...</strong><i><br>Publicado: '.formatofecha2($row['fecha']).'</i><br>';
                       }
                       ?>  
                                </p>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo SGA_URL ?>/foros" class="btn btn-success ">Ver más</a>
                            </div>
                        </div>
                    </div>
                
                    <?php if (isset($_SESSION['rol']) and strpos($_SESSION['rol'],"acudiente")){  ?>

                <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                           <a href="<?php echo SGA_URL ?>/cursos">  <h4>Tareas Pendientes</h4></a> 
                            </div>
                            <div class="panel-body">
                                <?php
                       require("comun/conexion.php");
  $sql='SELECT * FROM `actividad` where fecha_entrega >'.date('Y-m-d').' ';
                       $consulta = $mysqli -> query ($sql);
                 $contador_eventos = 0 ;
                       while ($row= $consulta ->fetch_assoc()){
              $contador_eventos++ ;
               echo $contador_eventos.'.'.$row['id_actividad'].'<strong> Inicia: </strong> '.$row['fecha_entrega'].' <strong> Finaliza:  </strong> '.$row['hora_entrega'].'<br/>';
                       }
                       ?>     
                         
                              
                            </div>
                            <div class="panel-footer">
    <a href="<?php echo SGA_URL ?>/cursos" class="btn btn-danger ">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    
          
        <?php if (isset($_SESSION['rol']) and strpos($_SESSION['rol'],"acudiente")){ ?>
                <div class="col-xs-12 col-md-6  col-lg-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                             <h4>Mis Estudiantes a cargo</h4> 
                            </div>
                            <div class="panel-body cuerpo_comenarios">
 <p>
     
 <!--
 <?php 
     $sql="SELECT `id_acudiente_estudiante`, `id_estudiante`, `id_acudiente` FROM `acudiente_estudiante` WHERE id_acudiente = '".$_SESSION['id_usuario']."'";
      $consulta = $mysqli -> query ($sql);
       while ($row= $consulta ->fetch_assoc()){
if (isset($_SESSION['hijo']) and $_SESSION['hijo']==$row['id_estudiante'])
echo "<strong>";
       # echo "Estudiante a cargo: ".$row['id_estudiante'];
        if (isset($_SESSION['hijo']) and $_SESSION['hijo']==$row['id_estudiante'])
echo "</strong>";
        echo "<br>";  
       }
 
     ?>
 </p-->  
                            <br>
                            <?php require("usuario/elegir_hijo.php");
                            ?>
                                                    </div>
                                              
                            <div class="panel-footer">
                              <button type="button" id="elegir_avatar" class="btn btn-info " data-toggle="modal" data-target="#myModal">Elegir</button>
                                                          </div>
                        </div>
                    </div>
                    <?php } ?>
        </div>
        </div>
    </div>
<script>
    $( ".sugerencias" ).tooltip();
</script>
<!--#Fin sección de Revista (Noticias) -->
<?php $contenido = ob_get_contents();
ob_clean();
include (dirname(__FILE__)."/comun/plantilla.php");
?>