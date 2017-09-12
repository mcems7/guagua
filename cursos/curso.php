<?php 
ob_start();
@session_start();
require_once("../comun/config.php");
require (SGA_COMUN_SERVER.'/conexion.php');
require_once (SGA_COMUN_SERVER.'/funciones.php');
$_SESSION['modulo']="actividad_curso";
$_SESSION['barra_busqueda'] = "actividad_curso";
$asignacion =mysqli_real_escape_string($mysqli,$_GET['asignacion']);
$sql_asignacion='select * from asignacion_academica,materia,usuario,categoria_curso where 
asignacion_academica.id_categoria_curso   = categoria_curso.id_categoria_curso and
asignacion_academica.id_docente=usuario.id_usuario and
asignacion_academica.id_materia = materia.id_materia and
id_asignacion ="'.$asignacion.'"';
$consulta_asignacion = $mysqli ->query($sql_asignacion);
while($infoactividad_asignacion=$consulta_asignacion->fetch_assoc() ){
    $nombre_docente = $infoactividad_asignacion['nombre'].' ' .$infoactividad_asignacion['apellido'];
    $foto_docente =$infoactividad_asignacion['foto'];
    $categoria_curso = $infoactividad_asignacion['nombre_categoria_curso'];
    $descripcion = $infoactividad_asignacion['descripcion'];
    $portada_asignacion = $infoactividad_asignacion['portada_asignacion'];
    $curso=$infoactividad_asignacion['nombre_materia'];
    setcookie('mirutactividades','asignacion='.$infoactividad_asignacion['id_asignacion'].'&curso='.$infoactividad_asignacion['nombre_materia']);
    $materia = $infoactividad_asignacion['nombre_materia'];
}


if (isset($_GET['actividad_curso'])){
$datos_busqueda  =mysqli_real_escape_string($mysqli,$_GET['actividad_curso']);
$campo_bd=mysqli_real_escape_string($mysqli,$_GET['campo']);
$asignacion = $_GET['asignacion'];
actividad_curso($asignacion,$datos_busqueda,$campo_bd);
exit();
} 

?>
<script type="text/javascript" >
    function menu_contextual(actividad,nombre){
    console.log('actividad'+actividad+'Nombre'+nombre);

    $.contextMenu({
            selector: '.Contenedor_periodos'+actividad, 
            callback: function(key, options) {
                
if(key=="Modificar Actividad"){window.location='actividad.php?actividad='+actividad; }
if(key=="Nuevo"){window.location='actividad.php?id_asignacion='+ObtenerGetJavascript('asignacion'); }           
            },
            items: {
               <?php @session_start(); if($_SESSION['rol']=="admin" or  $_SESSION['rol']=="docente") { ?>

                "titulo": {name: nombre},
                "sep1": "---------",
                "Modificar Actividad": {name: "Modificar Actividad"},
                "Nueva Actividad": {name: "Nueva Actividad"},
                "sep2": "---------",
                "Salir": {name: "Salir", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                <?php } ?>    
                    
                }}
            }
        });

        $('.Contenedor_periodos'+actividad).on('click', function(e){
            console.log('clicked', this);
        })    
   
}

