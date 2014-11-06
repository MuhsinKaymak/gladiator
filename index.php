<?php 
require_once('classes/Provider.php');

session_start();

if(isset($_SESSION["playerID"]) && $_SESSION["playerID"] > -1)
{
    header("Location: profile.php");
}

if(isset($_POST['btnLogin']))
{
    $sql = new Provider();
    
    $id = -1;
    $id = $sql->checkLogin($_POST['username'], $_POST['password']);
    
    if($id != -1)
    {
        $_SESSION["playerID"] = "$id";
        
        header("Location: profile.php");
    }
}

if(isset($_POST['btnRegister']))
{
    $sql = new Provider();
    
    echo "registered = ".$sql->register($_POST['regUsername'], $_POST['regPass'], $_POST['regMail']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Gladiator</title>

<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    
<div align="center">

<div id="title" class="title">
<a href="index.php"><img alt="Gladiators" src="graphics/title.png"/></a>
</div>

<div id="menu" class="menu">
<img src="graphics/marble_menu_side_l.png"/>
<div class="menu background">


<?php include('login.html'); ?>

</div>
<img src="graphics/marble_menu_side_r.png"/>
</div>

<div id="frame" align="left">

<div id="leftside" class="pillar left">

</div>

<div id="inner-frame">

<div class="chain-divider upper">
</div>

<div id="player-stats" class="player-stats">

<div id="stats">

</div>
</div>

<div class="chain-divider lower"></div>

<div id="inner" class="inner">
<div style="height:50px"></div>

<div class="banner">
<img alt="" src="graphics/banners/banner_welcome.png"/>
</div>

<div style="display:table;padding:25px;">
    
<div style="display:table-cell">
<h3>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ornare nisi nec dolor aliquam posuere. Praesent mi mi, lobortis id mattis et, imperdiet ut nisi. Ut sit amet cursus dui. Etiam eu turpis quis magna aliquet accumsan ut quis ante. Fusce at commodo tortor, vel commodo erat. Morbi eleifend feugiat ligula a blandit. Phasellus dignissim egestas luctus. Phasellus non tellus faucibus est egestas tristique et vitae sem. Nunc turpis lectus, vulputate nec tortor ut, mollis ornare lorem. Phasellus lacinia sapien et tellus vestibulum, at dictum erat lacinia. Sed at ultrices nisi, eu malesuada sem. Nullam bibendum dignissim massa, vitae scelerisque elit elementum eget. Nam tempus, ante eget venenatis condimentum, sem augue varius lorem, vitae tincidunt magna diam nec nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
</h3>
</div>

<div style="display:table-cell;width:500px;padding-left:25px">
    
<div class="banner" style="width:270px">
<img alt="" src="graphics/banners/banner_register.png"/>
</div>
    
    <div class="box" style="width:254px">
    
<form action="index.php" method="post">
<input id="register" name="regUsername" type="text" placeholder="username">
<input id="register" name="regPass" type="password" placeholder="password">
<input id="register" name="regPass2" type="password" placeholder="password again">
<input id="register" name="regMail" type="text" placeholder="E-mail"><br><br>
<button name="btnRegister" class="btnRegister" type="submit"><img alt="" src="graphics/banners/banner_register.png"></button>
</form>

</div>
    
</div>

</div>

</div>

<div class="chain-divider lower"></div>

</div>

<div id="rightside" class="pillar right">

</div>
</div>

<div id="copyright" class="copyright">
copyright &copy 2014-2015
</div>

</div>

<script type="text/javascript">
    document.getElementById("btnProfile").onclick = function () {
        location.href = "profile.php";
    };
    document.getElementById("btnMarket").onclick = function () {
        location.href = "market.php";
    };
    document.getElementById("btnArena").onclick = function () {
        location.href = "arena.php";
    };
    document.getElementById("btnHospital").onclick = function () {
        location.href = "hospital.php";
    };
</script>
</body>
</html>

<?php

?>