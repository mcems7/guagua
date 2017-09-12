<?php
if (isset($_GET['guia']) and $_GET['guia'] == "NO"){
setcookie("guia","NO");
}else if (isset($_GET['guia']) and $_GET['guia'] == "SI"){
setcookie("guia","SI");
}
if (isset($_COOKIE['guia']) and $_COOKIE['guia']=="SI"){
?>
<div class="row" style="width:62%;float:left;border:2px solid red;margin-bottom: -100%;
    z-index: 100;
    position: relative;height:624px;">
    A
</div>
<div class="row" style="width:38%;float:right;margin-right:14px;border:2px solid red;    margin-bottom: -100%;
    z-index: 100;
    position: relative;height:624px;">
    <div class="row" style="
    height:38%;
    border:2px solid red;
    z-index: 100;
    position: relative;
    width:100%;
    ">
    B1
</div>
    <div class="row" style="
    height:62%;
    border:2px solid red;
    z-index: 100;
    position: relative;
    width:100%;
    ">
    B2
</div>
</div>
<?php
}
?>