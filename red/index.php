<?php 
require '../comun/conexion.php';
require_once ("../comun/funciones.php");
require_once("../comun/config.php");
ob_start();
@session_start(); 
$_SESSION['barra_busqueda'] = "red";?>
<script>

$(function(){
    $.contextMenu({
        selector: '.context-menu-one', 
        trigger: 'hover',
        delay: 500,
        callback: function(key, options) {
    if(key=="Nuevo RED"){window.location='nuevo_red.php';}
    if(key=="Estadisticas"){window.location='../reportes/RED/estadisticas_red.php';}
    
            var m = "clicked: " + key;
        //    window.console && console.log(m) || alert(m); 
        },
        items: {
            <?php if($_SESSION['rol']=='admin' or $_SESSION['rol']=='docente' ) { ?>
            "Nuevo RED": {name: "Nuevo RED"},
            <?php } ?>
            "Estadisticas": {name: "Estadisticas"},
            "sep1": "---------",
            "Salir": {name: "Salir"}
        }
    });
});
document.getElementById('txt_buscar_red').focus();
function menu_contextual(red,nombre){
 $.contextMenu({
            selector: '.f_inicio'+red, 
            callback: function(key, options) {
             if(key=="Modificar"){
            window.location='nuevo_red.php?id_red='+red;
}

             if (key=="Eliminar"){
               var confirmar = window.confirmeliminar2("¿Está seguro que desea eliminar "+nombre+" ?");
    if (confirmar) {
                                 window.location='../comun/funciones.php?elred='+red;

    }
             
             }
            },
            items: {
            "materia": {name: nombre, icon: ""},
            "sep1": "---------",

                "Modificar": {name: "Modificar", icon: "edit"},
                "Eliminar": {name: "Eliminar", icon: "delete"},
                "sep2": "---------",
                "quit": {name: "Salir", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            }
        });

        $('.f_inicio').on('click', function(e){
            console.log('clicked', this);
        })    
}



</script>
<?php
if(!isset($_SESSION['rol'])){ exit(); }
if (isset($_POST['datos'])) $parametro_buqueda = $_POST['datos']; ?>
<span id="span_buscar_red">
    <div id="false" name="contenedor"  class="jumbotron">
<input style="z-index:1" id="opciones_cursos2"  type="button" value="Opciones"  class="btn btn-warning context-menu-one" name=""/>
  <div class="container text-center">
     
      <?php if($_SESSION['rol']=="admin" or $_SESSION['rol']=="docente") {  ?>
<!--a href ="nuevo_red.php"> <img title="Nuevo RED" src="<?php echo SGA_COMUN_URL.'/'.'img/nuevo.png' ; ?>" class="img-responsive" style="float:right;width:120px" alt="Image"></a-->
<?php } ?>

<div id="false" onclick="MostrarTodosLosRed(this.id);">
    <h1  id="titulo_red"  class="fip">
        <?php if($_SESSION['rol']=="estudiante"){
            echo 'Entretenmiento';
        }
        else{
                        echo 'RECURSOS EDUCATIVOS DIGITALES';

        }
    echo '</h1>';    
              ?></div>
              
  </div>
</div>
<div class="container-fluid bg-3 text-center">    
<div class="row"></div>
<?php if (isset($_GET['buscar_red'])){
?>
<?php busqueda_red($_GET['buscar_red'],$_GET['campo']);
exit();
} ?>
</span><!-- 14 -->

<?php
function busqueda_red($parametro_buqueda="",$campo){ ?>

<?php
require '../comun/conexion.php';
$sql ='select distinct( `id_materia`) , `id_materia`, `nombre_materia`, `obligatoria`, `area`, `icono_materia` from materia where  obligatoria = "SI" ';
$consulta = $mysqli ->query($sql);
while($row = $consulta ->fetch_assoc()){
    $arreglo[]=$row;
     mired($row['id_materia'],$parametro_buqueda,$campo);
}
}

function mired($materia,$parametro_buqueda,$campo){ 
require '../comun/conexion.php';
require_once '../comun/funciones.php';
$sql= 'select * from red,materia,usuario where
red.responsable = usuario.id_usuario and 
red.materia_red = materia.id_materia and 
materia_red="'.$materia.'"   ';

if ($parametro_buqueda!=""){
$sql.= ''; 
$parametro_buqueda_array = explode(" ",$parametro_buqueda);

foreach ($parametro_buqueda_array as $id => $parametro_buquedai){
$tabla='red';
if($campo=="nombre"){ $tabla ='usuario' ;}

if($campo=="nombre_materia"){ $tabla ='materia' ;}
if($campo=="nivel_eductivo"){ $parametro_buquedai = '["'.$parametro_buquedai.'"]' ;
}
$sql.= " and concat(LOWER(".$tabla.".".$campo.")) LIKE '%".mb_strtolower($parametro_buquedai, 'UTF-8')."%' ";


}
}
#echo $sql;

$consultan = $mysqli -> query($sql) ;
$resultados[] = $consultan->num_rows;

$materia="";
$cat="";
$nivel_educativo_estudiante ="";
if($_SESSION['rol']=="estudiante" or $_SESSION['rol']=="acudiente" ){
$año_lectivo = ano_lectivo();
$nivel_educativo_estudiante = nivel_educativo_de_estudiante($_SESSION['id_usuario'],$año_lectivo);
}
while ($rowa = $consultan ->fetch_assoc()){ 
#$rowa['nivel_eductivo'] = str_replace("[", "", $rowa['nivel_eductivo']);
#$rowa['nivel_eductivo'] = str_replace("]", "", $rowa['nivel_eductivo']);
#$rowa['nivel_eductivo'] =ereg_replace('"','',$rowa['nivel_eductivo']);
#$niveles = explode(",", $rowa['nivel_eductivo']);
$niveles = json_decode($rowa['nivel_eductivo']);
 $valor_alto = max($niveles);
if($nivel_educativo_estudiante <= $valor_alto or $_SESSION['rol']=='admin' or  $_SESSION['rol']=='docente'){$pertinencia = 1;}
else {$pertinencia = 0;}

if ($materia!=$rowa['materia_red']){
    $materia=$rowa['materia_red'];
    $estado_materia=true;
}else{
    $estado_materia=false;
}
if($cat!=$rowa['materia_red']){
    $cat=$rowa['materia_red'];
    $estado_cat=true;
}else{
    $estado_cat=false;
}
if($estado_materia==true){ ?>
</div>
<?php }
if($estado_materia==true){?>

    <div  class="col-sm-12">
        <div class="row"><div>
        <div  style="aling:center;background-color:#f2721d;height:5px; "><span style="float:right;opacity:0.7"><?php echo " Resultados Encontrados:".$consultan->num_rows; ?></span></div>
       <p align="center" onmouseup="mitoogle('#id_<?php echo $materia; ?>')" ><?php echo $rowa['nombre_materia']; ?></p>
    <?php if(!isset($actual)) $actual="#id_".$materia; ?>
    </div>
</div></div>

<?php } ?>
<?php if($estado_materia==true){ //Controla toogle?>
        <p onclick="mitoogle('#cat_<?php echo $materia.$cat; ?>')" class="Abckids"><?php if(isset($rowa['nombre_categoria_curso'])) echo $rowa['nombre_categoria_curso']; ?></p>

<div id="id_<?php echo $materia; ?>" class="cats" id="cat_<?php echo $materia.$cat; ?>">
<?php }
if($pertinencia ==1){

if($_SESSION['puntos']>=$rowa['cantidad_estrellas']){ ?>

<?php } ?>
 <div onclick="location.href = 'visor_red.php?red=<?php echo $rowa['id_red']; ?>&formato=<?php echo $rowa['formato']; ?>&enlace=<?php echo $rowa['enlace']; ?>&scorm=<?php echo $rowa['scorm']; ?>' "  <?php
 if($_SESSION['puntos']<$rowa['cantidad_estrellas']){
     echo 'style="opacity: 0.5;" ';
 }
@session_start();
 if($rowa['responsable']==$_SESSION['id_usuario'] or $_SESSION['id_usuario']=="admin" ){ ?> 
 onContextMenu="menu_contextual('<?php echo $rowa['id_red']; ?>','<?php echo  $rowa['titulo_red']; ?>');" <?php } ?> style="width:160px;margin-bottom:15px;" id="<?php echo $rowa['id_red']; ?>" name="red" align="center" class="col-sm-2 f_inicio<?php echo $rowa['id_red']; ?>">
   <?php mis_red_favoritos($rowa['id_red'], $rowa['estrellas']); ?>
        <h3 title="<?php echo $rowa['titulo_red'] ; ?>" ><strong><?php   $rowa['nivel_eductivo'] = str_replace("[", "", $rowa['nivel_eductivo']);$rowa['nivel_eductivo'] = str_replace("]", "", $rowa['nivel_eductivo']);
        $rowa['nivel_eductivo'] = str_replace('"','', $rowa['nivel_eductivo']);
       echo puntos_suspensivos($rowa['titulo_red'],12); ?></strong></h3>
<img style="width:50px;margin-right:40px"  class="img-responsive" align="right" style="margin-top:-5%;max-width: 100%;" width="15%" src="<?php echo   consultar_link_icono($rowa['icono_red']); ?>        
"></img>
   <!--span style="background-size: 40px 40px;margin-top:-10px;margin-left:-20px;"   title = " <?php echo $rowa['descripcion'].'Nivel Educativo:'.$rowa['nivel_eductivo'].', Monedas para ver:'.$rowa['cantidad_estrellas'];  ?>" class="<?php echo $rowa['icono_red']; ?>"/-->
        <?php if($_SESSION['puntos']>=$rowa['cantidad_estrellas'] or $_SESSION['rol']=='admin' or $_SESSION['rol']=='admin'){  } ?>
<div>
</div>
</div> 
<?php
} //fin validación de pertinencia del nivel de formación del recurso para el estudiante y acudiente 
  $acumulador_de_resultados_consulta[]=$resultados;
  } 
}
echo ' </div>';
echo ' </div>';
$contenido = ob_get_clean();
require '../comun/plantilla.php'; 
?>
