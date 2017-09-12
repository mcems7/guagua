<div align="center">
<?php
require_once '../../comun/lib/dompdf/dompdf_config.inc.php';
require '../../comun/conexion.php';
$inf_ie ='select * from config';
$consulta = $mysqli ->query($inf_ie);
$resultados = $consulta -> num_rows;
$html='';
if($rowinfosede =$consulta ->fetch_assoc()  ){ 
$sql = 'SELECT DISTINCT * FROM inscripcion, asignacion_academica,materia,usuario,categoria_curso,ano_lectivo';
$sql.= ' where
inscripcion.id_asignacion =asignacion_academica.id_asignacion and
asignacion_academica.ano_lectivo =ano_lectivo.id_ano_lectivo and
asignacion_academica.id_materia = materia.id_materia and
 asignacion_academica.id_categoria_curso  = categoria_curso.id_categoria_curso and
 usuario.id_usuario = inscripcion.id_estudiante  ';
if(isset($_POST['id_asignacion'])){
    $sql.=' and inscripcion.id_asignacion="'.$_POST['id_asignacion'].'" '; 
}
$consulta =$mysqli -> query ($sql);

if ( $row = $consulta ->fetch_Assoc()) {
$nombre_materia = $row['nombre_materia'];
$ombre_categoria_curso = $row['nombre_categoria_curso'];
$nombre_ano_lectivo =$row['nombre_ano_lectivo'];
}
    
$html.='<style type="text/css">
    .logo {
    font-family: "Arial Narrow";
    font-size: 14px;
    margin: 0.2cm 20cm 0cm 3cm ;
}
.IEM{
margin: -1cm 5cm 1cm 2cm ;
margin-left:330px!important;
    font-size:24px;
    
}
</style><img class="logo" height="60" src="../../comun/img/'.$rowinfosede["logo_institucion"].'"></img>
    <p class="IEM"><strong>
      '.$rowinfosede["nombre_institucion"].' <br/>
      </strong>   </p><h4 align="center">REPORTE ESTUDIANTES DE '.$nombre_materia.' ('.$ombre_categoria_curso.' / '.$nombre_ano_lectivo.') </h4>';
}

$html.='<table align="center" border="0.1"><tr>
<th>Identificación</th>
<th>nombre</th>
<th>Foto</th>
<th>usuario</th>
<th>Teléfono</th>
<th>Tipo de Sangre</th>
<th>Correo</th>
<th>Visitas</th>
<th>Estado</th>
<th>Ultimo ingreso</th>

</tr>';
require '../../comun/conexion.php';
require_once '../../comun/funciones.php';

#echo $sql;
if(isset($_POST['id_asignacion'])){
     $sql2='select * from usuario,inscripcion where
    inscripcion.id_estudiante = usuario.id_usuario and
    inscripcion.id_asignacion="'.$_POST['id_asignacion'].'"    ';
}
if(isset($_POST['id_inscripcion'])){
$sql2.=' and inscripcion.id_inscripcion="'.$_POST['id_inscripcion'].'"';
}
$sql2.=' order by usuario.apellido asc';
$consulta =$mysqli -> query ($sql2);
while ( $row = $consulta ->fetch_Assoc()) {
    $foto = '../../datos/foto/'.validarfoto($row['foto']);
$html.='<tr>
<td>'.$row['id_usuario'].'</td>
<td>'.$row['apellido'].' '.$row['nombre'].'</td>
<th><img id="foto_est_'.$row['id_estudiante'].'" title="tooltip" height="60" src="'.$foto.'"></img></th>
<td>'.$row['usuario'].'</td>
<td>'.$row['telefono'].'</td>
<td>'.$row['tipo_sangre'].'</td>
<td>'.$row['correo'].'</td>

<td>'.$row['num_visitas'].'</td>
<td>'.$row['estado'].'</td>';
$fecha = new DateTime($row['ultima_sesion']) ;
$fechaordenada = $fecha -> format('d/m/Y');


$fechas = explode(" ", $row['ultima_sesion']);
$hora =date("g:i a",strtotime($fechas[1]));
$html.='<td>'.($fechaordenada).' <br/> '.$hora.'</td>
</tr>';
}
$html.='</table><footer style=" position: fixed; bottom: -10px; left: 0px; right: 0px; ">Generado por Guagua: '.date('d-m-Y / g:i:s a').'</footer>';


$mipdf = new DOMPDF();
$mipdf ->set_paper("A4", "landscape");
$mipdf ->load_html($html,'UTF-8');
$mipdf ->render();
$mipdf ->stream('Acta.pdf', array("Attachment" => 0));





?>
</div>