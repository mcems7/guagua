<?php
@session_start();
require_once ("../comun/conexion.php");
if(!isset($_SESSION['rol'])){exit();}
if(isset($_GET['asignacion'])){
$id_asignacion = mysqli_real_escape_string($mysqli, $_GET['asignacion']);
$ano = ano_lectivo();
}

#######################
$html='';
$sqlperiodo ='select distinct(periodo) from actividad where id_asignacion ="'.$id_asignacion.'"';
$consultaperiodo = $mysqli -> query($sqlperiodo);
$resultados_seguimiento =$consultaperiodo -> num_rows;
while($rowperiodo =$consultaperiodo-> fetch_assoc()){
    $periodos_actividades[] =$rowperiodo;
}
if(empty($periodos_actividades)){ ?>
<script type="text/javascript">
alert('Informe no disponible \n por falta de datos');
window.close();
</script>
<?php }
if(!empty($periodos_actividades) and isset($html)){
foreach ($periodos_actividades as $periodo) {
$html.=  plantilla_boletin($id_asignacion ,$periodo['periodo'],$ano);
  if($_SESSION['rol']=="estudiante" or $_SESSION['rol']=="acudiente"){
       $html.=' <div style="page-break-before:always;"></div>';
$html.=hoja_de_observaciones($id_asignacion,$periodo['periodo'],$ano,$total_valoraciones,$materia);
$html.=' <div style="page-break-after:always;"></div>';
}


else{
    $html.=' <div style="page-break-after:always;"></div>';

}

}
}
if(isset($cuantasactividades) and $cuantasactividades >8){ //limitamos la cantidad de actividades según tipo de pape
    $hoja="Letter";
} else {
        $hoja="A4";

}
#$html.=graficadelinea();
if(isset($html)){
 echo 'Hola Mundo'; 
}
else {
    echo '<script>';
    echo "alert('No hay información')";
    echo 'window.close';
    echo '</script>';
    }
  
require_once '../comun/lib/dompdf/dompdf_config.inc.php';
$mipdf = new DOMPDF();
$mipdf ->set_paper($hoja, "Landscape"); 
$mipdf ->load_html($html,'UTF-8');
$mipdf ->render();
$mipdf ->stream('Acta.pdf', array("Attachment" => 0));    

  
    
    
/*

*/


####