</script>
<script>
$(function(){
    function createSomeMenu() {
        return {
            callback: function(key, options) {
if(key=="Nueva Actividad"){window.location='actividad.php?asignacion='+ObtenerGetJavascript('asignacion'); }
if(key=="Modificar Curso"){window.location='modificar_curso.php?asignacion='+ObtenerGetJavascript('asignacion'); } 
if(key=="Estudiantes del curso"){window.location='estudiante_curso.php?asignacion='+ObtenerGetJavascript('asignacion'); } 
if(key=="Reporte Valorativo"){window.open('../reportes/informe_valorativo.php?asignacion='+ObtenerGetJavascript('asignacion'),'_BLANK'); } 
if(key=="Estadisticas"){window.open('../reportes/promedio_estudiantil.php?asignacion='+ObtenerGetJavascript('asignacion'),'_BLANK'); } 
            },
            items: {
               <?php @session_start(); if($_SESSION['rol']=="admin" or  $_SESSION['rol']=="docente") { ?>
                "Nueva Actividad": {name: "Nueva Actividad"},
            "Modificar Curso": {name: "Modificar Curso"},
<?php } ?>
                "Estudiantes del curso": {name: "Estudiantes del curso"},
                 "Estudiantes del curso": {name: "Estudiantes del curso"},
                 "Reporte Valorativo": {name: "Reporte Valorativo"},
                 "Estadisticas": {name: "Estadisticas"},
            }
        };
    }
    $('.context-menu-one').on('mouseup', function(e){
        var $this = $(this);
        $this.data('runCallbackThingie', createSomeMenu);
        var _offset = $this.offset(),
            position = {
                x: _offset.left + 5, 
                y: _offset.top + 5
            }
        setTimeout(function(){ $this.contextMenu(position); }, 1000);
    });
    // setup context menu
    $.contextMenu({
        selector: '.context-menu-one',
        trigger: 'none',
        build: function($trigger, e) {
            e.preventDefault();
            return $trigger.data('runCallbackThingie')();
        }
    });
});
</script>
<div  id="portada" 
<?php if(isset($portada_asignacion) and $portada_asignacion<>""){ ?>
style="background-image: url('<?php echo SGA_CURSOS_URL.'/'.  $portada_asignacion; ?>');no-repeat left center;-webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover;"
class="jumbotron jumbotron-curso" <?php }else{  ?> class="jumbotron" <?php } ?> >
<?php 
#if($_SESSION['rol']<>"admin" and $_SESSION['rol']<>"docente" ){
$sql_informacion_academica='select * from asignacion_academica,usuario where 
asignacion_academica.id_docente = usuario.id_usuario and asignacion_academica.id_asignacion = "'.$asignacion.'"' ;
foreach(consultar_datos($sql_informacion_academica) as $informacion => $campos_bd){
$datos_busqueda_actividad['id_docente'] = $campos_bd[8];
$datos_busqueda_actividad['nombre'] = $campos_bd[12].' '.$campos_bd[13];
$datos_busqueda_actividad['foto'] = $campos_bd[15] ;
}
#}
?>
    <form method="post" action="<?php echo SGA_MENSAJE_URL ?>/redactar.php"; target="_blank">
<input type="hidden" name="responder_a" value="<?php if (isset($datos_busqueda_actividad)) echo $datos_busqueda_actividad['id_docente'];?>">
<input type="hidden" name="responder_n" value="<?php if (isset($datos_busqueda_actividad)) echo $datos_busqueda_actividad['nombre'];?>">
<?php if(isset($_SESSION['rol']) and $_SESSION['rol']<>'docente' ){ ?>
<input  type="image" id="imgdocente" title="Enviar Mensaje al docente <?php echo  $nombre_docente; ?>"  src="<?php echo validarfoto(READFILE_URL.'/foto/'.$foto_docente); ?>" >
<?php } ?>
</form>
<input id="opciones_cursos2"  type="button" value="Opciones"  class="btn btn-warning context-menu-one" name=""/>
  </form><div class="<?php if(isset($portada_asignacion) and $portada_asignacion<>""){ 
  echo 'container text-center'; } else { echo 'fip'; } ?> " 
  <?php if(isset($portada_asignacion) and $portada_asignacion<>""){ ?>
  style="width:580px;background-color:blue;opacity:0.01">
      <?php } ?>
    <h1 title="<?php echo ucwords($curso)?>" class="fip"> <?php echo puntos_suspensivos(ucwords($curso),20); ?></h1>  
 <form method="post" action="<?php echo SGA_MENSAJE_URL ?>/redactar.php"; target="_blank">
<input type="hidden" name="responder_a" value="<?php
@session_start();
echo $_SESSION['id_usuario'];?>">
<input type="hidden" name="responder_n" value="<?php echo $nombre_docente;?>">
<input type="hidden" name="materia_asunto" value="<?php echo ucwords($materia).' ('.$categoria_curso.'). ';?>">
<input type="hidden" name="responder_mensaje" value="">
<input style="width: 10%; vertical-align: middle;position: absolute;
    left: 75%;top:25%;z-index: 1; border-radius: 80%;"  type="image" id="imgdocente" title="Enviar Mensaje al docente: <?php echo  $nombre_docente; ?>"  src="<?php echo READFILE_URL.'/foto/'.$foto_docente; ?>" >
</form>
  </div>
