<?php
ob_start();
@session_start();
$_SESSION['barra_busqueda']=="";
unset($_SESSION['barra_busqueda']);
require("../comun/capturar.php"); 
require("../comun/funciones.php");
require("../comun/conexion.php"); ?>
<?php 
if (isset($_GET['red'])){
 require("../comun/conexion.php");
$sql_visita ="UPDATE `red` SET `visitas` = `visitas`+1 WHERE `id_red`=".$_GET['red'];
    $mysqli->query($sql_visita);
    
  $sql_red= 'select * from red,usuario,materia where
  red.materia_red = materia.id_materia and
  red.responsable = usuario.id_usuario 
  and id_red = "'.$_GET['red'].'"' ;
 $consulta = $mysqli -> query($sql_red) ;
 $metadatos= array();
 if($row_red = $consulta -> fetch_assoc()){
  $metadatos = $row_red ;
 }
}

$formato =$_GET['formato'];
$ruta =  $_GET['enlace'];
$scorm=$_GET['scorm'];?>
<br/>
<?php
echo '<div id="visor_red">';
require_once("../comun/funciones.php"); // Carga código de encabezamiento
reproductor ($formato,$ruta,$scorm);
echo '</div>';
if (isset($_GET['red'])){
 echo '<div style="position:absolute;margin-top:-30%;margin-left:60%;">';
 echo '<h2>'.$metadatos['titulo_red'].'</h2>'; 
  echo '<span>Responsable:  '.$metadatos['nombre'].' '.$metadatos['apellido'].'</span><br>'; 
  echo '<span>Materia :'.$metadatos['nombre_materia'].'</span><br>'; 
 # $metadatos['nivel_eductivo'] = explode(",",json_decode($metadatos['nivel_eductivo'],true));
 $metadatos['nivel_eductivo'] = str_replace("[", "", $metadatos['nivel_eductivo']);$metadatos['nivel_eductivo'] = str_replace("]", "", $metadatos['nivel_eductivo']);
  echo '<span>Nivel Educativo :'.$metadatos['nivel_eductivo'].'</span><br>'; 
  echo '<span>Fecha Publicación : '.formatofecha2($metadatos['fecha']).'</span><br>'; 
  echo '<span>Descripción :'.$metadatos['descripcion'].'</span><br>'; 
  echo '<span>Autor :'.$metadatos['autor'].'</span><br>'; 
  echo '<span>Dificultad :'.$metadatos['dificultad'].' (1 a 5)</span><br>';  
  echo '<span>Visitas :'.$metadatos['visitas'].'</span><br>';
  ?>

  <span>Estrellas : <span id="num_fav_red"><?php $array_estrellas = json_decode($metadatos['estrellas'],true); echo sumar_valores($array_estrellas) ?></span>&nbsp;<span class="fav_visor"><?php  echo mis_red_favoritos($metadatos['id_red'], $metadatos['estrellas']); ?></span>
  </span>
  <br/>
  <?php
  echo '<span>Palabras Clave :'.$metadatos['palabras_clave'].'</span><br>'; 
  echo '<span>Icono :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="'.$metadatos['icono_red'].'"></span></span><br>'; 
 ?> <input style="color:#FFF" onclick="window.open('../comun/funciones.php?ruta_red=<?php echo $metadatos['enlace']; ?>&formato=<?php echo $metadatos['formato']; ?>&scorm=<?php echo $metadatos['scorm']; ?>')" type="button" class="btn btn-primary" value="Descargar"/>
<?php
if($metadatos['scorm']=='SI'){
echo '<button type="submit" class="btn btn-success">Descargar Scorm</button>';
}
 echo '</div>';
}


$contenido = ob_get_clean();
require ("../comun/plantilla.php");
?>



   