function plantilla_boletin($id_asignacion,$periodo,$ano){
require ("../comun/conexion.php");
 $sqlmateria ='select * from asignacion_academica,materia,categoria_curso where 
 asignacion_academica.id_categoria_curso = categoria_curso.id_categoria_curso and
 materia.id_materia = asignacion_academica.id_materia and asignacion_academica.id_asignacion =  "'.$id_asignacion.'"';
$consultamateria = $mysqli ->query($sqlmateria);
while($rowmateria = $consultamateria -> fetch_assoc()){
$_SESSION['materia']=$rowmateria['nombre_materia'].' ('.$rowmateria['nombre_categoria_curso'].' )';
     $materia=$rowmateria['nombre_materia'];
     $categoria_curso =$rowmateria['nombre_categoria_curso'];
}
require_once '../comun/lib/dompdf/dompdf_config.inc.php';
$html='<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte Valorativo </title>
    <style type="text/css">
    span{
    text-decoration: underline;
    }
.logo {
    font-family: "Arial Narrow";
    font-size: 14px;
    margin: 0.2cm 15cm 0cm 3cm ;
}
.IEM{margin: -1cm 0cm 0cm 8cm ;
    font-size:25px;
    
}
.sed{ margin: -5cm 0cm 0cm 5cm ; }
</style>
</head>
<body>
<br/>';
require '../comun/conexion.php';
$inf_ie ='select * from config';
$consulta = $mysqli ->query($inf_ie);
$resultados = $consulta -> num_rows;
if($resultados<=0 ){ ?>
    <script type="text/javascript" >
    alert('No hay resultados');
   window.history.back();
            </script>

<?php }
if($rowinfosede =$consulta ->fetch_assoc() and isset($html) ){
$html.='<img class="logo" height="60" src="../comun/img/'.$rowinfosede["logo_institucion"].'"></img>
    <p class="IEM"><strong>
      '.$rowinfosede["nombre_institucion"].' <br/>
      </strong>   </p>
    
                 <br/>
<h4 align="center">REPORTE VALORATIVO '.$materia.' ('.$categoria_curso.') <br/> PERIODO '.$periodo.' ('.$ano.' )</h4>';
    
}
$html  .= valoracion_por_asignacion($id_asignacion,$periodo,$ano);

$html  .= '<br/>';
$html.='</tr>';
$html.='';
$html.='';
$html.='<tr align="right">
<td colspan="9"></td>
<td></td>
</tr>
</table>
    </p>
<br/><br/><br/>
<table width=100%  >
<tr> 

<td width=50> </td>

<td align= center >  
<img class="parrafo_imagen" src="" width ="190px" height="100px"/>
 <p class="docente" >_____________________________ </br>';
#require_once '../comun/funciones.php';
   $sql_docente ='select * from usuario , asignacion_academica where 
asignacion_academica.id_docente =usuario.id_usuario and asignacion_academica.id_asignacion = "'.$id_asignacion.'" ';
$consulta_docente = $mysqli ->query($sql_docente);
while($rowdocente = $consulta_docente -> fetch_assoc()){
   $html.= strtoupper($rowdocente['nombre'].' '.$rowdocente['apellido']); 
}
#$html.=docente_en_asignacion($id_asignacion);
$html.='<br /> 
    Docente
</td>
</tr>
</table>

</body>
<footer style=" position: fixed; bottom: -10px; left: 0px; right: 0px; ">Generado por Guagua: '.date('d-m-Y / g:i:s a').'</footer>

</html>';
 return $html;

}
####
function valoracion_por_asignacion($id_asignacion ,$periodo="",$ano=""){
require ("../comun/conexion.php");
require_once ("../comun/funciones.php");
require_once 'r.php';
if ($ano=="") {    $ano = ano_lectivo(); }

 $sql_reporte_m ='SELECT * from `inscripcion` inner join usuario on `inscripcion`.id_estudiante = usuario.id_usuario inner join `asignacion_academica` on `inscripcion`.id_asignacion = `asignacion_academica`.id_asignacion inner join `actividad` on `asignacion_academica`.`id_asignacion` = `actividad`.`id_asignacion` left join seguimiento on actividad.id_actividad = seguimiento.id_actividad and `inscripcion`.id_inscripcion = `seguimiento`.id_inscripcion where `actividad`.`periodo` = '.$periodo.' and ';
@session_start();
if($_SESSION['rol']=='acudiente' and isset($_SESSION['hijo']) ){
$sql_reporte_m.=' usuario.id_usuario="'.$_SESSION['hijo'].'" and ';
}
if($_SESSION['rol']=='estudiante' ){
$sql_reporte_m.=' usuario.id_usuario="'.$_SESSION['id_usuario'].'" and ';
}
  $sql_reporte_m.=' `fecha_inscripcion` LIKE "%'.$ano.'%"  and `inscripcion`.id_asignacion = '.$id_asignacion.' order by usuario.apellido ';
/**
 * Descripción:
 * Se desea visualizar todas las inscripciones de tu asignación y por cada una de ellas cruzar con las actividades y si tiene seguimiento mostrarlo */
 
$consulta_seguimiento = $mysqli->query($sql_reporte_m);
$actividades = array();//define el ancho
$estudiantes= array();//define el alto
$notas_por_estudiante = array();
while ($row_seguimiento = $consulta_seguimiento->fetch_assoc()){
if($row_seguimiento['id_actividad']<>""){
  $actividades[$row_seguimiento['id_actividad']] = $row_seguimiento['nombre_actividad'];

}
//para los th de la primera fila

$estudiantes[$row_seguimiento['id_usuario']] = $row_seguimiento['apellido']." ".$row_seguimiento['nombre'];
//para la primera columna de nombres

$datos_organizados[$row_seguimiento['id_usuario']][$row_seguimiento['id_actividad']]=$row_seguimiento['valoracion'];
//para las notas

$notas_por_estudiante[]=$row_seguimiento;
//todos los datos (por un caso)

}

$html = '<table  align="center" border="1" width="80%">';
//hacia abajo
$html .=  "<tr>";
$html .= "<th>";
$html .= "Nombre del Estudiante";
$html .= "</th>";
$cuantasactividades =count($actividades);

foreach ($actividades as $id_actividad => $nombre_actividad){
//hacia lo ancho
$html .= "<th>".$nombre_actividad."</th>";
}
$html .= "<th>Promedio</th>";
$html .= '<pre>';
#print_r($notas_por_estudiante);
$html .= '</pre>';
foreach ($estudiantes as $id_estudiante => $nombre_estudiante){
$html .= "<tr>";
#print_r($datos_est);
$html .= "<td>".$nombre_estudiante."</td>";

foreach ($datos_organizados[$id_estudiante] as $id_actividad => $valoracion_actividad){
 if($valoracion_actividad<>""){
    $total_valoraciones[]=$valoracion_actividad;
$html .= "<td>".$valoracion_actividad."</td>";
if ($valoracion_actividad!="") $promedio[$id_estudiante] += $valoracion_actividad;
if ($valoracion_actividad!="") $cont[$id_estudiante]++;
}
}

$html .= "<td>";
if(isset($cont)){
if ($cont[$id_estudiante]>0) $html .= $promedio[$id_estudiante]/$cont[$id_estudiante];
}
$html .= "</td>";
$html .= "</tr>";
}
$html .= "</table>";


$html.='<img src="" id="miuton"></img>';


if (isset($cont_gral) and $cont_gral>0) $html .= "<p>&nbsp&nbsp&nbsp&nbsp&nbspPromedio General de la Asignatura: ". $promedio_gral/$cont_gral.'</p>';
return $html;
}


