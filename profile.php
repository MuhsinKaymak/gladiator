<?php
require_once('classes/Provider.php');

session_start();
if(isset($_SESSION["playerID"]))
{
    if(!$_SESSION["username"] || !$_SESSION["health"] || !$_SESSION["attack"] || !$_SESSION["defence"] || !$_SESSION["gold"] || !$_SESSION["energy"] || !$_SESSION["levelID"] || !$_SESSION["xp"])
    {
        $sql = new Provider();
        $stats = $sql->getStats($_SESSION["playerID"]);

        $_SESSION["username"] = $stats['username'];
        $_SESSION["health"] = $stats['health'];
        $_SESSION["attack"] = $stats['attack'];
        $_SESSION["defence"] = $stats['defence'];
        $_SESSION["gold"] = $stats['gold'];
        $_SESSION["energy"] = $stats['energy'];
        $_SESSION["levelID"] = $stats['levelID'];
        $_SESSION["xp"] = $stats['xp'];
    }
}
else
{
    header("Location: index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Profile | Gladiators</title>

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


<?php include('nav-menu.html'); ?>

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
<?php include('stats-display.php'); ?>
</div>
</div>

<div class="chain-divider lower"></div>

<div id="inner" class="inner">
<div style="height:50px"></div>

<div class="banner">
    <img alt="" src="graphics/banners/banner_profile.png"/>
</div>
<div  style="width:100%;display:table;">
    
    <div style="display:cell;width:50px;float:left;">
    <img alt="" src="graphics/icons/ico_gold_m.png"/> 
    </div>
    <div class="gold-text" style="display:cell;width:100px;float:left">
    <?php echo (isset($_SESSION["gold"]) ? $_SESSION["gold"] : "0") ?>
    </div>
    
</div>

<div style="display:table;padding:10px;width:100%;">
    
<div style="display:table-cell;float:left;width:200px;">

<div class="banner" style="width:300px;">
<img alt="" src="graphics/banners/banner_stats.png"/>
</div>
<div class="box" style="width:290px;padding-left:2px;">
<table align="center">
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;padding-right:50px">Level</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["levelID"]) ? $_SESSION["levelID"] : "0") ?></th>
</tr>
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;">exp</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["xp"]) ? $_SESSION["xp"] : "0") ?></th>
</tr>
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;"><br></th>
</tr>
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;">Health</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["health"]) ? $_SESSION["health"] : "0") ?></th>
</tr>
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;">Attack</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["attack"]) ? $_SESSION["attack"] : "0") ?></th>
</tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;">Defence</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["defence"]) ? $_SESSION["defence"] : "0") ?></th>
<tr>
<th style="width:5px;position:relative;top:-2px;font-size:25px;text-align:left;">Energy</th>
<th id="stat" class="stats-cell" style="font-size:25px;"><?php echo (isset($_SESSION["energy"]) ? $_SESSION["energy"] : "0") ?></th>
</tr>
</table>
</div>
    
<br>    

<div class="banner" style="width:300px;">
    <img alt="" src="graphics/banners/banner_battle_log.png"/>
</div>

<div class="box" style="width:290px;">

<button class="log-btn">125125: gold:45, exp:50, date:10.02.14</button>    
<button class="log-btn">2121: gold:40, exp:120, date:11.04.14</button> 
<button class="log-btn">6212: gold:55, exp:10, date:19.06.14</button> 
<button class="log-btn">87623: gold:100, exp:96, date:10.07.14</button> 
<button class="log-btn">16252: gold:204, exp:229, date:15.07.14</button> 

</div>    
    
    
</div>

<div style="display:table-cell;width:500px;padding-right:15px;float:right;">
    
<div class="banner" style="width:500px">
    <img alt="" src="graphics/banners/banner_equipment.png"/>
</div>
    
<div class="box" style="width:485px">
    
    <table>
        <tr>
            <td class="equip-box" style="background-color:green;padding:55px">gloves</td>
            <td class="equip-box" style="background-color:green;padding:55px">helmet</td>
            <td  style="padding:55px"></td>
        </tr>
        <tr>
            <td class="equip-box" style="background-color:green;padding:55px">weapon</td>
            <td class="equip-box" style="background-color:green;padding:55px">armour</td>
            <td class="equip-box" style="background-color:green;padding:55px">shield</td>
        </tr>
        <tr>
            <td style="padding:55px"></td>
            <td class="equip-box" style="background-color:green;padding:55px">boots</td>
            <td style="padding:55px"></td>
        </tr>
    </table>

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