<?php 
require ("../comun/conexion.php");
require_once("../comun/config.php");
require_once ("../comun/funciones.php");
ob_start();
@session_start();
if($_SESSION['rol']=='acudiente' and (!isset($_SESSION['hijo']))){
header('location:'.SGA_USUARIO_URL.'/elegir_hijo.php');
}
if(isset($_SESSION['asigna'])){
    unset($_SESSION['asigna']);
}
$_SESSION['modulo']="cursos";
$_SESSION['barra_busqueda'] = "cursos";
if (isset($_GET['buscar_mis_cursos'])){
buscar_mis_cursos($_POST['datos'], $_POST['campo']);
exit();
}
?><br>

<script>
$(function(){
    function createSomeMenu() {
        return {
            callback: function(key, options) {
          if(key=="Nuevo Curso"){
              window.location='crear_curso.php';
          }
                    if(key=="Asignar Docente"){
              document.getElementById('checked_lista_docentes').click();
          }
           //     var m = "clicked: " + key;
             //   window.console && console.log(m) || alert(m);
            },
            items: {
                "Nuevo Curso": {name: "Nuevo Curso"},
          <?php if($_SESSION['rol']=='admin'){ ?>
                "Asignar Docente": {name: "Asignar Docente"},
        <?php } ?>
            }
        };
    }

    // some asynchronous click handler
    $('.context-menu-one').on('mouseup', function(e){
        var $this = $(this);
        // store a callback on the trigger
        $this.data('runCallbackThingie', createSomeMenu);
        var _offset = $this.offset(),
            position = {
                x: _offset.left + 5, 
                y: _offset.top + 5
            }
        // open the contextMenu asynchronously
        setTimeout(function(){ $this.contextMenu(position); }, 1000);
    });

    // setup context menu
    $.contextMenu({
        selector: '.context-menu-one',
        trigger: 'none',
        build: function($trigger, e) {
            e.preventDefault();

            // pull a callback from the trigger
            return $trigger.data('runCallbackThingie')();
        }
    });
});
</script>
<?php botones_portada(); ?>
<div id="jumbotron" style="" class="jumbotron">
  <div class="container text-center">
    <h1 class="fip" >MIS CURSOS</h1> 
 <?php if ($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" ){ ?>
  <input id="opciones_cursos" type="button" value="Opciones"  class="context-menu-one btn btn-warning" name=""/>
   <?php } ?>

<div align="center" style="">

<?php if ($_SESSION['rol']=="admin"){ ?>
<p style="margin-left:-1000px;margin-top:0px;" id="asignar_docentes" style="position:absolute;"><label><input hidden <?php if (isset($_COOKIE['checked_lista_docentes']) and $_COOKIE['checked_lista_docentes']=="true")
echo "checked"; ?> type="checkbox" onchange="espacio_cursos(this);grabarcookie('checked_lista_docentes',this.checked);" id="checked_lista_docentes" mostrarocultar="lista_docentes"></label></p>
<?php } ?>
</div>
  </div>
</div>
<span id="span_buscar_mis_cursos">
    <?php buscar_mis_cursos() ?>