####Observacioners
function hoja_de_observaciones($id_asignacion,$periodo,$ano="",$total_valoraciones,$materia){
require_once ("../comun/conexion.php");
 $inf_ie ='select * from config';
$consulta = $mysqli ->query($inf_ie);
$resultados = $consulta -> num_rows;
if($rowinfosede =$consulta ->fetch_assoc()  ){
$html.='<img class="logo" height="60" src="../comun/img/'.$rowinfosede["logo_institucion"].'"></img>
    <p class="IEM"><strong>
      '.$rowinfosede["nombre_institucion"].' <br/>
      </strong>   </p>
    <pre>';
    @session_start();
 $html.='</pre>
                 <br/>
<h4 align="center">HOJA DE OBSERVACIONES REPORTE VALORATIVO '.$_SESSION['materia'].' <br/> PERIODO '.$periodo.' ('.$ano.' )</h4><br/><br/>';
    
}

if ($ano=="") {    $ano = date("Y"); }
//$periodo=1;
   $sql_reporte_m ='SELECT * from `inscripcion` inner join usuario on `inscripcion`.id_estudiante = usuario.id_usuario inner join `asignacion_academica` on `inscripcion`.id_asignacion = `asignacion_academica`.id_asignacion inner join `actividad` on `asignacion_academica`.`id_asignacion` = `actividad`.`id_asignacion` left join seguimiento on actividad.id_actividad = seguimiento.id_actividad and `inscripcion`.id_inscripcion = `seguimiento`.id_inscripcion where `actividad`.`periodo` = '.$periodo.' and ';
    @session_start();
if($_SESSION['rol']=='acudiente' and isset($_SESSION['hijo']) ){
    $usuario =$_SESSION['hijo'];
$sql_reporte_m.=' usuario.id_usuario="'.$_SESSION['hijo'].'" and ';
}
if($_SESSION['rol']=='estudiante' ){
        $usuario =$_SESSION['id_usuario'];
$sql_reporte_m.=' usuario.id_usuario="'.$_SESSION['id_usuario'].'" and ';
}
 $sql_reporte_m.=' `fecha_inscripcion` LIKE "%'.$ano.'%"  and `inscripcion`.id_asignacion = '.$id_asignacion.' order by usuario.apellido ';
 
$consulta_seguimiento = $mysqli->query($sql_reporte_m);
$actividades = array();//define el ancho
$estudiantes= array();//define el alto
$notas_por_estudiante = array();
while ($row_seguimiento = $consulta_seguimiento->fetch_assoc()){
$actividades[$row_seguimiento['id_actividad']] = $row_seguimiento['nombre_actividad'];
//para los th de la primera fila
$estudiantes[$row_seguimiento['id_usuario']] = $row_seguimiento['apellido']." ".$row_seguimiento['nombre'];
//para la primera columna de nombres
$datos_organizados[$row_seguimiento['id_usuario']][$row_seguimiento['id_actividad']]=$row_seguimiento['observacion'];
//para las notas
$notas_por_estudiante[]=$row_seguimiento;
//todos los datos (por un caso)
}
foreach ($actividades as $id_actividad => $nombre_actividad){
 $html.= 'En la Actividad <strong>'.$nombre_actividad.'</strong>, ';
 if($datos_organizados[$usuario][$id_actividad].''.$datos_organizados['observacion']==''){
     $html.=' no ';
 }
 $html.=' presenta  observación :<strong>'.$datos_organizados[$usuario][$id_actividad].' '.$datos_organizados['observacion'].'</strong><br/>';

}
#$html.='a'.$notas_por_estudiante[0]['valoracion'];




return $html;

}

####Fin Observaciones


?>