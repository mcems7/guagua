<style>
#txt_entradas textarea, #txt_entradas textarea::-webkit-input-placeholder, .emojionearea-editor::-webkit-input-placeholder{
font-size: 20px !important;
}
#txt_entradas textarea, #txt_entradas textarea::-moz-placeholder{
font-size: 20px !important;
}
.area_visitas, .area_denuncias{
    float:right;
    margin: 0 15px;
}
.entradas p, .comentario {
    text-align: left;
    position: relative;
    margin-top: 80px !important;
}
.foro .panel-heading{
    border:0px solid transparent;
}
    .foro .cabecera_entrada{
        text-align:left;
        position:relative;
    }
    .foro .cabecera_entrada .autor_publicacion {
       float:left;
       margin-bottom:30px;
    }
    .foro .cabecera_entrada .fecha_publicacion {
       margin-left:50px;
       top: -15px;
       position: relative;
    }

</style>
<script>
//var dnd = $("[fn-dranganddrop]");
//if (dnd) cargar_dranganddrop();
/*
setTimeout(function(){
$(document).find(".emojionearea").each(function() {
var num = $(this).attr("emojionearea");
 idemojiarea = "contenido_"+num;
    ididemojiarea = "#"+idemojiarea+"_emojiareas";
var el = $("#"+idemojiarea).emojioneArea({
    container: ididemojiarea,
    hideSource: true,
    useSprite: true
  });
});
}, 3000);
*/
$(function(){ 
        var es_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
if(es_chrome){
			    
}else {
        $('input[type=date]').datepicker({
              dateFormat : 'yy-mm-dd'
            }
         );
}

//
/*
window.onbeforeunload = function (e) {
var e = e || window.event;
		   if (e) {
		     e.returnValue = 'Estimado usuario, Se perderan todos los datos que no hayas guardado';
		   }
}
*/
});
$("div[role=tooltip]").click(function(){
$("div[role=tooltip]").remove();
});
$(document).ready(function() {
    $('.form_ajax').submit(function(event) {
        event.stopPropagation();
        event.preventDefault();
        var resp_1 = $(this).attr('resp_1');
        var resp_0 = $(this).attr('resp_0');
        var callback_1 = $(this).attr('callback_1');
        var callback_0 = $(this).attr('callback_0');
        var callback = $(this).attr('callback');
        
        var type = "post";
        var url = $(this).prop("action");
        /* Cuando mandamos sólo texto (sin archivos)
             configuramos estos valores */
        var contentType = 'application/x-www-form-urlencoded';
        var processData = true;

        /* Para que PHP reciba todos los archivos hay que definir
             el <input> con corchetes, de modo que aquí tenemos que
             indicarlo igual */
        if (this['imagen_icono'] && this['imagen_icono'].files.length) {
            var data = new FormData(this);
            /* En este caso sí que hay que cambiar estos parámetros,
                 en particular contentType=false provoca una cabecera HTTP
                 'multipart/form-data; boundary=----...' */
            contentType = false;
            processData = false;
        } else {
            var data = $(this).serialize();
        }
        $.ajax({
            url: url,
            data: data,
            type: type,
            contentType: contentType,
            processData: processData
        }).done(function(data) {
            if (data=="1"){
            alert3(resp_1);
            eval(callback_1);
            }else if (data=="0"){
            alert3(resp_0,'danger');
            eval(callback_0);
            }else{
             alert3(data,'warning');   
            }
            setTimeout(function(){
                eval(callback);
            },2000);
        });
    });
});

$(document).bind('keydown', function(e) {
tecla=(document.all) ? e.keyCode : e.which;
if (document.getElementById('mover_fondo').checked==true){
if (tecla==37 && e.altKey){ //37 = letra flecha izq
document.getElementById('jumbotronbgPosX').value--;document.getElementById('jumbotronbgPosX').onchange();return false;}
if (tecla==38 && e.altKey){ //38 = letra flecha arriba
document.getElementById('jumbotronbgPosY').value--;document.getElementById('jumbotronbgPosY').onchange();return false;}
if (tecla==39 && e.altKey){ //39 = letra flecha derecha
document.getElementById('jumbotronbgPosX').value++;document.getElementById('jumbotronbgPosX').onchange();return false;}
if (tecla==40 && e.altKey){ //40 = letra flecha abajo
document.getElementById('jumbotronbgPosY').value++;document.getElementById('jumbotronbgPosY').onchange();return false;}
}
});
$(function(){
//$(document).tooltip();
//$(document).contextMenu();
});
</script>
<style>
    .jumbotron:not(.jumbotron-curso){
        height:200px;
        <?php 
if(defined('BANNER_INSTITUCION') and BANNER_INSTITUCION != ""){ ?>
background-image: url('<?php echo READFILE_URL.'/foto/'.BANNER_INSTITUCION; ?>');no-repeat left center;-webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover;<?php }
if(defined('BANNER_POSITION') and BANNER_POSITION != ""){
    echo 'background-position: '.BANNER_POSITION.';';
}
?>
    }
</style>
<footer id="sgafooter">
<div >
<?php
$sql ='select * from config';
    $consulta = $mysqli ->query($sql);
    $extensiones = array();
while( $row=$consulta->fetch_assoc()){
    echo $row['nombre_institucion'];
}   
?>
   </div>
</footer>