</span>
<?php function buscar_mis_cursos($parametro_buqueda="",$campo="nombre_materia"){
require ("../comun/conexion.php");
require_once("../comun/config.php");
require_once ("../comun/funciones.php");
$where="";
@session_start();
?>
<div class="container-fluid bg-3 text-center">    
<?php

$categorias=array();
  if ($_SESSION['rol']=="acudiente"){
      @session_start();

         $sql_estudiante = "SELECT * from inscripcion,asignacion_academica
         WHERE id_estudiante = '".$_SESSION['hijo']."' and
              asignacion_academica.id_asignacion=inscripcion.id_asignacion 
              order by id_inscripcion desc limit 1  ";
         $consulta_estudiante = $mysqli->query($sql_estudiante);
        if ($row_estudiante= $consulta_estudiante->fetch_assoc()){
                $_SESSION['id_categoria_curso'] = $row_estudiante['id_categoria_curso'];
        }
       }
 if ($_SESSION['rol']=="estudiante"){
        $sql_estudiante = "SELECT * from inscripcion,asignacion_academica
         WHERE id_estudiante = '".$_SESSION['id_usuario']."' and
              asignacion_academica.id_asignacion=inscripcion.id_asignacion 
              order by id_inscripcion desc limit 1  ";
         $consulta_estudiante = $mysqli->query($sql_estudiante);
        if ($row_estudiante= $consulta_estudiante->fetch_assoc()){
          $_SESSION['id_categoria_curso'] = $row_estudiante['id_categoria_curso'];
           
        }
       }


$sqlc="SELECT * FROM `categoria_curso` ";
 if($_SESSION['rol']=='docente'){
require_once ("../comun/funciones.php");
$ano_lectivo=consultar_id_ano_lectivo();
@session_start();
$categorias_docente = consultar_categoria_docente($_SESSION['id_usuario'],$ano_lectivo);
 $sqlc.= ' where ';
 $cantidad_elementos=count($categorias_docente);
 $ultimo= (end($categorias_docente[$cantidad_elementos-1])) ;
for ($i = 0; $i < count($categorias_docente); $i++) {
 $sqlc.='`categoria_curso`.`id_categoria_curso` = '.$categorias_docente[$i][0].'';
if($ultimo<>$categorias_docente[$i][0]){
    $sqlc.=' or ';
}
}

 }
     if ($_SESSION['rol']=="acudiente" or $_SESSION['rol']=="estudiante") {
   $sqlc.= ' where id_categoria_curso = "'.$_SESSION['id_categoria_curso'].'" ' ; 
      }
  $sqlc.=' order by nivel_educativo asc';
#echo $sqlc;
$consultac = $mysqli -> query($sqlc);
while ($rowc = $consultac ->fetch_assoc()){
    $categorias[$rowc['id_categoria_curso']]=$rowc['nombre_categoria_curso'];
}

?>
<div class="row">
<div id="lista_docentes" class="col-md-2" <?php 
if (isset($_COOKIE['checked_lista_docentes']) and $_COOKIE['checked_lista_docentes']=="true"){

}else{
echo 'style="display:none;"';
}
?>>

<?php
if ($_SESSION['rol']=="admin"){ ?>
<h4 onclick="document.getElementById('checked_lista_docentes').click();"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Asignar Docente</h4>
<br>
<input type="search" id="datos_buscar_docente_para_asignar" placeholder="Buscar docente..." onkeyup="buscar_docente_para_asignar(this.value)">
<ul id="ul_buscar_docente_para_asignar">
<?php
buscar_docente_para_asignar();
?>
</ul>
<?php } ?>
</div>
<?php
 $sqlp= "SELECT * FROM `ano_lectivo`";
     if ($_SESSION['rol']=="acudiente" or $_SESSION['rol']=="estudiante"){ 
        $sqlp.= ' where nombre_ano_lectivo like "'.date('Y').'" '  ; }
        $sqlp.=" order by id_ano_lectivo desc";
        $consultap = $mysqli -> query($sqlp) ;
      
        while ($rowp = $consultap ->fetch_assoc()){
        /* Revisar
        ?>
<script type="text/javascript">
$(document).ready(function (){
    $("#id_<?php echo $rowp['id_ano_lectivo'].$_SESSION['id_categoria_curso'] ?>").click();
});
</script>
*/
?>

<div class="col-md-<?php
if (isset($_COOKIE['checked_lista_docentes']) and $_COOKIE['checked_lista_docentes']=="true"){
echo '10'; 
}else{
echo '12';
}
?> espacio_curso">
<div style="background-color:#f2721d;width:100%;height:5px"></div>
<p onclick="mitoogle('#id_<?php echo $rowp['id_ano_lectivo']; ?>')" >
<?php echo $rowp['nombre_ano_lectivo']; ?>
<span style="float:right;opacity:.7;font-weight:bold;margin-left:-165px">
Categorias en uso: <?php
$sql_cat_ano = "SELECT count(*) as num_cat_ano FROM `seguimiento_categoria_ano` WHERE ano_lectivo = '".$rowp['id_ano_lectivo']."'";
require(dirname(__FILE__)."/../comun/conexion.php");
$consulta_cat_ano = $mysqli->query($sql_cat_ano);
$rowca = $consulta_cat_ano->fetch_assoc();
echo $rowca['num_cat_ano']; ?>
</span>
</p>
<?php if(!isset($actual)) $actual="#id_".$rowp['id_ano_lectivo']; ?>
<div class="anos" id="id_<?php echo $rowp['id_ano_lectivo']; ?>">

<?php
#if ($parametro_buqueda!="") echo 'Resultados para "'.$parametro_buqueda.'"';
#print_r($parametro_buqueda);
if ($parametro_buqueda!=""){
$where = '';
$parametro_buqueda_array = explode(" ",$parametro_buqueda);
#print_r($parametro_buqueda_array);
foreach ($parametro_buqueda_array as $id => $parametro_buquedai){

if ($campo == "nombre_materia")
$datocampo = 'LOWER(materia.nombre_materia)';
elseif($campo == "anio")
$datocampo = 'LOWER(ano_lectivo.nombre_ano_lectivo)';
elseif($campo == "nombre_categoria")
$datocampo = 'LOWER(categoria_curso.nombre_categoria_curso)';
elseif($campo == "nombre_docente")
$datocampo = 'concat(LOWER(usuario.id_usuario)," ",LOWER(usuario.nombre)," ",LOWER(usuario.apellido))';
elseif($campo == "todos")
$datocampo = 'concat(LOWER(categoria_curso.nombre_categoria_curso)," ",LOWER(materia.nombre_materia)," ",LOWER(usuario.nombre)," ",LOWER(usuario.apellido)," ",LOWER(ano_lectivo.nombre_ano_lectivo))';
else
$datocampo = 'LOWER(materia.nombre_materia)';
$where .= ' and '.$datocampo.' LIKE "%'.mb_strtolower($parametro_buquedai, 'UTF-8').'%"  ';
#echo $parametro_buquedai;
}
}
/**/


foreach ($categorias as $id_cat => $nombre_cat){
    if ($_SESSION['rol']=="admin" ){
 $sql= 'SELECT *, usuario.nombre as nombre_docente, usuario.apellido as apellido_docente FROM asignacion_academica, materia ,  ano_lectivo, usuario,categoria_curso where asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso and asignacion_academica.id_docente = usuario.id_usuario and  ano_lectivo.id_ano_lectivo = asignacion_academica.ano_lectivo and materia.id_materia = asignacion_academica.id_materia and asignacion_academica.ano_lectivo="'.$rowp['id_ano_lectivo'].'" and asignacion_academica.id_categoria_curso = "'.$id_cat.'"'.$where.'  Order By materia.nombre_materia asc ';
    }
    if ($_SESSION['rol']=="docente"){
        $sql= 'SELECT *, usuario.nombre as nombre_docente, usuario.apellido as apellido_docente FROM asignacion_academica, materia ,  ano_lectivo, usuario,  categoria_curso where asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso and asignacion_academica.id_docente = usuario.id_usuario and ano_lectivo.id_ano_lectivo = asignacion_academica.ano_lectivo and materia.id_materia = asignacion_academica.id_materia and asignacion_academica.ano_lectivo="'.$rowp['id_ano_lectivo'].'" and asignacion_academica.id_categoria_curso = "'.$id_cat.'" and asignacion_academica.id_docente = "'.$_SESSION['id_usuario'].'"'.$where.'  Order By materia.nombre_materia asc ';
    }
if ($_SESSION['rol']=="acudiente"){
        $sql= 'SELECT *, usuario.nombre as nombre_docente, usuario.apellido as apellido_docente FROM asignacion_academica, materia ,  ano_lectivo, usuario, inscripcion , categoria_curso where asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso and asignacion_academica.id_docente = usuario.id_usuario and 
        inscripcion.id_asignacion = asignacion_academica.id_asignacion and
        inscripcion.id_estudiante = "'.$_SESSION['hijo'].'"  and ano_lectivo.id_ano_lectivo = asignacion_academica.ano_lectivo and materia.id_materia = asignacion_academica.id_materia and  asignacion_academica.visible="SI" and asignacion_academica.ano_lectivo="'.$rowp['id_ano_lectivo'].'" and asignacion_academica.id_categoria_curso = "'.$id_cat.'"'.$where.'  Order By materia.nombre_materia asc ';
    }

   if ($_SESSION['rol']=="estudiante"){
        $sql= 'SELECT *, usuario.nombre as nombre_docente, usuario.apellido as apellido_docente FROM asignacion_academica, materia ,  ano_lectivo, usuario,inscripcion , categoria_curso where asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso  and inscripcion.id_asignacion = usuario.id_usuario and
        inscripcion.id_asignacion = asignacion_academica.id_asignacion and
        inscripcion.id_estudiante = "'.$_SESSION['id_usuario'].'"
        and ano_lectivo.id_ano_lectivo = asignacion_academica.ano_lectivo and materia.id_materia = asignacion_academica.id_materia and asignacion_academica.ano_lectivo="'.$rowp['id_ano_lectivo'].'" and asignacion_academica.visible="SI" and asignacion_academica.id_categoria_curso = "'.$id_cat.'"'.$where.'  Order By materia.nombre_materia asc ';
     
    }
   
    $consultan = $mysqli -> query($sql) ; ?>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-11">
        <div style="cursor:pointer;background-color:#f272FF;width:100%;height:5px;"></div>
        <p title ="Total de Cursos: <?php echo  $consultan->num_rows ?>" style="cursor:pointer;" id="id_<?php echo $rowp['id_ano_lectivo'].$id_cat; ?>"  onmouseup="ocultar_ano_cat('cat_<?php echo $rowp['id_ano_lectivo'].$id_cat; ?>');" class="Abckids"><?php echo $nombre_cat; ?><span style="float:right;opacity:.7"><?php #if(isset($parametro_buqueda) and $parametro_buqueda!="") 
        echo " Cursos Encontrados:".$consultan->num_rows; ?></span></p>
    </div>
</div><div class="cats" id="cat_<?php echo $rowp['id_ano_lectivo'].$id_cat; ?>">
<div class="row">
<?php
$mistooltip = "";
while ($rowa = $consultan ->fetch_assoc()){ ?>
<!--div style="border:2px solid #ccc;" class="btn-group btn-group-sm-2"-->

<div contextmenu="menu_curso<?php echo $rowa['id_asignacion'] ?>" id="ficha_curso<?php echo $rowa['id_asignacion'] ?>" style="text-align:center;margin-top:30px;margin-right:55px;border:2px solid #ccc;border-radius:15px;"  class="col-sm-2 menu_curso<?php echo $rowa['id_asignacion'] ?>  droppable" id_asignacion="<?php echo $rowa['id_asignacion'] ?>">
      <h4 class="Abckids"><strong><span
            <?php if($rowa['visible']=="NO") echo "style=color:gray;" ?>

      id="texto_curso_<?php echo $rowa['id_asignacion'] ?>" title="<?php echo $rowa['nombre_materia']; ?>" class="materia_droppable"><?php $puntos = puntos_suspensivos($rowa['nombre_materia'],24);
      echo mb_strtoupper($puntos,'UTF-8');
      ?></span></strong>
      <?php
   
      $mistooltip .= '$("#texto_docentecurso_'.$rowa['id_asignacion'].'" ).tooltip({ content: "<img height=\'20\' src=\''.READFILE_URL.'/foto/'.validarfoto($rowa['foto']).'\'></img>"});';
     #echo $mistooltip
 ?>
<script>
$(document).ready(function() {
 //   setTimeout(function() { cargar_tooltips(); }, 4000)
 });
</script>
      </h4>
      <h5 class="Abckids">Docente: <span
      <?php
      if($rowa['visible']=="NO") echo "style=color:gray;" ?>
      onmouseover="cargar_tooltips();"
      id="texto_docentecurso_<?php echo $rowa['id_asignacion']; ?>" class="docente_droppable"><?php echo $rowa['nombre_docente'].' '.$rowa['apellido_docente']; ?></span></h5>
    <a id="materia_<?php echo $rowa['id_asignacion'] ?>" href ="<?php echo SGA_CURSOS_URL?>/curso.php?asignacion=<?php echo $rowa['id_asignacion']; ?>">
    <img    id="iconomateria_<?php echo $rowa['id_asignacion'] ?>"     <?php if($rowa['visible']=="NO")  echo "style='-webkit-filter: grayscale(1);
filter:gray; display: block;margin-left: auto;      margin-right: auto;border:none;'"  ?>
 width="70%" height="70%" src="<?php echo consultar_link_icono($rowa['icono_materia']); ?>" title="Descripción: <?php echo $rowa['descripcion']; ?>" class="img-responsive <?php if($rowa['visible']=="NO") echo 'grises'; ?>" style="margin-left:30px!important" alt="Image">
  <script>
  <?php
 
  
  ?>
function cargar_tooltips(){
    <?php echo '$("#texto_docentecurso_'.$rowa['id_asignacion'].'" ).tooltip({ content: "a"});'; ?>
}
</script> 
    </A>   

    <span id="botones_curso_<?php // echo $i; ?>">

<?php if(($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" )){ ?>
<!--div style="border:2px solid #ccc;" class="btn-group btn-group-lg"-->

 <span style="width:50px!important;margin-left:40px;margin-top:-15px;" onclick="ver_curso(this);" id="ver_curso_<?php echo $rowa['id_asignacion'] ?>" id_curso="<?php echo $rowa['id_asignacion'] ?>" visible="<?php echo $rowa['visible'] ?>" class="<?php echo $rowa['visible']=="SI" ? "icon-sga-view" : "icon-sga-view-line"; ?>" title="<?php echo $rowa['visible']=="SI" ? "Ocultar" : "Mostrar"; ?>"></span>
<?php } ?>
</form>
<menu id="menu_curso<?php echo $rowa['id_asignacion'] ?>" style="display:none" class="showcase">
  <command label="<?php echo $rowa['nombre_materia']; ?>" onclick="document.getElementById('materia_<?php echo $rowa['id_asignacion'] ?>').click();">
  <hr>
  <?php @session_start(); if ($_SESSION['rol']<>"estudiante" and $_SESSION['rol']<>"acudiente" ){ ?>

    <command  label="Nueva Actividad"  onclick="
  document.location='<?php echo SGA_CURSOS_URL ?>/actividad.php?asignacion=<?php echo $rowa['id_asignacion'] ?>'">

  <command label="Estudiantes del curso"  onclick="
  document.location='<?php echo SGA_CURSOS_URL ?>/estudiante_curso.php?asignacion=<?php echo $rowa['id_asignacion'] ?>'">

  <command label="Modificar curso"  onclick="
  document.location='modificar_curso.php?asignacion=<?php echo $rowa['id_asignacion'] ?>'">
  <command label="Duplicar curso"  onclick="document.getElementById('duplicar_<?php echo $rowa['id_asignacion'] ?>').click();">
      <?php } ?>
       
<command target="_BLANK" label="Reporte Valorativo"  onclick="window.open('../reportes/informe_valorativo.php?asignacion=<?php echo $rowa['id_asignacion'] ?>','_blank');">
    
<command target="_BLANK" label="Estadisticas"  onclick="window.open('../reportes/promedio_estudiantil.php?asignacion=<?php echo $rowa['id_asignacion'] ?>','_blank');">
  <command target="_BLANK" label="Salir"  onclick="return 'context-menu-icon context-menu-icon-quit'">
  
 

</menu>

<script>
$(function(fn){
    fn.contextMenu({
    selector: '.menu_curso<?php echo $rowa['id_asignacion'] ?>', 
    items: fn.contextMenu.fromMenu($('#menu_curso<?php echo $rowa['id_asignacion'] ?>'))
});
});
</script>
<?php 
/*
<!--onclick="mifuncionAjax(<?php echo $rowa['id_asignacion']; ?> );"--> 
*/
?>
<script>
/*
    if_confirm_swal("¿Esta seguro de duplicar el curso <?php echo $rowa['nombre_materia'];  ?>?",'clonar_curso('<?php echo $rowa['id_asignacion']; ?>');','false',boton_verdadero = "Confirmar",boton_falso = "Cancelar",tipo='info',titulo = "Guagua");
    if(confirm('Esta seguro de duplicar el curso <?php echo $rowa['nombre_materia'];  ?>?')){ clonar_curso('<?php echo $rowa['id_asignacion']; ?>'); };
*/
</script>
<a style="display:none" class="btn_duplicar" id="duplicar_<?php echo $rowa['id_asignacion'] ?>" onclick="if_confirm_swal('¿Esta seguro de duplicar el curso <?php echo $rowa['nombre_materia'];  ?>?','clonar_curso(\'<?php echo $rowa['id_asignacion']; ?>\');','false','Confirmar','Cancelar','info','Guagua's);" 
url="#" value="Duplicar">
    <img width="45px" src="<?php echo SGA_COMUN_URL.'/'.'img/png/line-15-icons.png' ; ?>" title = "Duplicar <?php echo $rowa['nombre_materia'];  ?>"></img></a>
<?php if(($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente" )){ ?>
    <a id="modificar_<?php echo $rowa['id_asignacion'] ?>" href="modificar_curso.php?icon=<?php  echo $rowa['icono_materia'];  ?>&area=<?php  echo $rowa['ano_lectivo'];  ?>&ano_lectivo=<?php  echo $rowa['ano_lectivo'];  ?>&id_materia=<?php  echo $rowa['id_materia'];  ?>&nombre_materia=<?php echo $rowa['nombre_materia']; ?>&id_doc=<?php echo $rowa['id_docente']; ?>&asignacion=<?php echo $rowa['id_asignacion']; ?>&descripcion=<?php echo $rowa['descripcion']; ?>&nombre_docente=<?php echo $rowa['nombre_docente'].' '.$rowa['apellido_docente']; ?>" >
  <!--img style="position:absolute;margin-top:12px;margin-left:0px;" width="45px" src="<?php echo SGA_COMUN_URL.'/'.'img/png/settings-10.png' ; ?>" title = "Modificar <?php echo $rowa['nombre_materia'];  ?>"></img--></a> <?php } ?>
      </span>
      </div>
        
<?php } ?>
     

</div>

</div>
<?php } ?>

</div>
<?php } ?>
 <!--/div-->
</div><!--col-md-10-->
</div><!--row-->
</div>
<script>
cargar_drag_and_drop_asignacion();
mitoogle('.anos');
mitoogle
mitoogle('<?php echo $actual ?>');
</script>
<?php }//Fin function buscar_mis_cursos ?>
<br>
<?php
$contenido = ob_get_clean();
require '../comun/plantilla.php'; 
?>