</div>
 <div onclick="ocultar_descripcion_curso();" id="Contenedor_descripcion_curso"  ><p style="margin-top:5px"><?php echo 'CURSO '.ucwords($materia).' ('.$categoria_curso.')'; ?></p></div>
<div   id="div_parrafo_descripcion_curso">
<p  id="parrafo_descripcion_curso">
    <?php echo $descripcion; ?></p>
</div>
<?php
function actividad_curso($asignacion,$datos_busqueda='',$campo_bd="nombre_actividad"){ 
@session_start();
require ("../comun/conexion.php");
if(!isset($campo_bd)) $campo_bd="nombre_actividad";
if(!isset($_GET['asignacion']))  $asignacion = $_SESSION['asigna'];
$sql='SELECT DISTINCT (periodo) FROM actividad where id_asignacion="'.$asignacion.'" order by periodo desc ';
$consulta = $mysqli ->query($sql);
$resultados_periodos =$consulta->num_rows;  
while($infoactividad_cuantos_periodos = $consulta -> fetch_assoc()){
 $cuantos_periodos[]= $infoactividad_cuantos_periodos['periodo'];
}
if($resultados_periodos<=0){    echo '<p Align="center">No Hay Actividades</p>';}
else {
foreach ($cuantos_periodos as $periodo) {
$sql_actividades_periodo = 'select * from actividad where periodo="'.$periodo.'" and actividad.id_asignacion="'.$asignacion.'" ' ;
$sql_actividades_periodo.= ' and concat(LOWER(`actividad`.'.$campo_bd.')," " ) LIKE "%'.mb_strtolower($datos_busqueda, 'UTF-8').'%"  order by actividad.id_actividad desc ';
$consulta_actividades_periodo = $mysqli -> query  ($sql_actividades_periodo); ?> 
 <div id="contenedor_<?php echo $periodo ?>" class="flex-container">
     <div   id="separador_de_periodos">
    <p class="<?php echo $periodo ; ?>" onclick="actividades_por_periodo(this);" id="checkbox<?php echo $periodo; ?>">
        <?php echo 'Actividades Periodo '.$periodo ?><span id="span_actividades_encontradas">
     <?php echo " Actividades Encontradas:".$consulta_actividades_periodo -> num_rows ?></span>
    </p>
     </div>
    
 <?php


$sql_actividades = 'select * from actividad where periodo="'.$periodo.'" and  actividad.id_asignacion="'.$asignacion.'" ' ;
if($_SESSION['rol']=="estudiante" or $_SESSION['rol']=="acudiente"){    $sql_actividades.=' and visible = "SI" ';
    $sql_actividades.=' and "'.date('Y-m-d').'" >= `fecha_publicacion`  and 
"'.date('H:i:s').'" >= `hora_publicacion`';
} 

#$campo_bd="nombre_actividad" ;
$sql_actividades .= ' and concat(LOWER(`actividad`.'.$campo_bd.')," " ) LIKE "%'.mb_strtolower($datos_busqueda, 'UTF-8').'%"';
$sql_actividades.=' order by actividad.id_actividad desc';
#echo $sql_actividades_periodo;

$consulta_actividade = $mysqli -> query  ($sql_actividades);
 while ($infoactividad = $consulta_actividade -> fetch_assoc() and $infoactividad['id_asignacion']="'.$asignacion.'"  ) { 
 $actividad = $infoactividad['id_actividad'];
 $nombre = $infoactividad['nombre_actividad'];
 $evaluable = $infoactividad['evaluable'];
 $fecha_entreg =$infoactividad['fecha_entrega'];
 $fech_publi =$infoactividad['fecha_publicacion'];  ?>
<div style="border:solid 2px!important;text-align:center;margin-left:20px;border-radius:20px" onContextMenu="menu_contextual('<?php echo $actividad; ?>','<?php echo $nombre; ?>');"   id="periodo<?php echo $periodo; ?>" class="Contenedor_periodos<?php echo $actividad; ?>"
<?php if($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente") { ?>

<?php } ?>
class="col-*-* f_inicio<?php echo $nombre; ?>">
<form method="post" action="<?php echo SGA_CURSOS_URL ?>/valorar_actividad.php"; target="_blank">
<span id="texto_activiad_<?php echo $actividad; ?>" style="color:<?php echo $infoactividad['visible']=="SI" ? "black" : ""; ?>">
<?php echo $infoactividad['nombre_actividad']; ?></strong> <br/> 
<?php
if ($infoactividad['evaluable']=="SI"and $_SESSION['rol']=="estudiante" and  $_SESSION['rol']=="acudiente"   ){

     list($dia2,$mes2,$año2) = diferenciaentrefechas($infoactividad['fecha_publicacion'],$fecha_entrega);
$fecha_actual = date('Y-m-d');
list($dia,$mes,$año) = diferenciaentrefechas($fecha_entrega,$fecha_actual);
$micolor = colores($dia,$dia2);
?>
<a href="<?php echo SGA_CURSOS_URL.'/visor_actividad.php?a='.$actividad.''; ?>">
<?php
if (verificar_actividad_hecha($actividad) ==0 and $infoactividad['fecha_entrega'] < date('Y-m-d')   ) $periodocono_actividad="triste.PNG" ; 
if (verificar_actividad_hecha($actividad) ==0  and date('Y-m-d') < $infoactividad['fecha_entrega'] ) $periodocono_actividad="regalo.png"; 
if (verificar_actividad_hecha($actividad) >0 ) $periodocono_actividad="feliz.PNG"; 
}
 else {
    $periodocono_actividad="notebooka.png";
}
echo '<a target="_BLANK" href="'.SGA_CURSOS_URL.'/visor_actividad.php?a='.$actividad.'">
';
?>

    <img id="imagen_actividad<?php echo $actividad; ?>" <?php if($infoactividad['visible']=="NO")  echo "style='-webkit-filter: grayscale(1);
filter:gray; display: block;margin-left: auto;      margin-right: auto;border:none;'"; else {
   echo "style='-webkit-filter: grayscale(0);
filter:gray; display: block;margin-left: auto;      margin-right: auto;border:none;'"; 
}
?> 

width="50%" src="<?php echo SGA_COMUN_URL.'/img/png/'.$periodocono_actividad ; ?>"></img></a><br/>

<?php
if(strtolower($evaluable)=="si" and $_SESSION['rol']=="estudiante" ){
  list($dia, $mes,$año) = diferenciaentrefechas($fech_publi,$fecha_entreg);
list($dia2, $mes2,$año2) = diferenciaentrefechas(date('Y-m-d'),$fecha_entreg);
list($uno,$dos) = colores($dia,$dia2);
?>
<div title="
<?php if($dia2 > 0) { ?>
Restan <?php echo $dia2 ?> día(s)
<?php } 
else {
echo 'La Actividad finalizó el '.formatofecha($fecha_entreg) ;    
}
?>
" style="margin-top:-7px;margin-left:130px;position:absolute;width: 25px;
     height: 25px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     background: <?php echo $uno; ?>;"></div>
<?php

}
if($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" ){ ?>
<input type="hidden" name="id_actividad" value="<?php echo $actividad;?>"> <?php } 
if($_SESSION['rol']<>"estudiante" and $_SESSION['rol']<>"acudiente" ){ ?>
<span style="position: ;width:50px!important;margin-left:20px;margin-top:-40px;" onclick="ver_actividad(this);" id="ver_actividad_<?php echo $actividad ?>" id_actividad="<?php echo $actividad ?>" visible="<?php echo $infoactividad['visible'] ?>" class="<?php echo $infoactividad['visible']=="SI" ? "icon-sga-view" : "icon-sga-view-line"; ?>" title="<?php echo $infoactividad['visible']=="SI" ? "Ocultar" : "Mostrar"; ?>"></span>
<?php } ?>
<br/></form>

</div>
 <?php   

 }
 echo '</div>'  ;

}


 } #Fin función
}
  ?>


  <span id="span_actividad_curso">
<?php
$asignacion = $_GET['asignacion'];

echo actividad_curso($asignacion,$datos_busqueda="",$campo_bd="nombre_actividad"); 
?>
</span>
<style>
#ver_actividad{
   margin-top: -8px !important;
    margin-left: 0px !important;
    height:20px !important;
    width:20px !important;
    background-size: 40px 40px !important;
}
</style>

<?php

   echo '</body>'    ;                    
$contenido = ob_get_clean();
require ("../comun/plantilla.php");
?>

